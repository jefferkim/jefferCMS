<?
//vote dao
//zjb
//090216

class ResultDao extends BaseDao
{
	var $logger;

	function ResultDao($db)
	{
		$this->db = $db;
		$this->table = "t_result";

		$this->logger = new Logger($db);
	}

	function Add($result,$vote,$lan,$customerFieldArr)
	{
		
		$record['Result'] = stripslashes($result);
		$record['VoteId'] = $vote;
		$record['Language'] = $lan;
		$record['NoteTime'] = date("Y-m-d H:i:s");

        $id = $this->Insert($record+$customerFieldArr);
		
		$this->logger->add(GetIPAddr(),"添加投票答案，ID:".$id.",名称:".$result);

		return $id;
	
	}

	function Edit($id,$result,$vote,$lan,$customerFieldArr)
	{
		$record['Result'] = stripslashes($result);
		$record['VoteId'] = $vote;
		$record['Language'] = $lan;
		$record['NoteTime'] = date("Y-m-d H:i:s");

        $ok = $this->Update($record+$customerFieldArr,"id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"修改投票答案，ID:".$id.",名称:".$result);
			return $this->SUCCESS;
		}

		return $this->FAILED;
	}



//删除投票答案
function Delete($id)
	{
		$this->Remove("id=".$id);
		$this->logger->add(GetIPAddr(),"删除投票答案,ID:".$id);
	}


	//根据投票问题ID删除答案
	
	function DeleteByType($typeId)
	{
		$this->Remove("VoteId=".$typeId);
		$this->logger->add(GetIPAddr(),"删除投票问题，分类ID:".$typeId);
	}

}
?>