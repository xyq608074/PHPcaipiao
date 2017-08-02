<?php
class SystemModel extends ModelDB {
    //获取所有系统基本信息
    public function getSystem(){
        $sql="select * from {$this->table}";
        return $this->db->getAll($sql);
    }
}