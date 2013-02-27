function ChangePicType(lan)
{
	ChangeType("typelist.json.php",$.param({language:lan}),false);
}

$(function()
{
	$("select[name=language]").change(function()
	{
		ChangePicType($(this).val());
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
		});
	}

	$("input[name=uploadspic]").upload({
		name:'Filedata',
		method:'post',
		enctype:'multipart/form-data',
		action:uploadurl,
		onSubmit:function()
		{
			$("#message").show();
			$("#progressbars").html("正在上传图片");
		},
		onComplete:function(data)
		{
			$("#progressbars").html("上传成功");
			$("input[name=spic]").val(data);
			
		}
	});

	$("input[name=uploadbpic]").upload({
		name:'Filedata',
		method:'post',
		enctype:'multipart/form-data',
		action:uploadurl,
		onSubmit:function()
		{
			$("#message").show();
			$("#progressbars").html("正在上传图片");
		},
		onComplete:function(data)
		{
			$("#progressbars").html("上传成功");
			$("input[name=bpic]").val(data);
			
		}
	});

	$("input[type=submit]").click(function()
	{
		var called = $("input[name=called]").val();
		var spic = $("input[name=spic]").val();
		var bpic = $("input[name=bpic]").val();

		if (called == "")
		{
			alert("请填写名称");
			return;
		}
		if (spic == "")
		{
			alert("请选择小图片");
			return;
		}

		var language = "";
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

		var customerData = getCustomerData();
		var data = $.param({
			action : $("input[name=action]").val(),
			id : $("input[name=id]").val(),
			called : called,
			proid : $("input[name=proid]").val(),
			language : language,
			isshow : $("select[name=isshow]").val(),
			spic : spic,
			bpic : bpic
		});
		data = data +"&"+ customerData;
		//alert(data);

		AjaxSet("picturesave.php",data,function(data)
		{
			alert(data['result']);
			if (data['result']=="修改成功" || data['result']=="添加成功")
			{
				window.close();
			}

			ClearInput();
			$("input[name=spic]").val("");
			$("input[name=bpic]").val("");
		});
	});

	$("input[type=reset]").click(ClearInput);
});