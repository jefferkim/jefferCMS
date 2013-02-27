<?php
function GetSubNewsType($db)
{
	
$rd = $db->Execute("SELECT * FROM t_newtype ORDER BY id");

while(!$rd->EOF)
{
	$obj = $rd->FetchObject();
	$typeArr[$obj->ID] = $obj->CALLED;
	$rd->MoveNext();
}

	return $typeArr;
}
?>