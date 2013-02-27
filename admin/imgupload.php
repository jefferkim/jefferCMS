<?php
	include_once("config.php");
	LoginCheck($SysConfig['rooturl']."/login.php",true);
	$cdb = $SysConfig['customerdb'];
	$record = $cdb->Execute("SHOW TABLES");
	$rs = array();
	while(!$record->EOF)
	{
		$rs[] = $record->FetchObject();
		$record->MoveNext();
	}
	$countlist = 12;
?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?echo $SysConfig['title'];?></title>
<style type="text/css">
<!--
@import url("css.css");
-->
</style>
<script src="<?echo $SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?echo $SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="<?echo $SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="./js/jquery.ocupload-1.1.2.js"></script>
<script src="./js/linker.js"></script>
<script src="./js/upload.js"></script>
<script language="javascript">
var rooturl = "<?php echo $SysConfig['independ'] === true ? $SysConfig['domain']."/upload" : $SysConfig['domain']."/".$_SESSION['SWEBADMIN_USERNAME']."/upload";?>";
$(function(){
	$(".csh").find("input[type=button]").each(function(i){
		picFiles(i+1);						
	});
	$("#clearinput").click(function(){
		clearFile();					  
	});
	$("#btnChanges").click(function()
	{
		var arr = {};
		var type = $("select[name=slttype]").val();
		if(type == '请选择')
		{
			alert("请选择分类！");
			return false;
		}
		var reValue = $(".csh").find("input[rel=picurl]").val();
		if(typeof(reValue)== 'undefined')
		{
			alert("未选择图片！");
			return false;
		}
		$(".csh").find("input[type=hidden]").each(function(){
			arr["called"] = type;
			arr["opera"] = "save";
			var name = $(this).attr("name");
			var val = $(this).val();
			arr[name] = val;
		});
		var param = $.param(arr);
		AjaxSet("uploadsave.php",param,function(data)
		{
			alert(data.DATA);
			clearFile();
		})
	});
});
</script>

</head>

<body style="overflow:hidden;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="9" valign="middle" bgcolor="#0a5c8e"><span class="navPoint" title="关闭/打开左栏" onClick="frameToggle();"><img src="images/main_41.gif" name="img1" width=9 height=52 border="0"></span></td>
    <td align="center" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;">
      <tr>
        <td height="8" style=" line-height:8px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;">
          <tr>

            <td width="14"><img src="images/main_24.gif" width="14" height="8"></td>
            <td background="images/main_26.gif" style="line-height:8px;">&nbsp;</td>
            <td width="7"><img src="images/main_28.gif" width="7" height="8"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;">
          <tr>

            <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" background="images/tab_05.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="30"><img src="images/tab_03.gif" width="12" height="30" /></td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="30%" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>

                <td width="5%"><div align="center"><img src="images/tb.gif" width="16" height="16" /></div></td>
                <td width="95%"><span class="STYLE3">你当前的位置</span>：图片上传</td>
              </tr>
            </table></td>
            <td width="70%" align="left"><table border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle">&nbsp;</td>

              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="16"><img src="images/tab_07.gif" width="16" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="8" background="images/tab_12.gif">&nbsp;</td>
        <td style="padding-left:10px;padding-right:10px;">
        <?php
        	if(in_array('t_upload',$rs)){
		?>
        <div class="csh">
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
             <td height="30" colspan="4" align="left" style="padding-left:20px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="15%" height="30" align="left" valign="middle">请选择要添加的图片分类&nbsp;</td>
                 <td width="14%" height="30" align="left" valign="middle"> 
                 <select name="slttype" id="slttype">
                 <option>请选择</option>
                 <option value="单内容">单内容</option>
                 <option value="产品展示">产品展示</option>
                 <option value="图片列表">图片列表</option>
                 <option value="新闻列表">新闻列表</option>
               </select></td>
                 <td width="28%" height="30" align="left" valign="middle"><a href="uploadlist.php"><img src="images/002.gif" width="10" height="10"> 查看图片列表</a></td>
                 <td width="40%" height="30" align="left" valign="middle"><strong>点击文本框即可完成复制！</strong></td>
                 <td width="3%" height="30" align="left" valign="middle">&nbsp;</td>
               </tr>
             </table></td>
             </tr>
           <?php
           	for($i=1;$i<=$countlist;$i++){
		   ?>
           <tr>
              <td width="13%" height="30" align="center"><input type="button" name="uploadpic<?=$i?>" value="上传分类图片"></td>
              <td width="11%" align="center">上转后图片：</td>
              <td width="59%" id="progressbars<?=$i?>"></td>
              <td width="17%" id="upimg<?=$i?>"></td>
            </tr>
           <?php
			}
		   ?>
            <tr>
              <td height="30" colspan="4" align="center"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr align="center" valign="middle">
		  <td width="33%">&nbsp;</td>
		  <td width="25%" align="left"><table width="51" height="24" border="0" cellpadding="0" cellspacing="0" class="an">
			<tr>
			  <td align="center" valign="middle"><a href="javascript:;" id="btnChanges">保存</a></td>
			</tr>
		  </table></td>
		  <td width="42%" align="left"><table width="51" height="24" border="0" cellpadding="0" cellspacing="0" class="an">
			<tr>
			  <td align="center" valign="middle"><a href="javascript:;" id="clearinput">清空</a></td>
			</tr>
		  </table></td>
		</tr>
	  </table></td>
              </tr>
          </table>
        </div>
        <?php
			}
			else
			{
				echo '<div align="center">无图片上传！</div>';
			}
		?>
        </td>
        <td width="8" background="images/tab_15.gif">&nbsp;</td>

      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="35" background="images/tab_19.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="35"><img src="images/tab_18.gif" width="12" height="35" /></td>
        <td>&nbsp;</td>
        <td width="16"><img src="images/tab_20.gif" width="16" height="35" /></td>
      </tr>
    </table></td>
  </tr>
</table></td>
            <td width="3" style="width:3px; background:#0a5c8e;">&nbsp;</td>
          </tr>

        </table></td>
      </tr>
      <tr>
        <td height="12" style="line-height:12px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;">
          <tr>
            <td width="14" height="12"><img src="images/main_46.gif" width="14" height="12"></td>
            <td background="images/main_48.gif" style="line-height:12px;">&nbsp;</td>
            <td width="7"><img src="images/main_50.gif" width="7" height="12"></td>
          </tr>

        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</html>
