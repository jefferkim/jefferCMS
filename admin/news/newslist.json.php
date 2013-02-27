<?php
include_once("../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
if (!UserIsInRole('E4',$userRole))
{
	exit();
}

$custdb = $SysConfig['customerdb'];

$type_array  = array();
$rd = $custdb->Execute("SELECT * FROM t_newtype ORDER BY id");
while(!$rd->EOF)
{
	$obj = $rd->FetchObject();
	$type_array[$obj->ID] = $obj->CALLED;
	$rd->MoveNext();
}


$where = "WHERE 1=1";
$paraArr = array();
$page = 1;
$pageCounts = 10;
$language = "";
$newsType = "";
$parent = 0;

if (isset($_REQUEST['page']) && $_REQUEST['page']>1)
{
	$page = $_REQUEST['page'];
}
if (isset($_REQUEST['pagecounts']) && $_REQUEST['pagecounts'] >0)
{
	$pageCounts = $_REQUEST['pagecounts'];
}
if (isset($_REQUEST['language']))
{
	$language = trim($_REQUEST['language']);
}
if (isset($_REQUEST['newstype']))
{
	$newsType = intval($_REQUEST['newstype']);
}
if (isset($_REQUEST['parent']))
{
	$parent = intval($_REQUEST['parent']);
}

$where .= " AND Parent=?";
$paraArr[] = $parent;

if ($language != "")
{
	$where .= " AND Language=?";
	$paraArr[] = $language;
}
if ($newsType > 0)
{
	$where .= " AND NewType=?";
	$paraArr[] = $newsType;
}

$sql = "SELECT COUNT(id) FROM t_news ".$where;
$resultRs = $custdb->Execute($sql,$paraArr);
$counts = $resultRs->fields[0];

$sql = "SELECT * FROM t_news ".$where." ORDER BY OrderBy,id DESC LIMIT ?,?";
if ($_SESSION['SWEBADMIN_USERNAME'] == "fashion")
	$sql = "SELECT * FROM t_news ".$where." ORDER BY id DESC LIMIT ?,?";
$paraArr[] = ($page - 1)*$pageCounts;
$paraArr[] = intval($pageCounts);

$resultData = array();
$resultRs = $custdb->Execute($sql,$paraArr);
while (!$resultRs->EOF)
{
	$row = $resultRs->FetchObject();
	$row->LANGUAGE = $SysConfig['language'][$row->LANGUAGE];
	$row->NEWTYPE = $type_array[$row->NEWTYPE];
	$row->NOTETIME = date("Y-m-d",strtotime($row->NOTETIME));
	$resultData[] = $row;
	$resultRs->MoveNext();
}

$result = array(
	'counts' => $counts,
	'pageCounts' => $pageCounts,
	'page' => $page,
	'data' => $resultData
);

echo json_encode($result);
?>