<?php
include("../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
if (!UserIsInRole('F0',$userRole))
{
	exit();
}

$where = " WHERE 1=1";
$paraArr = array();
$page = 1;
$pageCounts = 15;
$language = "";
$pid="";

if (isset($_REQUEST['page']) && $_REQUEST['page']>0)
	$page = $_REQUEST['page'];
if (isset($_REQUEST['pagecounts']) && $_REQUEST['pagecounts']>0)
	$pageCounts = $_REQUEST['pagecounts'];
	
if (isset($_REQUEST['pid']) && $_REQUEST['pid']!="")
	$pid = $_REQUEST['pid'];

$start = ($page - 1) * $pageCounts;

if ($pid != "")
{
	$where .= " AND ProID=?";
	$paraArr[] = $pid;
}

$sql = "SELECT COUNT(*) FROM t_img ".$where;
$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$counts = $rs->fields[0];



$sql = "SELECT * FROM t_img ".$where." ORDER BY id desc LIMIT ?,?";
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