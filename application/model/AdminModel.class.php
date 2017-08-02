<?php
class AdminModel extends ModelDB{

    //查询所有管理员
    public function getAdmin(){
        $sql="select * from {$this->table} order by id desc";
        return $this->db->getAll($sql);
    }

    //查询所有管理员 带分页
    public function getPageAdmin($offset,$pagesize){
        $sql="select * from {$this->table} order by id desc limit $offset,$pagesize";
        return $this->db->getAll($sql);
    }

    //验证登陆
    public function userinfo($username,$userpwd){
        $userpwd=md5($userpwd);
        $sql="select * from admin where admin_name='$username' and admin_pwd='$userpwd' limit 1";
        return $this->db->getRow($sql);
    }

    //登陆成功 登陆次数加1
    public function loginCount($id){
        $sql="update {$this->table} set login_count=login_count+1 where id=$id";
        return $this->db->query($sql);
    }

    //登陆后获取上一次ip
    public function lastIp($ip,$id){
        $sql="update {$this->table} set last_ip='$ip' where id=$id";
        return $this->db->query($sql);
    }

    //登陆成功后获取到登陆的ip
    public function loginIp($id){
        $ip=$_SERVER['REMOTE_ADDR'];
        $sql="update {$this->table} set login_ip='$ip' where id=$id";
        return $this->db->query($sql);
    }


    //登陆后获取上一次ip
    public function lastTime($time,$id){
        $sql="update {$this->table} set last_time='$time' where id=$id";
        return $this->db->query($sql);
    }

    //获取登陆的时间
    public function loginTime($id){
        $time=date("Y-m-d H:i:s");
        $sql="update {$this->table} set login_time='$time' where id=$id";
        return $this->db->query($sql);
    }

}