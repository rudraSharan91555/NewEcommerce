<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;

class attributeController extends Controller
{
    use ApiResponse;

    // Attribute Name
    public function index_attribute_name()
   {
       $data = Attribute::get();
       return view('admin/Attribute/attribute', get_defined_vars());
   }

  

   public function store_attribute_name(Request $request)
   {

       $validation = Validator::make($request->all(), [
           'name'    => 'required|string|max:255',
           'slug'    => 'required|string|max:255',
           'id'    => 'required',
       ]);

       if ($validation->fails()) {
           return $this->error($validation->errors()->first(), 400, []);
           // return response()->json(['status'=>400,'message'=>$validation->errors()->first()]);
       } else {
          
        Attribute::updateOrCreate(
               ['id' => $request->id],
               ['name' => $request->name,'slug' => $request->slug, ]
           );
           return $this->success(['reload' => true], 'Successfully updated');
       }
   }  


//    Attribute Value
   public function index_attribute_value()
   {
       $data = AttributeValue::with('singleAttribute')->get();
    //    echo"<pre>";print_r($data);die();
       $attribute = Attribute::get();
       return view('admin/Attribute/attribute_value', get_defined_vars());
   }

   
   public function store_attribute_value(Request $request)
   {

       $validation = Validator::make($request->all(), [
           'attributes_id'    => 'required|exists:attributes,id',
           'value'    => 'required|string|max:255',
           'id'    => 'required',
       ]);

       if ($validation->fails()) {
           return $this->error($validation->errors()->first(), 400, []);
           // return response()->json(['status'=>400,'message'=>$validation->errors()->first()]);
       } else {
          
        AttributeValue::updateOrCreate(
               ['id' => $request->id],
               ['attributes_id' => $request->attributes_id,'value' => $request->value, ]
           );
           return $this->success(['reload' => true], 'Successfully updated');
       }
   }  
}