<?
include_once("../config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$SysConfig['title']?></title>
<link rel="stylesheet" type="text/css" href="../cs/base.css">
<link rel="stylesheet" type="text/css" href="../cs/layout.css">
<link rel="stylesheet" type="text/css" href="../cs/typography.css">
<script src="../js/ps_jquery.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	
var h=$(window).height()-68; //浏览器当前窗口可视区域高度
$("#box").css("height",h+"px");
} )
		 
$(function(){

$("#data_table").find("tr").mousemove(function(){
	
	$(this).find("td").css("background-color","#FBFCFE");
})

$("#data_table").find("tr").mouseout(function(){
	
	$(this).find("td").css("background-color","");
})

$("input[name=language]").change(function()
	{
	 window.location.href="index.php?language="+$(this).val();
	});


})
		 
</script>

</head> 
<body style="background:#FFF;">
  
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="main_bj">

  <tr>
  
    <td valign="top" align="left">
    
    <div class="right_title">
    <span style="font-weight:bold">位置：</span>SEO信息管理 — SEO文件列表
   </div>
    <div id="search" style="padding-top:5px;">
   <table width="100%" border="0" cellpadding="0" cellspacing="0" >
    <tr>
     <td align="right">
    <?
 $language="cn";
	if($_REQUEST['language']){
		
		$language=$_REQUEST['language'];
	}
	
   $lanArr = $SysConfig['customerLanguage'];
     $i=0;
		while(list($key,$val) = each($lanArr))
		{
			if($language){
			if($language==$key){
				
				echo '<input type="radio" name="language" value="'.$key.'" checked>&nbsp;'.$val."&nbsp;";
			}else{
				echo '<input type="radio" name="language" value="'.$key.'">&nbsp;'.$val."&nbsp;";
			}
			}else{
			
			if($i==0){
				echo '<input type="radio" name="language" value="'.$key.'" checked>&nbsp;'.$val."&nbsp;";
				
			}else{
				echo '<input type="radio" name="language" value="'.$key.'">&nbsp;'.$val."&nbsp;";
			}
			}
			
        $i++;	
		}
   ?>
   </td>
   </tr>
   </table>
   
   </div>
   
   <div id="box" style="overflow-y:auto; vertical-align:top">
   
   
  

 <table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr class="table_title">
    <td colspan="6" class="td_one">SEO文件列表关键字添加/修改</td>
    </tr>
</table>


 
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#C3D9EE" style="color:#074880" id="data_table">   
        <?php
		
	function extend($file_name)   
       {   
		$extend = pathinfo($file_name);   
		$extend = strtolower($extend["extension"]);   
		return $extend;   
     }  
	
   
		
    $dir="../../".$language;		
    @$dirs=opendir($dir);
    while (@$file=readdir($dirs)) {
    @$b="$dir/$file";
    @$a=is_dir($b);
	if($a=="0"){
	@$size=filesize("$dir/$file");
	@$size=$size/1024 ;
    @$size= number_format($size, 3);    
	@$lastsave=date("Y-n-d H:i",filectime("$dir/$file"));
	@$fileperm=substr(base_convert(fileperms("$dir/$file"),10,8),-4);
	$php_filename=substr($file,0,strrpos($file, '.'));
	$extend=extend($file);
	
	if($extend=="php"){
	?>
    
    <tr>
    
    <td bgcolor="#F1F9FD" height="30" align="center" width="5%"><img src="../images/icon_txt.gif" width="16" height="16" /></td>
    <td bgcolor="#F1F9FD" width="40%" style="padding-left:10px; font-weight:bold"><?=$file?></td>
    <td bgcolor="#F1F9FD" style="padding-left:10px;" width="15%"><?=$size?> KB</td>
    <td bgcolor="#F1F9FD" style="padding-left:10px;" width="15%"><?=$lastsave?></td>
    <td bgcolor="#F1F9FD" style="padding-left:10px;" width="15%"><a href='edit.php?editfile=<?=$php_filename?>&language=<?=$language?>'>添加网站SEO关键字</a></td>
    
    </tr>

      
      <?
	}
	}
	}
@closedir($dirs); 
?>

</table>


 </div>
 
 
      </td>
  </tr>
</table>


 
</body> 
</html>

