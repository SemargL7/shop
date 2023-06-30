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

Route::get('/', 'App\Http\Controllers\MainController@home')
    ->name('home');

Route::get('/product/{item_number}', 'App\Http\Controllers\MainController@itemView')
    ->name('itemView');

Route::get('/admin/createNewItem', 'App\Http\Controllers\AdminController@createNewItemPage')
    ->name('createNewItemPage');
Route::post('/admin/createNewItem', 'App\Http\Controllers\AdminController@createNewItem');

Route::get('/admin/editItem', 'App\Http\Controllers\AdminController@editItemPage')
    ->name('createNewItemPage');
Route::post('/admin/editItem', 'App\Http\Controllers\AdminController@updateItem');

Route::get('/admin/itemsList', 'App\Http\Controllers\AdminController@itemsList')
    ->name('itemsList');

Route::post('/admin/deleteItem', 'App\Http\Controllers\AdminController@deleteItem');

Route::post('/admin/switchActiveShowStatusItem', 'App\Http\Controllers\AdminController@switchActiveShowStatusItem');

