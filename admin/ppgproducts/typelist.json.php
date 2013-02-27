<?
include_once("../../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
if (!UserIsInRole('N6',$userRole))
{
	exit();
}

$customerdb = $SysConfig['customerdb'];

$where = "WHERE 1=1";
$paraArr = array();

$language = "";
$page = 1;
$pageCounts = 15;
$type = "";

if (isset($_REQUEST['language']))
{
	$language = $_REQUEST['language'];
}
if (isset($_REQUEST['page']) && $_REQUEST['page']>0)
{
	$page = $_REQUEST['page'];
}
if (isset($_REQUEST['pagecounts']) && $_REQUEST['pagecounts'] >0)
{
	$pageCounts = $_REQUEST['pagecounts'];
}
if (isset($_REQUEST['type']) && $_REQUEST['type']!="")
{
	$type = $_REQUEST['type'];
}
$start = ($page - 1) * $pageCounts;

if ($language != "")
{
	$where .= " AND Language=?";
	$paraArr[] = $language;
}
if ($type != "")
{
	$where .= " AND PID=?";
	$paraArr[] = $type;
}

$sql = "SELECT COUNT(*) FROM t_ppgprotype ".$where;
$rs = $customerdb->Execute($sql,$paraArr);
$counts = $rs->fields[0];

$sql = "SELECT * FROM t_ppgprotype ".$where." ORDER BY OrderBy LIMIT ?,?";
$paraArr[] = $start;
$paraArr[] = intval($pageCounts);

$rs = $customerdb->Execute($sql,$paraArr);
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