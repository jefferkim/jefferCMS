<?
include_once("../../config.php");
$userRole = $_SESSION['SWEBADMIN_USERROLE'];
if (!UserIsInRole('J0',$userRole))
{
	exit();
}

$where = "WHERE 1=1";
$page = 1;
$pageCounts = 15;
$language = "";
$name = "";
$paraArr = array();

if (isset($_POST['page']) && $_POST['page']>0)
	$page = $_POST['page'];
if (isset($_POST['pagecounts']) && $_POST['pagecounts'] > 0)
	$pageCounts = $_POST['pagecounts'];
if (isset($_POST['language']) && $_POST['language'] != "")
	$language = $_POST['language'];
if (isset($_POST['name']) && $_POST['name'] != "")
	$name = $_POST['name'];

$start = ($page - 1) * $pageCounts;

if ($language != "")
{
	$where .= " AND Language=?";
	$paraArr[] = $language;
}
if ($name != "")
{
	$where .= " AND (UserName LIKE ? OR Called LIKE ?)";
	$paraArr[] = "%".$name."%";
	$paraArr[] = "%".$name."%";
}

$rs = $SysConfig['customerdb']->Execute("SELECT COUNT(*) FROM t_comuser ".$where,$paraArr);
$counts = $rs->fields[0];

$sql = "SELECT * FROM t_comuser ".$where." ORDER BY id DESC LIMIT ?,?";
$paraArr[] = $start;
$paraArr[] = intval($pageCounts);
$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$data = array();
while (!$rs->EOF)
{
	$row = $rs->FetchObject();
	$row->LANGUAGE = $SysConfig['language'][$row->LANGUAGE];
	$row->NOTETIME = date("Y-m-d",strtotime($row->NOTETIME));
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