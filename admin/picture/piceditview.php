<style>

.file-box{ position:relative;width:340px; float:left;}
.btn1{ background-color:#FFF; border:1px solid #CDCDCD;height:24px; width:70px; margin-left:10px;}
.sys_file{ position:absolute; top:0; right:0px; width:68px; background:none; filter:alpha(opacity:0);opacity: 0; right:87px; height:24px; }

</style>
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr class="table_title">
    <td colspan="4" class="td_one">图片信息添加/修改</td>
    </tr>
  
   <tr>
     <td colspan="4">
      <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#DDEFFB">
    
  <tr>
  	<td width="12%" height="30" class="title_td"  bgcolor="#F6FAFD" align="right">图片名称：</td>
	<td height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><input type="text" name="called" value="<?=$called?>"  class="sys_input"></td>
    <td width="12%" height="30" class="title_td"  bgcolor="#F6FAFD" align="right">语言名称：</td>
	<td height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?php
	if ($editMode)
	{
		HtmlSelect('language',$lanArr,$currentLan,"style='width:173px;'");
	}
	else
	{
		$i=0;
		while(list($key,$val) = each($lanArr))
		{
			if($currentLanguage){
			if($currentLanguage==$key){
				
				echo '<input type="radio" name="language" value="'.$key.'" checked>&nbsp;'.$val."&nbsp;";
			}else{
				echo '<input type="radio" name="language" value="'.$key.'">&nbsp;'.$val."&nbsp;";
			}
			}else{
			
			if($i==0){
				echo '<input type="radio" name="language" value="'.$key.'" checked>&nbsp;'.$val."&nbsp;";
				
			}else{
				echo '<input type="radio" name="language" value="'.$key.'">&nbsp;'.$val."&nbsp;";
			}
			}
			
        $i++;	
		}
	}
	?></td>
    </tr>

 <tr>
  	<td width="12%" height="30" class="title_td"  bgcolor="#F6FAFD" align="right">图片分类：</td>
	<td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?HtmlSelect('type',$typeArr,$currentType)?></td>
    <td width="12%" height="30" class="title_td"  bgcolor="#F6FAFD" align="right">是否显示：</td>
	<td width="38%" height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><?HtmlSelect('isshow',$showArr,$currentShow)?></td>
</tr>

  
 <tr>
  	<td width="12%" height="100" class="title_td" bgcolor="#F6FAFD" align="right">上传小图片：</td>
    
	<td width="38%" height="100" bgcolor="#FFFFFF" style="padding-left:10px;">

<div class="file-box">

<input type="text" name="spic" value="<?=$spic?>" class="sys_input" style="float:left; height:22px; line-height:22px;">

<input type='button' name="uploadspic" class='btn1' value='浏览...' />
    </div>
    
    

    </td>
    
    <td width="12%" height="100" class="title_td" id="message1" bgcolor="#F6FAFD"><span id="progressbars1" style="float:left">   </span></td>
	<td width="38%" height="100"  bgcolor="#FFFFFF" style="padding:10px;"><div id="upimg1" style="float:left; padding-left:10px;"><img src="<? if($spic!=""){echo "../../upload/".$spic;}else{echo "../images/zwtp.gif";}?>" width="100" height="100" style=" width:100px; height:100px; border:solid 1px #CCC"/></div></td>
</tr>





<tr>
  	<td width="12%" height="100" class="title_td" bgcolor="#F6FAFD" align="right">上传大图片：</td>
    
	<td width="38%" height="100" bgcolor="#FFFFFF" style="padding-left:10px;">
    
       <div class="file-box">

        <input type="text" name="bpic" value="<?=$bpic?>" class="sys_input" style="float:left; height:22px; line-height:22px;">
        
        <input type='button' name="uploadbpic" class='btn1' value='浏览...' />
    </div>
    
   
    
    </td>
    
    <td width="12%" height="100" class="title_td" id="message" bgcolor="#F6FAFD"><span id="progressbars" style="float:left">   </span></td>
	<td width="38%" height="100"  bgcolor="#FFFFFF" style="padding:10px;"><div id="upimg" style="float:left; padding-left:10px;">
    
    <img src="<? if($bpic!=""){echo "../../upload/".$bpic;}else{echo "../images/zwtp.gif";}?>" width="100" height="100" style=" width:100px; height:100px; border:solid 1px #CCC"/>
    
  </div>
    
    </td>
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


<tr id="message" style="display:none;">
<td width="8%" height="30" class="title_td"><span id="progressbars"></span></td>
	<td width="42%" height="30"><div id="upimg"></div></td>
    <td width="8%" height="30" class="title_td"></td>
	<td width="42%" height="30"></td>

</tr>

 
	<td  colspan="4" align="center" height="40" valign="middle" bgcolor="#FFFFFF"  class="btn_line"><input type="submit" value="" class="sys_submit"> <input type="reset" value="" class="sys_reset"> <input type="button" value="" class="sys_close" onclick="window.close()"></td>
  </tr>
 
 </table>
 </td>
  </tr>

</table>



