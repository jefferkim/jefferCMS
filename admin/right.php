<?php
include_once("stat/stat_function.php");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="cs/base.css">
<link rel="stylesheet" type="text/css" href="cs/layout.css">
<link rel="stylesheet" type="text/css" href="cs/typography.css">
<link media="screen" rel="stylesheet" href="colorbox/colorbox.css" />
<script src="js/ps_jquery.js"></script>
<script src="colorbox/js/jquery.colorbox.js"></script>
	<script>
			$(document).ready(function(){
				$(".example6").colorbox({iframe:true, innerWidth:770, innerHeight:400});
			});
		</script>

</head>
<style>

div{ overflow:visible}
</style>

<body style="background:#FFF;">

<div class="server" style="overflow:hidden;">

<span class="server_top">我的客服</span>



<div class="server_bj" style="overflow:hidden;">


<div class="server_content" style="overflow:hidden;">

<p>客服：<?=$ServerName?></p>
<p>电话：<em style="font-size:11px;"><?=$ServerTel?></em></p>

<p>Q<span style="padding-left:5px;"></span>Q：<?=$ServerQQ?></p>


<span class="server_btn"><a href="tencent://message/?uin=<?=$ServerQQ?>&Site=&Menu=yes"><img src="images/server_btn.jpg" width="105" height="26" /></a></span>



</div>





</div>





</div>

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="main_bj">
  <tr>
    <td valign="top">
    <div class="right_title">
    <span style="font-weight:bold">位置：</span>基础管理 — 网站类别管理
   </div>
    
   
    <div class="right_one">
    
    <span class="one_span_title">系统公告：</span>
    
    <div class="one_content">
    
    <div class="one_content_left">
    
    
    <ul class="notice_list">
    
    <?
		$newsList=$SysConfig['maindb']->Execute("select * from t_news where IsCommend=1 order by id desc limit 0,5");
        $i=0;
		while(!$newsList->EOF)
		{
		$newsObj = $newsList->FetchObject();	
		?>

      <li><span><?echo date("Y-m-d",strtotime($newsObj->NOTETIME));?></span><a href="newsd.php?nid=<?=$newsObj->ID?>" class="example6"><?=substr_for_gb2312($newsObj->TITLE,0,22)?></a></li>
		
		<?	

			$newsList->MoveNext();
			$i++;
		}
		?>


     
     
    </ul>
    
    
    
    </div>
    
    
    <div class="one_content_right"><img src="images/ps_logo.jpg" width="402" height="115" /></div>
    
    </div>
    
    
    <br class="clear_cs" />
     <span class="two_span_title">提示信息：</span>

    <span class="two_span_content">
    
    <p class="two_p">最新有：<a href="admin_news/sys_news.php" target="main"><em><?=$i?></em></a> 条系统公告 | <a href="guest/main.php" target="main"><em><?=msg_raply("t_guestbook")?></em></a> 条客户新留言 | <a href="order/order.php" target="main"><em><?=isprocess("t_order")?></em></a> 份产品新订单 | <a href="job/career.php" target="main"><em><?=stat_num("t_career")?></em></a> 人应聘您的职位</p>
    
    
    </span>
    
    </div>
    
    
    <div class="right_two"><span style="color:#ff6600; font-weight:bold">注：</span>以上信息，强烈建议您坚持经常查看，以免错过商机及人才的求职机会，尤其正在招聘企业，同时要关注您的"留言管理"！</div>
    
    
    <div class="right_three">
    
    <span class="three_span_title">您当前信息统计：</span>
    
    <div class=" right_three_content">
    
    
    
    
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="122"><img src="images/pic.jpg" width="122" height="101"  style="display:block;"/></td>
    <td style="line-height:15px;">
    
      <p>空间总计：<?=$Space?>MB</p>
      <p>空间到期时间:<?=date("Y/m/d",strtotime($ServiceStart));?></p>
      <p>域名到期时间:<?=date("Y/m/d",strtotime($ServiceEnd));?></p>
      <p style="line-height:22px;"><a href="tencent://message/?uin=<?=$ServerQQ?>&Site=&Menu=yes" class="tj_a">立即续费&gt;&gt;</a></p>
      
      </td>
    <td style="line-height:24px;">
      <p><strong>上传产品</strong>---<strong><?=stat_num("t_products")?></strong>个</p>
      <p><strong>产品订单</strong>---总共<strong><?=stat_num("t_order")?></strong>份 [<a href="#" class="tj_a" style="font-weight:normal;"><?=isprocess("t_order")?>份未处理</a>]</p>
      <p><strong>客户留言</strong>---<strong><?=stat_num("t_guestbook")?></strong>条 [<a href="#" class="tj_a" style="font-weight:normal;"><?=msg_raply("t_guestbook")?>条未回复</a>]</p>
      
      </td>
    <td style="line-height:24px;">
    
      <p><strong>招聘职位</strong>---<strong><?=stat_num("t_job")?></strong>个 [已有<?=stat_num("t_career")?>人求职]</p>
      <P><strong>流量统计</strong>---<strong>已有<?=stat_num("t_flow")?>人访问</strong>[日访问<?=day_num("t_flow")?>]</P>
      <p><strong>会员统计</strong>---<strong><?=stat_num("t_user")?></strong>人</p>
      
      </td>
  </tr>
</table>

    
    
    
  
    
    
    
    </div>
    
    
    
    </div>
    
    
    <div class="right_four"><span style="color:#ff6600; font-weight:bold">注：</span>如果您在使用后台管理过程中有任何问题或疑问，可以给派桑发送站内短信，我们会及时在线回复.  &nbsp;&nbsp;&nbsp;&nbsp;<a href="tencent://message/?uin=<?=$ServerQQ?>&Site=&Menu=yes" class="tj_a">联系客服>></a></div>
    
    </td>
  </tr>
</table>




</body>
</html>
