<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Route::middleware(['auth'])->group(function () {
//    Route::get('/', function () {
//        return view('welcome');
//    });
//});
Route::group(['namespace' => 'App\Http\Controllers'], function() {
    Route::get('/', 'MainController@home')
        ->name('home');



    Route::get('/product/{item_number}', 'MainController@itemView')
        ->name('itemView');

    Route::get('/privacyPolicy', 'MainController@privacyPolicyPage');

    Route::get('/termsOfUse', 'MainController@termsOfUsePage');

    Route::post('/product/{item_number}', 'OrderController@store');
//    Route::get('/allproduct', 'MainController@getAllProducts');
    Route::get('/products/{category_id}','ProductController@getProductsByCategory');
    Route::get('/getItemsByCategory/{category_id}','ProductController@getItemsByCategory');

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');
    });

    Route::group(['middleware' => ['auth']], function() {
        Route::get('/profile', 'MainController@profilePage')->name('profile');
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });

    Route::group(['middleware' => ['auth', 'admin']], function() {
        Route::get('/admin/createNewItem', 'AdminController@createNewItemPage')
            ->name('createNewItemPage');

        Route::post('/admin/createNewItem', 'AdminController@createNewItem');

        Route::get('/admin/editItem', 'AdminController@editItemPage')
            ->name('createNewItemPage');

        Route::post('/admin/updateItem', 'AdminController@updateItem');

        Route::get('/admin/itemsList', 'AdminController@itemsList')
            ->name('itemsList');

        Route::post('/admin/deleteItem', 'AdminController@deleteItem');

        Route::post('/admin/switchActiveShowStatusItem', 'AdminController@switchActiveShowStatusItem');
    });
});
