<?php
//入口文件
error_reporting(0);
//中文
header("Content-Type:text/html;charset=utf-8");
//加载核心文件
include 'framework/core/Framework.class.php';

//运行核心文件
Framework::run();


?>