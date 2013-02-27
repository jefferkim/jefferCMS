<?
include_once("../../config.php");

$where = " WHERE 1=1";
$page = 1;
$pageCounts = 15;
$language = "";
$commend = "";
$keyword = "";

if (isset($_REQUEST['page']) && $_REQUEST['page']>0)
	$page = $_REQUEST['page'];
if (isset($_REQUEST['pagecounts']) && $_REQUEST['pagecounts']>0)
	$pageCounts = $_REQUEST['pagecounts'];
if (isset($_REQUEST['language']) && $_REQUEST['language']!="")
	$language = $_REQUEST['language'];
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

if ($keyword != "")
{
	$where .= " AND (ProName like ? OR Content like ?)";
	$paraArr[] = '%'.$keyword.'%';
	$paraArr[] = '%'.$keyword.'%';
}

$sql = "SELECT COUNT(*) FROM t_buy ".$where;
$proRs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$counts = $proRs->fields[0];

$sql = "SELECT * FROM t_buy ".$where." ORDER BY ORDERBY,id LIMIT ?,?";
$paraArr[] = $start;
$paraArr[] = intval($pageCounts);

$proRs = $SysConfig['customerdb']->Execute($sql,$paraArr);
$resultData = array();
while (!$proRs->EOF)
{
	$row = $proRs->FetchObject();
	$row->LANGUAGE = $SysConfig['language'][$row->LANGUAGE];
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