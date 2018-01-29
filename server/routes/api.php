<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => 'auth:api', 'namespace' => 'Api\V1', 'prefix' => 'v1'], function () {
    Route::post('logout', 'Auth\LogoutController@index');
    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
    Route::get('user', function (Request $request) {
        return $request->user();
    });
});

Route::group(['middleware' => 'guest:api', 'namespace' => 'Api\V1', 'prefix' => 'v1'], function () {
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});
