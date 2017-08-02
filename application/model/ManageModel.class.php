<?php
class ManageModel extends ModelDB{
    
    //查询所有
    public function getManage(){
        $sql="select * from {$this->table} order by id desc";
        return $this->db->getAll($sql);
    }
}