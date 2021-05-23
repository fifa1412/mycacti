<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class APIController extends Controller
{

    public static function initConst()
    {
        define('HTTP_STATUS_SUCCESS',array(
            'code'=>200,
            'message'=>'success'
        ));
        define('HTTP_STATUS_FAILED',array(
            'code'=>500,
            'message'=>'failed'
        ));
        define('SAFE_EXCEPTION_CODE', 99);
    }

    public static function callAPI($params){
        $api = $params['api'];
        $request = Request::create($api, 'POST');
        return Route::dispatch($request)->getContent();
    }

    public static function getResponseStatus($status,$class,$method){
        return array(
            'location'  => (new \ReflectionClass($class))->getShortName() . '_' . $method,
            'code'      => $status['code'],
            'message'   => $status['message'],
        );
    }

    public static function getResponseDescription(Exception $e){
        if(config('app.ENABLE_PRINT_SYSTEM_EXCEPTION') == true){
            return $e->getMessage();
        }else{
            if($e->getCode() == SAFE_EXCEPTION_CODE){
                return $e->getMessage();
            }else{
                return 'Unknown error.';
            }
        }
    }

    
}
