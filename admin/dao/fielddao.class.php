<?
//product field class
//zjb
//080722


class FieldDao extends BaseDao
{
	var $logger;

	function FieldDao($db)
	{
		$this->db = $db;
		$this->table = 't_fields';

		$this->logger = new Logger($db);
	}

	//给产品添加一个新字段
	function Add($called,$fieldName,$dataType,$uiType,$defaultValue,$table)
	{
		$record['Called'] = stripslashes($called);
		$record['FieldName'] = $fieldName;
		$record['DataType'] = $dataType;
		$record['UiType'] = $uiType;
		$record['DefaultValue'] = $defaultValue;
		$record['TypeName'] = $table;

		$id = $this->Insert($record);

		$this->logger->add(GetIPAddr(),"添加自定义字段,ID:".$id.",名称:".$called.",表名：".$table);

		return $this->SUCCESS;
	}

	//删除一个新加的字段
	function Delete($id)
	{
		$ok = $this->Remove("id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"删除自定义字段,ID:".$id);

			return $this->SUCCESS;
		}

		return $this->FAILED;
	}
}
?>