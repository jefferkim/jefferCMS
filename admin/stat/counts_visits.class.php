<?php
 


/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    SQL:
 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 	DROP TABLE IF EXISTS hl_counter;
  	CREATE TABLE `hl_counter` (
    `id` int(11) NOT NULL auto_increment,
    `ip` varchar(50) NOT NULL COMMENT 'IP地址',
    `counts` varchar(50) NOT NULL COMMENT '统计访问次数',
 	`date` datetime NOT NULL COMMENT '访问时间',
    PRIMARY KEY  (`id`)
 	)ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=gb2312;
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/**
 +----------------------------------------------------------------------
    使用实例：
 +----------------------------------------------------------------------
    $counts_visits = new counter('hl_counter');	实例化对象
 +----------------------------------------------------------------------
    记录访问数：
    $counts_visits->record_visits();
 +----------------------------------------------------------------------
 	获取访问数据：
 	$counts_visits->get_sum_visits();			获取总访问量
 	$counts_visits->get_sum_ip_visits(); 		获取总IP访问量
 	$counts_visits->get_month_visits();			获取当月访问量
  	$counts_visits->get_month_ip_visits();		获取当月IP访问量
    $counts_visits->get_date_visits();			获取当日访问量
    $counts_visits->get_date_ip_visits(); 		获取当日IP访问量
 +----------------------------------------------------------------------
    上述仅为逻辑演示,本类可灵活使用
 +----------------------------------------------------------------------
 */

	class counts_visits{

		/*
		 * 获取表名
		 *
		 * @private String
		 */
			private $table;


		/**
		 * 构造函数
		 *
		 * @access public
	 	 * @parameter string $table 表名
		 * @return void
		 */
		public function __construct($table){
			$this->table = $table;
		}

		/**
		 * 获得客户端真实的IP地址
		 *
		 * @access public
		 * @return void
		 */
		public function getip(){
			if(getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")){
				$ip = getenv("HTTP_CLIENT_IP");
			}else if(getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")){
				$ip = getenv("HTTP_X_FORWARDED_FOR");
			}else if(getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")){
				$ip = getenv("REMOTE_ADDR");
			}else if(isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")){
				$ip = $_SERVER['REMOTE_ADDR'];
			}else{
				$ip = "unknown";
			}
			return ($ip);
		}

		/**
		 * 记录访问数（默认一个IP每天只统计一次）
		 *
		 * @access public
		 * @return void
		 */
		public function record_visits(){
			$ip = $this->getip(); //获得客户端真实的IP地址
			$result = mysql_query("select * from $this->table where ip = '$ip'");
		 	$row = mysql_fetch_array($result);
		 	if(is_array($row)){
		 		if(!$_COOKIE['visits']){
					mysql_query("UPDATE $this->table SET `counts` =  '".($row[counts]+1)."' WHERE `ip` = '$ip' LIMIT 1 ;");
		 		}
		 	}else{
		 		mysql_query("INSERT INTO $this->table(`id`,`ip`,`counts`,`date`)VALUES (NULL,'$ip','1',Now());");
		 		setcookie('visits',$ip,time()+3600*24);
		 	}
		}

		/*
		 * 获取总访问量、月访问量、日访问量的共有方法
		 *
		 * @access private
		 * @parameter string $condition  sql语句条件
		 * @return integer
		 */
		private function get_visits($condition = ''){
			if($condition == ''){
				$query = mysql_query("select sum(counts) as counts from $this->table");
			}else{
				$query = mysql_query("select sum(counts) as counts from $this->table where $condition");
			}
			return mysql_result($query,0,'counts');
		}

		/*
		 * 获取IP访问量的共有方法
		 *
		 * @access private
		 * @parameter string $condition  sql语句条件
		 * @return integer
		 */
		private function get_ip_visits($condition = ''){
			if($condition == ''){
				$query = mysql_query("select * from $this->table");
			}else{
				$query = mysql_query("select * from $this->table where $condition");
			}
			while($row = mysql_fetch_array($query)){
				$ip_visits_arr[] = $row['ip'];
			}
			$ip_visits = count($ip_visits_arr);
			return $ip_visits;
		}

		/**
		 * 获取总访问量
		 *
		 * @access public
		 * @return integer
		 */
		public function get_sum_visits(){
			return $this->get_visits();
		}

		/**
		 * 获取总IP访问量
		 *
		 * @access public
		 * @return integer
		 */
		public function get_sum_ip_visits(){
			return $this->get_ip_visits();
		}

		/**
		 * 获取当月访问量
		 *
		 * @access public
		 * @return integer
		 */
		public function get_month_visits(){
			return $this->get_visits("DATE_FORMAT(date,'%Y-%m') = '".substr(date('Y-m-d'),0,7)."'");
		}

		/**
		 * 获取当月IP访问量
		 *
		 * @access public
		 * @return integer
		 */
		public function get_month_ip_visits(){
			return $this->get_ip_visits("DATE_FORMAT(date,'%Y-%m') = '".substr(date('Y-m-d'),0,7)."'");
		}

		/**
		 * 获取当日访问量
		 *
		 * @access public
		 * @return integer
		 */
		public function get_date_visits(){
			return $this->get_visits("DATE_FORMAT(date,'%Y-%m-%d') = '".date('Y-m-d')."'");
		}

		/**
		 * 获取当日IP访问量
		 *
		 * @access public
		 * @return integer
		 */
		public function get_date_ip_visits(){
			return $this->get_ip_visits("DATE_FORMAT(date,'%Y-%m-%d') = '".date('Y-m-d')."'");
		}

	}

?>




