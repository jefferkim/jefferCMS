<?php
include_once("config.php");
include_once(ROOTDIR."lib/folder.class.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);
include_once("water.php");

if ($_SESSION['SWEBADMIN_USERNAME']=="")
{
	exit;
}

$folder = new Folder();
$arr = $folder->readFolder("../upload");
$fileArr = $arr[1];
$nousedFileArr = array();

//var_dump($fileArr);
$len = count($fileArr);
echo $len;
for($i=0; $i<$len; $i++)
{
	echo $fileArr[$i]."<br />";
	
	WaterAdd("../upload/".$fileArr[$i],"新闻","1.jpg");
}
?>
ok