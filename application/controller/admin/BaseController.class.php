<?php
class BaseController extends Controller{
    public function __construct(){
        $this->setloginAction();
    }

    public function setloginAction(){
        if (empty($_SESSION['userinfo'])){
            $this->alertLocaltion("index.php?p=admin&c=login&a=login","");
        }
    }
}