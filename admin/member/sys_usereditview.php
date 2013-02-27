<style>

.power{ width:150px; height:30px; line-height:30px; display:block; float:left}

#role_list td{ padding:10px;}
</style>
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr class="table_title">
    <td colspan="4" class="td_one">系统管理员添加/修改</td>
    </tr>
    
    <tr>
    <td>
    
    <table width="100%" cellspacing="1" cellpadding="1" border="0" bgcolor="#DDEFFB">
    
  <tr>
  	<td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">用<span style="padding-left:6px;"></span>户<span style="padding-left:6px;"></span>名：</td>
	<td height="30" bgcolor="#FFFFFF"  style="padding-left:10px;"><input type="text" name="UserName" value="<?=$userName?>" class="sys_input"></td>
    <td width="12%" height="30" class="title_td" bgcolor="#F6FAFD" align="right">密<span style="padding-left:24px;"></span>码：</td>
	<td height="30" bgcolor="#FFFFFF" style="padding-left:10px;"><input type="password" name="PassWord" value="<?=$password?>" class="sys_input"></td>
    </tr>
    
  
  <tr>
  
  <td colspan="4" bgcolor="#DDEFFB"> 
    <table width="100%" cellspacing="1" cellpadding="1" border="0" id="role_list" >
    
  <tr>
  <?
				foreach($commonRoleList as $role)
				{
				?>
				<tr>
					<td height="30" width="17%" valign="middle" bgcolor="#F6FAFD"><?=$role[0]?>：(<?=$role[1]?>)</td>
					<td width="3%" align="center" valign="middle" bgcolor="#F6FAFD"><input type="checkbox" name="powercheck" id="<?echo substr($role[2][0]->code,0,1);?>" onClick="CheckPower(this,'<?echo substr($role[2][0]->code,0,1);?>')"></td>
					<td valign="top"  bgcolor="#FFFFFF" width="80%">
					<?
					foreach($role[2] as $item)
					{
					?>
					<span class="power"><input type="checkbox" name="power[]"  style=" vertical-align:text-bottom" id="power<?echo $item->code;?>"  value="<?=$item->code?>"<?if ($item->checked){echo " checked";}?>> &nbsp;<?=$item->name?></span>
					<?
					}
				}
					?>
                  
 </table>
 </td>
 </tr>   

</table>

</td>
</tr>

 <tr>
	<td  colspan="4" align="center" height="40" valign="middle"  class="btn_line"><input type="submit" value="" class="sys_submit"> <input type="reset" value="" class="sys_reset"> <input type="button" value="" class="sys_close" onclick="window.close()"></td>
  </tr>
</table>


 <script>
			function CheckPower(obj,id)
			{
				if ($(obj).attr("checked"))
				{
					$("input[id*=power"+ id +"]").attr("checked","true");
				}
				else
				{
					$("input[id*=power"+ id +"]").attr("checked","");
				}
			}
		  </script>
