<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;
use App\Traits\SaveFile;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\CategoryAttribute;
class categoryController extends Controller
{
    use ApiResponse;
    use SaveFile;

    public function index()
    {
        $data = Category::get();
        return view('admin/Category/category', get_defined_vars());
    }



    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'slug'    => 'required|string|max:255',
            'image'   => 'mimes:jpeg,png,webp,jpg,gif|max:5120', //max 5 MB
            'id'    => 'required',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
            // return response()->json(['status'=>400,'message'=>$validation->errors()->first()]);
        } else {
            // $slug = replaceStr($request->slug);
            if ($request->id > 0) {
                $image = Category::find($request->id);
                $imageName = $image->image;
                if($request->hasFile('image')){
                    $imageName = $this->saveImage($request->image, $imageName, 'images/categories');

                }
            } else {
                $imageName = $this->saveImage($request->image, '', 'images/categories');
            }
            if ($request->parent_category_id != 0) {

                Category::updateOrCreate(
                    ['id' => $request->id],
                    [
                        'name' => $request->name, 'slug' => $request->slug, 'image' => $imageName,
                        'parent_category_id' => $request->parent_category_id
                    ]
                );
            } else {
                Category::updateOrCreate(
                    ['id' => $request->id],
                    [
                        'name' => $request->name, 'slug' => $request->slug, 'image' => $imageName,
                    ]
                );
            }

            return $this->success(['reload' => true], 'Successfully updated');
        }
    }

  public function index_category_attribute()
    {
        $data = CategoryAttribute::with('category','attribute')->get();
        $category = Category::get();
        $attribute = Attribute::get();
        // prx($data);
        return view('admin/Category/category_attribute', get_defined_vars());
    }

   public function store_category_attribute(Request $request)
   {
    $validation = Validator::make($request->all(), [
        'attribute_id'    => 'required|exists:attributes,id',
        'category_id'    => 'required|exists:categories,id',
        'id'    => 'required',
    ]);

    if ($validation->fails()) {
        return $this->error($validation->errors()->first(), 400, []);
        // return response()->json(['status'=>400,'message'=>$validation->errors()->first()]);
    } else {
       
        CategoryAttribute::updateOrCreate(
            ['id' => $request->id],
            ['attribute_id' => $request->attribute_id,'category_id' => $request->category_id, ]
        );
        return $this->success(['reload' => true], 'Successfully updated');
    }
   }
   
}