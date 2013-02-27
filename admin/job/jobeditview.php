<input type="hidden" name="parent" value="<?=$parent?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr class="table_title">
    <td colspan="4" class="td_one">招聘信息添加/修改</td>
    </tr>
    
    <tr>
     <td colspan="4">
      <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#DDEFFB"> 
    
  <tr>
  	<td width="12%" height="30" class="title_td"  bgcolor="#F6FAFD" align="right">招聘职位：</td>
	<td height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="position" value="<?=$position?>" class="sys_input"></td>
    <td width="12%" height="30" class="title_td"  bgcolor="#F6FAFD" align="right">专业要求：</td>
	<td height="30"bgcolor="#FFFFFF" style="padding-left:10px;" ><input type="text" name="specialty" value="<?=$specialty?>" class="sys_input"></td>
    </tr>

  <tr>
    <td width="12%" height="30" class="title_td"  bgcolor="#F6FAFD" align="right">年龄要求：</td>
	<td bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="age" value="<?=$age?>" class="sys_input"></td>
	<td width="12%" height="30" class="title_td"  bgcolor="#F6FAFD" align="right">性别要求：</td>
	<td bgcolor="#FFFFFF" style="padding-left:10px;">
    <select name="sex" id="sex">
    	<option value="不限"<?php if($currentSex=="不限"){echo ' selected="selected"';}?>>不限</option>
        <option value="男"<?php if($currentSex=="男"){echo ' selected="selected"';}?>>男</option>
        <option value="女"<?php if($currentSex=="女"){echo ' selected="selected"';}?>>女</option>
    </select>
   </td>
    </tr>
    
    
    <tr>
	<td width="12%" height="30" class="title_td"  bgcolor="#F6FAFD" align="right">招聘人数：</td>
	<td bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="nums" value="<?=$nums?>" class="sys_input"></td>
	<td width="12%" height="30" class="title_td"  bgcolor="#F6FAFD" align="right">学历要求：</td>
	<td bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="educational" value="<?=$educational?>" class="sys_input"></td>
 </tr>
 <tr>
	<td width="12%" height="30" class="title_td"  bgcolor="#F6FAFD" align="right">工作经验：</td>
	<td bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="experience" value="<?=$experience?>" class="sys_input"></td>
	<td width="12%" height="30" class="title_td"  bgcolor="#F6FAFD" align="right">薪水要求：</td>
	<td bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="salary" value="<?=$salary?>" class="sys_input"></td>
</tr>

 <tr>
	<td width="12%" height="30" class="title_td"  bgcolor="#F6FAFD" align="right">结束时间：</td>
	<td bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="endtime" value="<?=$endTime?>" class="sys_input"></td>
	<td width="12%" height="30" class="title_td"  bgcolor="#F6FAFD" align="right">排<span style="padding-left:24px;"></span>序：</td>
	<td bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="orderby" value="<?=$orderBy?>" class="sys_input"></td>
</tr>


<tr>
	<td width="12%" height="30" class="title_td"  bgcolor="#F6FAFD" align="right">是否显示：</td>
	<td bgcolor="#FFFFFF" style="padding-left:10px;"><?HtmlSelect('isshow',$showArr,$currentShow)?></td>
	<td width="12%" height="30" class="title_td"  bgcolor="#F6FAFD" align="right">语言名称：</td>
	<td bgcolor="#FFFFFF" style="padding-left:10px;"><?
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
	}?></td>
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
	<td width="12%" height="30" class="title_td"  bgcolor="#F6FAFD" align="right" valign="top" style="padding-top:10px;">其它要求：</td>
	<td colspan="3" bgcolor="#FFFFFF" style="padding:10px;"><textarea name="memo" rows="4" cols="60" class="txt"><?=$memo?></textarea></td>
</tr>

 <tr>
	<td  colspan="4" align="center" height="40" valign="middle" bgcolor="#FFFFFF"  class="btn_line"><input type="submit" value="" class="sys_submit"> <input type="reset" value="" class="sys_reset"> <input type="button" value="" class="sys_close" onclick="window.close()"></td>
  </tr>
  
  </table>
  </td>
  </tr>
  
</table>




