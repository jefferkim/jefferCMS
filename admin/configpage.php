<?php
include_once("config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);

function GetConfigArr($db)
{
	$configArr = array();
	$configRs = $db->Execute("SELECT * FROM t_config WHERE code LIKE 'page%' ORDER BY id");
	while(!$configRs->EOF)
	{
		$obj = $configRs->FetchObject();
		$configArr[$obj->CODE] = array(
			'name' => $obj->NAME,
			'value' => $obj->VALUE
		);
		$configRs->MoveNext();
	}
	return $configArr;
}

function AddParam($db, $arr, $name, $code, $value)
{
	if (!array_key_exists($code, $arr))
	{
		$db->Execute("INSERT INTO t_config(name,code,value) values(?,?,?)", array($name, $code, $value));
	}
}

if (isset($_POST['name']) && $_POST['name']!="")
{
	$configArr = GetConfigArr($SysConfig['customerdb']);
	$name = $_POST['name'];
	$code = $_POST['code'];
	$val = $_POST['val'];
	AddParam($SysConfig['customerdb'],$configArr,$name,$code,$val);
}

$configArr = GetConfigArr($SysConfig['customerdb']);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$SysConfig['title']?></title>
<style type="text/css">
<!--
@import url("css.css");
-->
</style>
<script src="<?echo $SysConfig['jsroot']?>/jquery.js"></script>
<script src="<?echo $SysConfig['jsroot']?>/jquery.ui.js"></script>
<script src="<?echo $SysConfig['jsroot']?>/jquery.blockUI.js"></script>
<script src="./js/linker.js"></script>
<script>
$(function()
{
	$("input[type=submit]").click(function()
	{
		var arr = {};
		$("textarea").each(function()
		{
			var name = $(this).attr("name");
			var val = $(this).val();
			arr[name] = val;
		});

		AjaxSet("configpagesave.php",$.param(arr),function(data)
		{
			alert(data['result']);
		})
	});
})
	
	function showBg() {
		AjaxGetCHTML("configadd.php","",function(data)
		{
			$(".dragDiv2").html(data);									 
		});
		var bH = $(document).height();
		var bW = $(document).width();
		$('<div id="fullbg"></div>').appendTo("body");
		$('<div class="dragDiv2"></div>').appendTo("body");
		$("#fullbg").css({ width: bW, height: bH});
		$(".dragDiv2").css("display", "block")
		.css("left",(($(document).width())/2-(parseInt($(".dragDiv2").width())/2))+"px")
		.css("top",80+"px");
		
	}
	function closeBg() {
		$("#fullbg").remove();
		$(".dragDiv2").remove();
	}
	$(function(){
		var h = screen.availHeight-370;
		if(h<500){
			$(".csh").css({"height":h,"overflow-y":"scroll"});
		}
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
                <td width="95%"><span class="STYLE3">你当前的位置</span>：<span>网页设置</span></td>
              </tr>
            </table></td>
            <td width="70%" align="left"><table border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle">
                	<div style="padding:0 10px;"><img src="images/002.gif" width="10" height="10">&nbsp;<a href="javascript:;" onClick="showBg();">添加网业设置</a></div>
                </td>
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
        	<div class="blueborder" style="width:600px;margin:0 auto;margin-top:10px;">
            <table cellspacing="1" cellpadding="4" class="styletable" width="98%">
          <?foreach($configArr as $key=>$val):?>
          <tr>
            <td><?echo $configArr[$key]['name'];?>:</td>
            <td style="padding:10px;"><textarea name="<?echo $key;?>" rows="4" cols="50"><?echo $configArr[$key]['value'];?></textarea></td>
          </tr>
          <?endforeach;?>
          <tr>
            <td height="35" colspan="2"><input type="submit" value="保存" class="btnstyle"></td>
            </tr>
          </table>
          </div>
        </div>
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
