<div id="footer">
<div class="foot">
<?
$where = "WHERE Language='cn' AND Called='"."底部版权"."'";
$contentRs = $maindb->Execute("SELECT * FROM t_content ".$where);
if ($contentRs->RecordCount() > 0)
{
	$contentObj = $contentRs->FetchObject();
	echo $contentObj->CONTENT;
}?>

</div>
</div>