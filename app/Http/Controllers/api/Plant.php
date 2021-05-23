<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\APIController;
use App\Models\MyPlant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DB;
use Hash;

class Plant extends Controller
{
    public function __construct()
    {
        APIController::initConst();        
    }

    public function userGetPlantList(Request $request){
        $response_data = array();
        try {
            $response_data = MyPlant::all();
             
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
                'img'                =>  'image:jpeg,png,jpg,gif,svg',
            ]);
            if ($input_validator->fails()) {
                throw new Exception($input_validator->errors()->first(), SAFE_EXCEPTION_CODE);
            }

            // Upload Plant Images //
            $plant_img = null;
            if($request->file('img')!=null){
                $plant_filename = Str::random(16).".jpg";
                $plant_img = $request->file('img');
                $upload_plant_img = $plant_img->storeAs('public/plant_img', $plant_filename);
            }

            $plant_obj = MyPlant::create(array(
                    'plant_name' => $request->plant_name,
                    'price' => $request->price,
                    'received_date' => $request->received_date,
                    'note' => $request->note,
                    'img' => $plant_filename,
                    'user_id' => 1, // fix
                    'plant_status_id' => 1 // fix
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
