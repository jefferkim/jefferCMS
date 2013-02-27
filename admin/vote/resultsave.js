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
	var result = $("input[name=result]").val();
	if (result == "")
	{
		alert("请填写内容名称");
		return false;
	}
	
	var customerData = getCustomerData();
	var data = $.param({
		action : $("input[name=action]").val(),
		id : $("input[name=id]").val(),
		result : result,
		vote : $("input[name=vote]").val(),
		lan : $("input[name=lan]").val()
	});
    data = data +"&"+ customerData;
	AjaxSet("resultsave.php",data,function(data)
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
