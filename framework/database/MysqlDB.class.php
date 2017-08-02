<?php
header('Content-Type:text/html;charset=utf8');
class MysqlDB{

    //连接结果
    protected $conn;

    //sql语句
    protected $sql;

    //构造函数
    public function __construct($config=array()){
        //初始化连接数据库数据
        $host=isset($config['host'])? $config['host'] : 'localhost';
        $port=isset($config['port'])? $config['port'] : '3306';
        $dbuser=isset($config['dbuser'])? $config['dbuser'] : 'root';
        $dbpwd=isset($config['dbpwd'])? $config['dbpwd'] : '';
        $charset=isset($config['charset'])? $config['charset'] : 'utf8';
        $dbname=isset($config['dbname'])? $config['dbname'] : '';

        //连接数据库
        $this->conn=mysql_connect("$host:$port",$dbuser,$dbpwd)or die('数据库连接失败!');
        //选择数据库
        $this->conn=mysql_select_db($dbname) or die ('选择数据库失败!');
        //调用设置字符编码
        $this->setcharset($charset);
    }

    public function __destruct(){
        //关闭数据库
        @mysql_close($this->conn);
    }

    //设置字符编码集方法
    private function setcharset($charset){
        $this->query("set names $charset");
    }

    //设置执行数据库语句query
    public function query($sql){
        $this->sql=$sql;
        $result=mysql_query($this->sql);
        if (!$result){
            die($this->errno().':'.$this->error().'<br />出错语句为'.$this->sql.'<br />');
        }
        return $result;
    }

    //查询所有数据
    public function getAll($sql){
        $result=$this->query($sql);
        $list=array();
        while($row=mysql_fetch_assoc($result)){
            $list[]=$row;
        }
        return $list;
    }

    /**
     * 查询出一行数据
     * @param $sql 传入一条sql语句
     * @return array|bool 如果为真 返回一行数据 如果为假 返回假
     */
    public function getRow($sql){
        if($result=$this->query($sql)){
            $row=mysql_fetch_assoc($result);
            return $row;
        }else{
            return false;
        }
    }

    /**
     * 查询一条数据的第一个数据
     * @param $sql 传入一条sql语句
     * @return bool 返回查出当前行的第一条数据  如果为假 就返回一个假
     */
    public function getOne($sql){
        $result=$this->query($sql);
        $row=mysql_fetch_row($result);
        if ($row){
            return $row[0];
        }else{
            return false;
        }
    }

    //错误号
    private function errno(){
        return @mysql_errno($this->conn);
    }

    //错误信息
    private function error(){
        return @mysql_error($this->conn);
    }
}