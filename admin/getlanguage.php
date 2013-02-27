<?php
include_once("config.php");

$lanArr = $SysConfig['customerLanguage'];

$lan = $_REQUEST['lan'];
$result = $lanArr[$lan];

echo json_encode(array('result'=>$result));
?>