<?php
class AdminController extends BaseController{
    protected $adminmodel;

    public function __construct(){
        $this->adminmodel=new AdminModel("admin");
    }

    //列表页面
    public function AdminAction(){
        //调用查询所有管理员
//        $adminlist=$this->adminmodel->getAdmin();

        //分页
        //获取总记录数
        $total=$this->adminmodel->total();
        //获取当前页面
        $current=isset($_GET['page'])?$_GET['page']:1;
        //调用查询所有管理员带分页
        $offset=($current - 1)*PAGESIZE;
        $adminlist=$this->adminmodel->getPageAdmin($offset,PAGESIZE);
        //实例化分页 调用
        $this->library('Page');
        $page = new Page($total,PAGESIZE,$current);

        //载入管理员列表页面
        include CUR_VIEW."adminmanage.html";
    }

    //添加页面
    public function addAdminAction(){
        include CUR_VIEW."addadmin.html";
    }
    //添加动作
    public function addAction(){

        $this->helper('input');
        //获取post提交过来的信息 并且转义
        $admin_name=htmlchar_slashes_trim($_POST['admin_name']);
        $admin_pwd=md5($_POST['admin_pwd']);
        $data['admin_name']=$admin_name;
        $data['admin_pwd']=$admin_pwd;
        $data['login_ip']=$_SERVER['REMOTE_ADDR'];
        $data['login_time']=date("Y-m-d H:i:s");

        //验证信息
        if (empty($data['admin_name'])){
            $this->alertLocaltion('index.php?p=admin&c=admin&a=addadmin','用户名不得为空');
        }
        if(empty($data['admin_pwd']) || empty($_POST['admin_pwd'])){
            $this->alertLocaltion('index.php?p=admin&c=admin&a=addadmin','密码或者密码确认不得为空');
        }
        if($data['admin_pwd'] != md5($_POST['confirm_pass'])){
            $this->alertLocaltion('index.php?p=admin&c=admin&a=addadmin','密码与确认密码不符');
        }
        if ($this->adminmodel->selectByValue('admin_name',$data['admin_name'])){
            $this->alertLocaltion('index.php?p=admin&c=admin&a=addadmin','用户名已存在!');
        }

        //插入数据库
        if ($this->adminmodel->insert($data)){
            $this->alertLocaltion('index.php?p=admin&c=admin&a=admin','添加成功!');
        }else{
            $this->alertLocaltion('index.php?p=admin&c=admin&a=addadmin','添加失败!');
        }
    }

    //修改页面
    public function updateadminAction(){

        //获取一条需要修改的信息
        $updateone=$this->adminmodel->selectByPk($_GET['id']);
        //载入修改管理员页面
        include CUR_VIEW."updateadmin.html";
    }

    //执行修改
    public function updateAction(){
        $this->helper('input');
        $data['id']=$_POST['id'];
        $data['admin_name']=htmlchar_slashes_trim($_POST['admin_name']);
        $data['admin_pwd']=md5($_POST['admin_pwd']);

        if($this->adminmodel->update($data)){
            $this->alertLocaltion("index.php?p=admin&c=admin&a=admin","修改成功!");
        }else{
            $this->alertLocaltion("index.php?p=admin&c=admin&a=update","修改失败");
        }
    }
    
    //删除页面
    public function deleteAction(){
        if($this->adminmodel->delete($_GET['id'])){
            $this->alertLocaltion("index.php?p=admin&c=admin&a=admin","删除成功!");
        }
        else{
            $this->alertLocaltion("index.php?p=admin&c=admin&a=admin","删除失败");
        }
    }
}