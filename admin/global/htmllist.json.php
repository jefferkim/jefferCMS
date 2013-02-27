<?php
include_once("../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
if (!UserIsInRole('D0',$userRole))
{
	exit();
}

$where = " WHERE 1=1";
$page = 1;
$pageCounts = 15;
if (isset($_POST['page']) && $_POST['page']>0)
	$page = $_POST['page'];
if (isset($_POST['pagecounts']) && $_POST['pagecounts'] > 0)
	$pageCounts = $_POST['pagecounts'];
if (isset($_POST['language']) && $_POST['language'] != "")
	$language = $_POST['language'];

$start = ($page - 1) * $pageCounts;

$sql = "SELECT COUNT(*) FROM t_global ".$where;
$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$counts = $rs->fields[0];

$sql = "SELECT id,Webname,Language,Beian FROM t_global ".$where." ORDER BY id LIMIT ?,?";
$paraArr[] = $start;
$paraArr[] = intval($pageCounts);
$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$data = array();
while (!$rs->EOF)
{
	$row = $rs->FetchObject();
	$row->LANGUAGE = $SysConfig['language'][$row->LANGUAGE];
	$data[] = $row;
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