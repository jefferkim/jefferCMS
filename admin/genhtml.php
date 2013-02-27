<?php
include_once("config.php");
include_once(ROOTDIR."lib/folder.class.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);

$username = $_SESSION['SWEBADMIN_USERNAME'];

$folder = new Folder();
$lanArr = $SysConfig['customerLanguage'];

while(list($key,$val)=each($lanArr))
{
	ob_start();
	include_once(ROOTDIR.$username."/".$key."/index.php");
	$content = ob_get_contents();
	ob_flush();
	echo $content;
	echo "<br><br><br><br>";
}
?>