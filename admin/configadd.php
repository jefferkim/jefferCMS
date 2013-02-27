<?php
	include_once("config.php");
	LoginCheck($SysConfig['rooturl']."/login.php",true);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" background="images/tab_05.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="30"><img src="images/tab_03.gif" width="12" height="30" /></td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="5%"><div align="center"><img src="images/tb.gif" width="16" height="16" /></div></td>
                <td width="95%"><span class="STYLE3">你当前的位置</span>：系统设置添加</td>
              </tr>
            </table></td>
            <td width="30%" align="left" class="handler2">&nbsp;</td>
            <td width="20%" align="left"><table border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><div class="topmenu"><img src="images/002.gif" width="10" height="10"><a href="javascript:closeBg();"> 关闭</a></div></td>

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
        <td style="padding-left:10px;padding-right:10px; background-color:#FFF;">
        	<div style="height:170px;">
        <form action="" method="post">
        <table cellspacing="1" cellpadding="4" class="styletable" width="98%">
            <tr>
                <td height="30" align="center">名称:</td>
                <td height="30"><input type="text" name="name" value=""></td>
            </tr>
            <tr>
                <td height="30" align="center">代码:</td>
                <td height="30"><input type="text" name="code" value=""></td>
            </tr>
            <tr>
                <td height="30" align="center">值　:</td>
                <td height="30"><input type="text" name="val" value=""></td>
            </tr>  
            <tr>
            	<td height="30" colspan="2"><input type="submit" value="保存" class="btnstyle"></td>
            </tr>
        </table>
        </form>
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
</table>
