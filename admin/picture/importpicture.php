<?
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",false);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

$lanArr = $SysConfig['customerLanguage'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$SysConfig['title']?></title>
<link rel="stylesheet" type="text/css" href="../cs/base.css">
<link rel="stylesheet" type="text/css" href="../cs/layout.css">
<link rel="stylesheet" type="text/css" href="../cs/typography.css">
  <style>
    .title_td{ text-indent:10px; color:#023266}
	.img_ico{ vertical-align:middle; margin-right:5px; }
  </style>
<script src="<?=$SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="../js/linker.js"></script>
<script>
$(function()
{
	$("#btnSave").click(function()
	{
		var outputLan = $("select[name=outputLan]").val();

		var importLan = $("select[name=importLan]").val();

		if (outputLan == importLan)
		{
			alert("不能在同一个语言内导接图片");
			return;
		}

		var q = $.param({
			outputLan : outputLan,
			importLan : importLan
		});
		
		AjaxSet("importpicturesave.php",q,function(data)
		{
			alert(data['result']);
			if (data['result']=='导入成功')
			{
				window.close();
			}
		});
	});
})
</script>
</head>



<body style="background:#FFF;">



<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="main_bj">

  <tr>
  
    <td valign="top">
    
    <div class="right_title">
    <span style="font-weight:bold">位置：</span>图片信息管理 — 图片数据导接
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">

   
   <table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr class="table_title">
    <td colspan="4" class="td_one">图片数据导接</td>
    </tr>
    <tr>
     <td colspan="4">
      <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#DDEFFB">
   
  <tr>
  	<td width="16%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">导出图片的语言：</td>
	<td width="34%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?HtmlSelect("outputLan",$lanArr,"cn")?></td>
    <td width="16%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">导入图片的语言：</td>
	<td width="34%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?HtmlSelect("importLan",$lanArr,"cn")?></td>
</tr>
 

 <tr>
	<td  colspan="4" align="center" height="40" valign="middle" bgcolor="#FFFFFF"  class="btn_line"><input type="button" id="btnSave" value="开始导接" class="btnstyle"> <input type="button" value="关闭" class="btnstyle" onclick="window.close()"></td>
  </tr>
  
  </table>
  </td>
  </tr>
  
</table>
   
          
 </div>
  
    </td>
    
  </tr>
  
</table>


</body>

</html>
