<?php

/*******************************************
//全局设置文件
editor 10-05-10
editor files
********************************************/
date_default_timezone_set ('Asia/Shanghai');

define('ROOTDIR',dirname(__FILE__)."/");		//常量，系统根目录

//开始载入系统所需库
//数据库
include_once(ROOTDIR."lib/adodb/adodb.inc.php");

//json
if (PHP_VERSION < '5.2.0')
{
	include_once(ROOTDIR."lib/myjson.php");
}

include_once(ROOTDIR."lib/util.php");
include_once(ROOTDIR."lib/log.class.php");
include_once(ROOTDIR."lib/pager.class.php");
include_once(ROOTDIR."lib/basedao.class.php");
include_once(ROOTDIR."lib/htmlhelper.php");
include_once(ROOTDIR."lib/cart.class.php");
include_once(ROOTDIR."lib/IPager.php");
include_once(ROOTDIR."lib/TextPager.php");
include_once(ROOTDIR."lib/class.upload.php");

session_start();		//session支持

//全局设置
$SysConfig['title'] = '派桑软件网站建设系统';
$SysConfig['copyright'] = '版权所有&nbsp;&copy;&nbsp;宁波市科技园区派森软件有限公司(推荐使用IE7及FireFox)';
$SysConfig['modeldir'] = "model";		//模板包目录
$SysConfig['picdir'] = 'upload';		//模板图片目录
$SysConfig['backup'] = 'backup';		//数据备份文件目录
$SysConfig['plugindir'] = 'plugin';		//功能模块包目录
$SysConfig['webadmin'] = 'webadmin';	//网站管理员目录
$SysConfig['domain'] = "http://testweb6.iecworld.com";
$SysConfig['rooturl'] = $SysConfig['domain']."/hejumei/admin";		//网站根目录
$SysConfig['swfupload'] = "../upload.php";		//网站相对地址
$SysConfig['jsroot'] = $SysConfig['rooturl']."/js";	//js文件地址
$SysConfig['filewrite'] = false;	//是否开启文件写入模式
$SysConfig['independ'] = false;		//是否转出

$SysConfig['CommonRole'] = 0;		//通用模块常量
$SysConfig['CustomerRole'] = 1;		//定制模块常量
$SysConfig['UseRewrite'] = true;   //默认不使用网页重写生成URL

//全局数据库连接
$SysConfig['dbhost'] = 'localhost';
$SysConfig['dbuser'] = 'root';
$SysConfig['dbpass'] = 'root';
$SysConfig['database'] = "passion";
$SysConfig['maindb'] = ADONewConnection("mysql");
$SysConfig['maindb']->Connect($SysConfig['dbhost'],$SysConfig['dbuser'],$SysConfig['dbpass'],$SysConfig['database']);
$SysConfig['maindb']->debug = false;	//是否开启调试模式
$SysConfig['maindb']->charSet = 'UTF8';
$SysConfig['maindb']->Execute("set names 'UTF8'");

//admin图片上传目录
$SysConfig['PHPUPLOADDIR'] = "/";

//语言字典
$SysConfig['language'] = array();
$lanRs = $SysConfig['maindb']->Execute("SELECT * FROM t_dict WHERE Type=1 ORDER BY ORDERBY");
while (!$lanRs->EOF)
{
	$lan = $lanRs->FetchObject();
	$SysConfig['language'][$lan->CODE] = $lan->CALLED;
	$lanRs->MoveNext();
}

$SysConfig['yesnoarray'] = array(
	1 => '是',
	0 => '否'
);
//开启PHP错误描述
error_reporting(E_ALL);

//开启gzip压缩
//ob_start("ob_gzhandler");

//SWEBADMIN_DBNAME如存在，则建立客户的数据库连接
if (isset($_SESSION['SWEBADMIN_DBNAME']) && $_SESSION['SWEBADMIN_DBNAME']!="")
{
	$SysConfig['customerdb'] = ADONewConnection("mysql");
	$SysConfig['customerdb']->NConnect($SysConfig['dbhost'],$SysConfig['dbuser'],$SysConfig['dbpass'],$_SESSION['SWEBADMIN_DBNAME']);
	$SysConfig['customerdb']->charSet = 'UTF8';
	$SysConfig['currentLan'] = 'cn';
	$SysConfig['customerdb']->Execute("set names 'UTF8'");

	$customerLanArr = array();
	$i = 0;
	
	$lanRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_language WHERE UserId=".$_SESSION['SWEBADMIN_USERID']." ORDER BY id");
	
	$count = $lanRs->RecordCount();
	
	if($count>0){
		
    $lanRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_language WHERE UserId=".$_SESSION['SWEBADMIN_USERID']." ORDER BY id");
	
	}else{
    $lanRs = $SysConfig['maindb']->Execute("SELECT * FROM t_language WHERE UserId=".$_SESSION['SWEBADMIN_USERID']." ORDER BY id");
	}
	
	while (!$lanRs->EOF)
	{
		$lan = $lanRs->FetchObject();
		$customerLanArr[$lan->CALLED] = $SysConfig['language'][$lan->CALLED];
		if ($i == 0)
		{
			$SysConfig['currentLan'] = $lan->CALLED;
			$i = 1;
		}
		$lanRs->MoveNext();
	}

	$SysConfig['customerLanguage'] = $customerLanArr;
}
?>
