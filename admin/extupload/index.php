<?php
include_once("../config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>File Upload Field Example</title>
    <link rel="stylesheet" type="text/css" href="css/ext-all.css" />
    <link rel="stylesheet" type="text/css" href="css/examples.css" />
    <link rel="stylesheet" type="text/css" href="css/fileuploadfield.css"/>
    <style type=text/css>
        .upload-icon {
            background: url('images/image_add.png') no-repeat 0 0 !important;
        }
        #fi-button-msg {
            border: 2px solid #ccc;
            padding: 5px 10px;
            background: #eee;
            margin: 5px;
            float: left;
        }
    </style>
    
    <?
    $picRs = $SysConfig['customerdb']->Execute("SELECT PicName FROM t_pic where id='".$_REQUEST['id']."'");
if ($picRs->RecordCount() >0)
{
	$picname = $picRs->fields['PicName'];
}		
	
	?>
     <script>
	var id=<?=$_REQUEST['id']?>;
	var pic_pro_name="<?=$picname?>";
	var links="file-upload.php?id="+id+"&type=pic";
	</script>

    <script type="text/javascript" src="js/ext-base.js"></script>
    <script type="text/javascript" src="js/ext-all.js"></script>
    <script type="text/javascript" src="js/FileUploadField.js"></script>
    <script type="text/javascript" src="js/file-upload.js"></script>

</head>
<body>

        <div id="fi-form"></div>
</body>
</html>
