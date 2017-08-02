<?php
class ModelDB{
    protected $db;//数据库连接对象
    protected $table;//表名
    protected $field=array();//字段列表

    public function __construct($table){
        $dbconfig['host']=$GLOBALS['config']['host'];
        $dbconfig['port']=$GLOBALS['config']['port'];
        $dbconfig['dbuser']=$GLOBALS['config']['dbuser'];
        $dbconfig['dbpwd']=$GLOBALS['config']['dbpwd'];
        $dbconfig['charset']=$GLOBALS['config']['charset'];
        $dbconfig['dbname']=$GLOBALS['config']['dbname'];

        $this->db=new MysqlDB($dbconfig);
        $this->table=$GLOBALS['config']['prefix'].$table;
        $this->getField();
    }

    /**
     * 获取 表 中的字段列表
     */
    public function getField(){
        //使用sql语句查出来表中的所有字段的属性
        $sql="desc {$this->table}";
        //获取所有字段
        $result=$this->db->getAll($sql);
        //如果有主键 取出主键 保存变量$pk
        foreach ($result as $value){
            $this->field[]=$value['Field'];
            if($value['Key']=='PRI'){
                $pk=$value['Field'];
            }
        }


        //如果有主键值  放入field数组里面
        if (isset($pk)){
            $this->field['pk']=$pk;
        }
    }

    /**
     * 插入模板
     * @param $list传入一个数组
     * @return 最后执行成功返回真  执行失败返回假
     */
    public function insert($list){
        $field_list='';//字段列表字符串
        $value_list='';//值列表字符串

        foreach ($list as $key=>$value){
            if (in_array($key,$this->field)){
                $field_list.="{$key}".",";
                $value_list.="'".mysql_real_escape_string($value)."'".",";
            }
        }
        $field_list=rtrim($field_list,',');
        $value_list=rtrim($value_list,',');

        $sql="insert into {$this->table} ({$field_list}) values ({$value_list})";

        //执行语句 如果执行成功返回真  如果执行失败返回假
        if($this->db->query($sql)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 删除模板
     * @param $pk就是获取点击的id
     * @return 如果为真删除成功  如果为假删除失败
     */
    public function delete($pk){
        if (is_array($pk)){
            $where="{$this->field['pk']} in (".implode(',',$pk).")";
        }else{
            $where ="{$this->field['pk']}=$pk";
        }
        $sql="delete from {$this->table} where {$where}";

        //执行语句 如果执行成功返回真  如果执行失败返回假
        if($this->db->query($sql)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 更新语句
     * @param $list 传进去的一个数组
     * @return 返回真修改数据  返回假返回不修改数据
     */
    public function update($list){
        $updatelist='';

        foreach($list as $key=>$value){
            //判断是否是主键列
            if (in_array($key,$this->field)) {
                if ($key == $this->field['pk']) {
                    $where = "{$key}={$value}";
                } else {//非主键列
                    $value=mysql_real_escape_string($value);
                    $updatelist .= "{$key}='{$value}'" . ',';
                }
            }
        }
        $updatelist=rtrim($updatelist,',');
        $sql="update {$this->table} set {$updatelist} where {$where}";

        //执行语句 如果执行成功返回真  如果执行失败返回假
        if($this->db->query($sql)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 查询语句
     * @return array 返回查询的所有结果
     */
    public function select(){
        $sql="select * from {$this->table}";
        return $this->db->getAll($sql);
    }

    /**
     * 查询一条数据 根据传进来的主键 id
     * @param $pk
     * @return 返回给数据库连接类 执行 得出一行数据
     */
    public function selectByPk($pk){
        $sql="select * from {$this->table} where {$this->field['pk']}=$pk";
        return $this->db->getRow($sql);
    }

    /**
     * 根据传过来的字段和字段值来查询
     * @param $name 字段名
     * @param $value 比较的值
     * @return array|bool
     */
    public function selectByValue($name,$value){
        $sql="select * from {$this->table} where $name='$value'";
        return $this->db->getRow($sql);
    }

    /**
     * 获取总记录数
     * @param $where 一个查询条件
     * 如果没有$where 执行没有条件的 获取总记录数语句
     * 如果有$where 执行有条件的 总记录数语句
     */
    public function total($where=""){
        if (empty($where)) {
            $sql = "select count(*) from {$this->table}";
        }else{
            $sql ="select count(*) from {$this->table} where {$where}";
        }
        return $this->db->getOne($sql);
    }

    /**
     * 连表查询
     * @param $table1
     * @param $table2
     * @param string $where
     * @return array|bool
     */
    public function selectTo($field,$table1,$table2,$where=''){
        $sql="select $field from $table1,$table2 $where";
        return $this->db->getRow($sql);
    }
}