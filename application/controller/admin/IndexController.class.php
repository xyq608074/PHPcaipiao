<?php
class IndexController extends BaseController {
    public function indexAction(){
        include CUR_VIEW.'admin.html';
    }
    public function topAction(){
        include CUR_VIEW.'top.html';
    }
    public function sidebarAction(){
        include CUR_VIEW.'sidebarsystem.html';
    }
    public function mainAction(){
//        include CUR_VIEW.'main.html';
        $adminModel=new adminModel('nav');
    }

    //内容菜单
    public function sidebarnAction(){
        include CUR_VIEW.'sidebarn.html';
    }

    //系统菜单
    public function sidebarsystemAction(){
        include CUR_VIEW.'sidebarsystem.html';
    }

    //会员菜单
    public function sidebarmemberAction(){
        include CUR_VIEW.'sidebarmember.html';
    }
}