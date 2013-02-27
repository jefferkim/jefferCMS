<?
//product field class
//zjb
//080815


class MemberFieldDao extends BaseDao
{
	var $logger;

	function MemberFieldDao($db)
	{
		$this->db = $db;
		$this->table = 't_memberfield';

		$this->logger = new Logger($db);
	}

	//给产品添加一个新字段
	function Add($called,$fieldName,$dataType,$uiType,$defaultValue)
	{
		$record['Called'] = $called;
		$record['FieldName'] = $fieldName;
		$record['DataType'] = $dataType;
		$record['UiType'] = $uiType;
		$record['DefaultValue'] = $defaultValue;

		$id = $this->Insert($record);

		$this->logger->add(GetIPAddr(),"添加会员自定义字段,ID:".$id.",名称:".$called);

		return $this->SUCCESS;
	}

	//删除一个新加的字段
	function Delete($id)
	{
		$ok = $this->Remove("id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"删除会员自定义字段,ID:".$id);

			return $this->SUCCESS;
		}

		return $this->FAILED;
	}
}
?>