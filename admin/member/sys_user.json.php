<?
include_once("../config.php");
$userRole = $_SESSION['SWEBADMIN_USERROLE'];
if (!UserIsInRole('A0',$userRole))
{
	exit();
}

$where = "WHERE 1=1";
$page = 1;
$pageCounts = 11;
$language = "";
$name = "";
$paraArr = array();

if (isset($_POST['page']) && $_POST['page']>0)
	$page = $_POST['page'];
if (isset($_POST['pagecounts']) && $_POST['pagecounts'] > 0)
	$pageCounts = $_POST['pagecounts'];
$start = ($page - 1) * $pageCounts;


$rs = $SysConfig['customerdb']->Execute("SELECT COUNT(*) FROM t_admin ".$where,$paraArr);
$counts = $rs->fields[0];

$sql = "SELECT * FROM t_admin ".$where." ORDER BY id DESC LIMIT ?,?";
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
	'page' => $page,
	'data' => $data
);

echo json_encode($result);
?>