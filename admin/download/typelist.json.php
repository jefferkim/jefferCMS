<?
include_once("../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
if (!UserIsInRole('H5',$userRole))
{
	exit();
}

$where = " WHERE 1=1";
$page = 0;
$pageCounts = 15;
$language = "";
$paraArr = array();

if (isset($_REQUEST['page']) && $_REQUEST['page']>0)
	$page = $_REQUEST['page'];
if (isset($_REQUEST['pagecounts']) && $_REQUEST['pagecounts']>0)
	$pageCounts = $_REQUEST['pagecounts'];
if (isset($_REQUEST['language']) && $_REQUEST['language']!="")
	$language = $_REQUEST['language'];

$start = ($page - 1) * $pageCounts;

if ($language != "")
{
	$where .= " AND Language=?";
	$paraArr[] = $language;
}

if ($page > 0)
{
	$sql = "SELECT COUNT(*) FROM t_downloadtype ".$where;
	$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
	$counts = $rs->fields[0];

	$sql = "SELECT * FROM t_downloadtype ".$where." ORDER BY id LIMIT ?,?";
	$paraArr[] = $start;
	$paraArr[] = intval($pageCounts);
}
else
{
	$counts = 0;
	$sql = "SELECT * FROM t_downloadtype ".$where." ORDER BY id";
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
	'data' => $data
);

echo json_encode($result);
?>