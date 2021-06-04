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
Route::get('/', 'HomeController@index')->name('home');
Route::post('/search/products', 'HomeController@products')->name('search-product');

Route::get('/categories', 'CategoryController@index')->name('categories');
Route::get('/categories/{id}', 'CategoryController@detail')->name('categories-detail');

Route::get('/details/{id}', 'DetailController@index')->name('detail');
Route::post('/details/{id}', 'DetailController@add')->name('detail-add');

Route::post('/checkout/callback', 'CheckoutController@callback')->name('midtrans-callback');

Route::get('/success', 'CartController@success')->name('success');


Route::get('/register/success', 'Auth\RegisterController@success')->name('register-success');

Route::get('/promotion', 'PromotionController@index')->name('promotion');




Route::group(['middleware' => ['auth']], function(){

    Route::get('/cart', 'CartController@index')->name('cart');
    Route::delete('/cart/{id}', 'CartController@delete')->name('cart-delete');
    Route::post('/cart/update/min/{id}', 'CartController@updateMinus')->name('cart-update-min');

    // Route::post('/checkout', 'CheckoutController@process')->name('checkout');
    Route::post('/checkout', 'CheckoutController@processOrderToWhatsApp')->name('checkout');

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('/dashboard/products', 'DashboardProductController@index')
        ->name('dashboard-product');
    Route::get('/dashboard/products/create', 'DashboardProductController@create')
        ->name('dashboard-product-create');
    Route::post('/dashboard/products', 'DashboardProductController@store')
        ->name('dashboard-product-store');
    Route::get('/dashboard/products/{id}', 'DashboardProductController@details')
        ->name('dashboard-product-details');
    Route::post('/dashboard/products/{id}', 'DashboardProductController@update')
        ->name('dashboard-product-update');
    Route::post('/dashboard/products/gallery/upload', 'DashboardProductController@uploadGallery')
        ->name('dashboard-product-gallery-upload');
    Route::get('/dashboard/products/gallery/delete/{id}', 'DashboardProductController@deleteGallery')
        ->name('dashboard-product-gallery-delete');

    Route::get('/dashboard/transactions', 'DashboardTransactionController@index')
        ->name('dashboard-transactions');
    Route::get('/dashboard/transactions/{id}', 'DashboardTransactionController@details')
        ->name('dashboard-transactions-details');

    Route::get('/dashboard/transactions/myorder/list', 'DashboardTransactionController@myOrder')
        ->name('dashboard-transactions-myorder');

    Route::get('/dashboard/transactions/myorder/list/detail/{code}', 'DashboardTransactionController@myOrderDetail')
        ->name('dashboard-transactions-myorder-detail');

    Route::post('/dashboard/transactions/myorder/finish/{id}', 'DashboardTransactionController@orderFinish')
        ->name('dashboard-transactions-myorder-finish');

    Route::get('/dashboard/transactions/buy/{id}', 'DashboardTransactionController@detailsBuy')
        ->name('dashboard-transactions-details-buy');

    Route::get('/dashboard/transactions/sell/{id}', 'DashboardTransactionController@detailsSell')
        ->name('dashboard-transactions-details-sell');

    Route::post('/dashboard/transactions/{id}', 'DashboardTransactionController@update')
        ->name('dashboard-transactions-update');

    Route::get('/dashboard/payment/{code}', 'DashboardTransactionController@payment')
        ->name('dashboard-payment');
    Route::post('/dashboard/payment/store', 'DashboardTransactionController@paymentStore')
        ->name('dashboard-payment-store');

    Route::get('/dashboard/setting', 'DashboardSettingController@store')
        ->name('dashboard-settings-store');
    Route::get('/dashboard/account', 'DashboardSettingController@account')
        ->name('dashboard-settings-account');

    Route::post('/dashboard/store/idcard', 'DashboardSettingController@idCardStore')
        ->name('dashboard-settings-idcard-store');
    Route::get('/dashboard/store/idcard/delete/{id}', 'DashboardSettingController@deleteIdCard')
        ->name('dashboard-settings-idcard-delete');
    
    Route::post('/dashboard/account/{redirect}', 'DashboardSettingController@update')
        ->name('dashboard-settings-redirect');

    Route::get('/dashboard/report', 'DashboardReportController@index')
        ->name('dashboard-report');

});
Route::prefix('admin')
        ->namespace('Admin')
        ->middleware(['auth','admin'])
        ->group(function(){
            Route::get('/','DashboardController@index')->name('admin-dashboard');
            Route::resource('topcategory','TopCategoryController');
            Route::resource('category','CategoryController');
            Route::resource('user','UserController');
            Route::resource('product','ProductController');
            Route::resource('product-gallery','ProductGalleryController');
            Route::resource('transactions', 'TransactionController');
            Route::resource('submissionidcard', 'SubmissionIdcardController');
            Route::resource('promotion', 'PromotionController');

            Route::get('product/excel/format/download','ProductController@downloadFormatExcel')->name('product-excel-format-download');
            Route::post('product/upload','ProductController@uploadProductExcel')->name('product.uploadProductExcel');
            Route::post('product/excel/upload','ProductController@saveExcelUploadPoint')->name('product-upload-excel-save');

            Route::post('aproov/payment/{id}','TransactionController@aproovPayment')->name('aproov-payment');

            Route::resource('report','ReportController');
            Route::resource('point','PointController');

            Route::get('point/destroy/{id}','PointController@destroy');

            Route::post('point/excel','PointController@uploadPointExcel')->name('point-upload-excel');
            Route::post('point/excel/upload','PointController@saveExcelUploadPoint')->name('point-upload-excel-save');
            Route::get('point/exchange/{id}','PointController@exchangePoint')->name('point-exchange');
            Route::post('point/exchange/{id}','PointController@StoreexchangePoint')->name('point-exchange-store');
            Route::get('point/exchange/history/{users_id}','PointController@historyExchangePoint')->name('point-exchange-history');

            Route::get('point/excel/format/download','PointController@downloadFormatExcel')->name('point-excel-format-download');
            Route::get('point/delete/all','PointController@deleteAll')->name('point-delete-all');

        });

Auth::routes();

