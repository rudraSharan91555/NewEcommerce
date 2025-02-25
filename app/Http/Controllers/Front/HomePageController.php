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
      {
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
      $data['categories'] = Category::get();
      $data['brands'] = Brand::get();
      return $this->success(['data'=>$data],'Successfully data fetched');
    }

}