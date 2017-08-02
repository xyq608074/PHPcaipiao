<?php
class ManageController extends BaseController{

    protected $managemodel;

    public function __construct(){
        $managemodel=new ManageModel("admin");
    }

    public function ManageAction(){
        include "";
    }
}