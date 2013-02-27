<?
//order dao
//zjb
//080731

class OrderDao extends BaseDao
{
	var $logger;

	function OrderDao($db)
	{
		$this->db = $db;
		$this->table = "t_order";

		$this->logger = new Logger($db);
	}

	function Delete($id)
	{
		$this->Remove("id=".$id);
		$this->db->Execute("DELETE FROM t_orderdetail WHERE OrderID=?",array($id));
		$this->logger->add(GetIPAddr(),"删除订单,ID:".$id);
	}
}
?>