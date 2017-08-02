<?php
//基础控制器类
class Controller{
    public function alertLocaltion($url,$message){
        if(!empty($message)){
            echo "<script type='text/javascript'>alert('$message');location.href='$url';</script>";
        }else{
            header('Location:'.$url);
        }
        exit();
    }

    public function alertClose($message=''){
        if (!empty($message)) {
            echo "<script type='text/javascript'>alert('$message');location.close();</script>";
        }else{
            echo "<script type='text/javascript'>window.close();</script>";
        }
    }

    //载入工具
    public function library($lib){
        include LIBRARY."{$lib}.class.php";
    }
    //辅助函数
    public function helper($help){
        include HELPER."{$help}_helper.php";
    }
}