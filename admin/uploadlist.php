<?php
	include_once("config.php");
	LoginCheck($SysConfig['rooturl']."/login.php",true);
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
<script src="<?echo $SysConfig['jsroot']?>/jquery.pagination.js"></script>
<script src="<?echo $SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="./js/linker.js"></script>
<script src="./js/upload.js"></script>
<script language="javascript">
var g_type = "";
var rooturl = "<? echo $SysConfig['domain']."/upload/".$_SESSION['SWEBADMIN_USERNAME'];?>";
$(function(){
	AjaxGet(g_url,getParameter(),dataProcess);
	$("select[name=slttype]").change(function()
	{
		g_type = $(this).val();
		if(g_type == '请选择')
		{
			g_type = "";
		}
		g_currentPage = 1;
		AjaxGet(g_url,getParameter(),dataProcess);
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
                <td width="95%"><span class="STYLE3">你当前的位置</span>：查看图片</td>
              </tr>
            </table></td>
            <td width="70%" align="left"><table border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle" style="padding-right:50px;"> 
                <select name="slttype" id="slttype">
                 <option>请选择</option>
                 <option value="单内容">单内容</option>
                 <option value="产品展示">产品展示</option>
                 <option value="图片列表">图片列表</option>
                 <option value="新闻列表">新闻列表</option>
               </select></td>
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
        <div class="csh">
        <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="b5d6e6" id="tablist">
          <thead><tr>
           <td width="7%" height="23" align="center" valign="middle" background="images/bg.gif" bgcolor="#FFFFFF">编号</td>
            <td width="37%" align="left" valign="middle" background="images/bg.gif" bgcolor="#FFFFFF">&nbsp;显示名称</td>
            <td width="19%" align="center" valign="middle" background="images/bg.gif" bgcolor="#FFFFFF">类别</td>
            <td width="37%" align="center" valign="middle" background="images/bg.gif" bgcolor="#FFFFFF">上传时间</td>
            </tr>
          </thead>
            <tbody></tbody>
           </table></div>
        </td>
        <td width="8" background="images/tab_15.gif">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="35" background="images/tab_19.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="35"><img src="images/tab_18.gif" width="12" height="35" /></td>
        <td align="center" valign="middle"><div id="pager" class="pagination">&nbsp;</div></td>
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
