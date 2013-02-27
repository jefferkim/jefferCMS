<?php
include_once("config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);
$language = $SysConfig['customerLanguage'];
$db = $SysConfig['customerdb'];

$content = array();
$filecontent = array();
$result = '';
$lan_code = "angle_manager_";

function AddParam($db, $name, $code, $value , $isrefersh = false)
{
	$db->Execute("INSERT INTO t_config(name,code,value) values(?,?,?)",array($name, $code, $value));
	if($isrefersh)
	{
		$rs = $db->Execute("SELECT * from `t_config` WHERE code=?", array($code));
		while(!$rs->EOF)
		{
			$obj = $rs->FetchObject();
			$record = $obj->VALUE;
			$rs->MoveNext();
		}
		return $record;
	}
}

function UpdateParam($db, $code, $value)
{
	$db->Execute("UPDATE `t_config` SET value=? WHERE code=?", array($value, $code));
}

if($SysConfig['filewrite'])
{
	foreach($language as $lanCode => $lan)
	{
		$file = ROOTDIR.$_SESSION['SWEBADMIN_USERNAME']."/".$lanCode."/bottom.php";
		if (!file_exists($file))
		{
			if(!copy(ROOTDIR."bottombak.php",$file))
			{
				$result = '请将bottom.php手动移至于'.$lanCode.'目录'."<br>";
			}
		}
		if (isset($_POST[$lan_code.$lanCode]) && $_POST[$lan_code.$lanCode]!="")
		{
			$jsc = stripslashes($_POST[$lan_code.$lanCode]);
			UpdateParam($db, $lan_code.$lanCode, $jsc);
			$f = fopen($file,"w");
			if(fwrite($f,$jsc))
			{
				$result = '修改成功！';
			}
			fclose($f);
		}
		$content[$lan_code.$lanCode] = file_get_contents($file);
	}
}
else
{
	foreach($language as $lanCode => $lan)
	{
		if (isset($_POST[$lan_code.$lanCode]) && $_POST[$lan_code.$lanCode]!="")
		{
			$jsc = stripslashes($_POST[$lan_code.$lanCode]);
			UpdateParam($db, $lan_code.$lanCode, $jsc);
			$result = '修改成功！';
		}
		$rs = $db->Execute("SELECT * from `t_config` WHERE code=?", array($lan_code.$lanCode));
		if($rs->RecordCount()==0)
		{
			$filecontent[$lanCode] = '';
			$content[$lan_code.$lanCode] = AddParam($db, '外部角本',$lan_code.$lanCode, $filecontent[$lanCode],true);
			
		}
		else
		{
			while(!$rs->EOF)
			{
				$obj = $rs->FetchObject();
				$content[$obj->CODE] = $obj->VALUE;
				$rs->MoveNext();
			}
		}
	}
}
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
<script language="javascript">
$(function()
{
	$("#btnChange").click(function()
	{
		$("form").submit();
	});

	$("#btnReset").click(function()
	{
		$("textarea").val('');
	});
})
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
                <td width="95%"><span class="STYLE3">你当前的位置</span>：<span>外部脚本管理</span></td>
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
        <div class="csh">
        <form method="post" name="form" action="">
        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="MainTable">
	<tr align="left" valign="top" class="cn">
	  <td colspan="5"><table width="600" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td></td>
		</tr>
	  </table></td>
	</tr>
	<tr align="left" valign="top" class="cn">
	  <td height="25" colspan="5" align="center">
	  <span style="color:red;font-weight:bold;"><?
	  if (isset($result))
	  {
		echo $result;
	  }
	  ?></span>
	  </td>
	  </tr>
	<tr align="left" valign="top" class="cn">
	  <td colspan="5">
	  <div style="margin:0 auto;width:480px;">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		  <tr>
		    <td height="35" colspan="2" align="left" valign="middle" style="padding-left:5px;">脚本内容：</td>
		    </tr>
            <?php
			foreach($language as $lanCode => $lan)
			{
			?>
		  <tr>
		    <td width="10%" align="left" valign="top"><?=$lan?></td>
		    <td width="90%" align="left" valign="middle" style="padding:5px 0;">
            <textarea name="<?echo $lan_code.$lanCode?>" rows="6" cols="60"><?=$content[$lan_code.$lanCode]?></textarea>
            </td>
		    </tr>
		<?php
		}	
		?>
		  </table>
	  </div></td>
	</tr>
	<tr align="left" valign="top" class="cn">
	  <td>&nbsp;</td>
	  <td height="40" colspan="4" align="left" valign="middle"><table width="600" border="0" cellspacing="0" cellpadding="0">
		<tr align="center" valign="middle">
		  <td width="104">&nbsp;</td>
		  <td width="78" align="left"><table width="51" height="24" border="0" cellpadding="0" cellspacing="0">
			<tr>
			  <td align="center" valign="middle"><input type="submit" value="确定" class="btnstyle"></td>
			</tr>
		  </table></td>
		  <td width="418" align="left"><table width="51" height="24" border="0" cellpadding="0" cellspacing="0" class="an">
			<tr>
			  <td align="center" valign="middle"><a href="#" id="btnReset">清空</a></td>
			</tr>
		  </table></td>
		</tr>
	  </table></td>
	</tr>
  </table></form></div>
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
