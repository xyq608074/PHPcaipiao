<?php
//列表页
class IframeController extends FrontController{

    public function IframebjAction(){
        //北京pk10

        //获取开奖信息
        $this->library('caiinfo');
        $bjcaiinfo=new Caiinfo('http://b.apiplus.net/newly.do?token=7608eeac2d856f8d&code=bjpk10&rows=10');

        $bjinfo=$bjcaiinfo->caiinfo();
        //获取开奖号码
        $opencodeArr=$bjcaiinfo->caiopencode();

        //获取冠亚和
        $guanyahe=$bjcaiinfo->guanyahe();

        //获取龙虎
        $longhu=$bjcaiinfo->longhu();

        //载入页面
        include CUR_VIEW . "bjpk10.html";
    }


    public function IframecqAction(){
        //重庆时时彩

        //获取开奖信息
        $this->library('caiinfo');
        $cqcaiinfo=new Caiinfo('http://b.apiplus.net/newly.do?token=7608eeac2d856f8d&code=cqssc&rows=10');
        $cqinfo=$cqcaiinfo->caiinfo();

        //获取开奖号码
        $cqopencodeArr=$cqcaiinfo->caiopencode();

        //总和
        $zonghe=$cqcaiinfo->cqzonghe();

        //重庆龙虎
        $cqlonghu=$cqcaiinfo->cqlonghu();

        include CUR_VIEW . "cqssc.html";
    }

    //幸运飞艇
    public function IframeftAction(){
        $this->library('caiinfo');
        $ftcaiinfo=new Caiinfo('http://b.apiplus.net/newly.do?token=7608eeac2d856f8d&code=mlaft&rows=10');
        $ftinfo=$ftcaiinfo->caiinfo();

        //获取开奖号码
        $ftopencodeArr=$ftcaiinfo->caiopencode();

        //总和
        $ftguanyahe=$ftcaiinfo->guanyahe();

        //重庆龙虎
        $ftlonghu=$ftcaiinfo->longhu();

        include CUR_VIEW . "xyft.html";
    }
}