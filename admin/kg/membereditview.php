<?
$zy_array = array('钢琴','电子琴','声乐','其它');
?>
<table width="98%">
<tr>
	<td>姓名：</td>
	<td><input type="text" name="called" value="<?=$called?>"></td>
</tr>
<tr>
	<td>准考证号：</td>
	<td><input type="text" name="cardnum" value="<?=$cardnum?>"></td>
</tr>
<tr>
	<td>专业：</td>
	<td><select name="zy">
	<?
	foreach($zy_array as $item)
	{
		$selected = "";
		if ($zy == $item)
			$selected = " selected='true'";
	?>
	<option value="<?echo $item?>"<?echo $selected;?>><?echo $item?></option>
	<?
	}
	?>
	</select></td>
</tr>
<tr>
	<td>成绩：</td>
	<td><input type="text" name="cj" value="<?=$cj?>"></td>
</tr>
<?foreach($customerFieldArr as $fieldObj){?>
<tr>
	<td><?=$fieldObj->CALLED?>：</td>
	<td>
	<?=CustomerFieldEdit($fieldObj->UITYPE,$fieldObj->FIELDNAME,$fieldObj->DEFAULTVALUE,$fieldObj->SETVALUE)?>
	</td>
</tr>
<?
}
?>
<tr>
	<td></td>
	<td colspan="3"><input type="submit" value="保存" class="btnstyle"><input type="reset" value="重填" class="btnstyle"><input type="button" value="关闭" class="btnstyle" onclick="window.close();"></td>
</tr>
</table>