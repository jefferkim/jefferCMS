<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);

$userRole = $_SESSION['SWEBADMIN_USERROLE'];

$linkList = array();

if (UserIsInRole('O2',$userRole))
{
	$link = new Linker("javascript:;","反馈删除","btnDelete");
	$linkList[] = $link;
}

$lanArr = $SysConfig['customerLanguage'];
if($_REQUEST['language']){
$lan=$_REQUEST['language'];
}else{
$lan=$SysConfig['currentLan'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$SysConfig['title']?></title>
<link rel="stylesheet" type="text/css" href="../cs/base.css">
<link rel="stylesheet" type="text/css" href="../cs/layout.css">
<link rel="stylesheet" type="text/css" href="../cs/typography.css">
<script>
var g_language = '<?=$lan?>';
</script>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>

  <link media="screen" rel="stylesheet" href="../colorbox/colorbox.css" />
     <script src="../js/ps_jquery.js"></script>
      <script src="../colorbox/js/jquery.colorbox.js"></script>
	<script>
			$(document).ready(function(){
				$(".example6").colorbox({iframe:true, innerWidth:770, innerHeight:400});
			});
		</script>     
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.pagination.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery-impromptu.js"></script>
<script src="../js/linker.js"></script>
<script src="feed.js"></script>
<script language="javascript">
$(function(){
	$("#chkall").click(function()
	{
		CheckAll();
	});	   
});
$(function(){

	$("select[name=language]").change(function()
	{
	 $('#myform').submit() 
	});
	
})
</script>
</head>


<style>

div{ overflow:visible}

</style>

<body style="background:#FFF;">
<?
if (!UserIsInRole('O1',$userRole))
{
    echo '<script>';
	echo 'alert("您没有权限访问！");';
	echo '</script>';
	exit();
}

?>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="main_bj">
  <tr>
    <td valign="top">
    <div class="right_title">
    <span style="font-weight:bold">位置：</span>留言信息管理 — 反馈信息列表<em id="total" style="font-weight:bold">
    
       <?

$where = "WHERE 1=1";
$where .= " AND Language='".$lan."'";
$feedbackRs = $SysConfig['customerdb']->Execute("SELECT COUNT(*) FROM t_feedback ".$where);
$counts = $feedbackRs->fields[0];

echo "【共有:".$counts."条记录】";
?>

    
    </em>
   </div>
   
   <form action="feed.php" method="post" id="myform">
   <div id="search">

   <table width="100%" border="0" cellpadding="0" cellspacing="0"  >

     <thead>
    
     <tr>
               
                <td align="right">语言：<?HtmlSelect('language',$lanArr,$lan,"style='vertical-align:middle'")?></td>     
            </tr>

                </thead>

</table>

   </div>
  </form>
   
    
  <div id="box" style="overflow-y:auto; vertical-align:top; margin-top:5px;">
  <style>
    .title_td{ text-indent:10px; color:#023266}
	.img_ico{ vertical-align:middle; margin-right:5px; }
  </style>
  

          
 
     <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table_title" id="tablist" >
     
      <thead>
          <tr>
          
            <td width="4%"  align="center" class="td_title"><input type="checkbox" id="chkall" value='全选' name=chk></td> 
            <td width="4%"   align="center"   class="td_title">编号</td>
            <td width="32%"  align="center"   class="td_title">反馈名称</td>
            <td width="25%"  align="center"   class="td_title">反馈日期</td>
            <td width="20%"  align="center"   class="td_title">语言名称</td>
            <td width="15%"  align="center">操作</td>
            </tr>
            </thead>
             <tbody>
             
             
              <?
$linkurl = $_SERVER['PHP_SELF']."?";
$page = 1;
$pageCounts = 10;

$where = "WHERE 1=1";

if (isset($_REQUEST['page']) && $_REQUEST['page']>0)
{
	$page = $_REQUEST['page'];
}
$where .= " AND Language='".$lan."'";
$feedbackRs = $SysConfig['customerdb']->Execute("SELECT COUNT(*) FROM t_feedback ".$where);
$counts = $feedbackRs->fields[0];
$start = ($page - 1) * $pageCounts;
$feedbackRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_feedback $where ORDER BY NoteTime DESC LIMIT $start,$pageCounts");
?>

 <?
 $i=0;
while (!$feedbackRs->EOF)
{
$feedbackObj = $feedbackRs->FetchObject();
if($i%2==0){
	?>        
<tr>
<td valign="middle" align="center"><input type="checkbox" name="chk<?=$feedbackObj->ID?>" value="<?=$feedbackObj->ID?>"></td>

<td valign="middle" height="30" align="center"><?=$feedbackObj->ID?></td>
<td valign="middle" align="left" style="padding-left:10px;"><a class="example6" href="feed.json.php?id=<?=$feedbackObj->ID?>"><?=$feedbackObj->NAME?></a></td>
<td valign="middle" align="center"><?=$feedbackObj->NOTETIME?></td>
<td valign="middle" align="center"><?=$SysConfig['language'][$feedbackObj->LANGUAGE]?></td>
<td valign="middle" align="center">
<a class="example6" href="feed.json.php?id=<?=$feedbackObj->ID?>">查看</a>  
<a href="javascript:;" onclick="Del_id('<?=$feedbackObj->ID?>')">删除</a> 
</td>
</tr>


<?
}else{
?>

<tr class="two_tr">
<td valign="middle" align="center"><input type="checkbox" name="chk<?=$feedbackObj->ID?>" value="<?=$feedbackObj->ID?>"></td>

<td valign="middle" height="30" align="center"><?=$feedbackObj->ID?></td>
<td valign="middle" align="left" style="padding-left:10px;"><a class="example6" href="guestsd.php?id=<?=$feedbackObj->ID?>"><?=$feedbackObj->NAME?></a></td>
<td valign="middle" align="center"><?=$feedbackObj->NOTETIME?></td>
<td valign="middle" align="center"><?=$SysConfig['language'][$feedbackObj->LANGUAGE]?></td>
<td valign="middle" align="center">
<a class="example6" href="feed.json.php?id=<?=$feedbackObj->ID?>">查看</a>  
<a href="javascript:;" onclick="Del_id('<?=$feedbackObj->ID?>')">删除</a> 
</td>
</tr>          
  <?
}
	$feedbackRs->MoveNext();
	$i++;
}
?>        

<?
$pager = new Pager($linkurl,$counts,$page,$pageCounts);
$pager->setPrevText('上一页');
$pager->style=2;
$pager->setNextText('下一页');


?>  
             
             
             </tbody>
      <thead>
 <tr>
      <td colspan="11" height="30"  align="center" class="btn_line">
       <div class="pl_set" id="pl_set_bg">
       
       <?php
		  foreach($linkList as $link)
		  {
			  $id = "";
			  if ($link->id != "")
				$id = ' id="'.$link->id.'"';
			  $target = "";
			  if ($link->target != "")
				  $target = ' target="'.$link->target.'"';
		  ?>
                <span>
                <a href="<?=$link->link?>"<?=$id?><?=$target?>><?=$link->name?></a>
                </span>
               <?php
		  		}
			   ?>    
           
      
      </div>
      
      
<div id="pager" class="pagination1"><?=$pager->render();?></div>
</td>
</tr>
</thead>
    </table>
  
 </div>
  
    </td>
  </tr>
</table>



</body>


</html>

