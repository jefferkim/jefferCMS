<?php
include_once("config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);

$data = "";
$msg = false;
$action = trim($_REQUEST["opera"]);
$filter = array("gif","jpg");
$path = "upload/";

switch($action)
{
	case 'up':
		if(isset($_FILES["Filedata"]))
		{
			$up = new upload($_FILES["Filedata"],$path,dirname(ROOTDIR)."/",true,$filter);
			if($up->stat==true){
				$data = $up->result;
				$msg = true;
			}else{
				$data = $up->error;
				$msg = false;
			}
		}
		$result = array(
			'REMS' => $msg,
			'DATA' => $data
		);
		break;
	case 'save':
		$db = $SysConfig['customerdb'];
		$called = $_REQUEST['called'];
		$time = date("Y-m-d H:i:s");
		$ip = $_SERVER['REMOTE_ADDR'];
		for($i=1;$i<=10;$i++)
		{
			if(isset($_REQUEST['picur'.$i]))
			{
				$db->Execute("INSERT INTO t_upload(Called,PicURL,BigURL,NoteTime,IP) VALUES(?,?,?,?,?)",array($called,$_REQUEST['picur'.$i],$_REQUEST['picur'.$i],$time,$ip));
			}
		}
		$data = "添加成功！";
		$msg = false;
		$result = array(
			'REMS' => $msg,
			'DATA' => $data
		);
		break;
	case 'show':
		$where = " WHERE 1=1";
		$page = 1;
		$pageCounts = 15;
		$type = "";
		$paraArr = array();
		
		if (isset($_POST['page']) && $_POST['page']>0)
			$page = $_POST['page'];
		if (isset($_POST['pagecounts']) && $_POST['pagecounts'] > 0)
			$pageCounts = $_POST['pagecounts'];
		if (isset($_POST['type']) && $_POST['type'] != "")
			$type = $_POST['type'];
		
		$start = ($page - 1) * $pageCounts;
		
		if ($type != "")
		{
			$where .= " AND Called=?";
			$paraArr[] = $type;
		}
		$sql = "SELECT COUNT(*) FROM t_upload ".$where;
		$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
		$counts = $rs->fields[0];
		
		$sql = "SELECT id,Called,PicURL,NoteTime FROM t_upload ".$where." ORDER BY id DESC LIMIT ?,?";
		$paraArr[] = $start;
		$paraArr[] = intval($pageCounts);
		$rs = $SysConfig['customerdb']->Execute($sql,$paraArr);
		$data = array();
		while (!$rs->EOF){
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
		break;
}

echo json_encode($result);
?>
