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

   
    public function getCategoryData($slug='')
    {
      $data = Category::where('slug',$slug)->with('products:id,category_id,name,slug,image,item_code')->get();
      if($data[0]->parent_category_id == Null || $data[0]->parent_category_id == ''){
        // parent cat
        $cat = Category::where('parent_category_id',$data[0]->id)->get();
      }else{
        // child cat
        $cat = Category::where('parent_category_id',$data[0]->id)->where('id','!=',$data[0]->id)->get();
      }
      $lowPrice = ProductAttr::orderBy('price','asc')->select('price')->first();
      $highPrice = ProductAttr::orderBy('price','desc')->select('price')->first();
      $brands = Brand::get();
      $size = Size::get();
      $color = Color::get();
      return $this->success(['data'=>get_defined_vars()],'Sucessfully data fetched');
    }

}
