<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?
include_once("../config.php");

$sort=12;
$f_type=strtolower("swf,jpg,rar,zip,7z,iso,gif");//设置可上传的文件类型 
$file_size_max=200*1024*1024;//限制单个文件上传最大容量 
$overwrite = 0;//是否允许覆盖相同文件,1:允许,0:不允许 
$f_input="Files";//设置上传域名称
    foreach($_FILES[$f_input]["error"] as $key => $error){ 
        $up_error="no"; 
        if ($error == UPLOAD_ERR_OK){ 
            $f_name=$_FILES[$f_input]['name'][$key];//获取上传源文件名 
			
            $uploadfile=$uploaddir.strtolower(basename($f_name)); 
             
            $tmp_type=substr(strrchr($f_name,"."),1);//获取文件扩展名
			$tmp_type=strtolower($tmp_type); 
            if(!stristr($f_type,$tmp_type)){ 
                echo "<script>alert('对不起,不能上传".$tmp_type."格式文件, ".$f_name." 文件上传失败!')</script>"; 
                $up_error="yes"; 
            } 
             
            if ($_FILES[$f_input]['size'][$key]>$file_size_max) { 
			
                echo "<script>alert('对不起,你上传的文件 ".$f_name." 容量为".round($_FILES[$f_input]
['size'][$key]/1024)."Kb,大于规定的".($file_size_max/1024)."Kb,上传失败!')</script>"; 
                $up_error="yes"; 
            } 
             
            if (file_exists($uploadfile)&&!$overwrite){ 
                echo "<script>alert('对不起,文件 ".$f_name." 已经存在,上传失败!')</script>"; 
                $up_error="yes"; 
            } 
             $string = 'abcdefghijklmnopgrstuvwxyz0123456789';
$rand = '';
for ($x=0;$x<12;$x++)
$t=date("YmdHis").rand(10,99);

$attdir="../../upload/";  
    if(!is_dir($attdir))   
    {  mkdir($attdir);}
	
	
            $uploadfile=$attdir.$t.".".$tmp_type; 
			$filename=$t.".".$tmp_type;
			$called=$_POST['called'];
			$language=$_POST['language'];
			$type=$_POST['type'];
			
$pictypeRs = $SysConfig['customerdb']->Execute("SELECT Called FROM t_pictype where id='".$type."'");
if ($pictypeRs->RecordCount() >0)
{
	$typename = $pictypeRs->fields['Called'];
}		 
			
$picRs = $SysConfig['customerdb']->Execute("SELECT OrderBy,id FROM t_pic ORDER BY OrderBy DESC LIMIT 0,1");
$count=count($picRs);
if ($picRs->RecordCount() >0)
{
	$orderBy = $picRs->fields['OrderBy'] + 1;
	$picid=$picRs->fields['id'] + 1;
}else{
	$orderBy=1;
	$picid=1;
}

		$record = array(
		'id' => $picid,
	    'PicName' => $typename,
		'PicUrl' => $filename,
		'BigUrl' => $filename,
		'TypeID' => $type,
		'IsShow' => '1',
		'IsCommend' => '0',
		'OrderBy' => $orderBy,
		'NoteTime' => date("Y-m-d H:i:s"),
		'Language' => $language
	);
	$SysConfig['customerdb']->AutoExecute("t_pic",$record,"INSERT");

			
            if(($up_error!="yes") and (move_uploaded_file($_FILES[$f_input]['tmp_name']

[$key], $uploadfile))){ 

                 
				 
				$_msg=$_msg.$f_name.'上传成功\n';
				
				
            } 
			else{
			$_msg=$_msg.$f_name.'上传失败\n';
			}
        } 
	
    } 
echo "<script>window.parent.Finish('".$_msg."');</script>";	
?>
</body>
</html>
