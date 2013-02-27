<?php 
/************************************
函数： watermark($bigimg, $smallimg, $coord = 1)
作用： 添加水印
参数： $bigimg     必选。大图片--要加上水印的图片
       $smallimg   必选。小图片
        $coord      可选。水印在大图中的位置，
                1 左上角； 2 右上角； 3 右下角； 4 左下角； 5 中间
示例： watermark('datu.png', 'xiaotu.png', 3);
       //给datu.png打上水印，水印位置在右下角
*************************************/

function watermark($bigimg, $smallimg, $coord = 1){
//载入两张图片，并转成php识别的编码格式，
//等同于 imagecreate 函数，只不过这里创建的不是一个空图片。
$bi = getimagesize($bigimg);
switch($bi[2]){                     
   case 1:
   $im1 = imagecreatefromgif($bigimg);break;
   case 2;
   $im1 = imagecreatefromjpeg($bigimg);break;
   case 3;
   $im1 = imagecreatefrompng($bigimg);break;
}
$si = getimagesize($smallimg);
switch($si[2]){                     
   case 1:
   $im2 = imagecreatefromgif($smallimg);break;
   case 2;
   $im2 = imagecreatefromjpeg($smallimg);break;
   case 3;
   $im2 = imagecreatefrompng($smallimg);break;
}
// 创建水印--原理：复制小图到大图上。这里注意坐标值的计算
switch($coord){
   case 1:
   imagecopy ( $im1, $im2, 0, 0, 0, 0, $si[0], $si[1] ); break;
   case 2:
   imagecopy ( $im1, $im2, $bi[0]-$si[0], 0, 0, 0, $si[0], $si[1] ); break;
   case 3:
   imagecopy ( $im1, $im2, $bi[0]-$si[0], $bi[1]-$si[1], 0, 0, $si[0], $si[1] ); break;
   case 4:
   imagecopy ( $im1, $im2, 0, $bi[1]-$si[1], 0, 0, $si[0], $si[1] ); break;
   case 5:
   imagecopy ( $im1, $im2, ($bi[0]-$si[0])/2, ($bi[1]-$si[1])/2, 0, 0, $si[0], $si[1] ); break;
}
//根据后缀名生成不同格式的图片文件
switch($bi[2]){                     
   case 1:
   imagegif($im1);break;
   case 2;
   imagejpeg($im1);break;
   case 3;
   imagepng($im1);break;
}       
imagedestroy($im1);
}


/************************************************
//函数： thumbnail($srcimg, $multiple)
//作用： 生成一张缩略图
//参数：
// $srcimg     必选。源图片文件名
// $multiple   可选。缩略倍数，默认为2倍，即缩小为原来的1/2
//注意： 只支持gif、jpg、png的格式图片。
//示例： thumbnail('我的图片.jpg', 5);
*************************************************/

function thumbnail($srcimg, $multiple = 2){
//载入图片并保存其信息到数组
$srcimg_arr = getimagesize($srcimg);
//计算缩略倍数
$thumb_width = $srcimg_arr[0] / $multiple;
$thumb_height = $srcimg_arr[1] / $multiple;
//判断：要建立什么格式的图片（转成php识别的编码）
switch($srcimg_arr[2]){                     
   case 1:
   $im = imagecreatefromgif($srcimg);break;
   case 2;
   $im = imagecreatefromjpeg($srcimg);break;
   case 3;
   $im = imagecreatefrompng($srcimg);break;
}
//开始缩略操作
$thumb = imagecreatetruecolor($thumb_width, $thumb_height);
imagecopyresized($thumb, $im, 0, 0, 0 ,0, $thumb_width, $thumb_height, $srcimg_arr[0], $srcimg_arr[1]);
switch($srcimg_arr[2]){                     
   case 1:
   imagegif($thumb); break;
   case 2;
   imagejpeg($thumb); break;
   case 3;
   imagepng($thumb); break;
}
imagepng($thumb);    
imagedestroy($thumb);
}

//测试时不要同时使用这两个函数。
//watermark('cmz.png','bdtp.png',5);
thumbnail('cmz.png',3);

?>