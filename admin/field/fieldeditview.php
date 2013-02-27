<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr class="table_title">
    <td colspan="4" class="td_one">自定义字段添加</td>
    </tr>
    
    <tr>
     <td colspan="4">
      <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#DDEFFB"> 
    
  <tr>
  	<td width="13%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">描述名称：</td>
	<td width="37%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="called" value="<?=$called?>" class="sys_input"></td>
    <td width="13%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">数据库字段名称：</td>
	<td width="37%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="fieldname" value="<?=$fieldname?>" class="sys_input"></td>
</tr>

 <tr>
  	<td width="13%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">数据库字段类型：</td>
	<td width="37%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?HtmlSelect('datatype',$dataTypeArr,$currentDataType)?></td>
    <td width="13%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">页面显示类型：</td>
	<td width="37%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?HtmlSelect('uitype',$uiTypeArr,$currentUiType)?></td>
</tr>

 <tr>
  	<td width="13%" height="30" class="title_td" valign="top" bgcolor="#F6FAFD" align="right">默认值：</td>
	<td width="37%" height="100" valign="top" bgcolor="#FFFFFF" colspan="3" style="padding:10px;">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="75%"> <textarea name="defaultvalue" rows="3" cols="50" style="width:90%" class="txt"><?=$defaultValue?></textarea></td>
    <td width="25%">(如果页面显示为select类型，则列表值用竖线(|)分隔开)</td>
  </tr>
</table>

    
   
    
    </td>
    
  </tr>

 <tr>
	<td  colspan="4" align="center" height="40" valign="middle" bgcolor="#FFFFFF"  class="btn_line"><input type="submit" value="" class="sys_submit"> <input type="reset" value="" class="sys_reset"></td>
  </tr>
  
  
  </table>
  
  </td>
  
  </tr>
</table>