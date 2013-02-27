<?php
function GetSubProType($db,$lan)
{
	
$rd = $db->Execute("SELECT * FROM t_protype ORDER BY Language");

while(!$rd->EOF)
{
	$obj = $rd->FetchObject();
	$obj->LANGUAGE = $lan[$obj->LANGUAGE];
	$typeArr[$obj->ID] = $obj->CALLED."(".$obj->LANGUAGE.")";
	$rd->MoveNext();
}

	return $typeArr;
}
?>