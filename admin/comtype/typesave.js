$(function()
{
	$("input[type=submit]").click(doSave);

	$("select[name=language]").change(function()
	{
		$("select[name=pid]").empty();
		$("select[name=pid]").append('<option value="0">无父类</option>');

		AjaxGet("typeselectlist.json.php",$.param({language:$(this).val(),currentid:$("input[name=id]").val()}),function(data)
		{
			typeList = data['data'];
			for (i=0; i<typeList.length; i++)
			{
				$("select[name=pid]").append('<option value="'+ typeList[i].ID +'">'+ typeList[i].CALLED +'</option>');
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


	$("input[type=reset]").click(ClearInput);
});

function loadType()
{
	type = new Hashtable();
	$("input[name=language]").each(function()
	{
		AjaxGet("typeselectlist.json.php",$.param({language:$(this).val()}),function(data)
		{
			typeList = data['data'];
			type.add($(this).val(),typeList);
		})
	});
	
	return type;
}

function doSave()
{
	var name = $("input[name=called]").val();

	if (name == "")
	{
		alert("请填写产品分类名称");
		return false;
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
		return false;
	}

	var editor = FCKeditorAPI.GetInstance("memo");
	var memo = editor.GetXHTML(true);

	var customerData = getCustomerData();
	var data = $.param({
		action : $("input[name=action]").val(),
		id : $("input[name=id]").val(),
		called : name,
		pid : $("select[name=pid]").val(),
		language : language,
		orderby : $("input[name=orderby]").val(),
		memo : memo
	});
	data = data +"&"+ customerData;

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

	return false;
}

function FCKeditor_OnComplete(editorInstance)
{
	editorInstance.LinkedField.form.onsubmit = doSave;
}