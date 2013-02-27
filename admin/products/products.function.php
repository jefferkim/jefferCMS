<?php
function GetSubType($db,$pid,$currId="",$lan="",$wzlan)
{
	$typeArr = array();
	$where = "WHERE PID=".$pid;
	if ($lan != "")
		$where .= " AND Language='".$lan."'";

	$typeRs = $db->Execute("SELECT * FROM t_protype ".$where." ORDER BY OrderBy");
	while (!$typeRs->EOF)
	{
		$typeObj = $typeRs->FetchObject();

		if ($currId != "" && $currId==$typeObj->ID)
		{
			$typeRs->MoveNext();
			continue;
		}

		$typeArr[$typeObj->ID] = GetNbsp($typeObj->TYPELEVEL).$typeObj->CALLED."(".$wzlan[$typeObj->LANGUAGE].")";
		$subTypeArr = GetSubType($db,$typeObj->ID,$currId,$lan,$wzlan);
		if (count($subTypeArr) >0)
		{
			$typeArr = $typeArr + $subTypeArr;
		}
		$typeRs->MoveNext();
	}

	return $typeArr;
}

function GetSubTypeObject($db,$pid,$currId="",$lan="",$wzlan)
{
	$typeArr = array();
	$where = " WHERE PID=".$pid;
	if ($lan != "")
		$where .= " AND Language='".$lan."'";

	$typeRs = $db->Execute("SELECT * FROM t_protype ".$where." ORDER BY OrderBy");
	while(!$typeRs->EOF)
	{
		$typeObj = $typeRs->FetchObject();

		if ($currId != "" && $currId == $typeObj->ID)
		{
			$typeRs->MoveNext();
			continue;
		}

        $typeObj->LANGUAGE = $wzlan[$typeObj->LANGUAGE];
		$typeObj->CALLED = GetNbsp($typeObj->TYPELEVEL).$typeObj->CALLED;
		$typeArr[] = $typeObj;
		$subTypeArr = GetSubTypeObject($db,$typeObj->ID,$currId,$lan,$wzlan);
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