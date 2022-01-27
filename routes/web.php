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

Route::get('/', function () {
    return view('welcome');
})->name('website.home');

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');


Route::group(['middleware'=>['auth']], function() {
    Route::get('/dashboard', 'SuperAdmin\DashboardController@index')->name('home');
});



Route::group(['middleware'=>['auth', 'acl'], 'is'=>'admin'], function() {

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

//    Route::get('/dashboard', 'SuperAdmin\DashboardController@index')->name('home');

    Route::group(['prefix' => 'banners'], function () {
        Route::get('/', 'SuperAdmin\BannerController@index')->name('banners.list');
        Route::get('create', 'SuperAdmin\BannerController@create')->name('banners.create');
        Route::post('store', 'SuperAdmin\BannerController@store')->name('banners.store');
        Route::get('edit/{id}', 'SuperAdmin\BannerController@edit')->name('banners.edit');
        Route::post('update/{id}', 'SuperAdmin\BannerController@update')->name('banners.update');
        Route::get('delete/{id}', 'SuperAdmin\BannerController@delete')->name('banners.delete');
    });

    Route::group(['prefix'=>'customer'], function(){
        Route::get('/','SuperAdmin\CustomerController@index')->name('customer.list');
        Route::get('create','SuperAdmin\CustomerController@create')->name('customer.create');
        Route::post('store','SuperAdmin\CustomerController@store')->name('customer.store');
        Route::get('edit/{id}','SuperAdmin\CustomerController@edit')->name('customer.edit');
        Route::get('details/{id}','SuperAdmin\CustomerController@details')->name('customer.details');
        Route::post('upload-images/{id}','SuperAdmin\CustomerController@images')->name('customer.images.uploads');
        Route::get('image-delete/{id}','SuperAdmin\CustomerController@deleteimage')->name('customer.image.delete');
        Route::post('update/{id}','SuperAdmin\CustomerController@update')->name('customer.update');
        Route::get('chat/{id}','SuperAdmin\CustomerController@chat')->name('customer.chat');
        Route::post('image','SuperAdmin\CustomerController@image')->name('customer.image');

    });

    Route::group(['prefix'=>'membership'], function(){
        Route::get('/','SuperAdmin\MemberShipController@index')->name('membership.list');
        Route::get('create','SuperAdmin\MemberShipController@create')->name('membership.create');
        Route::post('store','SuperAdmin\MemberShipController@store')->name('membership.store');
        Route::get('edit/{id}','SuperAdmin\MemberShipController@edit')->name('membership.edit');
        Route::post('update/{id}','SuperAdmin\MemberShipController@update')->name('membership.update');

    });

    Route::group(['prefix'=>'coins'], function(){
        Route::get('/','SuperAdmin\CoinsController@index')->name('coins.list');
        Route::get('create','SuperAdmin\CoinsController@create')->name('coins.create');
        Route::post('store','SuperAdmin\CoinsController@store')->name('coins.store');
        Route::get('edit/{id}','SuperAdmin\CoinsController@edit')->name('coins.edit');
        Route::post('update/{id}','SuperAdmin\CoinsController@update')->name('coins.update');

    });
    Route::group(['prefix'=>'gift'], function(){
        Route::get('/','SuperAdmin\GiftController@index')->name('gift.list');
        Route::get('create','SuperAdmin\GiftController@create')->name('gift.create');
        Route::post('store','SuperAdmin\GiftController@store')->name('gift.store');
        Route::get('edit/{id}','SuperAdmin\GiftController@edit')->name('gift.edit');
        Route::post('update/{id}','SuperAdmin\GiftController@update')->name('gift.update');

    });

    Route::group(['prefix'=>'interests'], function(){
        Route::get('/','SuperAdmin\InterestController@index')->name('interest.list');
        Route::get('create','SuperAdmin\InterestController@create')->name('interest.create');
        Route::post('store','SuperAdmin\InterestController@store')->name('interest.store');
        Route::get('edit/{id}','SuperAdmin\InterestController@edit')->name('interest.edit');
        Route::post('update/{id}','SuperAdmin\InterestController@update')->name('interest.update');

    });

    Route::group(['prefix'=>'news'], function(){
        Route::get('/','SuperAdmin\NewsUpdateController@index')->name('news.list');
        Route::get('create','SuperAdmin\NewsUpdateController@create')->name('news.create');
        Route::post('store','SuperAdmin\NewsUpdateController@store')->name('news.store');
        Route::get('edit/{id}','SuperAdmin\NewsUpdateController@edit')->name('news.edit');
        Route::post('update/{id}','SuperAdmin\NewsUpdateController@update')->name('news.update');

    });

    Route::group(['prefix'=>'story'], function(){
        Route::get('/','SuperAdmin\StoryController@index')->name('story.list');
        Route::get('create','SuperAdmin\StoryController@create')->name('story.create');
        Route::post('store','SuperAdmin\StoryController@store')->name('story.store');
        Route::get('edit/{id}','SuperAdmin\StoryController@edit')->name('story.edit');
        Route::post('update/{id}','SuperAdmin\StoryController@update')->name('story.update');

    });

    Route::group(['prefix'=>'payment'], function(){
        Route::get('/','SuperAdmin\PaymentController@index')->name('payment.list');

    });

    Route::group(['prefix'=>'earning'], function(){
        Route::get('/','SuperAdmin\EarningController@index')->name('earning.list');

    });

});

Route::group(['prefix'=>'caller', 'middleware'=>['auth', 'acl'], 'is'=>'caller'], function() {

    Route::get('/dashboard', 'CallerAdmin\DashboardController@index')->name('caller.home');

    Route::group(['prefix'=>'customer'], function(){
        Route::get('/','CallerAdmin\CustomerController@index')->name('caller.customer.list');
        Route::get('chat/{id}','CallerAdmin\ChatController@chat')->name('caller.customer.chat');
        Route::get('recent-chat/{id}','CallerAdmin\ChatController@newchats')->name('caller.customer.recent-chat');
        Route::post('send-chat/{id}','CallerAdmin\ChatController@sendChat')->name('caller.send.chat');
//        Route::post('send-chat','CallerAdmin\ChatController@sendChat')->name('caller.send.chat');

    });

});

Route::group(['prefix'=>'Admincoinadd'], function(){
    Route::get('/','SuperAdmin\CoinAddbyAdminController@index')->name('Admincoinadd.list');
    Route::get('create','SuperAdmin\CoinAddbyAdminController@create')->name('Admincoinadd.create');        
    Route::post('store','SuperAdmin\CoinAddbyAdminController@store')->name('Admincoinadd.store');

    Route::get('edit/{id}','SuperAdmin\CoinAddbyAdminController@edit')->name('Admincoinadd.edit');
    Route::post('update/{id}','SuperAdmin\CoinAddbyAdminController@update')->name('Admincoinadd.update');
});

Route::group(['prefix'=>'url'], function(){
    Route::get('privacy-policy','SuperAdmin\UrlController@privacy');

});

require __DIR__.'/auth.php';
