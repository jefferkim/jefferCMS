<?php
	include_once("config.php");
	LoginCheck($SysConfig['rooturl']."/login.php",true);
	$userRole = $_SESSION['SWEBADMIN_USERROLE'];
	$maindb = $SysConfig['maindb'];
	$userId = $_SESSION['SWEBADMIN_USERID'];
	$user = $_SESSION['SWEBADMIN_USERNAME'];
	$userRole = $_SESSION['SWEBADMIN_USERROLE'];
	
    $rs = $SysConfig['customerdb']->Execute("SELECT * FROM t_admin WHERE id=?",array($userId));
	if($rs->RecordCount()>0){
		$rs = $SysConfig['customerdb']->Execute("SELECT * FROM t_admin WHERE id=?",array($userId));
	}else{
		$rs = $maindb->Execute("SELECT * FROM t_admin WHERE id=?",array($userId));
	}
	
	$status = $rs->fields['Status'];
	if($status >= 4){
		$pluginRs = $maindb->Execute("SELECT * FROM t_plugin ORDER BY OrderBy");
		$roleArr = array();
		while (!$pluginRs->EOF)
		{
			$plugin = $pluginRs->FetchObject();
			$index = explode("/",$plugin->POINT);
			$roleArr[$index[0]] = array(
									"power"=>$plugin->POWER	,
									"point"=>$plugin->POINT	,
									"called"=>$plugin->CALLED,
								);
	
			$pluginRs->MoveNext();
		}
	}
	function PowerIsInRole($names,$roleArr,$userRole){
		$pArr = explode("|",$roleArr[$names]['power']);
		foreach($pArr as $val){
			if(UserIsInRole($val,$userRole)){
				return true;
			}else{
				return false;
			}
		}
	}

	
$customRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_custom WHERE id=1");
$custom = $customRs->FetchObject();
$custom1 = $custom->CUSTOM1;
$custom2 = $custom->CUSTOM2;	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="cs/base.css">
<link rel="stylesheet" type="text/css" href="cs/layout.css">
<link rel="stylesheet" type="text/css" href="cs/typography.css">
<script src="js/ps_jquery.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function(){                          //实现折叠菜单
    $("#sideBar dt").click(function(){                 //向DT添加一个click事件
        $("#sideBar dd").css("display","none");
        $(this).next("dd").slideDown();               //点击DT时，显示DT后第一个DD
    });
	
	$(".two_ul>li>a").live('click',function(){
		$(".two_ul>li>a").removeClass();
		this.className="current";
	});
	
});
</script>
</head>

<body style="background:#6bb7ea; height:100%;">

<div class="left">

<dl class="left_dl" id="sideBar">

<dt class="click_li">系统设置</dt>
<dd style="display:block">
<ul class="two_ul">
<li><a href="right.php" target="main">系统首页</a></li>

<?
if(PowerIsInRole('admin_news',$roleArr,$userRole)){
?>
<li><a href="admin_news/sys_news.php" target="main">系统公告</a></li>
<?
}
?>

<li><a href="sys_config.php" target="main">系统设置</a></li>
<li><a href="global/main.php" target="main">站点管理</a></li>
<li><a href="field/main.php" target="main">自定义自段</a></li>
</ul>
</dd>

