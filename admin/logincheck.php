<?
if (!isset($_SESSION['SWEBADMIN_USERID']) || $_SESSION['SWEBADMIN_USERID'] == '')
{
	$uri = $_SERVER['REQUEST_URI'];
	$uriArray = explode("/",$uri);
	$len = count($uriArray);
	$newUri = "";
	for ($i=0;$i<$len-1;$i++)
	{
		if ($i == 0)
			$newUri .= $uriArray[$i];
		else
			$newUri .= "/".$uriArray[$i];
	}
	echo '<script>window.parent.location.href="'.$newUri.'/login.php";</script>';
	exit();
}
?>