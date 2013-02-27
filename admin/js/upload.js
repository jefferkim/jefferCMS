// JavaScript Document
var g_url = "uploadsave.php";
var g_currentPage = 1;
var g_pageCounts = 15;

function dataProcess(data)
{
	$("#tablist").find("tbody").empty();

	var recordList = data['data'];
	var recordLength = recordList.length;

	for (rIndex=0; rIndex<recordLength; rIndex++)
	{
		var row = $('<tr class="whitebg"><td height="23" align="center" valign="middle" rel="id"></td><td align="left" valign="middle" style="padding-left:5px;" rel="picurl"></td><td align="center" valign="middle" rel="called"></td><td align="center" valign="middle" rel="notetime"></td></tr>');

		row.find("td[rel=id]").html(recordList[rIndex].ID);
		row.find("td[rel=picurl]").html('<a href="'+ rooturl +"/"+ recordList[rIndex].PICURL +'" target="_blank">'+ recordList[rIndex].PICURL +'</a>');
		row.find("td[rel=called]").html(recordList[rIndex].CALLED);
		row.find("td[rel=notetime]").html(recordList[rIndex].NOTETIME);

		$("#tablist").append(row);
	}

	setPagination(data['counts'],data['pageCounts'],data['page']-1);
}

function setPagination(counts,pageCounts,currentPage)
{
	$("#pager").pagination(counts,{
		items_per_page : pageCounts,
		current_page : currentPage,
		num_display_entries : 12,
		next_text : "下一页",
		prev_text : "上一页",
		callback : function(newpage,container){
			g_currentPage = newpage + 1;
			AjaxGet(g_url,getParameter(),dataProcess);
		}
	});
}
function getParameter()
{
	return $.param({
		page : g_currentPage,
		pagecounts : g_pageCounts,
		type : g_type,
		opera : 'show'
	});
}

function picFiles(id){
	$("input[name=uploadpic"+ id +"]").upload({
		name:'Filedata',
		method:'post',
		enctype:'multipart/form-data',
		action:'uploadsave.php',
		params: {opera:"up"},
		onSubmit:function()
		{
			$("#progressbars"+ id +"").html('<img src="images/51.gif">&nbsp;正在上传图片');
		},
		onComplete:function(data)
		{
			var record = eval( "(" + data + ")" );//转换后的JSON对象
			if(record.REMS == true)
			{
				var progretext = '<input type="text" id="picur'+ id +'" class="imgtext" onClick="copyToClipboard($(this).val())" value="'+ rooturl +"/"+ record.DATA +'">';
				var uptext = '<img src="images/r.gif">&nbsp;上传成功！&nbsp;';
					uptext += '<input type="hidden" name="picur'+ id +'" value="'+ record.DATA +'" rel="picurl" >&nbsp;';
					uptext += '<a href="'+ rooturl +"/"+ record.DATA +'" target="_blank">查看图片</a>';
				$("#progressbars"+ id +"").html(progretext);
				$("#upimg"+ id +"").html(uptext);
			}
			else
			{
				alert(record.DATA);
				clearFile();
			}
		}
	});	
}

function clearFile()
{
	$(".csh").find("tr").each(function(i){
		$("#progressbars"+i).html('');	
		$("#upimg"+ i).html('');
	});
}

