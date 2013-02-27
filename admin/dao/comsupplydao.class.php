<?
//products dao class
//zjb
//080723

class ComSupplyDao extends BaseDao
{
	var $logger;

	function ComSupplyDao($db)
	{
		$this->db = $db;
		$this->table = "t_supply";

		$this->logger = new Logger($db);
	}

	//删除产品
	function Delete($id)
	{
		$this->Remove("id=".$id);
		$this->logger->add(GetIPAddr(),"删除供应信息,ID:".$id);
	}

	//推荐
	function setCommend($id)
	{
		$record['IsCommend'] = 1;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"设置供应信息推荐,ID:".$id);
	}

	//取消推荐
	function setUnCommend($id)
	{
		$record['IsCommend'] = 0;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"设置供应信息取消推荐,ID:".$id);
	}

	//设置排序位置
	function setOrder($id,$order)
	{
		$record['OrderBy'] = $order;
		$this->Update($record,"id=".$id);
		//$this->logger->add(GetIPAddr(),"设置产品排序，ID:".$id.",位置:".$order);
	}
}
?>