<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Order;
use App\DepositedArticle;
use \Osms\Osms;
use Carbon\Carbon;
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
require __DIR__.'/../vendor/autoload.php';

Route::get('/test', function (){
    


$config = array(
    'clientId' => 'VPZb3ew2KWoqo4PGcnSwN90JPidGAgkF',
    'clientSecret' => 'CGRaHAhk05NTxpeB'
);

$osms = new Osms($config);

// retrieve an access token
$response = $osms->getTokenFromConsumerKey();

//dd($response['access_token']);

if (!empty($response['access_token'])) {
    //$senderAddress = 'tel:+224621111180';
   // $receiverAddress = 'tel:+22893343699';
   // $message = 'Dominoin Test!';
    //$senderName = 'Dominion';

   // $osms->sendSMS($senderAddress, $receiverAddress, $message, $senderName);
    
    $respons = $osms->sendSms(
        // sender
            'tel:+224621111180',
            // receiver
            'tel:+224669537954',
            'Test SMS Dominion',
           'Pressing Dominion'
        );
        
        return $respons;
}else{
    
}

});


/*Route::get('/', function () {
    return view('welcome');
});*/

 /*Route::get('/test', function () {
    $order = Order::find(5);
    
    $date = Carbon::parse($order->created_at)->toDateString();
    
    dd($date);
    
   if (!$order->depositedarticles->isEmpty()) { 
        echo 'good';
    }
    
});*/


//Authentification
Auth::routes();

Route::get('terms-conditions',function (){
    return view('payments.terms');
})->name('terms');


/********* ENVOIE SMS ****************/
//Route::get('message', 'MessageController@create')->name('message.create');
Route::get('customer/{id}/message', ['as' => 'message.create', 'uses' => 'MessageController@create']);
Route::post('message', 'MessageController@send')->name('message.store');

//Ajax

Route::get('/findPrice', ['as' => 'findPrice', 'uses' => 'OrderController@findPrice']);

Route::get('user/{id}/kilodetail', ['as' => 'order.create', 'uses' => 'OrderController@add']);

Route::post('/postkilodetail', 'OrderController@kilodetail')->name('kilodetail');

Route::get('/customer_search/action', 'DashboardController@action')->name('customer_search.action');

Route::get('user/{id}/articledeposit', ['as' => 'depositedarticle.create', 'uses' => 'OrderController@doDeposit']);

Route::post('/recordorder', 'OrderController@recordOrder')->name('recordorder');

Route::post('/savedelivery', 'DeliveryController@save')->name('savedelivery');

Route::get('customer/{id}/orderdelivery', ['as' => 'delivery.create', 'uses' => 'DeliveryController@add']);
//Conso

Route::get('/consoOrders', 'ProductController@getConso')->name('conso-orders');

//Reporting

Route::get('/getCollector', 'ReportingController@search')->name('getCollector');

Route::get('singleCollects', 'ReportingController@singleCollects')->name('singleCollects');

Route::post('/collector/periodCollect', 'ReportingController@search_globalByCollector')->name('search_globalByCollector');

Route::get('singleCollectbyDay', 'ReportingController@singleCollectbyDay')->name('singleCollectbyDay');

Route::get('/collector/singleDayCollect', 'ReportingController@search_singleDayCollect')->name('search_singleDayCollect');

Route::get('allCollects', 'ReportingController@allCollects')->name('allCollects');

Route::post('/collectors/periodCollects', 'ReportingController@search_globalCollectors')->name('search_globalCollectors');

Route::get('allDayCollects', 'ReportingController@allCollectbyDay')->name('allDayCollects');

Route::get('/collectors/allDayCollect', 'ReportingController@search_allDayCollects')->name('search_allDayCollects');

Route::resource('profils', 'ProfilController');

Route::post('/updatepassword', 'ProfilController@updatePassword')->name('updatepassword');

Route::get('/setting', 'ProfilController@setting')->name('setting');

//Dashboard

Route::get('/', 'DashboardController@index')->name('dashboard');

//orders
Route::get('order/{id}/assigncollector', ['as' => 'assigncollector.create', 'uses' => 'OrderController@assignCollector']);

Route::get('/pending-orders', 'OrderController@pending')->name('pending-orders');

Route::get('/todeliver-orders', 'OrderController@ordersTodeliver')->name('todeliver-orders');

Route::get('/totake', 'OrderController@totake')->name('totake');

//Route::get('/answers', 'StatsController@getTotake')->name('getTotake');

//Route::post('/totake', 'StatsController@postTotake')->name('totake');


Route::resource('orders', 'OrderController');

//Payments

Route::resource('payments', 'PaymentController');

//Deliveries
Route::get('/pending-deliveries', 'DeliveryController@pending')->name('pending-deliveries');

Route::get('delivery/{id}/assigncollector', ['as' => 'assigndelivercollector.create', 'uses' => 'DeliveryController@assignCollector']);

Route::resource('deliveries', 'DeliveryController');

//Notifications
Route::resource('alerts', 'AlertController');

Route::get('/getNotifs', 'AlertController@lastNotifAjax')->name('getNotifs');

Route::get('/updateStatus', 'AlertController@updateStatusAjax')->name('updateStatus');

//Configurations
Route::resource('kiloprices', 'KiloPriceController');

Route::resource('deliveryhours', 'DeliveryHourController');

Route::resource('services', 'ServiceController');

Route::resource('articles', 'ArticleController');

Route::resource('products', 'ProductController');

Route::resource('paymentmethods', 'PaymentMethodController');

Route::resource('codepromos', 'CodePromoController');

Route::resource('status', 'StatusController');

//Ratings

Route::post('/postrating', 'RatingController@store')->name('postrating');

//Notifications

Route::resource('notifications', 'NotificationController');

//Comments

Route::resource('comments', 'CommentController');

//Users

Route::resource('customers', 'CustomerController');

Route::resource('collectors', 'CollectorController');

//Administrations

Route::resource('users', 'UserController');

Route::resource('roles', 'RoleController');

Route::resource('permissions', 'PermissionController');



/*Route::get('/send', function () {

    $code = rand(1111, 9999);
    //Mail::to($email)->send(new SendMailable($code));
    
    $basic = new \Nexmo\Client\Credentials\Basic('81de9211', '2uK4uXgfutl3LgtC');
    $client = new \Nexmo\Client($basic);
    
    $message = $client->message()->send([
        'to' => '+22893343699',
        'from' => '14373703901',
        'text' => 'DOMINION Test',
    ]);
        
});*/

/* Route::get('/create_role_permission', function () {
    $role = Role::create(['name' => 'Admin']);
    $permission = Permission::create(['name' => 'Admin Permissions']);
    auth()->user()->assignRole('Admin');
    auth()->user()->givePermissionTo('Admin Permissions');
}); */