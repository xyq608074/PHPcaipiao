<?php
//文章模型
class ContentModel extends ModelDB{

    //获取所有数据库中的列表信息
    public function getContent(){
        $sql="select * from {$this->table} order by id desc";
        return $this->db->getAll($sql);
    }
    //获取所有数据库中的列表信息  带分页
    public function getPageContent($offset,$pagesize,$where=''){
        if (empty($where)) {
            $sql = "select * from {$this->table} order by id desc limit $offset,$pagesize";
        }else{
            $sql = "select * from {$this->table} $where order by id desc limit $offset,$pagesize";
        }
        return $this->db->getAll($sql);
    }

    //获取所属栏目
    public function getContentNav(){
        $navmodel=new NavModel('nav');
        return $navmodel->getNav();
    }
}