<?php
if(PowerIsInRole('html',$roleArr,$userRole)){
 ?>
<dt>内容信息管理</dt>
<dd>
<ul class="two_ul">
<li><a href="<?echo $roleArr['html']['point']?>" target="main">内容列表</a></li>
<li><a href="html/add.php" target="_blank">添加内容</a></li>
</ul>
</dd>
<?php
}if(PowerIsInRole('products',$roleArr,$userRole)){
?>
 
<dt>产品信息管理</dt>
<dd>
<ul class="two_ul">
<li><a href="<?echo $roleArr['products']['point']?>" target="main">产品管理</a></li>
<li><a href="products/productadd.php" target="_blank">产品添加</a></li>
<li><a href="products/type.php" target="main">产品分类</a></li>
<li><a href="products/typeadd.php" target="_blank">分类添加</a></li>

<?php
if(PowerIsInRole('order',$roleArr,$userRole)){
?>
<li><a href="order/order.php" target="main">查看订单</a></li>

<?php
}
?>

<li><a href="products/productimport.php" target="main">复制产品</a></li>
</ul>
</dd>
<?php
}if(PowerIsInRole('news',$roleArr,$userRole)){
?>

<dt>新闻信息管理</dt>
<dd>
<ul class="two_ul">
<li><a href="<?echo $roleArr['news']['point']?>" target="main">新闻管理</a></li>
<li><a href="news/newsadd.php" target="_blank">新闻添加</a></li>
<li><a href="news/newstype.php" target="main">新闻分类</a></li>
<li><a href="news/typeadd.php" target="main">分类添加</a></li>
<li><a href="news/importnews.php" target="main">复制新闻</a></li>
</ul>
</dd>

<?php
}if(PowerIsInRole('picture',$roleArr,$userRole)){
?>

<dt>图片信息管理</dt>
<dd>
<ul class="two_ul">
<li><a href="<?echo $roleArr['picture']['point']?>" target="main">图片管理</a></li>
<li><a href="picture/picadd.php" target="main">图片添加</a></li>
<li><a href="picture/type.php" target="main">图片分类</a></li>
<li><a href="picture/typeadd.php" target="main">分类添加</a></li>
<li><a href="picture/importpicture.php" target="main">复制图片</a></li>
</ul>
</dd>
<?php
}if(PowerIsInRole('job',$roleArr,$userRole)){
?>


<dt>招聘信息管理</dt>
<dd>
<ul class="two_ul">
<li><a href="<?echo $roleArr['job']['point']?>" target="main">招聘管理</a></li>
<li><a href="job/jobadd.php" target="main">添加招聘</a></li>
<li><a href="job/career.php" target="main">查看简历</a></li>
<li><a href="job/importjob.php" target="main">复制招聘</a></li>
</ul>
</dd>
<?php
}if(PowerIsInRole('download',$roleArr,$userRole)){
?>

<dt>下载信息管理</dt>
<dd>
<ul class="two_ul">
<li><a href="<?echo $roleArr['download']['point']?>" target="main">下载管理</a></li>
<li><a href="download/downloadadd.php" target="main">添加下载</a></li>
<li><a href="download/type.php" target="main">下载分类</a></li>
<li><a href="download/typeadd.php" target="main">分类添加</a></li>
<li><a href="download/importtype.php" target="main">复制下载</a></li>
</ul>
</dd>
<?php
}if(PowerIsInRole('member',$roleArr,$userRole)){
?>
<dt>会员信息管理</dt>
<dd>
<ul class="two_ul">
<li><a href="member/member.php" target="main">会员管理</a></li>
<li><a href="member/memberadd.php" target="main">添加会员</a></li>
</ul>
</dd>

<?
}if(PowerIsInRole('guest',$roleArr,$userRole)){
?>

<dt>留言信息管理</dt>
<dd>
<ul class="two_ul">
<li><a href="guest/main.php" target="main">客户留言信息</a></li>
<?php
if(PowerIsInRole('feedback',$roleArr,$userRole)){
?>
<li><a href="feedback/feed.php" target="main">客户反馈信息</a></li>
<?
}
?>
</ul>
</dd>
<?
}if (PowerIsInRole('stat1',$roleArr,$userRole)){
?>

<dt>统计中心</dt>
<dd>
<ul class="two_ul">
<li><a href="stat/stat.php" target="main">数据统计</a></li>
</ul>
</dd>

<?
}if(PowerIsInRole('file_manage',$roleArr,$userRole)){
?>
<dt>SEO信息管理</dt>
<dd>
<ul class="two_ul">
<li><a href="file_manage/index.php" target="main">SEO关键字管理</a></li>
<li><a href="stat/anal.php" target="main">数据分析</a></li>
</ul>
</dd>

<?
}if(PowerIsInRole('vote',$roleArr,$userRole)){
?>

<dt>投票信息管理</dt>
<dd>
<ul class="two_ul">
<li><a href="vote/result.php" target="main">答案列表</a></li>
<li><a href="vote/resultadd.php" target="main">答案添加</a></li>
<li><a href="vote/vote.php" target="main">问题列表</a></li>
<li><a href="vote/voteadd.php" target="main">问题添加</a></li>
</ul>
</dd>

<?

}if(PowerIsInRole('sys_user',$roleArr,$userRole)){

?>

<dt>系统管理员管理</dt>
<dd>
<ul class="two_ul">
<li><a href="member/sys_user.php" target="main">系统管理员列表</a></li>
<li><a href="member/sys_useradd.php" target="main">系统管理员添加</a></li>
</ul>
</dd>

<?
}if(PowerIsInRole('custom1',$roleArr,$userRole)){
?>


<dt>系统自定义功能</dt>
<dd>
<ul class="two_ul">
<li><a href="custom1/main.php" target="main"><?=$custom1?>列表</a></li>
<li><a href="custom1/add.php" target="main"><?=$custom1?>添加</a></li>
<?
if (UserIsInRole('B4',$userRole))
{
?>
<li><a href="custom2/main.php" target="main"><?=$custom2?>列表</a></li>
<li><a href="custom2/add.php" target="main"><?=$custom2?>添加</a></li>
<?
}
?>
<li><a href="html/sys_custom.php" target="main">自定义功能设置</a></li>
</ul>
</dd>

<?
}
?>




</dl>
<div style="position:absolute; bottom:0px;">
<dl class="left_dl">
<dt class="click_li">浙江派桑网络</dt>
</dl>
</div>
</div>




</body>
</html>







