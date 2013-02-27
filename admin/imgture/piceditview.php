<table width="90%" align="center">
<tr>
	<td width="14%" height="30">图片名称：</td>
	<td width="32%"><input  type="text" name="called" value="<?=$called?>"></td>
	<td colspan="2">
	语言：<?
	if ($editMode)
	{
		HtmlSelect('language',$lanArr,$currentLan);
	}
	else
	{
		while(list($key,$val) = each($lanArr))
		{
			echo '<input type="checkbox" name="language" value="'.$key.'">&nbsp;'.$val."&nbsp;";
		}
	}?></td>
</tr>
<tr>
 <td width="14%">是否显示：</td>
    
  <td height="30" width="32%"><?HtmlSelect('isshow',$showArr,$currentShow)?></td>
  <td colspan="2" >
  
  <table width="100%" border="0">
  <tr>
    <td>选择图片：</td>
    <td> <input type="button" value="上传产品大图" name="uploadspic"><input type="hidden" name="spic" value="<?=$spic?>"></td>
    <td> 图像尺寸：900*980</td>
  </tr>
</table>

  
 
 
  
  <input type="hidden" name="proid" value="<?=$proid?>">
  
  
  </td>
 
</tr>
<tr>
	<td height="30"></td>
	<td></td>
	<td width="39%" colspan="2"><input type="hidden" value="上传大图片" name="uploadbpic" />
    <input type="hidden" name="bpic" value="<?=$bpic?>" /></td>
</tr>
<?foreach($customerFieldArr as $fieldObj){?>
<tr>
	<td height="30"><?=$fieldObj->CALLED?>：</td>
	<td colspan="4">
	<?=CustomerFieldEdit($fieldObj->UITYPE,$fieldObj->FIELDNAME,$fieldObj->DEFAULTVALUE,$fieldObj->SETVALUE)?>
	</td>
</tr>
<?
}
?>
<tr id="message" style="display:none;">
	<td height="30"></td>
	<td><span id="progressbars"></span></td>
</tr>
<tr>
	<td height="30"></td>
	<td colspan="4"><div id="upimg"></div></td>
</tr>
<tr>
	<td height="30"></td>
	<td><input type="submit" value="保存" class="btnstyle"><input type="reset" value="重填" class="btnstyle"><input type="button" value="关闭" class="btnstyle" onclick="window.close();"></td>
	<td colspan="2"></td>
</tr>
</table>