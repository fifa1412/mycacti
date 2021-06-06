<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\APIController;
use App\Models\MyPlant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Str;
use Storage;
use Image;
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
                //'img'                =>  'image:jpeg,png,jpg,gif,svg',
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
                GoogleDrive::uploadPlantImg($plant_img,$img_name);

                $thumbnail_img_name = $random_str."-thumbnail.jpg";
                GoogleDrive::uploadPlantThumbnailImg($plant_img,$thumbnail_img_name);

                //GoogleDrive::upload($photo,$thumbnail_img_name);
                //$upload_plant_img = $plant_img->store('','google'); // upload to google drive
                //$upload_plant_img = $plant_img->storeAs('public/plant_img', $plant_filename); // upload to local
            }

            // get incremental plant id
            $plant_id = MyPlant::max('plant_id');
            if($plant_id == null){
                $plant_id = 1;
            }else{
                $plant_id++;
            }

            // get url path from google drive
            $img_cloud_path = null;
            if($img_name != null){
                $url_list = GoogleDrive::getCloudFileList('gd-img');
                $img_cloud_path = $url_list[$img_name];
            }
            $thumbnail_img_cloud_path = null;
            if($thumbnail_img_name != null){
                $url_list = GoogleDrive::getCloudFileList('gd-thumbnail-img');
                $thumbnail_img_cloud_path = $url_list[$thumbnail_img_name];
            } 

            $response_data['plant_obj'] = MyPlant::create(array(
                    'plant_id' => $plant_id,
                    'plant_name' => $request->plant_name,
                    'user_id' => 1, // fix
                    'price' => $request->price,
                    'img_name' => $img_name,
                    'thumbnail_img_name' => $thumbnail_img_name,
                    'img_cloud_path' => $img_cloud_path,
                    'thumbnail_img_cloud_path' => $thumbnail_img_cloud_path,
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

class GoogleDrive {
    public static function uploadPlantImg($file, $filename){
        Storage::disk("gd-img")->putFileAs("", $file, $filename);
    }

    public static function uploadPlantThumbnailImg($file, $filename){
        $image = Image::make($file);
        $image->resize(800, 800, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save(public_path('images/'.$filename));
        $saved_image_uri = $image->dirname.'/'.$image->basename; 
        Storage::disk("gd-thumbnail-img")->put($filename, file_get_contents($saved_image_uri));
        $image->destroy();
        unlink($saved_image_uri);
    }

    public static function getCloudFileList($folder){
        $return_data = array();
        $file_list = Storage::disk($folder)->allFiles();
        foreach($file_list as $file){
            $details = Storage::disk($folder)->getMetadata($file);
            $fname = $details['name'];
            $url = Storage::disk($folder)->url($file);
            $return_data[$fname] = $url;
        }
        return $return_data;
    }
} 

