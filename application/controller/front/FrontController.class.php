<?php
class FrontController extends Controller{

    //获取网站基本信息
    public function getSystemInfo(){
        //显示系统基本信息
        $systemlist=new SystemModel('system');
        return $systemlist->getSystem();
    }

    //获取栏目信息
    public function getNavInfo(){
        //栏目信息
        $navlist=new  NavModel('nav');
        return $navlist->getNav();
    }
}