<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('registration',[AuthController::class,'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('login',[AuthController::class,'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');

Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');


Route::resource('products', ProductController::class);


Route::post('products_list_json', [ProductController::class , 'products_list_json'] )->name('product-list-json');

Route::delete('delete',[ProductController::class , 'delete'])->name('delete');
Route::get('products/edit/{id}',[ProductController::class ,'edit'])->name('edit');
Route::post('changeStatus',[ProductController::class ,'changeStatus'])->name('changeStatus');



