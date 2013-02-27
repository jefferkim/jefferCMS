<form>
<table width="100%" border="0" cellpadding="0" cellspacing="0" >

    <tr class="table_title">
    <td colspan="4" class="td_one">网站基本参数设置</td>
    </tr>
     <tr>
     <td colspan="4">
      <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#DDEFFB">
    
  <tr>
  	<td width="12%" height="30" bgcolor="#F6FAFD" align="right" class="title_td">站点名称：</td>
	<td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="webname" value="<?=$webname?>" class="sys_input"></td>
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right" class="title_td">站点标题：</td>
	<td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="title" value="<?=$title?>" class="sys_input"></td>
</tr>


 <tr>
  	<td width="12%" height="30" bgcolor="#F6FAFD" align="right" class="title_td">网站域名：</td>
	<td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="web" value="<?=$web?>" class="sys_input"></td>
    <td width="12%" height="30" bgcolor="#F6FAFD" align="right" class="title_td">上传目录：</td>
	<td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="upload" value="upload" class="sys_input" readonly="readonly"></td>
</tr>

 <tr>
  	<td width="12%" height="30" bgcolor="#F6FAFD" align="right" class="title_td">网站备案号：</td>
	<td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="beian" value="<?=$beian?>" class="sys_input"></td>
     <td width="12%" height="30" bgcolor="#F6FAFD" align="right" class="title_td">语言名称：</td>
	<td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?HtmlSelect('lan',$lanArr,$currentLan)?></td>
    </tr>


 <tr>
  	<td width="12%" height="30" bgcolor="#F6FAFD" align="right" class="title_td">站点关键字（keywords）：</td>
	<td width="38%" height="30" colspan="3" bgcolor="#FFFFFF" style="padding:10px;"><textarea name="keywords" rows="4" cols="50" class="txt"><?=$keywords?></textarea></td>
</tr>


 <tr>
  	<td width="12%" height="30" bgcolor="#F6FAFD" align="right" class="title_td">站点描述（description）：</td>
	<td width="38%" height="30" colspan="3" bgcolor="#FFFFFF" style="padding:10px;"><textarea name="description" rows="4" cols="50" class="txt"><?=$description?></textarea></td>

</tr>




 <tr>
	<td  colspan="4" align="center" height="40" valign="middle" bgcolor="#FFFFFF"  class="btn_line"><input type="submit" value="" class="sys_submit"> <input type="reset" value="" class="sys_reset"> <input type="button" value="" class="sys_close" onclick="window.close()"></td>
  </tr>
  
  </table>
  </td>
  
  </tr>
  
  
</table>


</form>