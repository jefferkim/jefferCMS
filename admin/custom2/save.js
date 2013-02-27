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
		var editor = FCKeditorAPI.GetInstance("content");
		editor.SetData(true);
	});
});

function doSave()
{
	var called = $("input[name=called]").val();
	if (called == "")
	{
		alert("请填写名称");
		return false;
	}

	var editor = FCKeditorAPI.GetInstance("content");
	var content = editor.GetXHTML(true);
	
	var customerData = getCustomerData();
	var data = $.param({
		action : $("input[name=action]").val(),
		id : $("input[name=id]").val(),
		called : called,
		lan : $("input[name=lan]").val(),
		content : content
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

function FCKeditor_OnComplete(editorInstance)
{
	editorInstance.LinkedField.form.onsubmit = doSave;
}