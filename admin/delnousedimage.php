<?php
include_once("config.php");
LoginCheck($SysConfig['rooturl']."/login.php",true);

$file = $_GET['file'];

unlink(ROOTDIR.$_SESSION['SWEBADMIN_USERNAME']."/upload/".$file);
?>
<script>
window.location.href='nousedimage.php';
</script>