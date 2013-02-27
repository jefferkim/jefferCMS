<?
//html辅助函数
//zjb
//080718

//打印显示
function EchoShow($show)
{
	if ($show == 1)
		echo "是";
	else
		echo "否";
}

//输出选择框
//$name 选择框名称
//$items 选择项hash collection
//$selectedItem 选中项的Value
//$clsstyle 选择框样式
function HtmlSelect($name,$items,$selectedItem,$clsstyle="")
{
	
	if($clsstyle==""){
		$clsstyle="style='weight:173px;'";
	}else{
		$clsstyle=$clsstyle;
	}
	$retStr = '';		//返回字符串
	$retStr = '<select name="'.$name.'" id="'.$name.'"';
	if ($clsstyle != "")
	{
		$retStr .= ' '.$clsstyle;
	}
	$retStr .= '>';
	while (list($key,$val) = each($items))
	{
		$selected = "";
		if ($selectedItem != "")
		{
			if ($key == $selectedItem)
			{
				$selected = " selected='selected'";
			}
		}
		else if ($selectedItem === 0)
		{
			if ($key === 0)
			{
				$selected = " selected='selected'";
			}
		}
		
		/*if ($key === 0 && $selectedItem === 0)
		{
			$selected = ' selected="selected"';
		}
		else
		{
			if ($key == $selectedItem)
				$selected = ' selected="selected"';
		}*/
		$retStr .= '<option value="'.$key.'"'.$selected.'>'.$val.'</option>';
	}
	$retStr .= "</select>";

	echo $retStr;
}

?>