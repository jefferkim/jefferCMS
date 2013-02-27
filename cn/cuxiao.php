<?include_once("../config.php")?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="cs/base.css">
<link rel="stylesheet" type="text/css" href="cs/layout.css">
<link rel="stylesheet" type="text/css" href="cs/typography.css">

</head>

<body>

<div id="main">

<? require_once('header.php');?>


<div id="center">


<div class="ny_cont">
  <div class="cx_title"><img src="images/cx_title.jpg" width="948" height="104" /></div>
 
   <div class="cx_cont">
   
	   <?
    $where = "WHERE Language='cn' AND Called='"."促销活动"."'";
    $contentRs = $maindb->Execute("SELECT * FROM t_content ".$where);
    if ($contentRs->RecordCount() > 0)
    {
        $contentObj = $contentRs->FetchObject();
        echo $contentObj->CONTENT;
    }?>

   
   
   </div>

</div>



</div>





</div>

<? require_once('footer.php');?>

</body>
</html>
<?include_once("bottom.php")?>