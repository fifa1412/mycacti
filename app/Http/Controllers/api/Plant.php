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

class Plant extends Controller
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
            if($request->file('img')!=null){
                $img_name = Str::random(16).".jpg";
                $plant_img = $request->file('img');
                GoogleDrive::upload($plant_img,$img_name);
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
            $cloud_img_url = null;
            if($img_name != null){
                $url_list = GoogleDrive::getURLList();
                $cloud_img_url = $url_list[$img_name];
            } 

            $response_data['plant_obj'] = MyPlant::create(array(
                    'plant_id' => $plant_id,
                    'plant_name' => $request->plant_name,
                    'user_id' => 1, // fix
                    'price' => $request->price,
                    'img_name' => $img_name,
                    'cloud_img_url' => $cloud_img_url,
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
    public static function upload($file, $filename){
        Storage::disk("google")->putFileAs("", $file, $filename);
    }

    public static function getURLList(){
        $return_data = array();
        $file_list = Storage::disk('google')->allFiles();
        foreach($file_list as $file){
            $details = Storage::disk('google')->getMetadata($file);
            $fname = $details['name'];
            $url = Storage::disk('google')->url($file);
            $return_data[$fname] = $url;
        }
        return $return_data;
    }
} 

