$(function()
{
	$("input[type=submit]").click(function()
	{
		var called = $("input[name=called]").val();

		if (called == "")
		{
			alert("请填写分类名称");
			return;
		}
		var language = "";
		if (editMode)
		{
			language = $("input[name=language]").val();
		}
		else
		{
			$("input[name=language]").each(function()
			{
				if ($(this).attr("checked"))
				{
					if (language == '')
					{
						language = $(this).val();
					}
					else
					{
						language += ',' + $(this).val();
					}
				}
			});
		}

		//alert(language);

		var customerData = getCustomerData();
		var data = $.param({
			action : $("input[name=action]").val(),
			typeid : $("input[name=typeid]").val(),
			called : called,
			language : language
		});
		data = data +"&"+ customerData;

		AjaxSet("typesave.php",data,function(data)
		{
			alert(data['result']);
			ClearInput();
			if (data['result'] == "修改成功")
			{
				history.go(-1);
			}
		});
	});

	$("input[type=reset]").click(ClearInput);
})