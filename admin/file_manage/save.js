$(function()
{
	$("form").submit(function()
	{
		alert("form submit");
		return false;
	});

	$("input[type=submit]").click(doSave);

	$("input[type=reset]").click(function()
	{
		ClearInput();
	});
});

function doSave()
{
	var title = $("input[name=title]").val();
	if (title == "")
	{
		alert("请填写网站标题");
		return false;
	}

	var customerData = getCustomerData();
	var data = $.param({
		action : $("input[name=action]").val(),
		id : $("input[name=id]").val(),
		title : title,
		lan : $("input[name=lan]").val(),
		keywords : $("textarea[name=keywords]").val(),
		description : $("textarea[name=description]").val(),
		url : $("input[name=url]").val()
	});
    data = data +"&"+ customerData;
	AjaxSet("save.php",data,function(data)
	{
		alert(data['result']);
		ClearInput();
		editor.SetData('');
		if (data['result'] == "修改成功")
		{
			window.close();
		}
	});

	return false;
}
