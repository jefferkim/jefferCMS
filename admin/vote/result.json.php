<?php
include_once("../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
if (!UserIsInRole('T0',$userRole))
{
	exit();
}

$custdb = $SysConfig['customerdb'];

$type_array  = array();
$rd = $custdb->Execute("SELECT * FROM t_vote ORDER BY id");
while(!$rd->EOF)
{
	$obj = $rd->FetchObject();
	$type_array[$obj->ID] = $obj->SUBJECT;
	$rd->MoveNext();
}



$where = " WHERE 1=1";
$page = 1;
$pageCounts = 15;
$language = "";
$paraArr = array();

if (isset($_POST['page']) && $_POST['page']>0)
	$page = $_POST['page'];
if (isset($_POST['pagecounts']) && $_POST['pagecounts'] > 0)
	$pageCounts = $_POST['pagecounts'];
if (isset($_POST['language']) && $_POST['language'] != "")
	$language = $_POST['language'];

$start = ($page - 1) * $pageCounts;

if ($language != "")
{
	$where .= " AND Language=?";
	$paraArr[] = $language;
}

$sql = "SELECT COUNT(*) FROM t_result ".$where;
$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$counts = $rs->fields[0];

$sql = "SELECT id,Result,VoteId,Language,NoteTime FROM t_result ".$where." ORDER BY id LIMIT ?,?";
$paraArr[] = $start;
$paraArr[] = intval($pageCounts);
$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$data = array();
while (!$rs->EOF)
{
	$row = $rs->FetchObject();
	$row->LANGUAGE = $SysConfig['language'][$row->LANGUAGE];
	$row->VOTEID = $type_array[$row->VOTEID];
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