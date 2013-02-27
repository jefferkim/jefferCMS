<?php
//job dao
//zjb
//080729

class JobDao extends BaseDao
{
	var $logger;

	function JobDao($db)
	{
		$this->db = $db;
		$this->table = 't_job';

		$this->logger = new Logger($db);
	}

	function Add($position,$specialty,$age,$sex,$num,$educational,$experience,$salary,$endtime,$isshow,$isCommend,$orderby,$language,$memo,$customerFieldArr)
	{
		$record = $this->GetRecord($position,$specialty,$age,$sex,$num,$educational,$experience,$salary,$endtime,$isshow,$isCommend,$orderby,$language,$memo,date("Y-m-d H:i:s"),$customerFieldArr);

		$id = $this->Insert($record);
		$this->logger->add(GetIPAddr(),"添加招聘信息,ID:".$id.",职位:".$position);
	}

	function Edit($id,$position,$specialty,$age,$sex,$num,$educational,$experience,$salary,$endtime,$isshow,$isCommend,$orderby,$language,$memo,$customerFieldArr)
	{
		$record = $this->GetRecord($position,$specialty,$age,$sex,$num,$educational,$experience,$salary,$endtime,$isshow,$isCommend,$orderby,$language,$memo,date("Y-m-d H:i:s"),$customerFieldArr);
		$ok = $this->Update($record,"id=".$id);
		if ($ok)
		{
			$this->logger->add(GetIPAddr(),"修改招聘信息,ID:".$id.",职位:".$position);
		}
	}

	function Delete($id)
	{
		$this->Remove("id=".$id);
		$this->logger->add(GetIPAddr(),"删除招聘信息,ID:".$id);
	}

	function SetShow($id)
	{
		$record['IsShow'] = 1;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"设置招聘信息显示,ID:".$id);
	}

	function SetHide($id)
	{
		$record['IsShow'] = 0;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"设置招聘信息隐藏,ID:".$id);
	}

	function SetCommend($id)
	{
		$record['IsCommend'] = 1;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"设置招聘信息推荐,ID:".$id);
	}

	function SetUnCommend($id)
	{
		$record['IsCommend'] = 0;
		$this->Update($record,"id=".$id);
		$this->logger->add(GetIPAddr(),"设置招聘信息取消推荐,ID:".$id);
	}

	function GetRecord($position,$specialty,$age,$sex,$num,$educational,$experience,$salary,$endtime,$isshow,$isCommend,$orderby,$language,$memo,$noteTime,$customerFieldArr)
	{
		$record['Position'] = stripslashes($position);
		$record['Specialty'] = stripslashes($specialty);
		$record['Sex'] = $sex;
		$record['Num'] = $num;
		$record['Age'] = $age;
		$record['Educational'] = stripslashes($educational);
		$record['Experience'] = stripslashes($experience);
		$record['Salary'] = $salary;
		$record['Memo'] = stripslashes($memo);
		$record['EndTime'] = $endtime;
		$record['IsShow'] = $isshow;
		$record['IsCommend'] = $isCommend;
		$record['OrderBy'] = $orderby;
		$record['Language'] = $language;
		if ($noteTime != "")
			$record['NoteTime'] = $noteTime;

		return $record + $customerFieldArr;
	}
}
?>