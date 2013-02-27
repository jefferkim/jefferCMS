<?
include_once("../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];

if (!UserIsInRole('P0',$userRole))
{
	echo '没有权限访问';
	exit();
}


$where = "WHERE 1=1";
$page = 1;
$pageCounts = 15;
$startDate = "";
$endDate = "";
$paraArr = array();

if (isset($_REQUEST['page']) && $_REQUEST['page']>0)
	$page = $_REQUEST['page'];
if (isset($_REQUEST['pagecounts']) && $_REQUEST['pagecounts']>0)
	$pageCounts = $_REQUEST['pagecounts'];
if (isset($_REQUEST['startdate']) && $_REQUEST['startdate']!="")
	$startDate = $_REQUEST['startdate']." 00:00:00";
if (isset($_REQUEST['enddate']) && $_REQUEST['enddate']!="")
	$endDate = $_REQUEST['enddate']." 23:59:59";
$start = ($page - 1)*$pageCounts;

if ($startDate != "" && $endDate != "")
{
	$where .= " AND NoteTime>? AND NoteTime<?";
	$paraArr[] = $startDate;
	$paraArr[] = $endDate;
}
else if ($startDate != "")
{
	$where .= " AND NoteTime>?";
	$paraArr[] = $startDate;
}
else if ($endDate != "")
{
	$where .= " AND NoteTime<?";
	$paraArr[] = $endDate;
}

$sql = "SELECT COUNT(*) FROM t_flow ".$where;
$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$counts = $rs->fields[0];

$sql = "SELECT * FROM t_flow ".$where." ORDER BY id DESC LIMIT ?,?";
$paraArr[] = $start;
$paraArr[] = intval($pageCounts);

$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$data = array();
while (!$rs->EOF)
{
	$row = $rs->FetchObject();
	$data[] = $row;
	$rs->MoveNext();
}


$result = array(
	'counts' => $counts,
	'pageCounts' => $pageCounts,
	'page' =>$page,
	'data' =>$data
);

echo json_encode($result);
?>