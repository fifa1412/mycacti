<?php

use Illuminate\Support\Facades\Route;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::group(
    [
        'middleware' => 'api',
        'namespace'  => 'App\Http\Controllers\api',
        //'prefix'     => $api_name,
    ],
    function () {
        Route::post('Plant/userAddPlant', 'PlantAPI@userAddPlant');
        Route::post('Plant/userGetPlantList', 'PlantAPI@userGetPlantList');
    
    }
);