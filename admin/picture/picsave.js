function ChangePicType(lan)
{
	ChangeType("typelist.json.php",$.param({language:lan}),$("select[name=type]"),false);
}

$(function()
{
	$("input[name=language]").change(function()
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
			AjaxGet("typelist.json.php",$.param({language:lan}),function(data)
			{
				typeList = data['data'];
				for (i=0; i<typeList.length; i++)
				{
					$("select[name=type]").append('<option value="'+ typeList[i].ID +'">'+ typeList[i].CALLED +'('+ typeList[i].LANGUAGE +')</option>');
				}
			});
			return false; 
		});
	}

	$("input[name=uploadspic]").upload({
		name:'Filedata',
		method:'post',
		enctype:'multipart/form-data',
		action:uploadurl,
		onSubmit:function()
		{
			$("#message1").show();
			$("#progressbars1").html("正在上传图片");
		},
		onComplete:function(data)
		{
			$("#progressbars1").html("上传成功");
			$("input[name=spic]").val(data);
			var img1=rooturl+'/upload/'+data;
			$("#upimg1>img").attr({'src':img1});
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
			var img=rooturl+'/upload/'+data;
			$("#upimg>img").attr({'src':img});
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
			type : $("select[name=type]").val(),
			language : language,
			isshow : $("input[name=isshow]").val(),
			spic : spic,
			bpic : bpic
		});
		data = data +"&"+ customerData;
		//alert(data);

		AjaxSet("picturesave.php",data,function(data)
		{
			alert(data['result']);
			if (data['result']=="修改成功")
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