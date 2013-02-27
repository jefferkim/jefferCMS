<?php include_once("../../config.php");?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="jquery-1.4.2.min.js"></script>
    <!--上传组件-->
    <link href="uploadify.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="swfobject.js"></script>
    <script type="text/javascript" src="jquery.uploadify.v2.1.4.min.js"></script>
</head>

<body>


        	<div id="custom-demo" class="demo">
            
         
        <script type="text/javascript">
				$(function() {
				$('#custom_file_upload').uploadify({
  'uploader'       : 'uploadify.swf',
  'script'         : 'uploadify.php',
  'cancelImg'      : 'cancel.png',
  'folder'         : '../../upload',
  'multi'          : true,
  'auto'           : true,
  'fileExt'        : '*.jpg;*.gif;*.png',
  'fileDesc'       : 'Image Files (.JPG, .GIF, .PNG)',
  'queueID'        : 'custom-queue',
  'queueSizeLimit' : 3,
  'simUploadLimit' : 3,
  'removeCompleted': false,
  'onSelectOnce'   : function(event,data) {
      $('#status-message').text(data.filesSelected + ' files have been added to the queue.');
    },
  'onAllComplete'  : function(event,data) {
      $('#status-message').text(data.filesUploaded + ' files uploaded, ' + data.errors + ' errors.');
    }
});				});
				</script>








        <div class="demo-box">
        
        
<div id="custom-queue"></div>


<input id="custom_file_upload" type="file" name="Filedata" />        </div>
      </div>



</body>
</html>