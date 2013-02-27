<?
//products dao class
//zjb
//080723

class ComBuyDao extends BaseDao
{
	var $logger;

	function ComBuyDao($db)
	{
		$this->db = $db;
		$this->table = "t_buy";

		$this->logger = new Logger($db);
	}

	//删除产品
	function Delete($id)
	{
		$this->Remove("id=".$id);
		$this->logger->add(GetIPAddr(),"删除求购信息,ID:".$id);
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