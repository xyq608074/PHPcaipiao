<?php

//核心类
class Framework{
    public static function run(){
        self::init();
        self::autoload();
        self::router();
    }

    //定义一个初始化方法
    public static function init(){
        //utf8字符
        header('Content-Type:text/html;charset=utf-8');
        //开启session
        session_start();
        //设置时间格式
        date_default_timezone_set("PRC");
        //分页
        define('PAGESIZE',5);
        //网站跟目录
        define('ROOT',getcwd().DIRECTORY_SEPARATOR);
        //定义当前项目中所有的路径
        define('APP',ROOT.'application'.DIRECTORY_SEPARATOR);
            define('CONFIG',APP.'config'.DIRECTORY_SEPARATOR);
            define('CONTROLLER',APP.'controller'.DIRECTORY_SEPARATOR);
            define('MODEL',APP.'model'.DIRECTORY_SEPARATOR);
            define('VIEW',APP.'view'.DIRECTORY_SEPARATOR);
        define('FRAMEWORK',ROOT.'framework'.DIRECTORY_SEPARATOR);
            define('CORE',FRAMEWORK.'core'.DIRECTORY_SEPARATOR);
            define('DATABASE',FRAMEWORK.'database'.DIRECTORY_SEPARATOR);
            define('HELPER',FRAMEWORK.'helper'.DIRECTORY_SEPARATOR);
            define('LIBRARY',FRAMEWORK.'library'.DIRECTORY_SEPARATOR);
        define('PUBLICPATH',ROOT.'public'.DIRECTORY_SEPARATOR);

        define('UPLOADS',PUBLICPATH.'uploads'.DIRECTORY_SEPARATOR);

        //控制器定义 ,解析url中的参数 可以确定具体的路径
        define('PLATFORM',isset($_REQUEST['p'])?$_REQUEST['p']:"front");
        define('CON',isset($_REQUEST['c'])?ucfirst($_REQUEST['c']):'index');
        define('ACTION',isset($_REQUEST['a'])?$_REQUEST['a']:'index');
        //当前controller
        define('CUR_CONTROLLER',CONTROLLER.PLATFORM.DIRECTORY_SEPARATOR);
        //当前视图
        define('CUR_VIEW',VIEW.PLATFORM.DIRECTORY_SEPARATOR);

        //手动加载类
        include CORE.'Controller.class.php';//手动加载核心基础控制器类
        include CORE.'ModelDB.class.php';//手动加载模型类
        include DATABASE.'MysqlDB.class.php';//手动加载数据类
        $GLOBALS['config']=include CONFIG.'config.php';

    }

    //定义路由功能
    public static function router(){
        //确定类的名称
        $controller_name=CON.'Controller';
        //确定方法的名称
        $action_name=ACTION.'Action';
        //实例化控制器,调用相应的方法
        $controller= new $controller_name;
        $controller->$action_name();
    }

    //自动加载功能
    public static function autoload(){
        spl_autoload_register(array(__CLASS__,"load"));
    }
    //加载方法
    public static function load($classname){
        if (substr($classname,-10)=='Controller'){
            require CUR_CONTROLLER."{$classname}.class.php";
        }elseif(substr($classname,-5)=='Model'){
            require MODEL."{$classname}.class.php";
        }else{
            echo "<script type='text/javascript'>alert('加载文件失败');</script>";
        }
    }
}