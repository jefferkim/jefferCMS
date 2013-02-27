<?php include_once("../../config.php")?>

<?php


if (!empty($_FILES)) {
	$files =time().'_';
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	$filename =new_name( $_FILES['Filedata']['name']);
	$targetFile =  str_replace('//','/',$targetPath) . $filename;
	
	move_uploaded_file($tempFile,iconv('utf-8','gbk', $targetFile));

$proid=$_REQUEST['pid'];

	$record = array(
		'PicUrl' => $filename,
		'ProID' => $proid,
		'NoteTime' => date("Y-m-d H:i:s"),
		'Language' => 'cn'
	);
	$maindb->AutoExecute("t_img",$record,"INSERT");
}

 function new_name($filename){
	$ext = pathinfo($filename);
	$ext = $ext['extension'];
	if ($ext=='jpg'||$ext=='gif'||$ext=='png') 
	{
	$name = basename($filename,$ext); 
	$name = md5($name.time()).'.'.$ext;
	return $name;
	}
	else
	{
	return;
	}
 }


?>