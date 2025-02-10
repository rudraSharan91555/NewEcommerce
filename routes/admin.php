<?php

use App\Http\Controllers\Admin\dashboardController;
use App\Http\Controllers\Admin\homeBannerController;
use App\Http\Controllers\Admin\profileController;
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


// Delete Data
Route::get('/deleteData/{id?}/{table?}',[dashboardController::class,'deleteData']);