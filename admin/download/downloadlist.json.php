﻿<?
include("../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
if (!UserIsInRole('H0',$userRole))
{
	exit();
}

$where = " WHERE 1=1";
$paraArr = array();
$page = 1;
$pageCounts = 15;
$language = "";
$type = "";

if (isset($_REQUEST['page']) && $_REQUEST['page']>0)
	$page = $_REQUEST['page'];
if (isset($_REQUEST['pagecounts']) && $_REQUEST['pagecounts']>0)
	$pageCounts = $_REQUEST['pagecounts'];
if (isset($_REQUEST['language']) && $_REQUEST['language']!="")
	$language = $_REQUEST['language'];
if (isset($_REQUEST['type']) && $_REQUEST['type']!="")
	$type = $_REQUEST['type'];

$start = ($page - 1) * $pageCounts;
if ($language != "")
{
	$where .= " AND Language=?";
	$paraArr[] = $language;
}
if ($type != "")
{
	$where .= " AND TypeID=?";
	$paraArr[] = $type;
}
$sql = "SELECT COUNT(*) FROM t_download ".$where;
$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$counts = $rs->fields[0];

$sql = "SELECT * FROM t_download ".$where." ORDER BY OrderBy,id LIMIT ?,?";
$paraArr[] = $start;
$paraArr[] = intval($pageCounts);

$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$data = array();
while (!$rs->EOF)
{
	$obj = $rs->FetchObject();
	$obj->LANGUAGE = $SysConfig['language'][$obj->LANGUAGE];
	$data[] = $obj;
	$rs->MoveNext();
}


$result = array(
	'counts' => $counts,
	'pageCounts' => $pageCounts,
	'page' => $page,
	'data' => $data
);

echo json_encode($result);
?>