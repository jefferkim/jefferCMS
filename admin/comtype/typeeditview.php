<form>
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
<?foreach($customerFieldArr as $fieldObj){?>
<tr>
	<td><?=$fieldObj->CALLED?>：</td>
	<td colspan="3">
	<?=CustomerFieldEdit($fieldObj->UITYPE,$fieldObj->FIELDNAME,$fieldObj->DEFAULTVALUE,$fieldObj->SETVALUE)?>
	</td>
</tr>
<?
}
?>
<tr>
	<td>分类描述：</td>
	<td colspan="3">
	<?
	include_once(ROOTDIR."lib/fckeditor/fckeditor.php");
	$oFCKeditor = new FCKeditor('memo') ;
	$oFCKeditor->BasePath = $SysConfig['rooturl'].'lib/fckeditor/' ;
	$oFCKeditor->Height = 300;
	$oFCKeditor->Value = $memo ;
	$oFCKeditor->Create() ;
	?></td>
</tr>
<tr>
	<td></td>
	<td colspan="3"><input type="submit" value="保存" class="btnstyle"><input type="reset" value="重填" class="btnstyle"><input type="button" value="关闭" class="btnstyle" onclick="window.close();"></td>
</tr>
</table>
</form>