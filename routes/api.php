<?php

use Illuminate\Http\Request;
$api = app('Dingo\Api\Routing\Router');

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

$api->post('login', 'MobileApps\Auth\LoginController@login');
$api->post('login-with-otp', 'MobileApps\Auth\LoginController@loginWithOtp');
$api->post('register', 'MobileApps\Auth\RegisterController@register');
$api->post('forgot', 'MobileApps\Auth\ForgotPasswordController@forgot');
$api->post('verify-otp', 'MobileApps\Auth\OtpController@verify');
$api->post('resend-otp', 'MobileApps\Auth\OtpController@resend');
$api->post('update-password', 'MobileApps\Auth\ForgotPasswordController@updatePassword');


$api->get('home', 'MobileApps\HomeController@home');
