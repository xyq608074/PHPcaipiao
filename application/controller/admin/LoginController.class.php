<?php
//登陆控制器
class LoginController extends Controller{
    //载入登陆页面
    public function LoginAction(){
        include CUR_VIEW.'admin_login.html';
    }

    //处理登陆动作
    public function signinAction(){
        $this->helper('input');
        //用户名密码
        $adminuser=htmlchar_slashes_trim($_POST['admin_user']);
        $adminpwd=htmlchar_slashes_trim($_POST['admin_pass']);

        //验证码
        $admincode=htmlchar_slashes_trim($_POST['code']);


        //验证用户名
        if ($adminuser==''){
            $this->alertLocaltion("index.php?p=admin&c=login&a=login","用户名不得为空!");
        }
        //密码不得为空
        if ($adminpwd==''){
            $this->alertLocaltion("index.php?p=admin&c=login&a=login","密码不得为空!");
        }
        //验证码不得为空
        if ($admincode==''){
            $this->alertLocaltion("index.php?p=admin&c=login&a=login","验证码不得为空!");
        }
        //验证验证码是否正确
        if ($admincode!=$_SESSION['code']){
            $this->alertLocaltion("index.php?p=admin&c=login&a=login","验证码错误!");
        }

        $adminModel=new adminModel("admin");
        $userinfo=$adminModel->userInfo($adminuser,$adminpwd);

        if(empty($userinfo)){
            //账号密码错误
            $this->alertLocaltion("index.php?p=admin&c=login&a=login","账号或密码错误!");
        }else{
            //登陆成功 session存储用户信息
            $_SESSION['userinfo']=$userinfo;
            $adminModel->loginCount($userinfo['id']);
            $adminModel->lastIp($userinfo['login_ip'],$userinfo['id']);
            $adminModel->loginIp($userinfo['id']);
            $adminModel->lastTime($userinfo['login_time'],$userinfo['id']);
            $adminModel->loginTime($userinfo['id']);
            $this->alertLocaltion("index.php?p=admin&c=index&a=index","登陆成功!");
        }
    }

    //退出登陆
    public function logoutAction(){
        unset($_SESSION['userinfo']);
        session_destroy();
        $this->alertLocaltion("index.php?p=admin&c=login&a=login","");
    }

    //验证码
    public function captchaAction(){
        //载入验证码
        $this->library('Captcha');
        //实例化
        $captcha = new Captcha();
        //调用验证码方法
        $captcha->generateCode();
        //获取验证码
        $_SESSION['code']=$captcha->getCode();
    }
}