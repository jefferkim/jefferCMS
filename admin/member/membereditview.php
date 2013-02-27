<input type="hidden" name="parent" value="<?=$parent?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr class="table_title">
    <td colspan="4" class="td_one">会员信息添加/修改</td>
    </tr>
    
     <tr>
     <td colspan="4">
      <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#DDEFFB">
    
  <tr>
  	<td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">用<span style="padding-left:6px;"></span>户<span style="padding-left:6px;"></span>名：</td>
	<td height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="username" value="<?=$userName?>" class="sys_input"></td>
    <td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">密<span style="padding-left:24px;"></span>码：</td>
	<td height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="password" value="<?=$password?>" class="sys_input"></td>
    </tr>

  <tr>
    <td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">姓<span style="padding-left:24px;"></span>名：</td>
	<td bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="called" value="<?=$called?>" class="sys_input"></td>
	<td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">联系电话：</td>
	<td bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="tel" value="<?=$tel?>" class="sys_input"></td>
    </tr>
    
    
    <tr>
	<td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">手<span style="padding-left:24px;"></span>机：</td>
	<td bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="mobile" value="<?=$mobile?>" class="sys_input"></td>
	<td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">电子邮件：</td>
	<td bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="mail" value="<?=$mail?>" class="sys_input"></td>
 </tr>
 <tr>
	<td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">是否锁定：</td>
	<td bgcolor="#FFFFFF" style="padding-left:10px;"><?HtmlSelect('islock',$showArr,$isLock)?></td>
	<td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">语言名称：</td>
	<td bgcolor="#FFFFFF" style="padding-left:10px;"><?=HtmlSelect('language',$lanArr,$language)?></td>
</tr>

 <tr>
	<td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">公司名称：</td>
	<td colspan="3" bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="company"  style=" width:480px" value="<?=$company?>" class="sys_input"></td>

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
	<td width="312%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=CustomerFieldEdit($fieldObj->UITYPE,$fieldObj->FIELDNAME,$fieldObj->DEFAULTVALUE,$fieldObj->SETVALUE)?></td>
    
<?
}else{
?>    
  	<td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right"><?=$fieldObj->CALLED?>：</td>
	<td width="312%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?=CustomerFieldEdit($fieldObj->UITYPE,$fieldObj->FIELDNAME,$fieldObj->DEFAULTVALUE,$fieldObj->SETVALUE)?></td>
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
	<td  colspan="4" align="center" height="40" bgcolor="#FFFFFF" valign="middle"  class="btn_line"><input type="submit" value="" class="sys_submit"> <input type="reset" value="" class="sys_reset"> <input type="button" value="" class="sys_close" onclick="window.close()"></td>
  </tr>
  </table>
  </td>
  </tr>
  
  
</table>

