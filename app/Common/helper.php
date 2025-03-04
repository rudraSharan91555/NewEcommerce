<?php

use Carbon\Carbon;

function prx($arr)
{
    echo "<pre>";
    print_r($arr);
    die();
}

function replceStr($str)
{
    // prx($str);
    $string = str_replace(array('[\', \']'), '', $str);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
    return strtolower(trim($string, '-'));
}


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