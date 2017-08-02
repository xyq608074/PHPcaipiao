<?php
//列表页
class LoginController extends FrontController{

    public function LoginAction(){
        $system = $this->getSystemInfo();
        $nav = $this->getNavInfo();
        //载入页面
        include CUR_VIEW . "login.html";
    }

    //登陆处理
    public function logininfoAction(){
        $membermodel=new MemberModel('member');
        $logininfo=$membermodel->selectByValue("loginname",$_POST['loginname']);

        if ($logininfo['loginname'] != $_POST['loginname'] || $logininfo['loginpwd'] != md5($_POST['loginpwd'])){
            $this->alertLocaltion("index.php?c=login&a=login", "账号或者密码错误!");
        }
        //验证码不得为空
        if ($_POST['code']==''){
            $this->alertLocaltion("index.php?c=login&a=login","验证码不得为空!");
        }
        //验证验证码是否正确
        if ($_POST['code'] != $_SESSION['code']){
            $this->alertLocaltion("index.php?c=login&a=login","验证码错误!");
        }

        $data['id']=$logininfo['id'];
        $data['count']=$logininfo['count']+1;
        $data['logintime']=date("Y-m-d H:i:s");
        $data['lasttime']=$logininfo['logintime'];
        $data['loginip']=$_SERVER['REMOTE_ADDR'];
        $data['lastip']=$logininfo['loginip'];

        if ($membermodel->update($data)){
            $_SESSION['logininfo']=$logininfo;
            $this->alertLocaltion("index.php?c=index&a=index", "登陆成功!");
        }else{
            $this->alertLocaltion("index.php?c=login&a=login", "登陆失败!");
        }
    }

    //退出登陆
    public function logoutAction(){
        unset($_SESSION['logininfo']);
        session_destroy();
        $this->alertLocaltion("index.php?c=login&a=login","");
    }

    //验证码
    public function captchaAction(){
        //载入验证码
        $this->library('captcha');
        //实例化
        $captcha = new Captcha();
        //调用验证码方法
        $captcha->generateCode();
        //获取验证码
        $_SESSION['code']=$captcha->getCode();
    }

}