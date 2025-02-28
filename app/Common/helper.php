<?php

use Carbon\Carbon;

function prx($arr)
{
    echo "<pre>";
    print_r($arr);
    die();
}

function replaceStr($str)
{
    return(preg_match('/\s+/','_',$str));
}


// Home Page Controller code common //

// public function changeSlug()
//     {
//       $data = Product::get();

//       foreach($data as $list){
//         $result = Product::get();
//         $result->slug = replaceStr($result->name);
//         $result-> save();
//       }
//     }

function checkTokenExpiryInMinutes($time , $timeDiff = 60)
{   
    // prx($time);
    $data = Carbon::parse($time->format('Y-m-d h:i:s a'));
    $now = Carbon::now();

    $diff = $data->diffInMinutes($now);

    if($diff > $timeDiff){
        return true;
    }else{
        return false;
    }
}

function generateRandomString($length = 20)
{
    $ch = '0123456789abcdefghijklmnopqrstwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $len = strlen($ch);
    $str = '';
    for($i = 0;$i<$length;$i++){
        $str .=$ch[random_int(0,$len-1)];
    }

    return $str;

}