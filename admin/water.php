<?
include_once(ROOTDIR."/lib/PhpUpImageWater.php");

function WaterAdd($pic, $text, $new="", $pos=5)
{
	$h = new PhpUpImageWater($pic,5); 
	//$h->setWaterImageInfo("small_php.gif",10); 
	$h->setWaterTextInfo($text,"#ffffff","15"); 
	$h->makeWater($new); 
}
?>
