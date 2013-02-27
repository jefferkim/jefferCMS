function check()
{
	var proName = $("input[name=called]").val();

	if (proName == "")
	{
		alert("请填写产品名称");
		return;
	}


	var orderby = $("input[name=orderby]").val();

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

	if (language == '')
	{
		alert('请选择语言');
		return;
	}

	var customerData = getCustomerData();
	var data = $.param({
		action : $("input[name=action]").val(),
		id : $("input[name=id]").val(),
		called : $("input[name=called]").val(),
		pid : $("select[name=pid]").val(),
		language : language,
		isshow : $("select[name=isshow]").val(),
		iscommend : $("select[name=iscommend]").val(),
		orderby : $("input[name=orderby]").val(),
		memo : $("textarea[name=memo]").val()
	});

	if (customerData != "")
	{
		data = data +"&"+ customerData;
	}
	//alert(data);

	color = colorName.join(",");
	img = colorImg.join(",");

	var sPicArr = Array();
	var mPicArr = Array();
	var bPicArr = Array();
	for (i=0; i<colorSPic.length; i++)
	{
		sPicArr.push(colorSPic[i].join("|"));
		mPicArr.push(colorMPic[i].join("|"));
		bPicArr.push(colorBPic[i].join("|"));
	}

	spic = sPicArr.join(",");
	mpic = mPicArr.join(",");
	bpic = bPicArr.join(",");

	var d = $.param({color:color,img:img,spic:spic,mpic:mpic,bpic:bpic});
	if (d != "")
	{
		data = data + "&" + d;
	}


	AjaxSet("productsave.php",data,function(data)
	{
		alert(data['result']);
		if (data['result']=="修改成功")
		{
			window.close();
		}
		ClearInput();
		$("#tbColorList").empty().append('<tr><td width="80">名称</td><td width="80">图片</td><td width="80">图片组数</td><td></td></tr>');
		colorName.length = 0
		colorImg.length = 0;
		colorSPic.length = 0;
		colorMPic.length = 0;
		colorBPic.length = 0;
		orderby++;
		$("input[name=orderby]").val(orderby);

	});
}

function ClearColor()
{
	$("input[name=colorname]").val('');
	$("input[name=txtColor]").val('');
}

function ClearPicture()
{
	$("input[name=txtSmallPic]").val('');
	$("input[name=txtMiddlePic]").val('');
	$("input[name=txtBigPic]").val('');
}

function initColors()
{
	for (i=0; i<colorName.length; i++)
	{
		var row = $('<tr rel=""><td rel="name" width="80"></td><td rel="pic" width="80"></td><td rel="nums" width="80"></td><td rel="btn"></td></tr>');

		row.attr("rel",i+1);
		row.find("td[rel=name]").html(colorName[i]);
		row.find("td[rel=pic]").html('<img src="'+ rooturl + uploadUser +'/upload/'+ colorImg[i] +'" width="20" height="20">');
		row.find("td[rel=nums]").html(colorSPic[i].length);
		row.find("td[rel=btn]").html('<input type="button" value="添加颜色图片组" name="add"><input type="button" value="删除颜色" name="remove">');

		row.find("td[rel=btn]").find("input[name=add]").click(function()
		{
			$("#winPictureWindow").find("input[name=colorpos]").val(row.attr("rel"));
			$("#winPictureWindow").show();
		});
		row.find("td[rel=btn]").find("input[name=remove]").click(function()
		{
			pos = row.attr("rel")-1
			colorName[pos] = "";
			colorImg[pos] = "";
			colorSPic[pos].length = 0;
			colorMPic[pos].length = 0;
			colorBPic[pos].length = 0;
			$(this).parent().parent().remove();
		});

		$("#tbColorList").append(row);
	}
}

