$(function()
{
	$("input[type=submit]").click(doSave);

	$("input[type=reset]").click(function()
	{
		ClearInput();
	});
});

function doSave()
{
	var webname = $("input[name=webname]").val();
	if (webname == "")
	{
		alert("请填写站点名称");
		return false;
	}

	var data = $.param({
		action : $("input[name=action]").val(),
		id : $("input[name=id]").val(),
		webname : webname,
		title : $("input[name=title]").val(),
		web : $("input[name=web]").val(),
		upload : $("input[name=upload]").val(),
		beian : $("input[name=beian]").val(),
		keywords : $("textarea[name=keywords]").val(),
		description : $("textarea[name=description]").val(),
		lan : $("input[name=lan]").val()
	});

	AjaxSet("save.php",data,function(data)
	{
		alert(data['result']);
		ClearInput();
		if (data['result'] == "修改成功")
		{
			window.close();
		}
	});

	return false;
}
