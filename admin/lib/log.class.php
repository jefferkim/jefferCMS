<?
//日志处理
//Date:08-05-07
//zjb

class Logger
{
	var $db;

	//$db			adodb数据库连接对象
	function Logger($db)
	{
		$this->db = $db;
	}

	//系统日志
	//table struct
	//table name`t_log`
	//id		int			自增主健
	//IP		varchar		IP地址
	//UserId	varchar		用户ID
	//UserName	varchar		用户名称
	//Time		DateTime	日期时间
	//Type		text		备注
	function write($ip,$userid,$username,$type)
	{
		$record['IP'] = $ip;
		$record['UserId'] = $userid;
		$record['UserName'] = $username;
		$record['Time'] = date("Y-m-d H:i:s");
		$record['Type'] = $type;

		$this->db->AutoExecute("t_log",$record,'INSERT');
	}

	//客户后台日志
	//table struct
	//table name`t_log`
	//id			int			自增主健
	//IP			varchar		IP地址
	//Time			DateTime	日期时间
	//Description	text		备注
	function add($ip,$type)
	{
		$record['IP'] = $ip;
		$record['Time'] = date("Y-m-d H:i:s");
		$record['Description'] = $type;

		$this->db->AutoExecute('t_log',$record,'INSERT');
	}
}
?>