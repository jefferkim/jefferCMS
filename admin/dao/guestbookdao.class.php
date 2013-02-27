<?
//guest book dao class
//zjb
//080727

class GuestBookDao extends BaseDao
{
	var $logger;

	function GuestBookDao($db)
	{
		$this->db = $db;
		$this->table = 't_guestbook';

		$this->logger = new Logger($db);
	}

	function setShow($id)
	{
		$record['IsShow'] = 1;

		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"设置留言显示,ID:".$id);
	}

	function setHide($id)
	{
		$record['IsShow'] = 0;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"设置留言隐藏,ID:".$id);
	}

	function Delete($id)
	{
		$this->Remove("id=".$id);
		$this->logger->add(GetIPAddr(),"删除留言,ID:".$id);
	}

	function Reply($id,$content)
	{
		$record['Reply'] = $content;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"留言回复,ID:".$id);
	}
}
?>