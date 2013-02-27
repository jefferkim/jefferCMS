<?
session_start();

$_SESSION['SWEBADMIN_USERID'] = '';
$_SESSION['SWEBADMIN_USERNAME'] = '';
$_SESSION['SWEBADMIN_USERREALNAME'] = '';
$_SESSION['SWEBADMIN_USERROLE'] = '';
$_SESSION['SWEBADMIN_DBNAME'] = '';
$_SESSION['PHPUPLOADDIR'] = "/websys/upload/";

session_destroy();
//session_unregister("SWEBADMIN_USERID");
//session_unregister("SWEBADMIN_USERNAME");
//session_unregister("SWEBADMIN_USERREALNAME");
//session_unregister("SWEBADMIN_USERROLE");
//session_unregister("SWEBADMIN_DBNAME");
?>
<meta http-equiv='refresh' content='0;url=login.php'>
