 <header>
    <div class="header">
        <div class="weblogo">
            <h1><img src="public/img/weblogo.png" alt="神马计划开奖网" width="200"></h1>
            <p>开奖最快的专业彩票开奖网站</p>
        </div>
        <div class="other">
            <?php if (!empty($_SESSION['logininfo'])){?>
                <div class="loginname"> 欢迎 <?php echo $_SESSION['logininfo']['loginname'];?> <a href="index.php?c=login&a=logout"> [ 退出 ]</a></div>
            <?php }else{ ?>
                <button onclick="window.location.href='index.php?c=login&a=login'">登陆</button>
            <?php } ?>
        </div>
    </div>
</header>
<nav>
    <i class="icon open"><a href="#nav">☰</a></i>
    <ul id="nav">
        <li class="selected"><a href="index.php?c=index&a=index">首页</a></li>
        <?php foreach($nav as $value) { ?>
        <li><a href="index.php?c=list&a=list&nav=<?php echo $value['nav_name'];?>"><?php echo $value['nav_name'];?></a></li>
        <?php } ?>
        <i class="icon close"><a href="#top">☰</a></i>
    </ul>
</nav>