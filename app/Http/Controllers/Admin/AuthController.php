<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function createCustomer()
    {
      $user         =  new User();
      $user->name   =  'admin';
      $user->email   =  'admin@gmail.com';  
      $user->password = Hash::make('123456');
      $user->save();
 
      $admin = Role::where('slug','admin')->first();
 
      $user->roles()->attach($admin);
    }
}
