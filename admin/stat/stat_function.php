<?
include_once("../config.php");

function stat_num($table){
$sql="select count(*) as num from ".$table."";
$allnum=mysql_query($sql); 
$rs=mysql_fetch_object($allnum); 
$num=$rs->num;
echo $num;
}

function day_num($table){
$sql="select count(*) as num from ".$table." where NoteTime='".date("Y-m-d")."'";
$allnum=mysql_query($sql); 
$rs=mysql_fetch_object($allnum); 
$num=$rs->num;
echo $num;
}

$adminid = $_SESSION['SWEBADMIN_USERID'];
$sys_userRs = $SysConfig['maindb']->Execute("SELECT * FROM t_admin WHERE id=?",array($adminid));
if ($sys_userRs->RecordCount() >0)
{
	$sys_userObj = $sys_userRs->FetchObject();
	$Space=	$sys_userObj->SPACE;
    $ServiceStart = $sys_userObj->SERVICESTART;
	$ServiceEnd = $sys_userObj->SERVICEEND;
	$ServerName = $sys_userObj->SERVERNAME;
	$ServerTel = $sys_userObj->SERVERTEL;
	$ServerQQ = $sys_userObj->SERVERQQ;
}

function msg_raply($table){
$sql="select count(*) as num from ".$table." where Reply<>''";
$allnum=mysql_query($sql); 
$rs=mysql_fetch_object($allnum); 
$num=$rs->num;
echo $num;
}


function isprocess($table){
$num=0;
$sql="select count(*) as num from ".$table." where IsProcess=0";
$allnum=mysql_query($sql); 
$rs=mysql_fetch_object($allnum); 
$num=$rs->num;
echo $num;
}




?>