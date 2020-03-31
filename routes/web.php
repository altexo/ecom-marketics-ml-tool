<?php

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
// Route::get('test', function (){
//     $e = explode("/", "/packs/2090960837/sellers/315787371");
//     return $e[2];
    
// });
Route::get('_auth/ml_auth', 'MeliController@meliLogin')->name('mlLogin');
Route::get('async/test', 'MeliController@index')->name('account.async');
// Route::get('_auth/ml_auth/{site_id?}/{user_id?}', 'MeliController@meliLogin');
Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)');


