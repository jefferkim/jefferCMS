<?php
include_once("../config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

if (!UserIsInRole('F0',$userRole))
{
	echo '没有权限访问';
	exit();
}
$proid=$_REQUEST['pid'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$SysConfig['title']?></title>
<link rel="stylesheet" type="text/css" href="../cs/base.css">
<link rel="stylesheet" type="text/css" href="../cs/layout.css">
<link rel="stylesheet" type="text/css" href="../cs/typography.css">
<script>
var rooturl = "<?echo globalpath()?>";
var proid='<? echo $_REQUEST['pid']?>';
var g_language = '<? echo $SysConfig['currentLan'];?>';
//var g_user = '<?echo $_SESSION["SWEBADMIN_USERNAME"]?>';
</script>


<script type="text/javascript" src="../uploadify/jquery-1.4.2.min.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="../js/jquery.pagination.js"></script>
<script src="<?=$SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="../js/linker.js"></script>
<script type="text/javascript" src="picture.js"></script>

    <!--上传组件-->
    <link href="../uploadify/uploadify.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../uploadify/swfobject.js"></script>
    <script type="text/javascript" src="../uploadify/jquery.uploadify.v2.1.4.min.js"></script>
    
    

</head>

<body style="background:#FFF;">



<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="main_bj">

  <tr>
  
      <td valign="top">
    
    <div class="right_title">
    <span style="font-weight:bold">位置：</span>产品信息管理 — 相关图片添加/列表
   </div>
    
  <div id="box" style="overflow-y:auto; vertical-align:top">


<table width="100%" border="0" cellpadding="0" cellspacing="0"  >
<tr class="table_title">
    <td colspan="4" class="td_one">相关图片添加/列表</td>
    </tr>

   <tr>
   
   <td colspan="4" >
   
   <div style="width:740px; height:auto; margin:0 auto; padding-bottom:5px;">
   
        	<div id="custom-demo" class="demo" style="margin-top:10px; margin-left:10px; float:left; display:inline">
            
         
        <script type="text/javascript">
				$(function() {
				$('#custom_file_upload').uploadify({
  'uploader'       : '../uploadify/uploadify.swf',
  'script'         : '../uploadify/uploadify.php?pid=<?=$proid?>',
  'cancelImg'      : '../uploadify/cancel.png',
  'folder'         : '../../upload',
  'multi'          : true,
  'auto'           : true,
  'fileExt'        : '*.jpg;*.gif;*.png',
  'fileDesc'       : 'Image Files (.JPG, .GIF, .PNG)',
  'queueID'        : 'custom-queue',
  'queueSizeLimit' : 100,
  'simUploadLimit' : 100,
  'removeCompleted': false,
  'onSelectOnce'   : function(event,data) {
      $('#status-message').text(data.filesSelected + ' files have been added to the queue.');
    },
  'onAllComplete'  : function(event,data) {
      $('#status-message').text(data.filesUploaded + ' files uploaded, ' + data.errors + ' errors.');
	 
	  getRefresh();
    }
});				

});
				</script>








        <div class="demo-box">
        
        
<div id="custom-queue"></div>


<input id="custom_file_upload" type="file" name="Filedata" />        </div>
      </div>
      
      <style>
	  
	  .img_list{ width:auto; margin-top:10px;  }
	  .img_list ul { height:310px;}
	  .img_list ul li{ width:100px; height:92px; float:left; margin-left:16px !important; margin-left:14px;  margin-bottom:10px !important; margin-bottom:7px; position:relative; display:inline;}
	  .img_list ul li .del_a{ position:absolute; right:-2px !important; right:2px; top:2px;}
	  
	  .img_list ul li .pic_a{ width:100px; height:92px; padding:1px; border:solid 1px #C7C5C6; display:block}
	  .img_list ul li .pic_a:hover{width:100px; height:92px; padding:1px; border:solid 1px #890D0D;}
	  
	  .img_list ul li img{ width:100px; height:92px; display:block;}
	  
	  </style>
           <div class="img_list">

           <ul id="tablist">

           </ul>
     
          <div id="pager" align="center" class="pagination" style="  margin-bottom:10px !important; margin-bottom:0px;"></div>
           </div>
      
       
   
      </div>
      
      <br class="clear_cs" />
      </td>
      </tr>
      
</table>
      
      
      
 </div>
  
    </td>
    
  </tr>
  
</table>


</body>


</html>