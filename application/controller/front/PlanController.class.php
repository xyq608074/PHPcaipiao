<?php
class PlanController extends FrontController{

    protected $plan;

    public function __construct(){
        $this->library('plan');
        $this->plan=new Plan();
    }

    public function planbjAction(){
        include CUR_VIEW . "planbj.html";
    }

    public function plansscAction(){
        include CUR_VIEW . "planssc.html";
    }

    public function planftAction(){
        include CUR_VIEW . "planft.html";
    }

    //pk10计划列表
    public function planlistpk10Action(){
        $planlist=$this->plan->planList('http://120.77.204.124/PK10Service.svc/GetList');
        $planexp=$this->plan->planList('http://120.77.204.124/PK10Service.svc/GetExpect');
        include CUR_VIEW . "planlistbj.html";
    }

    //ssc计划列表
    public function planlistsscAction(){
        $planlist=$this->plan->planList('http://120.77.204.124/sscService.svc/GetList');
        $planexp=$this->plan->planList('http://120.77.204.124/sscService.svc/GetExpect');
        include CUR_VIEW . "planlistssc.html";
    }
    //ft计划列表
    public function planlistftAction(){
        $planlist=$this->plan->planList('http://120.77.204.124/PK10Service.svc/GetList');
        $planexp=$this->plan->planList('http://120.77.204.124/PK10Service.svc/GetExpect');
        include CUR_VIEW . "planlistft.html";
    }

    //bj计划内容
    public function planjihuabjAction(){
        $planjihua=$this->plan->planjihua("http://120.77.204.124/PK10Service.svc/GetJiHua?expect={$_GET['exp']}&name={$_GET['name']}");
        include CUR_VIEW . "planjihuabj.html";
    }

    //ssc计划内容
    public function planjihuasscAction(){
        $planjihua=$this->plan->planjihua("http://120.77.204.124/sscService.svc/GetJiHua?expect={$_GET['exp']}&name={$_GET['name']}");
        include CUR_VIEW . "planjihuassc.html";
    }
    //bj计划内容
    public function planjihuaftAction(){
        $planjihua=$this->plan->planjihua("http://120.77.204.124/PK10Service.svc/GetJiHua?expect={$_GET['exp']}&name={$_GET['name']}");
        include CUR_VIEW . "planjihuaft.html";
    }
}