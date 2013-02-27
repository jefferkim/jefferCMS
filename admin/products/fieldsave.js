$(function()
{
	$("input[type=submit]").click(function()
	{
		var called = $("input[name=called]").val();
		var fieldName = $("input[name=fieldname]").val();

		if (called == "")
		{
			alert("请填写描述名称！");
			return;
		}
		if (fieldName == "")
		{
			alert("请选择数据库字段名称！");
			return;
		}

		var data = $.param({
			action : 'add',
			called : called,
			fieldname : fieldName,
			datatype : $("select[name=datatype]").val(),
			uitype : $("select[name=uitype]").val(),
			defaultvalue : $("textarea[name=defaultvalue]").val()
		});
		

		AjaxSet("fieldsave.php",data,function(data)
		{
			alert(data['result']);
			ClearInput();
		});
	});

	$("input[type=reset]").click(ClearInput);
})