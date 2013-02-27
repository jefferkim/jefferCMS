$(function()
{
	$("input[type=submit]").click(function()
	{
		var name = $("input[name=called]").val();

		if (name == "")
		{
			alert("请填写产品分类名称");
			return;
		}
		
		var orderBy = $("input[name=orderby]").val();
		var language = '';
		if (editMode)
		{
			language = $("select[name=language]").val();
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

		if (language == "")
		{
			alert("请选择语言");
			return;
		}

		var data = $.param({
			action : $("input[name=action]").val(),
			id : $("input[name=id]").val(),
			called : name,
			pid : $("select[name=pid]").val(),
			language : language,
			isshow : $("select[name=isshow]").val(),
			orderby : $("input[name=orderby]").val(),
			memo : $("textarea[name=memo]").val()
		});

		AjaxSet("typesave.php",data,function(data)
		{
			alert(data['result']);
			ClearInput();
			orderBy++;
			$("input[name=orderby]").val(orderBy);
			if (data['result'] == "修改成功")
			{
				window.close();
			}
		});
	});

	if (!editMode)
	{
		$("input[name=language]").each(function()
		{
			var lan = $(this).val();
			var lancn;
			AjaxGet("../getlanguage.php",$.param({lan:lan}),function(data)
			{
				lancn = data['result'];
			});
			AjaxGet("typeselectlist.json.php",$.param({language:lan}),function(data)
			{
				typeList = data['data'];
				for (i=0; i<typeList.length; i++)
				{
					$("select[name=pid]").append('<option value="'+ typeList[i].ID +'">'+ typeList[i].CALLED +'('+ lancn +')</option>');
				}
			});
		});
		
	}

	$("select[name=language]").change(function()
	{
		ChangeType("typeselectlist.json.php",$.param({language:$(this).val(),currentid:$("input[name=id]").val()}),$("select[name=pid]"),true);
	});

	$("input[type=reset]").click(ClearInput);
})