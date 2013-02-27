<?php
function GetSubDownType($db,$language){

$where = " WHERE 1=1";

if ($language != "")
{
	$where .= " AND Language='".$language."'";
}
	
$rd = $db->Execute("SELECT * FROM t_downloadtype $where ORDER BY id");

while(!$rd->EOF)
{
	$obj = $rd->FetchObject();
	$typeArr[$obj->ID] = $obj->CALLED;
	$rd->MoveNext();
}

	return $typeArr;
	
}

?>