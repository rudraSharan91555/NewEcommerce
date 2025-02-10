<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class authCotroller extends Controller
{

function loginUser(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string'
        ]);
        // EMail not present in DB
        if ($validation->fails()) {
            return response()->json(['status' => 400, 'message' => $validation->errors()->first()]);
        } else {
            $cred = array('email' => $request->email, 'password' => $request->password);
            // Right Auth
            if (Auth::attempt($cred, false)) {
                if (Auth::User()->hasRole('admin')) {
                    return response()->json(['status' => 200, 'message' => 'Admin User', 'url' => 'admin/dashboard']);
                } else {
            
                    $user = User::where('id',Auth::User()->id)->first();
                    $user['token'] = $user->createToken('API Token')->plainTextToken;
                    // return response()->json(['status'=>200,'message'=>'Succesfull login']);
                    return $this->success(
                        ['user' => $user],
                        'succesfull login'
                    );
                }
            } else {
                return response()->json(['status' => 404, 'message' => 'Wrong Cred']);
            }
        }
    }


}
