<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\CategoryAttribute;
use App\Models\Color;
use App\Models\HomeBanner;
use App\Models\Product;
use App\Models\ProductAttr;
use App\Models\Size;
use App\Models\TempUsers;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; 


class HomePageController extends Controller
{
  use ApiResponse;

  public function getCategoriesData()
  { {
      $data['categories'] = Category::with('subcategories')
        // ->where('parent_category_id', Null)
        ->get();
      return $this->success(['data' => $data], 'Successfully data fetched');
    }
  }
  public function getHomeData()
  {
    $data = [];
    $data['banner'] = HomeBanner::get();
    $data['categories'] = Category::with('products:id,category_id,name,slug,image,item_code')->get();
    $data['brands'] = Brand::get();
    $data['products'] = Product::with('productAttributes')->select('id', 'category_id', 'image', 'name', 'slug', 'item_code')->get();
    return $this->success(['data' => $data], 'Successfully data fetched');
  }


  public function getCategoryData(Request $request)
  {

    $attribute        = $request->attribute;
    $brand            = $request->brand;
    $color            = $request->color;
    $size             = $request->size;
    $highPrice        = $request->highPrice;
    $lowPrice         = $request->lowPrice;
    $slug             = $request->slug;
    $category = Category::where('slug', $slug)->first();
    if (isset($category->id)) {
      // $products = Product::where('category_id', $category->id)->with('productAttributes')->select('id', 'name', 'slug', 'image', 'item_code')->paginate(10);
      $products = $this->getFilterProducts($category->id, $size, $color, $brand, $attribute, $lowPrice, $highPrice);
      if ($category->parent_category_id == Null || $category->parent_category_id == '') {
        // parent cat
        $categories = Category::where('parent_category_id', $category->id)->get();
      } else {
        // child cat
        $categories = Category::where('parent_category_id', $category->parent_category_id)->where('id', '!=', $category->id)->get();
      }
    } else {
      $category = Category::first();
      // $products = Product::where('category_id', $category->id)->with('productAttributes')->slect('id', 'name', 'slug', 'image', 'item_code')->paginate(10);
      if ($category->parent_category_id == Null || $category->parent_category_id == '') {
        // parent cat
        $categories = Category::where('parent_category_id', $category->id)->get();
      } else {
        // child cat
        $categories = Category::where('parent_category_id', $category->parent_category_id)->where('id', '!=', $category->id)->get();
      }
    }
    $lowPrice = ProductAttr::orderBy('price', 'asc')->pluck('price')->first();
    $highPrice = ProductAttr::orderBy('price', 'desc')->pluck('price')->first();
    $brands = Brand::get();
    $sizes = Size::get();
    $colors = Color::get();
    $attributes = CategoryAttribute::where('category_id', $category->id)->with('attribute')->get();
    return $this->success(['data' => get_defined_vars()], 'Successfully data fetched');
  }

  function getFilterProducts($category_id, $size, $color, $brand, $attribute, $lowPrice, $highPrice)
  {
    $products = Product::where('category_id', $category_id);

    if (sizeof($brand) > 0) {
      $products = $products->whereIn('brand_id', $brand);
    }

    if (sizeof($attribute) > 0) {
      $products = $products->withWhereHas('attribute', function ($q) use ($attribute) {
        $q->whereIn('attribute_value_id', $attribute);
      });
    }

    if (sizeof($size) > 0) {
      $products = $products->withWhereHas('productAttributes', function ($q) use ($size) {
        $q->whereIn('size_id', $size);
      });
    }

    if (sizeof($color) > 0) {
      $products = $products->withWhereHas('productAttributes', function ($q) use ($color) {
        $q->whereIn('color_id', $color);
      });
    }

    if ($lowPrice != '' && $lowPrice != null && $highPrice != '') {
      $products = $products->withWhereHas('productAttributes', function ($q) use ($lowPrice, $highPrice) {
        $q->whereBetween('price', [$lowPrice, $highPrice]);
      });
    }

    $products = $products->with('productAttributes')->select('id', 'name', 'slug', 'image', 'item_code')->paginate(10);
    return $products;
  }





