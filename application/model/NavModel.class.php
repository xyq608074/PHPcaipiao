<?php
class NavModel extends ModelDB {
    //获取所有栏目列表
    public function getNav(){
        $sql="select * from {$this->table} order by sort asc";
        return $this->db->getAll($sql);
    }

    //获取栏目列表为父级parent_id=0的
    public function getPageNav($offset,$pagesize){
        $sql="select * from {$this->table} order by sort asc limit $offset,$pagesize";
        return $this->db->getAll($sql);
    }

    //排序
    public function sort($data){
        foreach ($data as $key=>$value){
            $sql[]="update {$this->table} set sort='$value' where id={$key};";
        }
        foreach ($sql as $value) {
            $this->db->query($value);
        }
        return 1;
    }
}