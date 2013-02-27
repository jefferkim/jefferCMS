function ChangeNewsType(lan)
{
	ChangeType("typelist.json.php",$.param({language:lan}),$("select[name=type]"),false);
	
}

$(function()
{
	
	
	$("input[name=showtime]").datepicker();

	$("input[name=language]").change(function()
	{
		ChangeNewsType($(this).val());
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
			$("input[name=smallpic]").val(data);
			$("#upimg").html('<a href="'+rooturl+'/upload/'+data+'" target="_blank"> <img src="'+rooturl+'/upload/'+data+'" width="100" height="100" style=" width:100px; height:100px; border:solid 1px #CCC"/></a>');
		}
	});

	$("input[type=submit]").click(doSave);

	$("input[type=reset]").click(function()
	{
		ClearInput();
		var editor = FCKeditorAPI.GetInstance("content");
	});
});

function doSave()
{
	var title = $("input[name=title]").val();
	var type = $("select[name=type]").val();

	if (title == "")
	{
		alert("请填写新闻标题");
		return false;
	}
	if (type == "")
	{
		alert("请选择分类");
		return false;
	}

	var editor = FCKeditorAPI.GetInstance("content");
	var content = editor.GetXHTML(true);

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

	if (language == "")
	{
		alert("请选择语言!");
		return false;
	}

	var customerData = getCustomerData();
	var data = $.param({
		action : $("input[name=action]").val(),
		newsid : $("input[name=newsid]").val(),
		title : title,
		parent : $("input[name=parent]").val(),
		language : language,
		type : type,
		webtitle : $("input[name=webtitle]").val(),
		showtime : $("input[name=showtime]").val(),
		webkey : $("textarea[name=webkey]").val(),
		webdesc : $("textarea[name=webdesc]").val(),
		smallpic : $("input[name=smallpic]").val(),
		isshow : $("input[name=isshow]").val(),
		iscommend : $("input[name=iscommend]").val(),
		username : $("input[name=username]").val(),
		orderby : $("input[name=orderby]").val(),
		content : content
	});
	data = data +"&"+ customerData;

	AjaxSet("newssave.php",data,function(data)
	{
		alert(data['result']);
		if (data['result']=="修改成功")
		{
			window.close();
		}

		var orderBy = parseInt($("input[name=orderby]").val()) + 1;
		var showtime = $("input[name=showtime]").val()
		ClearInput();
		$("input[name=smallpic]").val("");
		$("input[name=orderby]").val(orderBy);
		$("input[name=showtime]").val(showtime);
	});

	return false;
}

function FCKeditor_OnComplete(editorInstance)
{
	editorInstance.LinkedField.form.onsubmit = doSave;
}