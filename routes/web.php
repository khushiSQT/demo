<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\countrycontroller;
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

Route::get('password/{token}',[AuthController::class, 'password'])->name('password');
Route::post('storepassword/{token} ',[AuthController::class, 'passwordconfirm'])->name('passwordconfirm.post');


Route::get('login',[AuthController::class,'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');

Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');


Route::resource('products', ProductController::class);


Route::post('products_list_json', [ProductController::class , 'products_list_json'] )->name('product-list-json');

Route::delete('delete',[ProductController::class , 'delete'])->name('delete');
Route::get('products/edit/{id}',[ProductController::class ,'edit'])->name('edit');
Route::post('changeStatus',[ProductController::class ,'changeStatus'])->name('changeStatus');

//user
Route::get('users',[UserController::class,'index'])->name('user.index');
Route::get('users/edit/{id}',[UserController::class,'edit'])->name('user.edit');
Route::post('users/edit/{id}',[UserController::class,'update'])->name('user.update');
Route::get('changeStatus',[UserController::class,'changeStatus'])->name('changeStatus');


//items

Route::get('item/index',[ItemController::class,'index'])->name('item.index');
Route::post('item/indexjson',[ItemController::class,'indexjson'])->name('index.indexjson');

Route::get('item/create',[ItemController::class,'create'])->name('item.create');
Route::post('item/store',[ItemController::class,'store'])->name('item.store');

Route::delete('item/delete',[ItemController::class,'delete'])->name('item.delete');
//eidt
Route::get('item/edit/{id}',[ItemController::class,'edit'])->name('item.edit');
Route::post('item/update/{id}',[ItemController::class,'update'])->name('item.update');

//multiple edit
Route::get('item/multiple-edit',[ItemController::class,'multiepledit'])->name('item.multiepledit');
Route::post('item/multiple-update',[ItemController::class,'multiepleupdate'])->name('item.multiepleupdate');

//multiple delete
Route::post('item/multi-delete', [ItemController::class, 'multiDelete'])->name('item.multi-delete');

//book
Route::get('book/index',[BookController::class,'index'])->name('book.index');
Route::get('book/save',[BookController::class,'save'])->name('book.save');
Route::post('book/store',[BookController::class,'store'])->name('book.store');


//group by
Route::get('item/groupby',[ItemController::class,'groupby'])->name('item.groupby');
Route::get('item/a',[ItemController::class,'a'])->name('item.a');
Route::get('item/lib',[ItemController::class,'lib'])->name('item.2');

//depandent dropdown
Route::get('dropdown/country',[countrycontroller::class,'country'])->name('dropdown.country');

Route::post('dropdown/state',[countrycontroller::class,'state'])->name('dropdown.state');

Route::post('dropdown/city',[countrycontroller::class,'city'])->name('dropdown.city');


