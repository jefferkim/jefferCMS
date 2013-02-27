<?
//DAO基类
//08-05-12
//zjb

class BaseDao
{
	var $db;
	var $table;

	var $SUCCESS = "SUCCESS";
	var $FAILED = "FAILED";

	function BaseDao($db,$table)
	{
		$this->db = $db;
		$this->table = $table;
	}

	function Insert($records)
	{
		$this->db->AutoExecute($this->table,$records,'INSERT');

		return $this->db->Insert_ID();
	}

	function Update($records,$where)
	{
		if ($where == "")
			return false;

		return $this->db->AutoExecute($this->table,$records,'UPDATE',$where);
	}

	function Remove($where)
	{
		if ($where == "")
			return false;

		return $this->db->Execute("DELETE FROM ".$this->table." WHERE ".$where);
	}

	//设置排序位置
	function SetOrder($id,$order)
	{
		$record['OrderBy'] = $order;
		$this->Update($record,'id='.$id);
	}

	//向上移一位
	function MovePrev($id)
	{
		$current = $this->db->Execute("SELECT OrderBy FROM ".$this->table." WHERE id=?",array($id));
		
		if ($current->RecordCount() == 1)
		{
			$currentOrder = $current->fields['OrderBy'];
			$prev = $this->db->Execute("SELECT id,OrderBy FROM ".$this->table." WHERE OrderBy<? ORDER BY OrderBy DESC LIMIT 0,1",array($currentOrder));
			if ($prev->RecordCount() == 1)
			{
				$prevOrder = $prev->fields['OrderBy'];
				$prevId = $prev->fields['id'];
				$this->db->Execute("UPDATE ".$this->table." SET OrderBy=? WHERE id=?",array($currentOrder,$prevId));
				$this->db->Execute("UPDATE ".$this->table." SET OrderBy=? WHERE id=?",array($prevOrder,$id));
			}
		}
	}

	//向下移一位
	function MoveNext($id)
	{
		$current = $this->db->Execute("SELECT OrderBy FROM ".$this->table." WHERE id=?",array($id));
		
		if ($current->RecordCount() == 1)
		{
			$currentOrder = $current->fields['OrderBy'];
			$next = $this->db->Execute("SELECT id,OrderBy FROM ".$this->table." WHERE OrderBy>? ORDER BY OrderBy LIMIT 0,1",array($currentOrder));
			if ($next->RecordCount() == 1)
			{
				$nextOrder = $next->fields['OrderBy'];
				$nextId = $next->fields['id'];
				$this->db->Execute("UPDATE ".$this->table." SET OrderBy=? WHERE id=?",array($currentOrder,$nextId));
				$this->db->Execute("UPDATE ".$this->table." SET OrderBy=? WHERE id=?",array($nextOrder,$id));
			}
		}
	}

	//移到首位
	function MoveFirst($id)
	{
		$rs = $this->db->Execute("SELECT MIN(OrderBy) FROM ".$this->table);
		$current = $this->db->Execute("SELECT OrderBy FROM ".$this->table." WHERE id=?",array($id));
		if ($rs->RecordCount() == 1 && $current->RecordCount() == 1)
		{
			$firstOrder = $rs->fields[0];
			$currentOrder = $current->fields['OrderBy'];
			$this->db->Execute("UPDATE ".$this->table." SET OrderBy=OrderBy+1 WHERE OrderBy<=?",array($currentOrder));
			$this->db->Execute("UPDATE ".$this->table." SET OrderBy=".$firstOrder." WHERE id=?",array($id));
		}
	}

	//移到尾位
	function MoveLast($id)
	{
		$rs = $this->db->Execute("SELECT MAX(OrderBy) FROM ".$this->table);
		$current = $this->db->Execute("SELECT OrderBy FROM ".$this->table." WHERE id=?",array($id));
		if ($rs->RecordCount() == 1 && $current->RecordCount() == 1)
		{
			$lastOrder = $rs->fields[0];
			$currentOrder = $current->fields['OrderBy'];
			$this->db->Execute("UPDATE ".$this->table." SET OrderBy=OrderBy-1 WHERE OrderBy>=?",array($currentOrder));
			$this->db->Execute("UPDATE ".$this->table." SET OrderBy=".$lastOrder." WHERE id=?",array($id));
		}
	}
}
?>