  public function getUserData(Request $request)
  {
      $token = $request->token;
  
      if (!$token) {
          $newToken = generateRandomString();
          $user_id = rand(11111, 99999);
          $time = now();
  
          TempUsers::create([
              'user_id' => $user_id,
              'token' => $newToken,
              'created_at' => $time,
              'updated_at' => $time
          ]);
  
          return response()->json([
              'status' => 'Success',
              'message' => 'New user created',
              'data' => ['user_type' => 2, 'token' => $newToken]
          ], 200);
      }
  
      $checkUser = TempUsers::where('token', $token)->first();
  
      if ($checkUser) {
          if (checkTokenExpiryInMinutes($checkUser->updated_at, 60)) {
              $newToken = generateRandomString();
              $checkUser->token = $newToken;
              $checkUser->updated_at = now();
              $checkUser->save();
              $token = $newToken;
          }
  
          return response()->json([
              'status' => 'Success',
              'message' => 'User data fetched',
              'data' => ['user_type' => $checkUser->user_type, 'token' => $token]
          ], 200);
      }
  
      return response()->json(['status' => 'Error', 'message' => 'Invalid token'], 400);
  }
 
    
  public function getCartData(Request $request)
  {
      Log::info('Received Token:', ['token' => $request->token]);
  
      $validation = Validator::make($request->all(), [
          'token' => 'required|exists:temp_users,token',
      ]);
  
      if ($validation->fails()) {
          Log::error('Validation failed:', $validation->errors()->toArray());
          return response()->json([
              'status' => 'Error',
              'message' => $validation->errors()->first(),
              'data' => []
          ], 400);
      }
  
      $userToken = TempUsers::where('token', $request->token)->first();
      Log::info('User Token Data:', ['user_id' => $userToken->user_id]);
  
      $cartData = Cart::where('user_id', $userToken->user_id)->with('products')->get();
      Log::info('Fetched Cart Data:', $cartData->toArray());
  
      return response()->json([
          'status' => 'Success',
          'message' => 'Cart data fetched successfully',
          'data' => $cartData
      ], 200);
  }
  // public function addToCart(Request $request)
  // {
  //     $validation = Validator::make($request->all(), [
  //         'token' => 'required|exists:temp_users,token',
  //         'product_id' => 'required|exists:temp_users,product,id',
  //         'product_attr_id' => 'required|exists:temp_users,product_attr,id',
  //         'qty' => 'required|numeric|min:0|not_in:0',
  //     ]);
  
  //     if ($validation->fails()) {
  //         return $this->error($validation->errors()->first(), 400, []);
  //     } else{
  //       $user = TempUsers::where('token', $request->token)->first();
  //       Cart::updateOrCreate(['user_id'=>$user->user_id,'product_id'=>$request->product_id,
  //       'product_attr_id'=>$request->product_attr_id],
  //       ['user_id'=>$user->user_id,'product_id'=>$request->product_id,
  //       'product_attr_id'=>$request->product_attr_id,'qty'=>$request->qty,'user_type'=>$user->user_type]
  //     );
  //       return $this->success(['data' => $user], 'Successfully fetched data');
  //     }
  // }
  
 
  public function addToCart(Request $request) 
{
    $validation = Validator::make($request->all(), [
        'token' => 'required|exists:temp_users,token',
        'product_id' => 'nullable|exists:products,id',  
        'product_attr_id' => 'nullable|exists:product_attrs,id',  
        'qty' => 'nullable|numeric|min:1',  
    ]);

    if ($validation->fails()) {
        return response()->json([
            'error' => true,
            'message' => $validation->errors()->first()
        ], 400);
    }

    return response()->json([
        'error' => false,
        'message' => 'Item added to cart successfully!',
    ], 200);
}

  
}
