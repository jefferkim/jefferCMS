<?php 
include_once("../config.php");
$upload_dir = '../../upload/';
$file_name=$_FILES['photo-path']['name'];
$file=$_FILES['photo-path']['tmp_name'];
$t=date("YmdHis").rand(10,99);
$tmp_type=substr(strrchr($file_name,"."),1);//获取文件扩展名
$tmp_type=strtolower($tmp_type); 

$webfile=$t.".".$tmp_type;

$result = move_uploaded_file($file,$upload_dir.$webfile);

    $id=$_REQUEST['id'];
	$type=$_REQUEST['type'];
    $pname=$_POST['Pname'];
	
if($type=="pic"){
	
	$record = array(
	    'PicName' => $pname,
		'PicUrl' => $webfile
	);

    $SysConfig['customerdb']->AutoExecute("t_pic",$record,"UPDATE","id=".$id);
	
}else if($type=="pro"){
	
	$record = array(
	    'ProName' => $pname,
		'SmallPic' => $webfile
	);

    $SysConfig['customerdb']->AutoExecute("t_products",$record,"UPDATE","id=".$id);
}
	



if(!$result){
  echo '{success:true, file:'.json_encode($file."上传失败").'}';
}
else{
  echo '{success:true, file:'.json_encode("上传成功").'}';
}
?>