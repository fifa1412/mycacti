<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return view('layouts.main-template')->with('action', 'list-plant'); });
Route::get('/add-plant', function () { return view('layouts.main-template')->with('action', 'add-plant'); });