<?
function GetSubType($db,$pid,$currId="",$lan="")
{
	$typeArr = array();
	$where = "WHERE PID=".$pid;
	if ($lan != "")
		$where .= " AND Language='".$lan."'";

	$typeRs = $db->Execute("SELECT * FROM t_comtype ".$where." ORDER BY OrderBy");
	while (!$typeRs->EOF)
	{
		$typeObj = $typeRs->FetchObject();

		if ($currId != "" && $currId==$typeObj->ID)
		{
			$typeRs->MoveNext();
			continue;
		}

		$typeArr[$typeObj->ID] = GetNbsp($typeObj->TYPELEVEL).$typeObj->CALLED;
		$subTypeArr = GetSubType($db,$typeObj->ID,$currId,$lan);
		if (count($subTypeArr) >0)
		{
			$typeArr = $typeArr + $subTypeArr;
		}
		$typeRs->MoveNext();
	}

	return $typeArr;
}

function GetSubTypeObject($db,$pid,$currId="",$lan="")
{
	$typeArr = array();
	$where = " WHERE PID=".$pid;
	if ($lan != "")
		$where .= " AND Language='".$lan."'";

	$typeRs = $db->Execute("SELECT * FROM t_comtype ".$where." ORDER BY OrderBy");
	while(!$typeRs->EOF)
	{
		$typeObj = $typeRs->FetchObject();

		if ($currId != "" && $currId == $typeObj->ID)
		{
			$typeRs->MoveNext();
			continue;
		}

		$typeObj->CALLED = GetNbsp($typeObj->TYPELEVEL).$typeObj->CALLED;
		$typeArr[] = $typeObj;
		$subTypeArr = GetSubTypeObject($db,$typeObj->ID,$currId,$lan);
		if (count($subTypeArr) > 0)
		{
			$typeArr = array_merge($typeArr,$subTypeArr);
		}
		$typeRs->MoveNext();
	}

	return $typeArr;
}

function GetNbsp($level)
{
	$ret = "";
	for ($i=0; $i<$level; $i++)
	{
		$ret .= "&nbsp;";
	}

	return $ret;
}
?>