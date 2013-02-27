function Del_id(id){
	
	AjaxSetConfirm("确定要删除吗？","feedset.php",$.param({action:'del',id:id}),function()
			{
				window.location.href="feed.php?language="+lan;
			});
	
}


$(function()
{

	$("#chk").click(CheckAll);

	$("#btnDelete").click(function()
	{
		var checkedVal = CheckBoxSelect(false);
		if (checkedVal != "")
		{
			AjaxSetConfirm("确定要删除吗？","feedset.php",$.param({action:'del',id:checkedVal}),function()
			{
				window.location.href="feed.php?language="+g_language;
			});
		}
	});
});