<?php

/**
 * 分页类
 * Class Page
 */
class Page{
    private $total; //总记录数
    private $pagesize; //每页显示的记录数
    private $current; //当前记录
    private $pagenum; //总页数
    private $pagefirst; //首页
    private $pageend;   //尾页
    private $prvepage;//上一页
    private $nextpage;//下一页
    private $linkpage; //超链接

    public function __construct($total,$pagesize,$current){
        $this->total=$total;
        $this->pagesize=$pagesize;
        $this->current=$current;
        $this->pagenum=ceil($total/$pagesize);
        $this->linkpage=$this->url(); //连接
        $this->pagefirst=$this->first(); //首页
        $this->pageend=$this->end();    //尾页
        $this->prvepage=$this->prev();  //上一页
        $this->nextpage=$this->next();  //下一页
    }

    /**
     * 获取url
     * @return string 返回一个连接
     */
    private function url(){
        $_url=$_SERVER["REQUEST_URI"];
        $_parse=parse_url($_url);
        parse_str($_parse['query']);
        return "{$_parse['path']}?p=".$p."&c=".$c."&a=".$a."&page=";
    }

    /**
     * 显示跳转首页
     * @return string 如果是第一页 返回没有a标签的首页  如果不是第一页 返回带有a标签的首页
     */
    private function first(){
        if ($this->current==1){
            return " <span class='disabled'>首页</span>";
        }else{
            return " <a href='{$this->linkpage}1'>首页</a>";
        }
    }

    /**
     * 显示跳转末页
     * @return string 如果是最后 返回没有a标签的末页  如果不是最后 返回带有a标签的末页
     */
    private function end(){
        if ($this->current==$this->pagenum){
            return "<span class='disabled'>末页</span>";
        }else{
            return "<a href='{$this->linkpage}{$this->pagenum}'>末页</a>";
        }
    }

    /**
     * 显示跳转上一页
     * @return string 如果到第一页 无法跳转 显示没有a标签的上一页  如果不是第一页 显示a标签的上一页
     */
    private function prev(){
        if ($this->current==1){
            return "<span class='disabled'>上一页</span>";
        }else{
            return "<a href='{$this->linkpage}".($this->current-1)."'>上一页</a>";
        }
    }

    /**
     * 显示跳转下一页
     * @return string 如果到最后一页 无法跳转 显示没有a标签的下一页 如果不是最后一页 显示a标签的下一页
     */
    private function next(){
        if ($this->current==$this->pagenum){
            return "<span class='disabled'>下一页</span>";
        }else{
            return "<a href='{$this->linkpage}".($this->current+1)."'>下一页</a>";
        }
    }

    /**
     * 显示文本分页方法
     * @return string 返回出拼接好的分页记录
     */
    public function showTxtPage(){
        if ($this->pagenum >= 1){
            return "共有 {$this->total} 条记录 , 
            每页显示 {$this->pagesize} 条记录 , 
            当前为 {$this->current}/{$this->pagenum} {$this->pagefirst} {$this->prvepage} {$this->nextpage} {$this->pageend}";
        }else{
            return "分页加载失败...";
        }
    }

    /**
     * 计算数字分页 前后连边的数字
     * @return string 前后两边的数字
     */
    private function numPagePrve(){
        for ($i=$this->current-2;$i<$this->current;$i++) {
            if($i<1) continue;
            @$pagenumlist.=" <a href='{$this->linkpage}$i'>$i</a> ";
        }
        @$pagenumlist.="<span class='selected'>{$this->current}</span>";
        for ($j=$this->current+1;$j<$this->current+3;$j++){
            if ($j>$this->pagenum) break;
            @$pagenumlist.=" <a href='{$this->linkpage}$j'>$j</a> ";
        }
        return $pagenumlist;
    }

    /**
     * 数字分页
     * @return string 返回数字分页
     */
    public function showNumPage(){
        if ($this->pagenum >= 1){
            return "共有 {$this->total} 条记录 {$this->pagefirst} {$this->numPagePrve()} {$this->pageend} {$this->prvepage} {$this->nextpage}";
        }else{
            return "分页加载失败...";
        }
    }
}