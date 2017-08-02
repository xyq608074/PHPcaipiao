<?php

class MemberModel extends ModelDB{

    public function getmember(){
        $sql="select * from {$this->table} order by id desc";
        return $this->db->getAll($sql);
    }
    
    public function getpagemember($offset,$pagesize){
        $sql="select * from {$this->table} order by id desc limit $offset,$pagesize";
        return $this->db->getAll($sql);
    }

}