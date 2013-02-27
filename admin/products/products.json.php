<?php
include_once("../config.php");

$where = " WHERE 1=1";
$page = 1;
$pageCounts = 14;
$language = "";
$type = "";
$show = "";
$commend = "";
$keyword = "";

if (isset($_REQUEST['page']) && $_REQUEST['page']>0)
	$page = $_REQUEST['page'];
if (isset($_REQUEST['pagecounts']) && $_REQUEST['pagecounts']>0)
	$pageCounts = $_REQUEST['pagecounts'];
if (isset($_REQUEST['language']) && $_REQUEST['language']!="")
	$language = $_REQUEST['language'];
if (isset($_REQUEST['type']) && $_REQUEST['type']>0)
	$type = $_REQUEST['type'];
if (isset($_REQUEST['show']) && $_REQUEST['show']!="")
	$show = $_REQUEST['show'];
if (isset($_REQUEST['commend']) && $_REQUEST['commend']!="")
	$commend = $_REQUEST['commend'];
if (isset($_REQUEST['keyword']) && $_REQUEST['keyword']!="")
	$keyword = $_REQUEST['keyword'];

$start = ($page - 1)*$pageCounts;

$paraArr = array();
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
if ($show != "")
{
	$where .= " AND IsShow=?";
	$paraArr[] = $show;
}
if ($commend != "")
{
	$where .= " AND IsCommend=?";
	$paraArr[] = $commend;
}
if ($keyword != "")
{
	$where .= " AND (ProName like ? OR Content like ?)";
	$paraArr[] = '%'.$keyword.'%';
	$paraArr[] = '%'.$keyword.'%';
}

$sql = "SELECT COUNT(*) FROM t_products ".$where;
$proRs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$counts = $proRs->fields[0];

$sql = "SELECT * FROM t_products ".$where." ORDER BY ORDERBY,id LIMIT ?,?";
$paraArr[] = $start;
$paraArr[] = intval($pageCounts);

$proRs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$resultData = array();
while (!$proRs->EOF)
{
	$row = $proRs->FetchObject();
	$row->LANGUAGE = $SysConfig['language'][$row->LANGUAGE];
	$row->NOTETIME = date("Y-m-d",strtotime($row->NOTETIME));
	$resultData[] = $row;
	$proRs->MoveNext();
}

$result = array(
	'counts' => $counts,
	'pageCounts' => $pageCounts,
	'page' => $page,
	'data' => $resultData
);

echo json_encode($result);
?>