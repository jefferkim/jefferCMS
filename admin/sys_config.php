<?php
include_once("config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);

$configArr = array();
$configRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_config ORDER BY id");
while(!$configRs->EOF)
{
	$obj = $configRs->FetchObject();
	$configArr[$obj->CODE] = array(
		'name' => $obj->NAME,
		'value' => $obj->VALUE
	);
	$configRs->MoveNext();
}

$showArr = array(
	'true' => '显示',
	'false' => '不显示'
);
$orderArr = array(
	'true' => '顺序',
	'false' => '倒序'
);
$openArr = array(
	'new' => '新窗口',
	'old' => '原窗口',
	'popup' => '弹出窗口'
);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$SysConfig['title']?></title>
<link rel="stylesheet" type="text/css" href="cs/base.css">
<link rel="stylesheet" type="text/css" href="cs/layout.css">
<link rel="stylesheet" type="text/css" href="cs/typography.css">
<script src="<?echo $SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?echo $SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="<?echo $SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="js/jquery_select.js"></script>
<script src="./js/linker.js"></script>
<script>
$(function()
{
	$("input[type=submit]").click(function()
	{
		var arr = {};
		$("input[type=text]").each(function()
		{
			var name = $(this).attr("name");
			var val = $(this).val();
			arr[name] = val;
		});
		$("input[type=hidden]").each(function()
		{
			var name = $(this).attr("name");
			var val = $(this).val();
			arr[name] = val;
		});
		$("select").each(function()
		{
			var name = $(this).attr("name");
			var val = $(this).val();
			arr[name] = val;
		})
		AjaxSet("configsave.php",$.param(arr),function(data)
		{
			alert(data['result']);
		})
	});
})
$(function(){
	var h = screen.availHeight-330;
	$(".csh").css({"height":h,"overflow-y":"scroll"});
});

$(function(){

	$("#productcommendorder").sBox({animated:true});
	$("#productcommendopentype").sBox({animated:true});
	$("#productcommendshowpic").sBox({animated:true});
	$("#productcommendshowname").sBox({animated:true});
	$("#productcommendshowmemo").sBox({animated:true});
	$("#productcommendshowcontent").sBox({animated:true});
	$("#productorder").sBox({animated:true});
	$("#productopentype").sBox({animated:true});
	$("#productshowpic").sBox({animated:true});
	$("#productshowname").sBox({animated:true});
	$("#productshowmemo").sBox({animated:true});
	$("#productshowcontent").sBox({animated:true});
	$("#newscommendorder").sBox({animated:true});
	$("#newscommendopentype").sBox({animated:true});
	$("#newsorder").sBox({animated:true});
	$("#newsopentype").sBox({animated:true});
	$("#pictureorder").sBox({animated:true});
	$("#pictureopentype").sBox({animated:true});
	$("#joborder").sBox({animated:true});
	$("#downorder").sBox({animated:true});
})
</script>



<script type="text/javascript">
$(document).ready(function()         
         {
var h=$(window).height()-40; //浏览器当前窗口可视区域高度

$("#box").css("height",h+"px");

}
         )
</script>


</head>

<body style="background:#FFF;">



<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="main_bj">
  <tr>
    <td valign="top">
    <div class="right_title">
    <span style="font-weight:bold">位置：</span>基础管理 — 网站类别管理
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">
  
  <style>
  
  .title_td{ text-indent:10px; color:#023266}
  </style>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" >
  
    <?
  if (isset($configArr['producttype']))
  {
  ?>
  <tr class="table_title">
    <td colspan="4" class="td_one">产品分类设置</td>
    </tr>
  <tr>
  	<td width="25%" height="30" class="title_td"><?=$configArr['producttype']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect("producttype",$showArr,$configArr['producttype']['value'])?></td>
    
     <?
	if (isset($configArr['producttypeorder']))
	{
  ?>
	<td width="25%" height="30" class="title_td"><?=$configArr['producttypeorder']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect("producttypeorder",$orderArr,$configArr['producttypeorder']['value'])?></td>
    <?
	}
	?>
  </tr>
<?
  }if (isset($configArr['productcommendlines'])){
?>


<tr class="table_title">
	<td  colspan="4" class="td_one">首页推荐产品设置</td>
  </tr>
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['productcommendlines']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="productcommendlines" value="<?=$configArr['productcommendlines']['value']?>" class="sys_input"></td>
     <?
	if (isset($configArr['productcommendorder']))
	  {
  ?>
  <td width="25%" height="30" class="title_td"><?=$configArr['productcommendorder']['name']?> ：</td>
  <td width="25%" height="30"><?HtmlSelect("productcommendorder",$orderArr,$configArr['productcommendorder']['value'])?></td>
 
  </tr>
<?
  } if (isset($configArr['productcommendopentype'])) {
?>
<tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['productcommendopentype']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect('productcommendopentype',$openArr,$configArr['productcommendopentype']['value'])?></td>
<?
  }if (isset($configArr['productcommendpoptop'])){
?>
<td width="25%" height="30" class="title_td"><?=$configArr['productcommendpoptop']['name']?> ：</td>
<td width="25%" height="30"><input type="text" name="productcommendpoptop" value="<?=$configArr['productcommendpoptop']['value']?>" class="sys_input"></td>
 </tr>
<?
  } if (isset($configArr['productcommendpopleft'])){
?>
 <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['productcommendpopleft']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="productcommendpopleft" value="<?=$configArr['productcommendpopleft']['value']?>" class="sys_input"></td>
    
 <?
  }if (isset($configArr['productcommendpopwidth'])){
 ?>   
 
 <td width="25%" height="30" class="title_td"><?=$configArr['productcommendpopwidth']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="productcommendpopwidth" value="<?=$configArr['productcommendpopwidth']['value']?>" class="sys_input"></td>
  </tr>
<?
  }if (isset($configArr['productcommendpopheight'])) {
?>

<tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['productcommendpopheight']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="productcommendpopheight" value="<?=$configArr['productcommendpopheight']['value']?>" class="sys_input"></td>
 <?
 }if (isset($configArr['productcommendshowpic'])){
  ?>

	<td width="25%" height="30" class="title_td"><?=$configArr['productcommendshowpic']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect("productcommendshowpic",$showArr,$configArr['productcommendshowpic']['value'])?></td>
  </tr>
<?
   }if (isset($configArr['productcommendshowname'])) {
  ?>

<tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['productcommendshowname']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect("productcommendshowname",$showArr,$configArr['productcommendshowname']['value'])?></td>

  <?
	  }
    if (isset($configArr['productcommendshowmemo']))
	  {
  ?>
	<td width="25%" height="30" class="title_td"><?=$configArr['productcommendshowmemo']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect("productcommendshowmemo",$showArr,$configArr['productcommendshowmemo']['value'])?></td>
  </tr>
 <?
	} if (isset($configArr['productcommendshowcontent'])){
  ?>
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['productcommendshowcontent']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect("productcommendshowcontent",$showArr,$configArr['productcommendshowcontent']['value'])?></td>
  </tr>
  
  <?
    } 
	}
	if (isset($configArr['productlines'])){
  ?>
  
<tr class="table_title">
	<td  colspan="4" class="td_one">产品展示设置</td>
  </tr>
 <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['productlines']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="productlines" value="<?=$configArr['productlines']['value']?>" class="sys_input"></td>

  
   <?
	if (isset($configArr['productcols']))  
	  {
  ?>
  

	<td width="25%" height="30" class="title_td"><?=$configArr['productcols']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="productcols" value="<?=$configArr['productcols']['value']?>" class="sys_input"></td>
  </tr>
 <?
	  } if (isset($configArr['productorder'])){
  ?>
  <tr >
	<td width="25%" height="30" class="title_td"><?=$configArr['productorder']['name']?> ：</td>
	<td width="25%" height="30" ><?HtmlSelect('productorder',$orderArr,$configArr['productorder']['value'])?></td>

  <?
	  }
    if (isset($configArr['productopentype']))
	  {
  ?>

	<td width="25%" height="30" class="title_td"><?=$configArr['productopentype']['name']?> ：</td>
	<td width="25%" height="30" ><?HtmlSelect('productopentype',$openArr,$configArr['productopentype']['value'])?></td>
  </tr>
  <?
	  }if (isset($configArr['productpoptop'])){
  ?>
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['productpoptop']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="productpoptop" value="<?=$configArr['productpoptop']['value']?>" class="sys_input"></td>

  <?
	  }if (isset($configArr['productpopleft'])){
  ?>
	<td width="25%" height="30" class="title_td"><?=$configArr['productpopleft']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="productpopleft" value="<?=$configArr['productpopleft']['value']?>" class="sys_input"></td>
  </tr>
 <?
	  }
    if (isset($configArr['productpopwidth']))
	  {
  ?>
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['productpopwidth']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="productpopwidth" value="<?=$configArr['productpopwidth']['value']?>" class="sys_input"></td>
  <?
	  }if (isset($configArr['productpopheight'])){
  ?>
	<td width="25%" height="30" class="title_td"><?=$configArr['productpopheight']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="productpopheight" value="<?=$configArr['productpopheight']['value']?>" class="sys_input"></td>
  </tr>
  <?
	  }
    if (isset($configArr['productshowpic']))
	  {
  ?>
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['productshowpic']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect("productshowpic",$showArr,$configArr['productshowpic']['value'])?></td>
  <?
	  }
    if (isset($configArr['productshowname']))
	  {
  ?>
	<td width="25%" height="30" class="title_td"><?=$configArr['productshowname']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect("productshowname",$showArr,$configArr['productshowname']['value'])?></td>
  </tr>
  <?
	  }
    if (isset($configArr['productshowmemo']))
	  {
  ?>
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['productshowmemo']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect("productshowmemo",$showArr,$configArr['productshowmemo']['value'])?></td>

  <?
	  }
    if (isset($configArr['productshowcontent']))
	  {
  ?>
 
	<td width="25%" height="30" class="title_td"><?=$configArr['productshowcontent']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect("productshowcontent",$showArr,$configArr['productshowcontent']['value'])?></td>
  </tr>
  <?
	  }
  }
  if (isset($configArr['newscommendlines']))
  {
  ?>
  <tr class="table_title">
	<td  colspan="4" class="td_one">推荐新闻设置</td>
  </tr>
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['newscommendlines']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="newscommendlines" value="<?=$configArr['newscommendlines']['value']?>" class="sys_input"></td>
 
  <?
	if (isset($configArr['newscommendorder'])) 
	  {
  ?>
 
	<td width="25%" height="30" class="title_td"><?=$configArr['newscommendorder']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect("newscommendorder",$orderArr,$configArr['newscommendorder']['value'])?></td>
  </tr>
  <?
	  }
    if (isset($configArr['newscommendopentype']))
	  {
  ?>
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['newscommendopentype']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect('newscommendopentype',$openArr,$configArr['newscommendopentype']['value'])?></td>
 
  <?
	  }
    if (isset($configArr['newscommendpoptop']))
	  {
  ?>

	<td width="25%" height="30" class="title_td"><?=$configArr['newscommendpoptop']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="newscommendpoptop" value="<?=$configArr['newscommendpoptop']['value']?>" class="sys_input"></td>
  </tr>
  <?
	  }
    if (isset($configArr['newscommendpopleft']))
	  {
  ?>
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['newscommendpopleft']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="newscommendpopleft" value="<?=$configArr['newscommendpopleft']['value']?>" class="sys_input"></td>
 
  <?
	  }
    if (isset($configArr['newscommendpopwidth']))
	  {
  ?>
  
	<td width="25%" height="30" class="title_td"><?=$configArr['newscommendpopwidth']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="newscommendpopwidth" value="<?=$configArr['newscommendpopwidth']['value']?>" class="sys_input"></td>
  </tr>
  <?
	  }
    if (isset($configArr['newscommendpopheight']))
	  {
  ?>
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['newscommendpopheight']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="newscommendpopheight" value="<?=$configArr['newscommendpopheight']['value']?>" class="sys_input"></td>
 
  <?
	  }
  }
  if (isset($configArr['newslines']))
  {
  ?>
   <tr class="table_title">
	<td  colspan="4" class="td_one">新闻设置</td>
  </tr>
 
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['newslines']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="newslines" value="<?=$configArr['newslines']['value']?>" class="sys_input"></td>

  <?
	if (isset($configArr['newsorder']))  
	  {
  ?>

	<td width="25%" height="30" class="title_td"><?=$configArr['newsorder']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect("newsorder",$orderArr,$configArr['newsorder']['value'])?></td>
  </tr>
  <?
	  }
    if (isset($configArr['newsopentype']))
	  {
  ?>
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['newsopentype']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect('newsopentype',$openArr,$configArr['newsopentype']['value'])?></td>

  <?
	  }
    if (isset($configArr['newspoptop']))
	  {
  ?>
 
	<td width="25%" height="30" class="title_td"><?=$configArr['newspoptop']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="newspoptop" value="<?=$configArr['newspoptop']['value']?>" class="sys_input"></td>
  </tr>
  <?
	  }
    if (isset($configArr['newspopleft']))
	  {
  ?>
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['newspopleft']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="newspopleft" value="<?=$configArr['newspopleft']['value']?>" class="sys_input"></td>
 
  <?
	  }
    if (isset($configArr['newspopwidth']))
	  {
  ?>

	<td width="25%" height="30" class="title_td"><?=$configArr['newspopwidth']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="newspopwidth" value="<?=$configArr['newspopwidth']['value']?>" class="sys_input"></td>
  </tr>
  <?
	  }
    if (isset($configArr['newspopheight']))
	  {
  ?>
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['newspopheight']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="newspopheight" value="<?=$configArr['newspopheight']['value']?>" class="sys_input"></td>
    <td width="25%" height="30" class="title_td"></td>
	<td width="25%" height="30"></td>
  </tr>
  <?
	  }
  }
  if (isset($configArr['picturelines']))
  {
  ?>
   <tr class="table_title">
	<td  colspan="4" class="td_one">图片设置</td>
  </tr>
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['picturelines']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="picturelines" value="<?=$configArr['picturelines']['value']?>" class="sys_input"></td>
  
  <?
	if (isset($configArr['picturecols']))  
	  {
  ?>

	<td width="25%" height="30" class="title_td"><?=$configArr['picturecols']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="picturecols" value="<?=$configArr['picturecols']['value']?>" class="sys_input"></td>
  </tr>
  <?
	  }
    if (isset($configArr['pictureorder']))
	  {
  ?>
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['pictureorder']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect("pictureorder",$orderArr,$configArr['pictureorder']['value'])?></td>
  
  <?
	  }
    if (isset($configArr['pictureopentype']))
	  {
  ?>
  
	<td width="25%" height="30" class="title_td"><?=$configArr['pictureopentype']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect('pictureopentype',$openArr,$configArr['pictureopentype']['value'])?></td>
  </tr>
  <?
	  }
    if (isset($configArr['picturepoptop']))
	  {
  ?>
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['picturepoptop']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="picturepoptop" value="<?=$configArr['picturepoptop']['value']?>" class="sys_input"></td>
  
  <?
	  }
    if (isset($configArr['picturepopleft']))
	  {
  ?>

	<td width="25%" height="30" class="title_td"><?=$configArr['picturepopleft']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="picturepopleft" value="<?=$configArr['picturepopleft']['value']?>" class="sys_input"></td>
  </tr>
  <?
	  }
    if (isset($configArr['picturepopwidth']))
	  {
  ?>
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['picturepopwidth']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="picturepopwidth" value="<?=$configArr['picturepopwidth']['value']?>" class="sys_input"></td>
  
  <?
	  }
    if (isset($configArr['picturepopheight']))
	  {
  ?>
 
	<td width="25%" height="30" class="title_td"><?=$configArr['picturepopheight']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="picturepopheight" value="<?=$configArr['picturepopheight']['value']?>" class="sys_input"></td>
  </tr>
  <?
	  }
  }
  if (isset($configArr['joblines']))
  {
  ?>
 <tr class="table_title">
	<td  colspan="4" class="td_one">招聘设置</td>
  </tr>
  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['joblines']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="joblines" value="<?=$configArr['joblines']['value']?>" class="sys_input"></td>
  
  <?
	if (isset($configArr['joborder']))  
	  {
  ?>

	<td width="25%" height="30" class="title_td"><?=$configArr['joborder']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect("joborder",$orderArr,$configArr['joborder']['value'])?></td>
  </tr>
  <?
	  }
  }
  if (isset($configArr['downlines']))
  {
  ?>
   <tr class="table_title">
	<td  colspan="4" class="td_one">下载设置</td>
  </tr>

  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['downlines']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="downlines" value="<?=$configArr['downlines']['value']?>" class="sys_input"></td>
 
  <?
	if (isset($configArr['downorder']))  
	  {
  ?>
 
	<td width="25%" height="30" class="title_td"><?=$configArr['downorder']['name']?> ：</td>
	<td width="25%" height="30"><?HtmlSelect("downorder",$orderArr,$configArr['downorder']['value'])?></td>
  </tr>
  <?
	  }
  }
  if (isset($configArr['guestlines']))
  {
  ?>
    <tr class="table_title">
	<td  colspan="4" class="td_one">留言设置</td>
  </tr>

  <tr>
	<td width="25%" height="30" class="title_td"><?=$configArr['guestlines']['name']?> ：</td>
	<td width="25%" height="30"><input type="text" name="guestlines" value="<?=$configArr['guestlines']['value']?>" class="sys_input"></td>
    <td width="25%" height="30" class="title_td"></td>
	<td width="25%" height="30"></td>
  </tr>
  <?
  }
  ?> 
  
   <tr>
	<td  colspan="4" align="center" height="80" valign="middle"  class="btn_fgx"><input type="submit" value="" class="sys_btn"></td>
  </tr>
 
</table>
   
         
  
 </div>
  
    </td>
  </tr>
</table>




</body>
</html>

