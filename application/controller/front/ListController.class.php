<?php
//列表页
class ListController extends FrontController{
    public function listAction(){
        $system=$this->getSystemInfo();
        $nav=$this->getNavInfo();

        $navname=$_GET['nav'];
        switch ($navname){
            case "北京pk拾":
                //北京pk10

                //获取开奖信息
                $this->library('caiinfo');
                $bjcaiinfo=new Caiinfo('http://b.apiplus.net/newly.do?token=7608eeac2d856f8d&code=bjpk10&rows=10');

                $bjinfo=$bjcaiinfo->allcaiinfo();
                //获取开奖号码
                $opencodeArr=$bjcaiinfo->caiopencode();

                //获取冠亚和
                $guanyahe=$bjcaiinfo->guanyahe();

                //获取龙虎
                $longhu=$bjcaiinfo->longhu();

                include CUR_VIEW."bjpk10list.html";
                break;
            case "重庆时时彩":
                //重庆时时彩

                //获取开奖信息
                $this->library('caiinfo');
                $cqcaiinfo=new Caiinfo('http://b.apiplus.net/newly.do?token=7608eeac2d856f8d&code=cqssc&rows=10');
                $cqinfo=$cqcaiinfo->allcaiinfo();

                //总和
                $zonghe=$cqcaiinfo->cqzonghe();

                //重庆龙虎
                $cqlonghu=$cqcaiinfo->cqlonghu();

                include CUR_VIEW."cqssclist.html";
                break;
            case "幸运飞艇":
                //北京pk10

                //获取开奖信息
                $this->library('caiinfo');
                $ftcaiinfo=new Caiinfo('http://b.apiplus.net/newly.do?token=7608eeac2d856f8d&code=mlaft&rows=10');

                $ftinfo=$ftcaiinfo->allcaiinfo();
                //获取开奖号码
                $opencodeArr=$ftcaiinfo->caiopencode();

                //获取冠亚和
                $guanyahe=$ftcaiinfo->guanyahe();

                //获取龙虎
                $longhu=$ftcaiinfo->longhu();

                include CUR_VIEW."xyftlist.html";
                break;
        }
    }
}