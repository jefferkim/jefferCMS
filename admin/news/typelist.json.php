<?php
include_once("../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
if (!UserIsInRole('E4',$userRole))
{
	exit();
}

$where = "WHERE 1=1";
$paraArr = array();

$page = 0;
$pageCounts = 15;
$language = "";

if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];
if (isset($_REQUEST['pagecounts']) && $_REQUEST['pagecounts']>0)
	$pageCounts = $_REQUEST['pagecounts'];
if (isset($_REQUEST['language']) && $_REQUEST['language']!="")
	$language = $_REQUEST['language'];

if ($language != "")
{
	$where .= " AND Language=?";
	$paraArr[] = $language;
}

if ($page > 0)
{
	$sql = "SELECT COUNT(*) FROM t_newtype ".$where;
	$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
	$counts = $rs->fields[0];

	$sql = "SELECT * FROM t_newtype ".$where." ORDER BY id LIMIT ?,?";
	$paraArr[] = ($page - 1)*$pageCounts;
	$paraArr[] = intval($pageCounts);
}
else
{
	$counts = 0;
	$sql = "SELECT * FROM t_newtype ".$where." ORDER BY id";
}

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
	'data' =>$data
);

echo json_encode($result);
?>