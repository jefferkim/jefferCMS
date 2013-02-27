<?php
include_once("../config.php");
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

if (!UserIsInRole('I0',$userRole))
{
	exit();
}

$where = " WHERE 1=1";
$paraArr = array();
$page = 1;
$pageCounts = 15;
$language = "";

if (isset($_REQUEST['page']) && $_REQUEST['page']>0)
	$page = $_REQUEST['page'];
if (isset($_REQUEST['pagecounts']) && $_REQUEST['pagecounts']>0)
	$pageCounts = $_REQUEST['pagecounts'];
if (isset($_REQUEST['language']) && $_REQUEST['language']!="")
	$language = $_REQUEST['language'];

$start = ($page - 1) * $pageCounts;

if($language != "")
{
	$where .= " AND Language=?";
	$paraArr[] = $language;
}

$sql = "SELECT COUNT(*) FROM t_guestbook ".$where;
$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$counts = $rs->fields[0];

$sql = "SELECT * FROM t_guestbook ".$where." ORDER BY id DESC LIMIT ?,?";
$paraArr[] = $start;
$paraArr[] = intval($pageCounts);

$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$resultData = array();
while (!$rs->EOF)
{
	$row = $rs->FetchObject();
	$row->LANGUAGE = $SysConfig['language'][$row->LANGUAGE];
	$resultData[] = $row;
	$rs->MoveNext();
}

$result = array(
	'counts' => $counts,
	'pageCounts' => $pageCounts,
	'page' => $page,
	'data' => $resultData
);

echo json_encode($result);
?>