<form>
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr class="table_title">
    <td colspan="4" class="td_one"><?=$custom2?>添加/修改</td>
    </tr>
    <tr>
     <td colspan="4">
      <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#DDEFFB">
   
  <tr>
  	<td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">内容名称：</td>
	<td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="called" value="<?=$called?>" class="sys_input"></td>
    <td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">内容语言：</td>
	<td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?HtmlSelect('lan',$lanArr,$currentLan)?></td>
</tr>
 <?
	$i=0;
	$j=1;
	$count=count($deltext_customerFieldArr);
    foreach($deltext_customerFieldArr as $fieldObj){
	  
	  if($count%2!=0 && $j==$count){
	  
  ?>
  <tr>

  	<td height="24" class="title_td" bgcolor="#F6FAFD" align="right"><?=$fieldObj->CALLED?>：</td>
	<td height="24" colspan="3" bgcolor="#FFFFFF" style="padding:10px;"><?=CustomerFieldEdit($fieldObj->UITYPE,$fieldObj->FIELDNAME,$fieldObj->DEFAULTVALUE,$fieldObj->SETVALUE)?></td>
    </tr>
    
 <?
	  }else{
 ?>   
    
    
   <?
if($i%2==0){
?>

<tr>
  	<td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right"><?=$fieldObj->CALLED?>：</td>
	<td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=CustomerFieldEdit($fieldObj->UITYPE,$fieldObj->FIELDNAME,$fieldObj->DEFAULTVALUE,$fieldObj->SETVALUE)?></td>
    
<?
}else{
?>    
  	<td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right"><?=$fieldObj->CALLED?>：</td>
	<td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=CustomerFieldEdit($fieldObj->UITYPE,$fieldObj->FIELDNAME,$fieldObj->DEFAULTVALUE,$fieldObj->SETVALUE)?></td>
</tr> 
    
    
  <?
      }
	  }
 $i++;
 $j++;
  }
  ?>  
  
    

  <?
  foreach($text_customerFieldArr as $fieldObj){
  ?>
  <tr>

  	<td height="24" class="title_td" bgcolor="#F6FAFD" align="right"><?=$fieldObj->CALLED?>：</td>
	<td height="24" colspan="3" bgcolor="#FFFFFF" style="padding:10px;"><?=CustomerFieldEdit($fieldObj->UITYPE,$fieldObj->FIELDNAME,$fieldObj->DEFAULTVALUE,$fieldObj->SETVALUE)?></td>
    </tr>
    
  <?
  }
  ?> 


 <tr>
  	<td width="12%" height="30" class="title_td" valign="top" style="padding-top:10px;" bgcolor="#F6FAFD" align="right">详细内容：</td>
	<td height="30" colspan="3" bgcolor="#FFFFFF" style="padding:10px;">
	<?php
	include_once(ROOTDIR."/lib/fckeditor/fckeditor.php");
	$oFCKeditor = new FCKeditor('content');
	$oFCKeditor->BasePath = $SysConfig['rooturl'].'/lib/fckeditor/';
	$oFCKeditor->Width = '98%';
	$oFCKeditor->Height = 360;
	$oFCKeditor->Value = $content ;
	$oFCKeditor->Create();
	?></td>
    </tr>

 <tr>
	<td  colspan="4" align="center" height="40" valign="middle" bgcolor="#FFFFFF"  class="btn_line"><input type="submit" value="" class="sys_submit"> <input type="reset" value="" class="sys_reset"> <input type="button" value="" class="sys_close" onclick="window.close()"></td>
  </tr>
  
  </table>
  </td>
  </tr>
  
</table>


</form>