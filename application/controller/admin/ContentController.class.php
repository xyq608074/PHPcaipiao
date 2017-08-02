<?php
class ContentController extends BaseController{
    protected $contentModel;

    public function __construct(){
        $this->contentModel=new ContentModel('content');
    }

    //显示所有的内容列表
    public function contentAction(){
        //分页
        //获取总记录
        $total=$this->contentModel->total();
        //获取当前
        $current=isset($_GET['page'])?$_GET['page']:1;
        //调用模型层查询方法
        $offset=($current - 1)*PAGESIZE;
        if (empty($_POST['nav'])) {
            $contentlist = $this->contentModel->getPageContent($offset,PAGESIZE);
        }else{
            $contentlist = $this->contentModel->getPageContent($offset, PAGESIZE,"where nav={$_POST['nav']}");
        }

        //实例化分页类
        $this->library('Page');
        $page=new Page($total,PAGESIZE,$current);
        //调用栏目列表
        $navlist=$this->contentModel->getContentNav();

        //引入html模板
        include CUR_VIEW."content.html";
    }

    //选择菜单的查询
    public function selectnav($navid){
        if (!empty($_POST['nav'])) {
            if ($navid==$_POST['nav']){
                echo 'selected';
            }else{
                echo '';
            }
        }
    }

    //插入内容
    public function addContentAction(){
        //调用栏目列表
        $navlist=$this->contentModel->getContentNav();
        //显示插入页面模板
        include CUR_VIEW."addcontent.html";
    }

    //载入上传文件页面
    public function adduploadAction(){
        include CUR_VIEW."addupload.html";
    }

    //处理提交过来的上传
    public function uploadAction(){
        $this->library('Upload');
        $uploads=new Upload();
        if($filename=$uploads->moveUpload($_FILES['file'])){
            echo "<script type='text/javascript'>window.opener.document.getElementById('thumbnail').value='public/uploads/".$filename."'</script>";
            echo "<script type='text/javascript'>window.opener.document.getElementById('uploadpic').src='public/uploads/".$filename."'</script>";
            echo "<script type='text/javascript'>window.opener.document.getElementById('uploadpic').style.display='block'</script>";
            $this->alertClose();
        }else{
            $this->alertLocaltion("index.php?p=admin&c=content&a=addupload","图片上传失败");
        }
    }

    //插入动作
    public function addAction(){
        //获取网站中需要插入的所有信息
        $this->helper('input');
        $data['title']=htmlchar_slashes_trim($_POST['title']);
        $data['nav']=$_POST['nav'];
        $data['type']=empty($_POST['type'])?'无属性':implode(',',$_POST['type']);
        $data['tag']=htmlchar_slashes_trim($_POST['tag']);
        $data['keyword']=htmlchar_slashes_trim($_POST['keyword']);
        $data['thumbnail'] = htmlchar_slashes_trim($_POST['thumbnail']);
        $data['author']=htmlchar_slashes_trim($_POST['author']);
        $data['info']=htmlchar_slashes_trim($_POST['info']);
        $data['content']=htmlchar_slashes_trim($_POST['content']);
        $data['commend']=$_POST['commend'];
        $data['sort']=$_POST['sort'];
        $data['gold']=htmlchar_slashes_trim($_POST['gold']);
        $data['readlimit']=$_POST['readlimit'];
        $data['count']=htmlchar_slashes_trim($_POST['count']);
        $data['date']=date('Y-m-d H:i:s');

        if($this->contentModel->insert($data)){
            $this->alertLocaltion("index.php?p=admin&c=content&a=content","添加文章成功");
        }else{
            $this->alertLocaltion("index.php?p=admin&c=content&a=addcontent","添加文章失败");
        }
    }

    //修改
    public function updateContentAction(){
        $contentmodel=$this->contentModel->selectByPk($_GET['id']);

        //调用栏目列表
        $navlist=$this->contentModel->getContentNav();

        //定义属性
        $typeArr=array('头条','推荐','加粗','幻灯');
        $type=explode(',',$contentmodel['type']);
        $typediff=array_diff($typeArr,$type);
        if ($type[0]!='无属性'){
            foreach ($type as $value) {
                @$checked .= "<input type='checkbox' name='type[]' value={$value} checked />{$value}";
            }
        }
        foreach ($typediff as $value){
            @$checked .= "<input type='checkbox' name='type[]' value={$value} />{$value}";
        }

        //评论选项
        if ($contentmodel['commend']==1){
            $commend="<input type='radio' name='commend' value='1' checked/>允许评论 <input type='radio' name='commend' value='0'/>禁止评论";
        }else{
            $commend="<input type='radio' name='commend' value='1' />允许评论 <input type='radio' name='commend' value='0' checked/>禁止评论";
        }

        //文档排序
        $sortArr=array(0=>'默认排序',1=>'置顶一天',2=>'置顶一周',3=>'置顶一月',4=>'置顶一年');
        foreach ($sortArr as $key=>$value) {
            if ($key == $contentmodel['sort']) $selected = "selected";
            @$sort .= "<option value='{$key}' {$selected}>$value</option>";
            $selected = '';
        }
        //阅读权限
        $readlimitArr=array(0=>'开放浏览',1=>'初级会员',2=>'中级会员',3=>'高级会员',4=>'VIP会员');
        foreach ($readlimitArr as $key=>$value) {
            if ($key == $contentmodel['readlimit']) $selected = "selected";
            @$readlimit .= "<option value='{$key}' {$selected}>$value</option>";
            $selected = '';
        }

        //载入修改模板
        include CUR_VIEW."updatecontent.html";
    }
    //执行修改动作
    public function updateAction(){
        $this->helper('input');
        $data['id']=htmlchar_slashes_trim($_POST['id']);
        $data['title']=htmlchar_slashes_trim($_POST['title']);
        $data['nav']=$_POST['nav'];
        $data['type']=empty($_POST['type'])?'无属性':implode(',',$_POST['type']);
        $data['tag']=htmlchar_slashes_trim($_POST['tag']);
        $data['keyword']=htmlchar_slashes_trim($_POST['keyword']);
        $data['thumbnail'] = htmlchar_slashes_trim($_POST['thumbnail']);
        $data['author']=htmlchar_slashes_trim($_POST['author']);
        $data['info']=htmlchar_slashes_trim($_POST['info']);
        $data['content']=htmlchar_slashes_trim($_POST['content']);
        $data['commend']=$_POST['commend'];
        $data['sort']=$_POST['sort'];
        $data['gold']=htmlchar_slashes_trim($_POST['gold']);
        $data['readlimit']=$_POST['readlimit'];
        $data['count']=htmlchar_slashes_trim($_POST['count']);

        if ($this->contentModel->update($data)){
            $this->alertLocaltion("index.php?p=admin&c=content&a=content","修改文章成功");
        }else{
            $this->alertLocaltion("index.php?p=admin&c=content&a=updatecontent","修改文章失败");
        }
    }

    //执行删除动作
    public function deleteAction(){
        if($this->contentModel->delete($_GET['id'])){
            $this->alertLocaltion("index.php?p=admin&c=content&a=content","删除成功!");
        }else{
            $this->alertLocaltion("index.php?p=admin&c=content&a=content","删除失败");
        }
    }
}