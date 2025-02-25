<?php

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