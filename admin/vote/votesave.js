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
	var subject = $("input[name=subject]").val();
	if (subject == "")
	{
		alert("请填写内容名称");
		return false;
	}
	
	var customerData = getCustomerData();
	var data = $.param({
		action : $("input[name=action]").val(),
		id : $("input[name=id]").val(),
		subject : subject,
		lan : $("input[name=lan]").val()
	});
    data = data +"&"+ customerData;
	AjaxSet("votesave.php",data,function(data)
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
