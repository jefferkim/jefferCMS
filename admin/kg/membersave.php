<?
include_once("../../config.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_POST['action'];

$msg = "";

switch($action)
{
	case "add":

		$msg = add($SysConfig['customerdb']);
		break;
	case "edit":

		$msg = edit($SysConfig['customerdb']);
		break;
}

echo json_encode(array('result'=>$msg));

function add($db)
{
	$name = $_POST['name'];
	$cardnum = $_POST['cardnum'];
	$zy = $_POST['zy'];
	$cj = $_POST['cj'];

	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_kg' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	/*$dao = new MemberDao($db);
	$dao->Add($userName,$password,$called,$tel,$mobile,$mail,$company,$isLock,$language,$customerFieldArr);*/

	$record = array(
		'name'	=> $name,
		'cardnum'	=> $cardnum,
		'zy'	=> $zy,
		'cj'	=> $cj,
	);

	$record = array_merge($record,$customerFieldArr);

	$db->AutoExecute('t_kg',$record,'INSERT');

	return "添加成功";
}

function edit($db)
{
	$id = $_POST['id'];
	$name = $_POST['name'];
	$cardnum = $_POST['cardnum'];
	$zy = $_POST['zy'];
	$cj = $_POST['cj'];

	$customerFieldArr = array();
	$fieldRs = $db->Execute("SELECT * FROM t_fields WHERE TypeName='t_user' ORDER BY id");
	while (!$fieldRs->EOF)
	{
		$fieldObj = $fieldRs->FetchObject();
		$customerFieldArr[$fieldObj->FIELDNAME] = $_REQUEST[$fieldObj->FIELDNAME];
		$fieldRs->MoveNext();
	}

	//$dao = new MemberDao($db);
	//$dao->Edit($id,$userName,$password,$called,$tel,$mobile,$mail,$company,$isLock,$language,$customerFieldArr);

	$record = array(
		'name'	=> $name,
		'cardnum'	=> $cardnum,
		'zy'	=> $zy,
		'cj'	=> $cj,
	);

	$record = array_merge($record,$customerFieldArr);

	$db->AutoExecute('t_kg',$record,'UPDATE',"id=".$id);

	return "修改成功";
}
?>