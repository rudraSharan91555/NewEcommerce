<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;
use App\Traits\SaveFile;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryAttribute;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductAttr;
use App\Models\ProductAttribute;
use App\Models\ProductAttrImages;
use App\Models\Size;
use App\Models\Tax;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;


class productController extends Controller
{
    use ApiResponse;
    use SaveFile;



    public function index()
    {
        $data = Product::get();
        return view('admin/Product/product', get_defined_vars());
    }


    public function view_product($id = 0)
    {
        $category   = Category::get();
        $brand      = Brand::get();
        $color      = Color::get();
        $size       = Size::get();
        $tax        = Tax::get();

        if ($id == 0) {
            // New product
            $data = new Product();
            // $data['productAttributes'] = ProductAttr::get();
            // $data = (object)[];
           
            $data['productAttributes'] = $this->attrDummyData();
            // prx($data['productAttributes']); 
            $product_attr_images = new ProductAttrImages();
        } else {
            $data['id'] = $id;
            // Update Product
            $validation = Validator::make($data, [
                'id'    => 'required|exists:products,id',
            ]);

            if ($validation->fails()) {
                return Redirect::back();
                // return response()->json(['status'=>400,'message'=>$validation->errors()->first()]);
            } else {
                $data = Product::where('id', $id)->with('attribute','productAttributes')->first();
                // prx($data);
            }
        }
        // prx($data);
        return view('admin/Product/manage_product', get_defined_vars());
        // prx(get_defined_vars());
    }

    public function attrDummyData()
    {
        $data[0]['id'] = 0;
        $data[0]['color_id'] = 0;
        $data[0]['size_id'] = 0;
        $data[0]['sku'] = 0;
        $data[0]['mrp'] = 0;
        $data[0]['price'] = 0;
        $data[0]['length'] = 0;
        $data[0]['breadth'] = 0;
        $data[0]['height'] = 0;
        $data[0]['weight'] = 0;
        return $data;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction(); 
            // prx($request->all());
            $validation = Validator::make($request->all(), [
                'name'    => 'required|string|max:255',
                'slug'    => 'required|string|max:255',
                'image'   => 'mimes:jpeg,png,webp,jpg,gif|max:5120', 
                'category_id'  => 'required|exists:categories,id',

            ]);
            $cleanImageName = $this->clean($request->name);
            
            if ($validation->fails()) {
                return $this->error($validation->errors()->first(), 400, []);
                // return response()->json(['status'=>400,'message'=>$validation->errors()->first()]);
            } else {
                // $slug = replceStr($request->slug);
                if ($request->hasfile('image')) {
                    if ($request->id > 0) {
                        $image = Product::where('id', $request->id)->first();
                        $image_path = "images/products/" . $image->image . "";
                        if (File::exists($image_path)) {
                            File::delete($image_path);
                        }
                    }
                   
                    $image_name = "images/products/" . $cleanImageName . time() . '.' . $request->image->extension();
                    $request->image->move(public_path('images/products/'), $image_name);
                } elseif ($request->id > 0) {
                    $image_name = Product::where('id', $request->post('id'))->pluck('image')->first();
                }
                $productId =   Product::updateOrCreate(
                    ['id' => $request->id],
                    [
                        'name' => $request->name, 'slug' => $request->slug, 'image' => $image_name,
                        'category_id' => $request->category_id, 'brand_id' => $request->brand_id,
                        'tax_id' => $request->tax_id, 'item_code' => $request->item_code, 'keywords' => $request->keywords,
                        'description' => $request->description
                    ]
                );
                $productId = $productId->id;
                // Product Category Attribute
                ProductAttribute::where('product_id', $productId)->delete();
               if($request->attribute_id!='')
               {
                foreach ($request->attribute_id as $key => $val) {
                    ProductAttribute::updateOrCreate(
                        [
                            'product_id' => $productId, 'category_id' => $request->category_id,
                            'attribute_value_id' => $val
                        ],
                        [
                            'product_id' => $productId, 'category_id' => $request->category_id,
                            'attribute_value_id' => $val
                        ]
                    );
                }
               }
               
               
                //Product Attr 
                $productAttrNewId = [];
                foreach ($request->sku as $key => $val) {
                    $productAttrId =   ProductAttr::updateOrCreate(
                        // ['id' => $paid],
                        ['id' => $request->productAttrId[$key]],
                        [
                            'product_id' => $productId, 'color_id' => $request->color_id[$key],
                            'size_id' => $request->size_id[$key], 'sku' => $request->sku[$key],
                            'size_id' => $request->size_id[$key], 'mrp' => $request->mrp[$key],
                            'price' => $request->price[$key], 'length' => $request->length[$key],
                            'breadth' => $request->breadth[$key],  'height' => $request->height[$key],
                            'weight' => $request->weight[$key]
                        ]  
                    );
                    $productAttrId = $productAttrId->id;
                    
                        // array_push($attrImage , $val);
                        $imageVal = 'attr_image_' . $request->imageValue[$key];
                           
                        if($request->$imageVal){
                            print_r($imageVal);
                            echo"<br>";
                            foreach ($request->$imageVal as $key => $val) {
    
    
                                $image_name = "images/productsAttr/" . $this->getRandomValue() . $cleanImageName . time() . '.' . $val->extension();
                                $val->move(public_path('images/productsAttr/'), $image_name);
        
        
                                ProductAttrImages::updateOrCreate(
                                    [
                                        'product_id' => $productId, 'product_attr_id' => $productAttrId,
                                        'image' => $image_name
                                    ]
                                );
                            }
                        }

                        
                    
                   
                }
                $attrImage = [];
                
               

               
                DB::commit(); //process end
                echo "No Error occurs";
                return redirect::back();
                // return $this->success(['reload' => true], 'Successfully updated');
            }
        } catch (\Throwable $th) {
           
            DB::rollBack(); 
            echo $th;
        }
    }

    public function clean($string) {
        $string = str_replace(' ', '-', $string); 
     
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); 
     }


    public function getAttributes(Request $request)
    {
        $category_id = $request->category_id;
        $data = CategoryAttribute::where('category_id', $category_id)->with('attribute', 'values')->get();

        return $this->success(['data' => $data], 'Successfully updated');
    }

    public function getRandomValue()
    {
        $random = rand(111111, 999999);
        return $random;
    }

    public function removeAttrId(Request $request)
    {
        $type = $request->type;
        DB::table($request->type)->where('id',$request->id)->delete();
        return $this->success(['status'=>'success'],'Successfully updated');
    }
}