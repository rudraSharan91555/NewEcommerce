<?php



use Illuminate\Support\Facades\Route;

use App\Http\Controllers\auth\authCotroller;
use Illuminate\Support\Facades\Auth;


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