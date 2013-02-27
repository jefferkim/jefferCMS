function check()
{
	var proName = $("input[name=called]").val();
	var oldpic = $("input[name=oldpic]").val();

	if (proName == "")
	{
		alert("请填写产品名称");
		return false;
	}
	/*if (oldpic == "")
	{
		alert("请上传产品小图片");
		return false;
	}*/

	var editor = FCKeditorAPI.GetInstance("content");
	var content = editor.GetXHTML(true);
	var editor1 = FCKeditorAPI.GetInstance("memo");
	var memo = editor1.GetXHTML(true);
	var orderby = $("input[name=orderby]").val();

	var language = '';
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

	if (language == '')
	{
		alert('请选择语言');
		return false;
	}

	var customerData = getCustomerData();
	var data = $.param({
		action : $("input[name=action]").val(),
		id : $("input[name=id]").val(),
		called : $("input[name=called]").val(),
		pid : $("select[name=pid]").val(),
		language : language,
		webtitle : $("input[name=webtitle]").val(),
		webkey : $("textarea[name=webkey]").val(),
		webdesc : $("textarea[name=webdesc]").val(),
		isshow : $("input[name=isshow]").val(),
		iscommend : $("input[name=iscommend]").val(),
		orderby : $("input[name=orderby]").val(),
		oldpic : $("input[name=oldpic]").val(),
		memo : memo,
		content : content
	});
	data = data +"&"+ customerData;
	//alert(data);

	AjaxSet("productsave.php",data,function(data)
	{
		alert(data['result']);
		if (data['result']=="修改成功")
		{
			window.close();
		}
		ClearInput();
		$("input[name=oldpic]").val("");
		orderby++;
		$("input[name=orderby]").val(orderby);

	});

	return false;
}

$(function()
{
	$("input[name=language]").change(function()
	{
		ChangeType("typeselectlist.json.php",$.param({language:$(this).val()}),$("select[name=pid]"),false);
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
					$("select[name=pid]").append('<option value="'+ typeList[i].ID +'">'+ typeList[i].CALLED +'('+ typeList[i].LANGUAGE +')</option>');
				}
			});
			return false;
		});
	}

	$("input[name=uploadpic]").upload({
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
			$("input[name=oldpic]").val(data);
			$("#upimg").html('<a href="'+rooturl+'/upload/'+data+'" target="_blank"> <img src="'+rooturl+'/upload/'+data+'" width="100" height="100" style=" width:100px; height:100px; border:solid 1px #CCC"/></a>');
		}
	});

	$("input[type=submit]").click(check);

	$("input[type=reset]").click(function()
	{
		var orderby = $("input[name=orderby]").val();
		ClearInput();
		$("input[name=orderby]").val(orderby);
	});
});

function FCKeditor_OnComplete(editorInstance)
{
	editorInstance.LinkedField.form.onsubmit = check;
}