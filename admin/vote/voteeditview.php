<form>
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr class="table_title">
    <td colspan="4" class="td_one">投票问题添加/修改</td>
    </tr>
    
    <tr>
     <td colspan="4">
    
   <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#DDEFFB">  
  <tr>
  	<td width="10%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">问题名称：</td>
	<td width="40%" height="30" bgcolor="#ffffff" style="padding-left:10px;"><input type="text" name="subject" value="<?=$subject?>" class="sys_input"></td>
    <td width="10%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">语言名称：</td>
	<td width="40%" height="30" bgcolor="#ffffff" style="padding-left:10px;"><?HtmlSelect('lan',$lanArr,$currentLan)?></td>
</tr>

<?
$i=0;
foreach($customerFieldArr as $fieldObj){
?>

<?
if($fieldObj->UITYPE=="textarea"){
?>

<tr>

  	<td  height="24" class="title_td" bgcolor="#F6FAFD" align="right"><?=$fieldObj->CALLED?>：</td>
	<td  height="24" colspan="3" bgcolor="#FFF"  style="padding-left:10px;"><?=CustomerFieldEdit($fieldObj->UITYPE,$fieldObj->FIELDNAME,$fieldObj->DEFAULTVALUE,$fieldObj->SETVALUE)?></td>
    </tr>

<?
}else{
?>

<?
if($i%2==0){
?>

<tr>
  	<td width="10%" height="30" class="title_td" align="right"><?=$fieldObj->CALLED?>：</td>
	<td width="40%" height="30"  style="padding-left:10px;"><?=CustomerFieldEdit($fieldObj->UITYPE,$fieldObj->FIELDNAME,$fieldObj->DEFAULTVALUE,$fieldObj->SETVALUE)?></td>
    
<?
}else{
?>    
  	<td width="10%" height="30" class="title_td" align="right"><?=$fieldObj->CALLED?>：</td>
	<td width="40%" height="30"  style="padding-left:10px;"><?=CustomerFieldEdit($fieldObj->UITYPE,$fieldObj->FIELDNAME,$fieldObj->DEFAULTVALUE,$fieldObj->SETVALUE)?></td>
</tr>

<?
}
}
$i++;
}
?>

</table>
</td>
</tr>

 <tr>
	<td  bgcolor="#FFFFFF" colspan="4" align="center" height="40" valign="middle"  class="btn_line"><input type="submit" value="" class="sys_submit"> <input type="reset" value="" class="sys_reset"> <input type="button" value="" class="sys_close" onclick="window.close()"></td>
  </tr>


   </table>

</form>