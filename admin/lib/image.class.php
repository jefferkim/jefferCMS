<?
//图片处理
//Date:08-05-06
//zjb
//需要GD支持
//png需安装libpng
//jpeg需激活jpeg支持
//中文支持需安装freetype


class Image
{
	//修改图片的大小
	//$image				图片全路径
	//$rating				缩放百分比
	function reSize($image,$newimage,$rating)
	{
		$imageInfo = getimagesize($image);
		$oldWidth = $imageInfo[0];
		$oldHeight = $imageInfo[1];
		$newWidth = $oldWidth * ($rating/100);
		$newHeight = $oldHeight * ($rating/100);

		$oldImg = imagecreatefromjpeg($image);
		$newImg = imagecreate($newWidth,$newHeight);
		imagecopyresized($newImg,$oldImg,0,0,0,0,$newWidth,$newHeight,$oldWidth,$oldHeight);
		//unlink($image);
		imagejpeg($newImg,$newimage);
		imagedestroy($newImg);
	}

	//加图片水印
	//$destImage					加过水印后的图
	//$sourceImage				加水印前的原图
	//$waterImage				作为水印的图
	//$position						水印位置
	//0:左上角,1:顶居中,2:右上角,3:左居中,4:正中,5:右居中,6:左下角,7:底居中,8:右下角
	//或是一个数级array(x,y)
	function waterImage($destImage,$sourceImage,$waterImage,$position=8)
	{
		$sourceInfo = getimagesize($sourceImage);
		$sourceWidth = $sourceInfo[0];
		$sourceHeight = $sourceInfo[1];
		$imageType = $sourceInfo[2];
		switch($sourceInfo[2])
		{
			case IMAGETYPE_GIF:
				$sourceImg = imagecreatefromgif($sourceImage);
				break;
			case IMAGETYPE_JPEG:
				$sourceImg = imagecreatefromjpeg($sourceImage);
				break;
			case IMAGETYPE_PNG:
				$sourceImg = imagecreatefrompng($sourceImage);
				break;
		}

		$waterInfo = getimagesize($waterImage);
		$waterWidth = $waterInfo[0];
		$waterHeight = $waterInfo[1];
		switch($sourceInfo[2])
		{
			case IMAGETYPE_GIF:
				$waterImg = imagecreatefromgif($waterImage);
				break;
			case IMAGETYPE_JPEG:
				$waterImg = imagecreatefromjpeg($waterImage);
				break;
			case IMAGETYPE_PNG:
				$waterImg = imagecreatefrompng($waterImage);
				break;
		}
		
		if ($waterWidth > $sourceWidth)
			return false;
		if ($waterHeight > $sourceHeight)
			return false;

		$waterPosX = 0;
		$waterPosY = 0;
		if (is_array($position) > 0)
		{
			$waterPosX = $position[0];
			$waterPosY = $position[1];
		}
		else
		{
			$pos = $this->getPosition($sourceWidth,$sourceHeight,$waterWidth,$waterHeight,$position);
			$waterPosX = $pos[0];
			$waterPosY = $pos[1];
		}

		imagealphablending($sourceImg,true);
		imagecopy($sourceImg,$waterImg,$waterPosX,$waterPosY,0,0,$waterWidth,$waterHeight);
		//echo $waterPosX." ".$waterPosY;

		switch($imageType)
		{
			case IMAGETYPE_GIF:
				imagegif($sourceImg,$destImage);
				break;
			case IMAGETYPE_JPEG:
				imagejpeg($sourceImg,$destImage);
				break;
			case IMAGETYPE_PNG:
				imagepng($sourceImg,$destImage);
				break;
		}

	}

	//加文字水印
	//$destImage					加过水印后的图
	//$sourceImage				加水印前的原图
	//$text							水印文字
	//$size							文字大小
	//$color							文字颜色
	//$position						水印位置
	//0:左上角,1:顶居中,2:右上角,3:左居中,4:正中,5:右居中,6:左下角,7:底居中,8:右下角
	//或是一个数级array(x,y)
	function waterText($destImage,$sourceImage,$text,$position=8,$color="",$size=11,$font="simkai.ttf")
	{
		$sourceInfo = getimagesize($sourceImage);
		$sourceWidth = $sourceInfo[0];
		$sourceHeight = $sourceInfo[1];
		$imageType = $sourceInfo[2];
		switch($sourceInfo[2])
		{
			case IMAGETYPE_GIF:
				$sourceImg = imagecreatefromgif($sourceImage);
				break;
			case IMAGETYPE_JPEG:
				$sourceImg = imagecreatefromjpeg($sourceImage);
				break;
			case IMAGETYPE_PNG:
				$sourceImg = imagecreatefrompng($sourceImage);
				break;
		}

		$waterPosX = 0;
		$waterPosY = 0;
		if (is_array($position))
		{
			$waterPosX = $position[0];
			$waterPosY = $position[1];
		}
		else
		{
			//大小
			$temp = imagettfbbox($size,0,$font,$text);
			$width = $temp[2] - $temp[0];
			$height = $temp[1] - $temp[7];
			$pos = $this->getPosition($sourceWidth,$sourceHeight,$width,$height,$position);
			$waterPosX = $pos[0];
			$waterPosY = $pos[1];
			if ($waterPosY == 0)
				$waterPosY = 15;
		}
		//echo $waterPosX." ".$waterPosY;

		if (strlen($color) != 7)
			return false;

		//颜色
		if ($color == "")
			$color = "#000000";
		$r = substr($color,1,2);
		$g = substr($color,3,2);
		$b = substr($color,5,2);
		$col = imagecolorallocate($sourceImg,$r,$g,$b);
		imagealphablending($sourceImg,true);
		$text = iconv("GB2312","UTF-8",$text);
		imagettftext($sourceImg,$size,0,$waterPosX,$waterPosY,$col,$font,$text);
		//imagestring($sourceImg,$font,$waterPosX,$waterPosY,$text,$col);

		switch($imageType)
		{
			case IMAGETYPE_GIF:
				imagegif($sourceImg,$destImage);
				break;
			case IMAGETYPE_JPEG:
				imagejpeg($sourceImg,$destImage);
				break;
			case IMAGETYPE_PNG:
				imagepng($sourceImg,$destImage);
				break;
		}
	}

	function getPosition($dstW,$dstH,$srcW,$srcH,$position)
	{
		$pos = array();
		switch($position)
		{
			case 0:
				$pos[0] = 0;
				$pos[1] = 0;
				break;
			case 1:
				$pos[0] = intval($dstW/2) - intval($srcW/2);
				$pos[1] = 0;
				break;
			case 2:
				$pos[0] = $dstW - $srcW;
				$pos[1] = 0;
				break;
			case 3:
				$pos[0] = 0;
				$pos[1] = intval($dstH/2) - intval($srcH/2);
				break;
			case 4:
				$pos[0] = intval($dstW/2) - intval($srcW/2);
				$pos[1] = intval($dstH/2) - intval($srcH/2);
				break;
			case 5:
				$pos[0] = $dstW - $srcW;
				$pos[1] = intval($dstH/2) - intval($srcH/2);
				break;
			case 6:
				$pos[0] = 0;
				$pos[1] = $dstH - $srcH;
				break;
			case 7:
				$pos[0] = intval($dstW/2) - intval($srcW/2);
				$pos[1] = $dstH - $srcH;
				break;
			case 8:
				$pos[0] = $dstW - $srcW;
				$pos[1] = $dstH - $srcH;
				break;
		}

		return $pos;
	}
}
?>