$(function()
{
	//upload def
	var upname = "";
	var swfu;
	swfSetting.upload_url = uploadurl;
	swfSetting.post_params = {user:uploadUser};
	swfSetting.upload_success_handler = uploadSuccess;

	swfu = new SWFUpload(swfSetting);

	function uploadSuccess(file, serverData)
	{
		switch(upname)
		{
			case "btnChooseColor":
				$("input[name=txtColor]").val(serverData);
				break;
			case "btnChooseSmallPic":
				$("input[name=txtSmallPic]").val(serverData);
				break;
			case "btnChooseMiddlePic":
				$("input[name=txtMiddlePic]").val(serverData);
				break;
			case "btnChooseBigPic":
				$("input[name=txtBigPic]").val(serverData);
				break;
		}
	}

	initColors();

	$("select[name=language]").change(function()
	{
		ChangeType("typeselectlist.json.php",$.param({language:$(this).val(),currentid:$("input[name=id]").val()}),$("select[name=pid]"),true);
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
		});

	}

	$("input[type=submit]").click(function()
	{
		check();
	});

	$("input[type=reset]").click(function()
	{
		var orderby = $("input[name=orderby]").val();
		ClearInput();
		$("input[name=orderby]").val(orderby);
	});


	//color

	$("#btnColorAdd").click(function()
	{
		$("#winColorWindow").show();
	});

	$("#btnChooseColor").click(function()
	{
		upname = "btnChooseColor";
		swfu.selectFiles();
	});

	$("#btnColorOk").click(function()
	{
		if ($("input[name=colorname]").val() == "")
		{
			alert("请填写颜色名称");
			return;
		}
		if ($("input[name=txtColor]").val() == "")
		{
			alert("请上传颜色图片");
			return;
		}
		colorName.push($("input[name=colorname]").val());
		colorImg.push($("input[name=txtColor]").val());

		colorSPic.push(Array());
		colorMPic.push(Array());
		colorBPic.push(Array());

		var row = $('<tr rel=""><td rel="name" width="80"></td><td rel="pic" width="80"></td><td rel="nums" width="80"></td><td rel="btn"></td></tr>');

		row.attr("rel",colorName.length);
		row.find("td[rel=name]").html($("input[name=colorname]").val());
		row.find("td[rel=pic]").html('<img src="'+ rooturl + uploadUser + '/upload/'+ $("input[name=txtColor]").val() +'" width="20" height="20">');
		row.find("td[rel=nums]").html("0");
		row.find("td[rel=btn]").html('<input type="button" value="添加颜色图片组" name="add"><input type="button" value="删除颜色" name="remove">');

		row.find("td[rel=btn]").find("input[name=add]").click(function()
		{
			$("#winPictureWindow").find("input[name=colorpos]").val(row.attr("rel"));
			$("#winPictureWindow").show();
		});
		row.find("td[rel=btn]").find("input[name=remove]").click(function()
		{
			pos = row.attr("rel")-1
			colorName[pos] = "";
			colorImg[pos] = "";
			colorSPic[pos].length = 0;
			colorMPic[pos].length = 0;
			colorBPic[pos].length = 0;
			$(this).parent().parent().remove();
		});

		$("#tbColorList").append(row);
		$("#winColorWindow").hide();
		ClearColor();
	});

	$("#btnColorCancel").click(function()
	{
		$("#winColorWindow").hide();
		ClearColor();
	});

	$("#btnPictureOk").click(function()
	{
		if ($("input[name=txtSmallPic]").val() == "")
		{
			alert("请上传小图片");
			return;
		}
		if ($("input[name=txtMiddlePic]").val() == "")
		{
			alert("请上传中图片");
			return;
		}
		if ($("input[name=txtBigPic]").val() == "")
		{
			alert("请上传大图片");
			return;
		}
		colorPosition = $("input[name=colorpos]").val();
		colorSPic[colorPosition-1].push($("input[name=txtSmallPic]").val());
		colorMPic[colorPosition-1].push($("input[name=txtMiddlePic]").val());
		colorBPic[colorPosition-1].push($("input[name=txtBigPic]").val());

		$("#tbColorList").find("tr[rel="+ colorPosition +"]").find("td[rel=nums]").html(colorSPic[colorPosition-1].length);

		ClearPicture();
		$("#winPictureWindow").hide();
	});

	$("#btnPictureCancel").click(function()
	{
		ClearPicture();
		$("#winPictureWindow").hide();
	});

	$("#btnChooseSmallPic").click(function()
	{
		upname = "btnChooseSmallPic";
		swfu.selectFiles();
	});

	$("#btnChooseMiddlePic").click(function()
	{
		upname = "btnChooseMiddlePic";
		swfu.selectFiles();
	});

	$("#btnChooseBigPic").click(function()
	{
		upname = "btnChooseBigPic";
		swfu.selectFiles();
	});
})