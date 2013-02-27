<?php
 


/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    SQL:
 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 	DROP TABLE IF EXISTS hl_counter;
  	CREATE TABLE `hl_counter` (
    `id` int(11) NOT NULL auto_increment,
    `ip` varchar(50) NOT NULL COMMENT 'IP��ַ',
    `counts` varchar(50) NOT NULL COMMENT 'ͳ�Ʒ��ʴ���',
 	`date` datetime NOT NULL COMMENT '����ʱ��',
    PRIMARY KEY  (`id`)
 	)ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=gb2312;
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/**
 +----------------------------------------------------------------------
    ʹ��ʵ����
 +----------------------------------------------------------------------
    $counts_visits = new counter('hl_counter');	ʵ��������
 +----------------------------------------------------------------------
    ��¼��������
    $counts_visits->record_visits();
 +----------------------------------------------------------------------
 	��ȡ�������ݣ�
 	$counts_visits->get_sum_visits();			��ȡ�ܷ�����
 	$counts_visits->get_sum_ip_visits(); 		��ȡ��IP������
 	$counts_visits->get_month_visits();			��ȡ���·�����
  	$counts_visits->get_month_ip_visits();		��ȡ����IP������
    $counts_visits->get_date_visits();			��ȡ���շ�����
    $counts_visits->get_date_ip_visits(); 		��ȡ����IP������
 +----------------------------------------------------------------------
    ������Ϊ�߼���ʾ,��������ʹ��
 +----------------------------------------------------------------------
 */

	class counts_visits{

		/*
		 * ��ȡ����
		 *
		 * @private String
		 */
			private $table;


		/**
		 * ���캯��
		 *
		 * @access public
	 	 * @parameter string $table ����
		 * @return void
		 */
		public function __construct($table){
			$this->table = $table;
		}

		/**
		 * ��ÿͻ�����ʵ��IP��ַ
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
		 * ��¼��������Ĭ��һ��IPÿ��ֻͳ��һ�Σ�
		 *
		 * @access public
		 * @return void
		 */
		public function record_visits(){
			$ip = $this->getip(); //��ÿͻ�����ʵ��IP��ַ
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
		 * ��ȡ�ܷ��������·��������շ������Ĺ��з���
		 *
		 * @access private
		 * @parameter string $condition  sql�������
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
		 * ��ȡIP�������Ĺ��з���
		 *
		 * @access private
		 * @parameter string $condition  sql�������
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
		 * ��ȡ�ܷ�����
		 *
		 * @access public
		 * @return integer
		 */
		public function get_sum_visits(){
			return $this->get_visits();
		}

		/**
		 * ��ȡ��IP������
		 *
		 * @access public
		 * @return integer
		 */
		public function get_sum_ip_visits(){
			return $this->get_ip_visits();
		}

		/**
		 * ��ȡ���·�����
		 *
		 * @access public
		 * @return integer
		 */
		public function get_month_visits(){
			return $this->get_visits("DATE_FORMAT(date,'%Y-%m') = '".substr(date('Y-m-d'),0,7)."'");
		}

		/**
		 * ��ȡ����IP������
		 *
		 * @access public
		 * @return integer
		 */
		public function get_month_ip_visits(){
			return $this->get_ip_visits("DATE_FORMAT(date,'%Y-%m') = '".substr(date('Y-m-d'),0,7)."'");
		}

		/**
		 * ��ȡ���շ�����
		 *
		 * @access public
		 * @return integer
		 */
		public function get_date_visits(){
			return $this->get_visits("DATE_FORMAT(date,'%Y-%m-%d') = '".date('Y-m-d')."'");
		}

		/**
		 * ��ȡ����IP������
		 *
		 * @access public
		 * @return integer
		 */
		public function get_date_ip_visits(){
			return $this->get_ip_visits("DATE_FORMAT(date,'%Y-%m-%d') = '".date('Y-m-d')."'");
		}

	}

?>




