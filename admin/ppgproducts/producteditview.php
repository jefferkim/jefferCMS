<table width="98%">
<tr>
	<td>名称：</td>
	<td><input type="text" name="called" value="<?=$called?>"></td>
	<td>分类：</td>
	<td><?HtmlSelect('pid',$typeArr,$currentType)?></td>
</tr>
<tr>
	<td>语言：</td>
	<td>
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
	}
	?>
	</td>
	<td>排序：</td>
	<td><input type="text" name="orderby" value="<?=$orderBy?>"></td>
</tr>
<tr>
	<td></td>
	<td colspan="3">是否显示：<?HtmlSelect('isshow',$showArr,$currentShow)?>是否推荐：<?HtmlSelect('iscommend',$showArr,$currentCommend)?></td>
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
	<td>产品简介：</td>
	<td colspan="3">
	<textarea name="memo" rows="3" cols="50"><?=$memo?></textarea>
	</td>
</tr>
<tr>
	<td>颜色:</td>
	<td><input type="button" value="添加颜色" id="btnColorAdd"></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>
	<table id="tbColorList">
		<tr>
			<td width="80">名称</td>
			<td width="80">图片</td>
			<td width="80">图片组数</td>
			<td></td>
		</tr>
	</table>
	</td>
</tr>
<tr>
	<td></td>
	<td colspan="3"><input type="submit" value="保存" class="btnstyle"><input type="reset" value="重填" class="btnstyle"><input type="button" value="关闭" class="btnstyle" onclick="window.close();"></td>
</tr>
</table>
<div id="winColorWindow" style="display:none;">
<table>
<tr>
	<td>名称:</td>
	<td><input type="text" name="colorname" value=""></td>
</tr>
<tr>
	<td>图片:</td>
	<td><input type="button" value="选择颜色图片" id="btnChooseColor"><input type="hidden" name="txtColor"></td>
</tr>
<tr>
	<td></td>
	<td><input type="button" id="btnColorOk" value="保存"><input type="button" id="btnColorCancel" value="取消"></td>
</tr>
</table>
</div>
<div id="winPictureWindow" style="display:none">
<table>
<tr>
	<td>小图片:</td>
	<td><input type="button" value="选择小图片" id="btnChooseSmallPic"><input type="hidden" name="txtSmallPic"></td>
</tr>
<tr>
	<td>中图片:</td>
	<td><input type="button" value="选择中图片" id="btnChooseMiddlePic"><input type="hidden" name="txtMiddlePic"></td>
</tr>
<tr>
	<td>大图片:</td>
	<td><input type="button" value="选择大图片" id="btnChooseBigPic"><input type="hidden" name="txtBigPic"></td>
</tr>
<tr>
	<td><input type="hidden" name="colorpos"></td>
	<td><input type="button" id="btnPictureOk" value="保存"><input type="button" id="btnPictureCancel" value="取消"></td>
</tr>
</table>
</div>
<div id="message" style="display:none;">
	<span id="progressbars"></span>
</div>