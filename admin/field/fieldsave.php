<?php
include_once("../config.php");
include_once("../dao/fielddao.class.php");

$userRole = $_SESSION['SWEBADMIN_USERROLE'];
$action = $_REQUEST['action'];

$msg = "";

switch($action)
{
	case "add":
		$msg = add($SysConfig['customerdb']);
		break;
	case "del":
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
	$tableName = $_REQUEST['tablename'];
	if ($dataType == "varchar")
	{
		$dataType = "varchar(255)";
	}
	if ($called == "" || $fieldName == "")
	{
		return "请填写名称";
	}

	if (HasThisField($db,$fieldName,$tableName))
	{
		return "此字段已经存在，不能添加";
	}

	$sql = "ALTER TABLE `".$tableName."` ADD `".$fieldName."` ".$dataType." NOT NULL";
	$db->Execute($sql);

	if ($defaultValue != "")
	{
		$sql = "UPDATE ".$tableName." SET `".$fieldName."`='".$defaultValue."'";
		$db->Execute($sql);
	}

	$dao = new FieldDao($db);
	$dao->Add($called,$fieldName,$dataType,$uiType,$defaultValue,$tableName);

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
		$tableName = $obj->TYPENAME;

		if (HasThisField($db,$fieldName,$tableName))
		{
			$sql = "ALTER TABLE `".$tableName."` DROP `".$fieldName."`";
			$db->Execute($sql);
		}

		$dao = new FieldDao($db);
		$dao->Delete($id);
		return "删除成功";
	}

	return "删除失败";
}

function HasThisField($db,$field,$tableName)
{
	$fieldDict = $db->MetaColumns($tableName);
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