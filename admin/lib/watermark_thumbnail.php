<?php 
/************************************
������ watermark($bigimg, $smallimg, $coord = 1)
���ã� ���ˮӡ
������ $bigimg     ��ѡ����ͼƬ--Ҫ����ˮӡ��ͼƬ
       $smallimg   ��ѡ��СͼƬ
        $coord      ��ѡ��ˮӡ�ڴ�ͼ�е�λ�ã�
                1 ���Ͻǣ� 2 ���Ͻǣ� 3 ���½ǣ� 4 ���½ǣ� 5 �м�
ʾ���� watermark('datu.png', 'xiaotu.png', 3);
       //��datu.png����ˮӡ��ˮӡλ�������½�
*************************************/

function watermark($bigimg, $smallimg, $coord = 1){
//��������ͼƬ����ת��phpʶ��ı����ʽ��
//��ͬ�� imagecreate ������ֻ�������ﴴ���Ĳ���һ����ͼƬ��
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
// ����ˮӡ--ԭ������Сͼ����ͼ�ϡ�����ע������ֵ�ļ���
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
//���ݺ�׺�����ɲ�ͬ��ʽ��ͼƬ�ļ�
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
//������ thumbnail($srcimg, $multiple)
//���ã� ����һ������ͼ
//������
// $srcimg     ��ѡ��ԴͼƬ�ļ���
// $multiple   ��ѡ�����Ա�����Ĭ��Ϊ2��������СΪԭ����1/2
//ע�⣺ ֻ֧��gif��jpg��png�ĸ�ʽͼƬ��
//ʾ���� thumbnail('�ҵ�ͼƬ.jpg', 5);
*************************************************/

function thumbnail($srcimg, $multiple = 2){
//����ͼƬ����������Ϣ������
$srcimg_arr = getimagesize($srcimg);
//�������Ա���
$thumb_width = $srcimg_arr[0] / $multiple;
$thumb_height = $srcimg_arr[1] / $multiple;
//�жϣ�Ҫ����ʲô��ʽ��ͼƬ��ת��phpʶ��ı��룩
switch($srcimg_arr[2]){                     
   case 1:
   $im = imagecreatefromgif($srcimg);break;
   case 2;
   $im = imagecreatefromjpeg($srcimg);break;
   case 3;
   $im = imagecreatefrompng($srcimg);break;
}
//��ʼ���Բ���
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

//����ʱ��Ҫͬʱʹ��������������
//watermark('cmz.png','bdtp.png',5);
thumbnail('cmz.png',3);

?>