<?php
include_once("../config.php");
$userRole = $_SESSION['SWEBADMIN_USERROLE'];

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

$sql = "SELECT COUNT(*) FROM t_custom1 ".$where;
$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$counts = $rs->fields[0];

$sql = "SELECT id,Called,Language,NoteTime FROM t_custom1 ".$where." ORDER BY id LIMIT ?,?";
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