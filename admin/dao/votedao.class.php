<?
//vote dao
//zjb
//090216
include_once("resultdao.class.php");
class VoteDao extends BaseDao
{
	var $logger;

	function VoteDao($db)
	{
		$this->db = $db;
		$this->table = "t_vote";

		$this->logger = new Logger($db);
	}

	function Add($subject,$lan,$customerFieldArr)
	{
		
		$record['Subject'] = stripslashes($subject);
		$record['Language'] = $lan;
		$record['NoteTime'] = date("Y-m-d H:i:s");

        $id = $this->Insert($record+$customerFieldArr);
		
		$this->logger->add(GetIPAddr(),"添加投票内容，ID:".$id.",名称:".$subject);

		return $id;
	
	}

	function Edit($id,$subject,$lan,$customerFieldArr)
	{
		$record['Subject'] = stripslashes($subject);
		$record['Language'] = $lan;
		$record['NoteTime'] = date("Y-m-d H:i:s");

        $ok = $this->Update($record+$customerFieldArr,"id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"修改投票内容，ID:".$id.",名称:".$subject);
			return $this->SUCCESS;
		}

		return $this->FAILED;
	}


//删除投票问题并删除问题下的所有答案
	function Delete($id,$cascade=false)
	{
		$this->Remove("id=".$id);

		if ($cascade)
		{
			$dao = new ResultDao($this->db);
			$dao->DeleteByType($id);
		}

		$this->logger->add(GetIPAddr(),"投票问题,ID:".$id);
	}

}
?>