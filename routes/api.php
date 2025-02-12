<?php


use App\Http\Controllers\auth\authCotroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/auth/register', [authCotroller::class, 'register']);

Route::post('/auth/login', [authCotroller::class, 'loginUser']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(['middleware' => ['auth:sanctum']],function (){
//     Route::get('/user',function(Request $request){
//         return $request->user();
//     });
//     Route::post('/updateUser', [authCotroller::class, '/updateUser']);

//     // Route::post('/auth/logout',)
// });
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/updateUser', [authCotroller::class, 'updateUser']);

    Route::post('/auth/logout',function(Request $request){
        auth()->user()->tokens()->delete(); 
        return [
            'message' => 'Tokens Revoked'
        ];
    });
});
