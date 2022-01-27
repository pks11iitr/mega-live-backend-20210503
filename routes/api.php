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
$api->post('google-login', 'MobileApps\Auth\LoginController@googleLogin');


 $api->get('initiate-coin-payment/{plan_id}', 'MobileApps\PaymentController@initiateCoinPayment');
$api->post('request_otp', 'MobileApps\AuthController@requestOtp');
$api->post('verify_otp', 'MobileApps\AuthController@verifyOtp');

//$api->post('admin/login-with-otp', 'MobileApps\AdminUsersApp\Auth\LoginController@loginWithOtp');

$api->post('webhook-receive-133232983892', 'MobileApps\WebhookController@receive');


<<<<<<< HEAD
$api->group(['middleware' => ['customer-api-auth', 'lastlog']], function ($api) {
    $api->get('initiate-call/{profile_id}', 'MobileApps\CallController@initiateVideoCall');
=======
    $api->group(['middleware' => ['customer-api-auth', 'lastlog']], function ($api) {

>>>>>>> 407cc086e51af3b64f372c82c1b72c33b8c686f1
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



<<<<<<< HEAD

=======
>>>>>>> 407cc086e51af3b64f372c82c1b72c33b8c686f1
   // $api->get('initiate-coin-payment/{plan_id}', 'MobileApps\PaymentController@initiateCoinPayment');
    $api->post('verify-payment', 'MobileApps\PaymentController@verifyPayment');
    $api->get('genrate_order', 'MobileApps\PaymentController@genrate_order');



    $api->get('my-interests', 'MobileApps\ProfileController@getInterests');
    $api->post('update-interests', 'MobileApps\ProfileController@updateInterests');




    $api->group(['prefix' => 'admin'], function ($api) {
        $api->get('users', 'MobileApps\AdminUsersApp\UsersController@index');
        $api->get('chats', 'MobileApps\AdminUsersApp\ChatController@chatlist');
        $api->get('chats/{user_id}', 'MobileApps\AdminUsersApp\ChatController@chatDetails');
        $api->post('send-message/{user_id}', 'MobileApps\AdminUsersApp\ChatController@send');
        $api->get('initiate-call/{profile_id}', 'MobileApps\CallController@initiateVideoCall');

        $api->get('get-profile', 'MobileApps\AdminUsersApp\ProfileController@getprofile');
        $api->post('update-profile', 'MobileApps\AdminUsersApp\ProfileController@updateprofile');

        $api->get('pictures', 'MobileApps\AdminUsersApp\ProfileController@picures');
        $api->post('upload-pictures', 'MobileApps\AdminUsersApp\ProfileController@uploadpictures');
        $api->get('delete-picture/{id}', 'MobileApps\AdminUsersApp\ProfileController@deletepic');
        $api->get('set-profile-pic/{id}', 'MobileApps\AdminUsersApp\ProfileController@updateProfilePic');

        $api->get('profile', 'MobileApps\AdminUsersApp\ProfileController@profile');

        $api->get('earnings', 'MobileApps\AdminUsersApp\EarningsController@earnings');

        $api->post('send-bulk', 'MobileApps\AdminUsersApp\ChatController@bulkMessage');

        $api->get('like/{id}', 'MobileApps\AdminUsersApp\LikeDislikeController@like');
        $api->get('dislike/{id}', 'MobileApps\AdminUsersApp\LikeDislikeController@dislike');
        $api->get('ilike', 'MobileApps\AdminUsersApp\LikeDislikeController@ilike');
        $api->get('likeme', 'MobileApps\AdminUsersApp\LikeDislikeController@likeme');

    });





});

$api->get('privacy-policy','SuperAdmin\UrlController@privacy');
$api->get('faq','SuperAdmin\UrlController@faq');
$api->get('support','SuperAdmin\UrlController@customercare');
$api->get('about','SuperAdmin\UrlController@about');
$api->get('countries','DataController@countries');
$api->get('terms-conditions','SuperAdmin\UrlController@terms');
