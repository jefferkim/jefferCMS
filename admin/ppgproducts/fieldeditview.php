<table width="98%">
<tr>
	<td>描述名称：</td>
	<td><input type="text" name="called" value="<?=$called?>"></td>
	<td>数据库字段名称</td>
	<td><input type="text" name="fieldname" value="<?=$fieldname?>"></td>
</tr>
<tr>
	<td>数据库字段类型</td>
	<td><?HtmlSelect('datatype',$dataTypeArr,$currentDataType)?></td>
	<td>页面显示类型</td>
	<td><?HtmlSelect('uitype',$uiTypeArr,$currentUiType)?></td>
</tr>
<tr>
	<td>默认值：</td>
	<td colspan="3"><textarea name="defaultvalue" rows="3" cols="50"><?=$defaultValue?></textarea><br />(如果页面显示为select类型，则列表值用竖线(|)分隔开)</td>
</tr>
<tr>
	<td></td>
	<td colspan="3"><input type="submit" value="保存" class="btnstyle"><input type="reset" value="重填" class="btnstyle"><input type="button" value="关闭" class="btnstyle" onclick="window.close()"></td>
</tr>
</table>