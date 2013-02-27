function ChangeDownType(lan)
{
	ChangeType("typelist.json.php",$.param({language:lan}),$("select[name=type]"),false);
}

$(function()
{
	$("input[name=language]").change(function()
	{

		ChangeDownType($(this).val());
		
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
	
	
	
	$("input[name=uploadfile]").upload({
		name:'Filedata',
		method:'post',
		enctype:'multipart/form-data',
		action:uploadurl,
		onSubmit:function()
		{
			$("#message").show();
			$("#progressbars").html("正在上传");
		},
		onComplete:function(data)
		{
			$("#progressbars").html("上传成功");
			$("input[name=fileurl]").val(data);
		}
	});

	$("input[type=submit]").click(function()
	{
		var called = $("input[name=called]").val();
		var file = $("input[name=fileurl]").val();

		if (called == "")
		{
			alert("请填写名称");
			return;
		}
		if (file == "")
		{
			alert("请选择上传文件");
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
			fileurl : file,
			memo : $("textarea[name=memo]").val()
		});
		data = data +"&"+ customerData;
		//alert(data);
		
		AjaxSet("downloadsave.php",data,function(data)
		{
			alert(data['result']);
			if (data['result']=="修改成功")
			{
				window.close();
			}

			ClearInput();
			$("input[name=fileurl]").val("");
		});
	});

	$("input[type=reset]").click(ClearInput);
});