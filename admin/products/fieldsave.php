<?
include_once("../config.php");
include_once("../dao/fielddao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];

$msg = "";

switch($action)
{
	case "add":
		if (!UserIsInRole('F11',$userRole))
		{
			$msg = "没有权限";
			break;
		}

		$msg = add($SysConfig['customerdb']);
		break;
	case "del":
		if (!UserIsInRole('F11',$userRole))
		{
			$msg = "没有权限";
			break;
		}
		$msg = del($SysConfig['customerdb']);
		break;
}

echo json_encode(array('result'=>$msg));

function add($db)
{
	$called = trim($_REQUEST['called']);
	$fieldName = trim($_REQUEST['fieldname']);
	$dataType = trim($_REQUEST['datatype']);
	$uiType = trim($_REQUEST['uitype']);
	$defaultValue = trim($_REQUEST['defaultvalue']);
	if ($dataType == "varchar")
	{
		$dataType = "varchar(255)";
	}
	if ($called == "" || $fieldName == "")
	{
		return "请填写名称";
	}

	if (HasThisField($db,$fieldName))
	{
		return "此字段已经存在，不能添加";
	}

	$sql = "ALTER TABLE `t_products` ADD `".$fieldName."` ".$dataType." NOT NULL";
	$db->Execute($sql);

	$dao = new FieldDao($db);
	$dao->Add($called,$fieldName,$dataType,$uiType,$defaultValue,"t_products");

	return "添加成功";
}

function del($db)
{
	$id = $_REQUEST['id'];

	$rs = $db->Execute("SELECT * FROM t_fields WHERE id=?",array($id));
	if ($rs->RecordCount() > 0)
	{
		$obj = $rs->FetchObject();
		$fieldName = $obj->FIELDNAME;

		if (HasThisField($db,$fieldName))
		{
			$sql = "ALTER TABLE `t_products` DROP `".$fieldName."`";
			$db->Execute($sql);
		}

		$dao = new FieldDao($db);
		$dao->Delete($id);
		return "删除成功";
	}

	return "删除失败";
}

function HasThisField($db,$field)
{
	$fieldDict = $db->MetaColumns('t_products');
	while (list($key,$val) = each($fieldDict))
	{
		if ($key == strtoupper($field))
		{
			return true;
		}
	}

	return false;
}
?>