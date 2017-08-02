<?php
class MemberController extends Controller{

    protected $membermodel;
    protected $ipaddress;

    public function __construct(){
        $this->membermodel = new MemberModel("member");
        $this->library('IP');
        $this->ipaddress = new IP();
    }

    public function MemberAction(){
        //先获取当前分页的记录
        $current=isset($_GET['page'])?$_GET['page']:1;
        //分页获取信息
        $offset=($current -1 )*PAGESIZE;
        $memberlist=$this->membermodel->getpagemember($offset,PAGESIZE);

        //查询总记录数
        $total=$this->membermodel->total();
        $this->library('page');
        $page=new Page($total,PAGESIZE,$current);

        include CUR_VIEW."member.html";
    }

    //载入插入页面
    public function addmemberAction(){
        include CUR_VIEW."addmember.html";
    }
    //执行插入
    public function addAction(){

        $this->helper('input');

        if($name=$this->membermodel->selectByValue("loginname",$_POST['loginname'])){
            $this->alertLocaltion("index.php?p=admin&c=member&a=addmember", "用户名已注册!");
        }

        if(mb_strlen(htmlchar_slashes_trim($_POST['loginname'],"utf-8"))<2 || mb_strlen(htmlchar_slashes_trim($_POST['loginname'],"utf-8"))>20){
            $this->alertLocaltion("index.php?p=admin&c=member&a=addmember","用户名不得小于2位 或者 不得大于20位");
        }else{
            $data['loginname']=htmlchar_slashes_trim($_POST['loginname']);
        }

        if(mb_strlen($_POST['loginpwd'],"utf-8") < 6){
            $this->alertLocaltion("index.php?p=admin&c=member&a=addmember","密码不得小于6位");
        }else{
            if($_POST['loginpwd'] === $_POST['notpwd']){
                $data['loginpwd']=md5($_POST['loginpwd']);
            }else{
                $this->alertLocaltion("index.php?p=admin&c=member&a=addmember","两次输入的密码不一致");
            }
        }

        $data['email']=htmlchar_slashes_trim($_POST['email']);
        $data['phone']=htmlchar_slashes_trim($_POST['phone']);

        if ($this->membermodel->insert($data)){
            $this->alertLocaltion("index.php?p=admin&c=member&a=member","添加成功!");
        }else{
            $this->alertLocaltion("index.php?p=admin&c=member&a=addmember","添加失败!");
        }
    }

    //载入修改页面
    public function updatememberAction(){
        $updateinfo=$this->membermodel->selectByPk($_GET['id']);
        include CUR_VIEW."updatemember.html";
    }
    //执行修改
    public function updateAction(){
        $this->helper('input');
        $data['id']=$_POST['id'];

        if(mb_strlen($_POST['loginpwd'],'utf-8') < 6){
            $this->alertLocaltion("index.php?p=admin&c=member&a=updatemember","密码不得小于6位");
        }else{
            $data['loginpwd']=md5($_POST['loginpwd']);
        }

        $data['email']=htmlchar_slashes_trim($_POST['email']);
        $data['phone']=htmlchar_slashes_trim($_POST['phone']);

        if ($this->membermodel->update($data)) {
            $this->alertLocaltion("index.php?p=admin&c=member&a=member", "修改成功!");
        } else {
            $this->alertLocaltion("index.php?p=admin&c=member&a=updatemember", "修改失败!");
        }
    }
    
    //执行删除
    public function deleteAction(){
        if($this->membermodel->delete($_GET['id'])){
            $this->alertLocaltion("index.php?p=admin&c=member&a=member", "删除成功!");
        }else{
            $this->alertLocaltion("index.php?p=admin&c=member&a=member", "删除失败!");
        }
    }

    //获取IP地址所在地
    public function getiptoaddress($ip){
        $ipaddr=$this->ipaddress->GetIpLookup($ip);
        return $ipaddr['country'].$ipaddr['province'].$ipaddr['city'];
    }
}