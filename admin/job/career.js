$(function()
{

	$("#chk").click(CheckAll);
	$("#btnDelete").click(function()
	{
		var checkedVal = CheckBoxSelect(false);
		if (checkedVal != "")
		{
			AjaxSetConfirm("确定要删除吗？","careerset.php",$.param({action:'del',id:checkedVal}),function()
			{
				window.location.href="career.php?language="+g_language;
			});
		}
	});
});

function Del_id(id,lan){
	
	AjaxSetConfirm("确定要删除吗？","careerset.php",$.param({action:'del',id:id}),function()
			{
				window.location.href="career.php?language="+lan;
			});
	
}
