$(function()
{
	$("input[type=submit]").click(function()
	{
		var called = $("input[name=called]").val();
		if (called == "")
		{
			alert('分类名称不能为空');
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

		var customerData = getCustomerData();
		var data = $.param({
			action : $("input[name=action]").val(),
			id : $("input[name=id]").val(),
			called : $("input[name=called]").val(),
			language : language,
			memo : $("textarea[name=memo]").val()
		});
		data = data +"&"+ customerData;

		AjaxSet("typesave.php",data,function(data)
		{
			alert(data['result']);
			if (data['result'] == "修改成功")
			{
				window.close();
			}
			ClearInput();
		});
	});

	$("input[type=reset]").click(ClearInput);
})