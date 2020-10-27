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

// public routes
Route::post('register', 'API\RegisterController@register');

Route::post('loginclient', 'API\RegisterController@loginClient');

Route::post('logincollector', 'API\RegisterController@loginCollector');

//Route::post('login', 'API\RegisterController@login');

Route::post('checkemail', 'API\RegisterController@checkemail');

Route::post('checkphone', 'API\RegisterController@checkphone');

Route::post('checkcustomer', 'API\RegisterController@checkcustomer');

Route::post('checkcollector', 'API\RegisterController@checkollector');

Route::post('posttoken', 'API\RegisterController@postToken');

Route::post('forgot_password', 'API\RegisterController@forgot_password');

Route::get('kiloprice', 'API\PriceController@kiloprice');

Route::get('articleprice', 'API\PriceController@articleprice');

Route::post('resetpassword', 'API\RegisterController@resetpassword');

Route::post('postverify', 'API\RegisterController@postVerify');

Route::post('resendcode', 'API\RegisterController@postCode');

Route::post('updatephone', 'API\RegisterController@updatephone');

// private routes  
Route::middleware('auth:api')->group( function () {

    Route::get('/logout', 'API\RegisterController@logout')->name('logout');
    
    Route::post('updatelang', 'API\RegisterController@updatelang');

    Route::resource('services', 'API\ServiceController');

    Route::resource('articles', 'API\ArticleController');

    Route::resource('statuses', 'API\StatusController');

    Route::resource('orders', 'API\OrderController');

    Route::resource('payments', 'API\PaymentController');

    Route::resource('deliveries', 'API\DeliveryController');

    Route::resource('comments', 'API\CommentController');

    Route::post('clientcomment', 'API\CommentController@clientcomment');

    Route::post('clientrating', 'API\RatingController@clientRating');

    Route::post('collectorrating', 'API\RatingController@collectorRating');

    Route::put('makekilocollect/{order}', 'API\OrderController@makekilocollect');
    
    Route::put('updateplace/{order}', 'API\OrderController@updatePlace');

    Route::put('makedetailcollect/{order}', 'API\OrderController@makedetailcollect');

    Route::put('makekilodetailcollect/{order}', 'API\OrderController@makekilodetailcollect');

    Route::put('updatecollect/{order}', 'API\OrderController@updateCollect');

    Route::post('checkout', 'API\PaymentController@checkout');
    
    Route::post('payleft', 'API\PaymentController@payLeft');

    Route::post('verify', 'API\PaymentController@verify');

    Route::post('payonline', 'API\PaymentController@payonline');

    Route::get('mypendingcollects', 'API\OrderController@mypendingcollects');

    Route::get('myorderscollects', 'API\OrderController@myorderscollects');

    Route::get('myorders', 'API\OrderController@myorders');

    Route::get('mypendingdeliveries', 'API\DeliveryController@mypendingcollects');

    Route::get('mycloseddeliveries', 'API\DeliveryController@mycloseddeliveries');

    Route::get('mydeliveries', 'API\DeliveryController@mydeliveries');

    Route::post('searchorder', 'API\SearchController@searchOrder');

    Route::get('getidentifier', 'API\PaymentController@generateIdentifier');

    Route::post('getidentifier', 'API\PaymentController@getIdentifier');

    Route::post('postidentifier', 'API\PaymentController@postIdentifier');

    Route::post('change_password', 'API\RegisterController@change_password');

    Route::post('update_profile', 'API\RegisterController@update_profile');

    Route::post('update_picture', 'API\RegisterController@update_picture');

    Route::post('delete_picture', 'API\RegisterController@delete_picture');

    Route::resource('notifications', 'API\NotificationController');

    Route::get('myunreadnotifications', 'API\NotificationController@unread');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



    