<?php
include_once("config.php");

$extArr = array("pdf","doc","xls","ppt","zip","rar","7z","txt","jpg","gif","png","docx","xlsx","pptx","pps","ppsx","swf","wmv","avi","flv","mp3","wma");
$picroot = "upload/";

$uploadResult = SaveFile('Filedata',$picroot,"",dirname(ROOTDIR)."/",8192,$extArr);

if ($uploadResult[0])
{
	echo $uploadResult[1];
}
?>