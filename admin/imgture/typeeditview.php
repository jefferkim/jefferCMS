<table width="90%" align="center">
<tr>
	<td width="17%" height="30">分类名称：</td>
	<td width="63%"><input type="text" name="called" value="<?=$called?>"></td>
	<td width="10%" align="center">语言：</td>
	<td width="10%">
	<?
	if ($editMode)
	{
		HtmlSelect('language',$lanArr,$currentLan);
	}
	else
	{
		while(list($key,$val) = each($lanArr))
		{
			echo '<input type="checkbox" name="language" value="'.$key.'">'.$val."&nbsp;";
		}
	}?>
	</td>
</tr>
<?foreach($customerFieldArr as $fieldObj){?>
<tr>
	<td height="30"><?=$fieldObj->CALLED?>：</td>
	<td colspan="3">
	<?=CustomerFieldEdit($fieldObj->UITYPE,$fieldObj->FIELDNAME,$fieldObj->DEFAULTVALUE,$fieldObj->SETVALUE)?>
	</td>
</tr>
<?
}
?>
<tr>
	<td height="30">备注：</td>
	<td colspan="3"><textarea name="memo" rows="4" cols="50"><?=$memo?></textarea></td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" value="保存" class="btnstyle"><input type="reset" value="重填" class="btnstyle"></td>
	<td></td>
	<td></td>
</tr>
</table>