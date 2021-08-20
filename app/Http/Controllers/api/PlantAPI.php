<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\helper\GoogleDriveHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\APIController;
use App\Models\MyPlant;
use App\Models\CloudImageDetails;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Str;

use File;

class PlantAPI extends Controller
{
    public function __construct()
    {
        APIController::initConst();        
    }

    public function userGetPlantList(Request $request){
        $response_data = array();
        try {
            $response_data['plant_list'] = MyPlant::all();
             
            return response()->json([
                'status'  =>  array_merge(APIController::getResponseStatus(HTTP_STATUS_SUCCESS , __CLASS__ , __FUNCTION__),
                    array('description' => 'user get plant list success.')),
                'data'    =>  $response_data,
            ]);
        }catch (Exception $e) {
            return response()->json([
                'status'  =>  array_merge(APIController::getResponseStatus(HTTP_STATUS_FAILED , __CLASS__ , __FUNCTION__),
                    array('description' => APIController::getResponseDescription($e))),
                'data'    =>  $response_data,
            ]);
        }
    }

    public function userAddPlant(Request $request){
        $response_data = array();
        try {
            $input_validator = Validator::make($request->all(),[
                'plant_name'         =>  'required|string',
                'price'              =>  'required|numeric',
                'received_date'      =>  'date_format:Y-m-d',
                'note'               =>  'string',
            ]);
            if ($input_validator->fails()) {
                throw new Exception($input_validator->errors()->first(), SAFE_EXCEPTION_CODE);
            }

            // Upload Plant Images //
            $plant_img = null;
            $img_name = null;
            $thumbnail_img_name = null;
            if($request->file('img')!=null){
                $random_str = Str::random(16);
                $img_name = $random_str.".jpg";
                $plant_img = $request->file('img');
                GoogleDriveHelper::uploadPlantImg($plant_img,$img_name);

                $thumbnail_img_name = $random_str."-thumbnail.jpg";
                GoogleDriveHelper::uploadPlantThumbnailImg($plant_img,$thumbnail_img_name);

            }

            // get url path from google drive
            $img_cloud_path = null;
            if($img_name != null){
                $url_list = GoogleDriveHelper::getCloudFileList('gd-img');
                $img_cloud_path = $url_list[$img_name];
            }
            $thumbnail_img_cloud_path = null;
            if($thumbnail_img_name != null){
                $url_list = GoogleDriveHelper::getCloudFileList('gd-thumbnail-img');
                $thumbnail_img_cloud_path = $url_list[$thumbnail_img_name];
            } 

            // insert cloud image details
            $cloud_image_id = CloudImageDetails::create(array(
                    'location' => 'google_drive',
                    'img_name' => $img_name,
                    'thumbnail_img_name' => $thumbnail_img_name,
                    'date_taken' => '2021-01-01',
                    'img_cloud_path' => $img_cloud_path,
                    'thumbnail_img_cloud_path' => $thumbnail_img_cloud_path,
                    'is_available' => 1,
                    'is_deleted' => 0
                )
            )->id;
            
            $response_data['plant_obj'] = MyPlant::create(array(
                    'user_id' => 1, // fix
                    'plant_name' => $request->plant_name,
                    'price' => $request->price,
                    'main_image' => $cloud_image_id,
                    'image_list' => "1,2,3",
                    'plant_status_id' => 1, // normal status
                    'received_date' => $request->received_date,
                    'note' => $request->note,
                )
            );
             
            return response()->json([
                'status'  =>  array_merge(APIController::getResponseStatus(HTTP_STATUS_SUCCESS , __CLASS__ , __FUNCTION__),
                    array('description' => 'user add plant success.')),
                'data'    =>  $response_data,
            ]);
        }catch (Exception $e) {
            return response()->json([
                'status'  =>  array_merge(APIController::getResponseStatus(HTTP_STATUS_FAILED , __CLASS__ , __FUNCTION__),
                    array('description' => APIController::getResponseDescription($e))),
                'data'    =>  $response_data,
            ]);
        }

    }

}


