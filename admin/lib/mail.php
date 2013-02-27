<?php
if (!defined('ROOTDIR'))
	define('ROOTDIR',dirname(__FILE__)."/");

function SendEmail($email,$subject,$content)
{
	if (!class_exists("PHPMailer"))
	{
		include(ROOTDIR."/class.phpmailer.php");
	}

	$mail = new PHPMailer();
	//$mail->debug = true;
	$mail->CharSet      = 'UTF-8';
	$mail->IsSMTP(); // set mailer to use SMTP
	$mail->Host = "smtp.sina.net"; // specify main and backup server
	$mail->SMTPAuth = true; // turn on SMTP authentication
	$mail->Username = "zjb@iecworld.com"; // SMTP username
	$mail->Password = "123456"; // SMTP password

	$mail->From = "zjb@iecworld.com";
	$mail->FromName = "网站";
	$mail->AddAddress($email, "");
	//$mail->AddAddress(""); // name is optional
	//$mail->AddReplyTo("", "");

	//$mail->WordWrap = 50; // set word wrap to 50 characters
	//$mail->AddAttachment("/var/tmp/file.tar.gz"); // add attachments
	//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // optional name
	//$mail->IsHTML(true); // set email format to HTML

	$mail->Subject = $subject;
	$mail->Body = $content;
	//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

	if(!$mail->Send())
	{
	 return false;
	}

	return true;
}

$return = "";
$msg = "";
$return = $_REQUEST['returl'];
$msg = $_REQUEST['msg'];
$mail = $_REQUEST['email'];
$subject = urldecode($_REQUEST['subject']);
$content = urldecode($_REQUEST['content']);

SendEmail($mail,$subject,$content);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>邮件系统</title>
</head>
<script>
<?
if ($msg != "")
{
?>
alert('<?echo $msg?>');
<?
}
if ($return != "")
{
?>
	location.href='<?echo $return;?>';
<?
}
else
{
?>
window.close();	
<?
}
?>
</script>
</html>