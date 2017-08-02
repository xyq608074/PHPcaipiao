<?php
class NavController extends BaseController{

    protected $navmodel;
    
    public function __construct(){
        $this->navmodel=new NavModel('nav');
    }

    //导航列表
    public function navAction(){
        //先获取当前分页的记录
        $current=isset($_GET['page'])?$_GET['page']:1;
        //在做分页获取信息
        $offset=($current - 1) * PAGESIZE;
        $navlist=$this->navmodel->getPageNav($offset,PAGESIZE);

        //查询总记录数
        $total=$this->navmodel->total();
        //引入Page分页类
        $this->library('Page');
        $page = new Page($total,PAGESIZE,$current);

        include CUR_VIEW.'nav.html';
    }

    //添加导航
    public function addnavAction(){
        $navlist=$this->navmodel->getNav();
        include CUR_VIEW.'addnav.html';
    }

    //执行添加动作方法
    public function insertAction(){
        //收集信息
        $this->helper('input');
        $data['nav_name']=htmlchar_slashes_trim($_POST['nav_name']);
        $data['nav_info']=htmlchar_slashes_trim($_POST['nav_info']);
        $data['sort']=$_POST['sort'];
        $data['is_show']=$_POST['is_show'];

        //验证信息
        if ($data['nav_name']===''){
            $this->alertLocaltion('index.php?p=admin&c=nav&a=addnav','导航名称不的为空');
        }
        //进入数据库
        if ($this->navmodel->insert($data)){
            $this->alertLocaltion('index.php?p=admin&c=nav&a=nav','添加导航成功!');
        }else{
            $this->alertLocaltion('index.php?p=admin&c=nav&a=addnav','添加导航失败!');
        }
    }


    //修改导航
    public function editAction(){
        $nav_id=$_GET['parent_id'];
        $nav=$this->navmodel->selectByPk($nav_id);
        $navs=$this->navmodel->getNav();

        include CUR_VIEW.'editnav.html';
    }
    //执行修改动作方法
    public function updateAction(){
        //收集信息
        $data['id']=$_POST['id'];
        $this->helper('input');
        $data['nav_name']=htmlchar_slashes_trim($_POST['nav_name']);
        $data['nav_info']=htmlchar_slashes_trim($_POST['nav_info']);
        $data['parent_id']=$_POST['parent_id'];
        $data['sort']=$_POST['sort'];
        $data['is_show']=$_POST['is_show'];
        //验证信息
        if ($data['nav_name']===''){
            $this->alertLocaltion('index.php?p=admin&c=nav&a=edit','导航名称不的为空');
        }
        //进入数据库
        $navModel=new NavModel('nav');
        if ($navModel->update($data)){
            $this->alertLocaltion('index.php?p=admin&c=nav&a=nav','修改导航成功!');
        }else{
            $this->alertLocaltion('index.php?p=admin&c=nav&a=edit','修改导航失败!');
        }
    }


    //删除导航
    public function deleteAction(){
        //获得要删除的id
        $nav_id=$_GET['parent_id'];

        if ($this->navmodel->delete($nav_id)){
            $this->alertLocaltion('index.php?p=admin&c=nav&a=nav','删除导航成功!');
        }else{
            $this->alertLocaltion('index.php?p=admin&c=nav&a=nav','删除导航失败!');
        }
    }

    //排序nav
    public function sortnavAction(){
        if($this->navmodel->sort($_POST['sort'])){
            $this->alertLocaltion('index.php?p=admin&c=nav&a=nav','',0);
        }
    }
}