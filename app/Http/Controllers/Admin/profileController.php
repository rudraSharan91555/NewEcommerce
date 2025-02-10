<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;

class profileController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/profile');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // print_r($request->all());die();
        $validation = Validator::make($request->all(),[
            'name'    => 'required|string|max:255',
            'email'   => 'required|string|email|unique:users,email,'.Auth::User()->id,
            // 'password'=> 'required|string|min:6|confirmed',
            'image'   => 'mimes:jpeg,png,jpg,gif|max:5120',//max 5 MB
            'address'    => 'required|string|max:255',
            'twitter_link'    => 'string|max:255',
            'fb_link'    => 'string|max:255',
            'insta_link'    => 'string|max:255',
            // 'user_id' => 'required|exists:users,id'
        ]);
   
        if($validation->fails()){
            return $this->error($validation->errors()->first(),400,[]);
            // return response()->json(['status'=>400,'message'=>$validation->errors()->first()]);
        }else{
            if($request->hasFile('image')){
                $image_name = 'images/'.$request->name.time().'.'.$request->image->extension();
                
                $request->image->move(public_path('images/'),$image_name);
            }else{
                $image_name = Auth::User()->image;
            }
            $user = User::updateOrCreate(
                ['id'=>Auth::User()->id],
                ['name'=>$request->name ,'phone'=>$request->phone,'email'=>$request->email,'image'=>$image_name,'address'=>$request->address
                ,'twitter_link'=>$request->twitter_link, 'insta_link'=>$request->insta_link
                ,'fb_link'=>$request->fb_link]
            );
            // return response()->json(['status'=>200,'message'=>'Successfully updated']);
            return $this->success([],'Successfully updated');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
