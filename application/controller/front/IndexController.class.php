<?php
//列表页
class IndexController extends FrontController{

    public function IndexAction(){
        $system = $this->getSystemInfo();
        $nav = $this->getNavInfo();

        //载入页面
        include CUR_VIEW . "index.html";
    }
}