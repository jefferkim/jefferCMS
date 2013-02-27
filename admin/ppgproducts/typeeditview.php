<table width="98%">
<tr>
	<td>名称：</td>
	<td><input type="text" name="called" value="<?=$called?>"></td>
	<td>父类：</td>
	<td><?HtmlSelect('pid',$typeArr,$currentType)?></td>
</tr>
<tr>
	<td>语言：</td>
	<td><?
	if ($editMode)
	{
		HtmlSelect('language',$lanArr,$currentLan);
	}
	else
	{
		while(list($key,$val)=each($lanArr))
		{
			echo '<input type="checkbox" name="language" value="'.$key.'">'.$val."&nbsp;";
		}
	}
	?></td>
	<td>排序：</td>
	<td><input type="text" name="orderby" value="<?=$orderBy?>"></td>
</tr>
<tr>
	<td></td>
	<td colspan="3">是否显示：<?HtmlSelect('isshow',$showArr,$currentShow)?></td>
</tr>
<tr>
	<td>分类描述：</td>
	<td colspan="3"><textarea name="memo" rows="4" cols="50"><?=$memo?></textarea></td>
</tr>
<tr>
	<td></td>
	<td colspan="3"><input type="submit" value="保存" class="btnstyle"><input type="reset" value="重填" class="btnstyle"><input type="button" value="关闭" class="btnstyle" onclick="window.close();"></td>
</tr>
</table>