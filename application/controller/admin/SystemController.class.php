<?php
//系统基本配置
class SystemController extends BaseController{

    private $systemModel;

    public function __construct(){
        $this->systemModel=new SystemModel('system');
    }

    //显示基本配置页面信息
    public function systemAction(){
        //查找数据库中的系统表
        $systemlist=$this->systemModel->getSystem();
        //载入模板文件
        include CUR_VIEW."system.html";
    }

    //修改配置信息
    public function updateAction(){
        $this->helper('input');
        $data['id']=htmlchar_slashes_trim($_POST['id']);
        $data['webtitlename']=htmlchar_slashes_trim($_POST['webtitlename']);
        $data['webtitle']=htmlchar_slashes_trim($_POST['webtitle']);
        $data['webkeywordsname']=htmlchar_slashes_trim($_POST['webkeywordsname']);
        $data['webkeywords']=htmlchar_slashes_trim($_POST['webkeywords']);
        $data['webdescriptionname']=htmlchar_slashes_trim($_POST['webdescriptionname']);
        $data['webdescription']=htmlchar_slashes_trim($_POST['webdescription']);
        if ($this->systemModel->update($data)){
            $this->alertLocaltion("index.php?p=admin&c=system&a=system","修改成功");
        }else{
            $this->alertLocaltion("index.php?p=admin&c=system&a=system","修改失败");
        }
    }
}