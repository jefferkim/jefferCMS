function Del_id(id,lan){
	
	AjaxSetConfirm("确定要删除吗？","guestset.php",$.param({action:'del',id:id}),function()
			{
				window.location.href="main.php?language="+lan;
			});
	
}

function show(id,lan){
	
	AjaxSetConfirm("确定要设置为显示吗？","guestset.php",$.param({action:'show',id:id}),function(data)
			{
				window.location.href="main.php?language="+lan;
			});
}

function hide(id,lan){
	
	AjaxSetConfirm("确定要设置为隐藏吗？","guestset.php",$.param({action:'hide',id:id}),function(data)
			{
				window.location.href="main.php?language="+lan;
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
			AjaxSetConfirm("确定要删除吗？","guestset.php",$.param({action:'del',id:checkedVal}),function()
			{
				window.location.href="main.php?language="+g_language;
			});
		}
	});

});