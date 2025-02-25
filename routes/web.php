<?php



use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\authCotroller;
use Illuminate\Support\Facades\Auth;


// Route::get('/createAdmin',[AuthController::class,'createCustomer']);


// Route::get('/', function () {
//     return redirect('admin/dashboard');
// });

Route::get('/', function () {
    return view('index');
});


Route::get('/login', function () {
    return view('auth/signIn');
});

Route::get('/apiDocs', function () {
    return view('apiDocs');
});

Route::post('/login_user',[authCotroller::class,'loginUser']);

Route::get('/logout',function (){
    Auth::logout();
    return redirect('/login') ;
});


Route::get('/{vue_capture?}', function() {
    return view('index');
})->where('vue_capture', '[\/\w\.-]*');

