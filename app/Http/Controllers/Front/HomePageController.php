<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    use ApiResponse;
    public function  getHomeData(){
        $data = [];
        $data['banner'] = HomeBanner::get();
        return $this->success(['data'=>$data],'Sucessfully data fetched');
    }
}
