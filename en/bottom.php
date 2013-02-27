<?php 
//以下代码实现从客户端获取IP，操作系统，浏览器的信息
class clientGetObj //类
{
function getBrowse() //取浏览器版本函数
{
global $_SERVER;
$Agent = $_SERVER['HTTP_USER_AGENT']; 
$browser = '';
$browserver = '';
$Browser = array('Lynx', 'MOSAIC', 'AOL', 'Opera', 'JAVA', 'MacWeb', 'WebExplorer', 'OmniWeb'); 
for($i = 0; $i <= 7; $i ++)
{
if(strpos($Agent, $Browsers[$i]))
{
$browser = $Browsers[$i]; 
$browserver = '';
}
}
if(ereg('Mozilla', $Agent) && !ereg('MSIE', $Agent))
{
$temp = explode('(', $Agent); 
$Part = $temp[0];
$temp = explode('/', $Part);
$browserver = $temp[1];
$temp = explode(' ', $browserver); 
$browserver = $temp[0];
$browserver = preg_replace('/([d.]+)/', '1', $browserver);
$browserver = $browserver;
$browser = 'Netscape Navigator'; 
}
if(ereg('Mozilla', $Agent) && ereg('Opera', $Agent)) {
$temp = explode('(', $Agent);
$Part = $temp[1]; 
$temp = explode(')', $Part);
$browserver = $temp[1];
$temp = explode(' ', $browserver); 
$browserver = $temp[2];
$browserver = preg_replace('/([d.]+)/', '1', $browserver);
$browserver = $browserver;
$browser = 'Opera'; 
}
if(ereg('Mozilla', $Agent) && ereg('MSIE', $Agent)){
$temp = explode('(', $Agent);
$Part = $temp[1]; 
$temp = explode(';', $Part);
$Part = $temp[1];
$temp = explode(' ', $Part);
$browserver = $temp[2]; 
$browserver = preg_replace('/([d.]+)/','1',$browserver);
$browserver = $browserver;
$browser = 'Internet Explorer';
}
if($browser != ''){ 
$browseinfo = $browser.' '.$browserver;
} else {
$browseinfo = false;
}
return $browseinfo;
}
function getIP () //取IP函数
{
global $_SERVER;
if (getenv('HTTP_CLIENT_IP')) {
$ip = getenv('HTTP_CLIENT_IP');
} else if (getenv('HTTP_X_FORWARDED_FOR')) {
$ip = getenv('HTTP_X_FORWARDED_FOR'); 
} else if (getenv('REMOTE_ADDR')) {
$ip = getenv('REMOTE_ADDR');
} else {
$ip = $_SERVER['REMOTE_ADDR'];
}
return $ip; 
}

function getOS () //取操作系统类型函数
{
global $_SERVER;
$agent = $_SERVER['HTTP_USER_AGENT'];
$os = false;
if (eregi('win', $agent) && strpos($agent, '95')){ 
$os = 'Windows 95';
}
else if (eregi('win 9x', $agent) && strpos($agent, '4.90')){
$os = 'Windows ME'; 
}
else if (eregi('win', $agent) && ereg('98', $agent)){
$os = 'Windows 98';
}
else if (eregi('win', $agent) && eregi('nt 5.1', $agent)){ 
$os = 'Windows XP';
}
else if (eregi('win', $agent) && eregi('nt 5', $agent)){
$os = 'Windows 2000';
} 
else if (eregi('win', $agent) && eregi('nt', $agent)){
$os = 'Windows NT';
}
else if (eregi('win', $agent) && ereg('32', $agent)){ 
$os = 'Windows 32';
}
else if (eregi('linux', $agent)){
$os = 'Linux';
}
else if (eregi('unix', $agent)){ 
$os = 'Unix';
}
else if (eregi('sun', $agent) && eregi('os', $agent)){
$os = 'SunOS';
} 
else if (eregi('ibm', $agent) && eregi('os', $agent)){
$os = 'IBM OS/2';
}
else if (eregi('Mac', $agent) && eregi('PC', $agent)){ 
$os = 'Macintosh';
}
else if (eregi('PowerPC', $agent)){
$os = 'PowerPC';
}
else if (eregi('AIX', $agent)){ 
$os = 'AIX';
}
else if (eregi('HPUX', $agent)){
$os = 'HPUX';
}
else if (eregi('NetBSD', $agent)){ 
$os = 'NetBSD';
}
else if (eregi('BSD', $agent)){
$os = 'BSD';
}
else if (ereg('OSF1', $agent)){ 
$os = 'OSF1';
}
else if (ereg('IRIX', $agent)){
$os = 'IRIX';
}
else if (eregi('FreeBSD', $agent)){ 
$os = 'FreeBSD';
}
else if (eregi('teleport', $agent)){
$os = 'teleport';
}
else if (eregi('flashget', $agent)){ 
$os = 'flashget';
}
else if (eregi('webzip', $agent)){
$os = 'webzip';
}
else if (eregi('offline', $agent)){ 
$os = 'offline';
}
else {
$os = 'Unknown';
}
return $os;
}
}
//以下代码实现将获取的信息显示到浏览器中
$code = new clientGetObj; 
$ip = $code->getIP();//IP地址： 
$xitong = $code->getOS();//操作系统：
$liulanqi = $code->getBrowse();

$url=$_SERVER['HTTP_REFERER'];
if($url==""){
	$url="直接输入网址访问";
}else{
	$url=$_SERVER['HTTP_REFERER'];
}
?>


<body>


<?php
$flow_id="";
$where = "WHERE ip = '".$ip."' AND NoteTime='".date("Y-m-d")."'";
$flowRs = $maindb->Execute("SELECT * FROM t_flow ".$where);
if ($flowRs->RecordCount() > 0)
{
	$flowObj = $flowRs->FetchObject();
	$flow_id=$flowObj->ID;
}

if($flow_id==""){

	$record = array(
	    'NoteTime' => date("Y-m-d"),
		'IP' => GetIPAddr(),
		'ViewPage' => $_SERVER['PHP_SELF'],
		'RefPage' => $url,
		'OS' => $xitong,
		'Browser' => $liulanqi
	);
	
	
	$maindb->AutoExecute("t_flow",$record,"INSERT");
}
?>

