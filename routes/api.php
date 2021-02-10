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

//$api->post('login', 'MobileApps\Auth\LoginController@login');
$api->post('login-with-otp', 'MobileApps\Auth\LoginController@loginWithOtp');
//$api->post('register', 'MobileApps\Auth\RegisterController@register');
//$api->post('forgot', 'MobileApps\Auth\ForgotPasswordController@forgot');
$api->post('verify-otp', 'MobileApps\Auth\OtpController@verify');
$api->post('resend-otp', 'MobileApps\Auth\OtpController@resend');
//$api->post('update-password', 'MobileApps\Auth\ForgotPasswordController@updatePassword');

$api->post('admin/login-with-otp', 'MobileApps\AdminUsersApp\Auth\LoginController@loginWithOtp');


$api->group(['middleware' => ['customer-api-auth', 'lastlog']], function ($api) {

    $api->get('get-profile', 'MobileApps\ProfileController@getprofile');
    $api->post('update-profile', 'MobileApps\ProfileController@updateprofile');

    $api->get('pictures', 'MobileApps\ProfileController@picures');
    $api->post('upload-pictures', 'MobileApps\ProfileController@uploadpictures');
    $api->get('delete-picture/{id}', 'MobileApps\ProfileController@deletepic');
    $api->get('set-profile-pic/{id}', 'MobileApps\ProfileController@updateProfilePic');

    $api->get('profile', 'MobileApps\ProfileController@profile');
    $api->get('get-mypreferences', 'MobileApps\ProfileController@getmypreferences');
    $api->post('update-mypreferences', 'MobileApps\ProfileController@updatemypreferences');

    $api->get('my-matches', 'MobileApps\MatchesController@findMatches');
    $api->get('match-details/{id}', 'MobileApps\MatchesController@matchDetails');

    //dating
    $api->get('dating/{type}', 'MobileApps\DatingController@dating');

    //membership
    $api->get('membership-list', 'MobileApps\MemberShipController@index');
    $api->get('subscribe-membership/{plan_id}', 'MobileApps\MemberShipController@subscribe');

    //coins
    $api->get('coins-list', 'MobileApps\CoinsController@index');
    $api->get('buy-coins/{plan_id}', 'MobileApps\CoinsController@buycoins');


    $api->get('gifts', 'MobileApps\GiftsController@index');
    $api->post('send-gift', 'MobileApps\GiftsController@sendGift');

    $api->get('like/{id}', 'MobileApps\LikeDislikeController@like');
    $api->get('dislike/{id}', 'MobileApps\LikeDislikeController@dislike');
    $api->get('ilike', 'MobileApps\LikeDislikeController@ilike');
    $api->get('likeme', 'MobileApps\LikeDislikeController@likeme');

    $api->get('chats', 'MobileApps\ChatCotroller@chatlist');
    $api->get('chats/{user_id}', 'MobileApps\ChatCotroller@chatDetails');
    $api->post('send-message/{user_id}', 'MobileApps\ChatCotroller@send');

    $api->post('initiate-call/{profile_id}', 'MobileApps\CallCotroller@initiateVideoCall');


    $api->get('initiate-coin-payment/{plan_id}', 'MobileApps\PaymentCotroller@initiateCoinPayment');
    $api->post('verify-payment', 'MobileApps\PaymentCotroller@initiateCoinPayment');




    $api->group(['prefix' => 'admin','middleware' => ['admin-api-auth']], function ($api) {
        $api->get('users', 'MobileApps\AdminUsersApp\UsersController@index');
        $api->get('chats', 'MobileApps\AdminUsersApp\ChatController@chatlist');
        $api->get('chats/{user_id}', 'MobileApps\AdminUsersApp\ChatController@chatDetails');
        $api->post('send-message/{user_id}', 'MobileApps\AdminUsersApp\ChatController@send');
    });


});

