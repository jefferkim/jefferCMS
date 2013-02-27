<?php
include_once("../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
if (!UserIsInRole('K5',$userRole))
{
	exit();
}

$where = " WHERE 1=1";
$page = 1;
$pageCounts = 5;
$language = "";
$position = "";
$paraArr = array();

if (isset($_REQUEST['page']) && $_REQUEST['page']>0)
	$page = $_REQUEST['page'];
if (isset($_REQUEST['pagecounts']) && $_REQUEST['pagecounts']>0)
	$pageCounts = $_REQUEST['pagecounts'];
if (isset($_REQUEST['language']) && $_REQUEST['language']!="")
	$language = $_REQUEST['language'];
if (isset($_REQUEST['position']) && $_REQUEST['position']!="")
	$position = $_REQUEST['position'];

$start = ($page - 1)*$pageCounts;
if ($language != "")
{
	$where .= " AND Language=?";
	$paraArr[] = $language;
}
if ($position != "")
{
	$where .= " AND Position=?";
	$paraArr[] = $position;
}

$sql = "SELECT COUNT(*) FROM t_career ".$where;
$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$counts = $rs->fields[0];

$sql = "SELECT * FROM t_career ".$where." ORDER BY id DESC LIMIT ?,?";
$paraArr[] = $start;
$paraArr[] = intval($pageCounts);

$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$data = array();
while (!$rs->EOF)
{
	$row = $rs->FetchObject();
	$row->LANGUAGE = $SysConfig['language'][$row->LANGUAGE];
	$rowObj = explode("<br>",$row->CONTENT);
	$row->CONTENT = end(explode(":",$rowObj[0]));
	$data[] = array(
				"ID"=>$row->ID,
				"CONTENT"=>$row->CONTENT,
				"NOTETIME"=>$row->NOTETIME,
				"LANGUAGE"=> $row->LANGUAGE);
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