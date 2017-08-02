<?php
class Upload{
    private $uploadpath; //上传目录路径
    private $uploadMax; //上传最大值
    private $uploadErrno; //错误号
    private $mine=array('image/jpg','image/png','image/gif','image/jpeg'); //允许上传格式
    //初始化数据
    public function __construct($path=UPLOADS){
        $this->uploadpath=$path;    //目录路径
        $this->uploadMax=1000000;   //上传最大值
    }


    //上传
    public function moveUpload($file){
        //指定上传的目录
        $datedir=date('Ymd').'/';
        //判断是否存在目录 如果不存在 则创建文件夹
        if(!is_dir($this->uploadpath.$datedir)){
            mkdir($this->uploadpath.$datedir);
        }

        //从新指定文件名 时间+随机数+文件后缀名
        $filename=date('YmdHis').uniqid().strrchr($file['name'],'.');

        //上传
        if(move_uploaded_file($file['tmp_name'],$this->uploadpath.$datedir.$filename)){
            return $datedir.$filename;
        }else{
            return false;
        }
    }
}