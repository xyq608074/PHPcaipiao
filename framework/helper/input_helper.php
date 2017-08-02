<?php

//转义成html实体标签
function htmlchar($data){
    //判断存在
    if (empty($data)){
        return $data;
    }
    //判断传过来的变量是数组还是单个变量
    return is_array($data) ? array_map('htmlchar',$data) : htmlspecialchars($data);
}

//转义
function slashes($data){
    //判断存在
    if (empty($data)){
        return $data;
    }
    //判断传过来的变量是数组还是单个变量
    if(!get_magic_quotes_gpc()) {
        return is_array($data) ? array_map('slashes', $data) : addslashes($data);
    }else{
        return is_array($data) ? array_map('slashes', $data) : $data;
    }
}

//集合 转义实体符 转义符号 去中间空格 去除两遍空格
function htmlchar_slashes_trim($data){
    $str=htmlchar($data);
    $str=slashes($str);
//    $str=str_replace(" ","",$str); //去除中间空格
    return trim($str);
}

