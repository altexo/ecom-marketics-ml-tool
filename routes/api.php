<?php

use Illuminate\Http\Request;
use App\MercadolibreServices\MLTest;
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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
         $user = $request->user();
         return $user->setAttribute('ml_accounts', $request->user()->ml_accounts);
    });

    //Route::post('messages/send', 'Messages\MessagesController@sendMessage');
    Route::get('/users', function () {
        return App\User::all();
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    //Route::get('/messages', 'Messages\MessagesController@index');
    //Route::get('messages/{ml_user_id}', 'Messages\MessagesController@getMessages');
    Route::get('messages/{ml_user_id}', 'Messages\MessagesController@getMessages');
    Route::get('messages/unread/{ml_user_id}', 'Messages\MessagesController@getUnreadMessages');
    Route::get('messages/search/{ml_user_id}/{search}','Messages\MessagesController@searchMessages');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('messages/send', 'Messages\MessagesController@sendMessage');

    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
    // Route::get('/user/pub', function (Request $request) {
    //     return $request->user();
    // });
//Test route
    // Route::get('create/testuser', function(){
    //     $mlTest = new MLTest();
    //     return $mlTest->createTestUser('APP_USR-741691194923802-031317-493c5796f050f68bc13133b14c21238d-315787371', 'MLM');
    // });
    //Test outside auth routes
    // Route::get('messages/{ml_user_id}', 'Messages\MessagesController@getMessages');
    // Route::get('messages/unread/{ml_user_id}', 'Messages\MessagesController@getUnreadMessages');
   // Route::get('messages/search/{ml_user_id}/{search}','Messages\MessagesController@searchMessages');
});
