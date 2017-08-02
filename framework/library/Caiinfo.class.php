<?php
class Caiinfo{
    private $dejson;
    private $caiinfo;
    private $opencode;

    public function __construct($url){
        $xml=simplexml_load_file($url);
        $json=json_encode($xml);
        $this->dejson=json_decode($json,true);
    }

    //获取 开奖信息
    public function caiinfo(){
        foreach ($this->dejson['row'] as $v){
            $this->caiinfo=$v["@attributes"];
            return $this->caiinfo;
        }
    }

    public function allcaiinfo(){
        $this->caiinfo=$this->dejson['row'];
        return $this->caiinfo;
    }


    //获取 开奖号码
    public function caiopencode(){
        $this->opencode=explode(',',$this->caiinfo['opencode']);
        return $this->opencode;
    }

    //获取冠亚和
    public function guanyahe(){
        $guanya=array('num'=>'','daxiao'=>'','danshuang'=>'');
        //和
        $guanya['num']=$this->opencode[0]+$this->opencode[1];
        //大小
        if($guanya['num']>11){
            $guanya['daxiao']="大";
        }else{
            $guanya['daxiao']="小";
        }
        //单双
        if ($guanya['num']%2===0){
            $guanya['danshuang']="双";
        }else{
            $guanya['danshuang']="单";
        }

        return $guanya;
    }

    //龙虎
    public function longhu(){
     $longhu=array();
        for($i=0;$i<5;$i++){
            if ($this->opencode[$i] > $this->opencode[count($this->opencode)-$i-1]) {
                $longhu[$i] = "<span style='color:red;'>龍</span>";
            } else {
                $longhu[$i] = "虎";
            }
        }
        return $longhu;
    }

    //重庆综合
    public function cqzonghe(){
        $cqzonghe=array('num'=>'','daxiao'=>'','danshuang'=>'');
        //和
        for ($i=0;$i<count($this->opencode);$i++) {
            $cqzonghe['num'] += $this->opencode[$i];
        }
        //大小
        if($cqzonghe['num']>22){
            $cqzonghe['daxiao']="大";
        }else{
            $cqzonghe['daxiao']="小";
        }
        //单双
        if ($cqzonghe['num']%2===0){
            $cqzonghe['danshuang']="双";
        }else{
            $cqzonghe['danshuang']="单";
        }

        return $cqzonghe;
    }

    //重庆龙虎
    public function cqlonghu(){
        if($this->opencode[0] > $this->opencode[4]){
            $cqlonghu = "<span style='color:red;'>龍</span>";
        } else {
            $cqlonghu = "虎";
        }
        return $cqlonghu;
    }


}