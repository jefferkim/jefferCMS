<?
include("JSON.php");

function json_decode($jsonstring)
{
	$json = new Services_JSON();
	return $json->decode($jsonstring);
}

function json_encode($jsonobj)
{
	$json = new Services_JSON();
	return $json->encode($jsonobj);
}
?>