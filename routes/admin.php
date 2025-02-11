<?php

use App\Http\Controllers\Admin\attributeController;
use App\Http\Controllers\Admin\colorController;
use App\Http\Controllers\Admin\dashboardController;
use App\Http\Controllers\Admin\homeBannerController;
use App\Http\Controllers\Admin\profileController;
use App\Http\Controllers\Admin\sizeController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', function () {
    return view('admin/index');
});  


//Profile Section
Route::get('/profile',[profileController::class,'index']);
Route::post('/saveProfile',[profileController::class,'store']);

// Home Banner
Route::get('/home_banner',[homeBannerController::class,'index']);
Route::post('/updateHomeBanner', [homeBannerController::class, 'store'])->name('admin.updateHomeBanner');

// Size
Route::get('/manage_size',[sizeController::class,'index']);
Route::post('/updatesize', [sizeController::class, 'store']);

// Color
Route::get('/manage_color',[colorController::class,'index']);
Route::post('/updatecolor', [colorController::class, 'store']);

// Attribute
Route::get('/attribute_name',[attributeController::class,'index_attribute_name']);
Route::post('/update_attribute_name',[attributeController::class,'store_attribute_name']);

Route::get('/attribute_value',[attributeController::class,'index_attribute_value']);
Route::post('/update_attribute_value',[attributeController::class,'store_attribute_value']);


// Delete Data
Route::get('/deleteData/{id?}/{table?}',[dashboardController::class,'deleteData']);