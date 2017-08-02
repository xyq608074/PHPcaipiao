<?php
class Plan{
    protected $dejson;

    //获取计划列表
    public function planList($url){
        $fgc=file_get_contents($url);
        $this->dejson=json_decode($fgc,true);
        return $this->dejson['d'];
    }

//    //获取计划最新期数
//    public function planExpect($url){
//        $fgc=file_get_contents($url);
//        $this->dejson=json_decode($fgc,true);
//        return $this->dejson['d'];
//    }

    //获取计划
    public function planJihua($content){
        $fgc=file_get_contents($content);
        $this->dejson=json_decode($fgc,true);
        return $this->dejson['d'];
    }
}
