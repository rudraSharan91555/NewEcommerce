<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
 use App\Traits\ApiResponse;

class homeBannerController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = HomeBanner::get();
        return view('admin/HomeBanner/home_banners',get_defined_vars());
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
        
        $validation = Validator::make($request->all(),[
            'text'    => 'required|string|max:255',
            'image'   => 'mimes:jpeg,png,webp,jpg,gif|max:5120',//max 5 MB
            'link'    => 'required|string|max:255',
            'id'    => 'required',
        ]);
   
        if($validation->fails()){
            return $this->error($validation->errors()->first(),400,[]);
            // return response()->json(['status'=>400,'message'=>$validation->errors()->first()]);
        }else{
            if($request->hasfile('image')){
                if($request->id > 0){
                    $image = HomeBanner::where('id',$request->id)->first();
                    $image_path = "images/".$image->image."";
                    if(File::exists($image_path)){
                        File::delete($image_path);
                    }
                }
                $image_name = 'images/'.$request->name.time().'.'.$request->image->extension();
                $request->image->move(public_path('images/'),$image_name);
            }elseif($request->id >0){
                $image_name = HomeBanner::where('id',$request->post('id'))->pluck('image')->first();
            }
            HomeBanner::updateOrCreate(
                ['id'=>$request->id],
                ['text'=>$request->text,'link'=>$request->link ,'image'=>$image_name]
            );
            return $this->success(['reload'=>true],'Successfully updated');
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