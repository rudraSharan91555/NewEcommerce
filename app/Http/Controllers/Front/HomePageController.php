<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryAttribute;
use App\Models\Color;
use App\Models\HomeBanner;
use App\Models\Product;
use App\Models\ProductAttr;
use App\Models\Size;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    use ApiResponse;

    public function getCategoriesData()
    {
      $data['categories'] = Category::with('subcategories')
      // ->where('parent_category_id', Null)
      ->get();
      return $this->success(['data' => $data], 'Successfully data fetched');
    }

    public function  getHomeData(){
        $data = [];
        $data['banner'] = HomeBanner::get();
        $data['categories'] = Category::with('products:id,category_id,name,slug,image,item_code')->get();
        $data['brands'] = Brand::get();
        $data['products'] = Product::with('productAttributes')->select('id', 'category_id', 'image', 'name', 'slug', 'item_code')->get();
        return $this->success(['data'=>$data],'Sucessfully data fetched');
    }

    // public function getCategoryData($slug='')
    // {
    //   $data = Category::where('slug',$slug)->with('products:id,category_id,name,slug,image,item_code')->get();
    //   return $this->success(['data'=>$data],'Sucessfully data fetched');
    // }
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
        $products = Product::where('category_id', $category->id)->with('productAttributes')->select('id', 'name', 'slug', 'image', 'item_code')->paginate(10);
        // $products = $this->getFilterProducts($category->id, $size, $color, $brand, $attribute, $lowPrice, $highPrice);
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
}
