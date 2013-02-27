var g_url = "typelist.json.php";
var g_currentPage = 1;
var g_pageCounts = 15;

function dataProcess(data)
{
	$("#tablist").find("tbody").empty();

	var recordList = data['data'];
	var recordLength = recordList.length;

	for (rIndex=0; rIndex<recordLength; rIndex++)
	{
		var row = $('<tr class="whitebg"><td align="center" valign="middle" rel="chk"></td><td height="23" align="center" valign="middle" rel="id"></td><td align="left" valign="middle" rel="called"></td><td align="center" valign="middle" rel="language"></td><td align="center" valign="middle" rel="notetime"></td></tr>');

		row.find("td[rel=chk]").html('<input type="checkbox" name="chk" value="'+ recordList[rIndex].ID +'">');
		row.find("td[rel=id]").html(recordList[rIndex].ID);
		row.find("td[rel=called]").html(recordList[rIndex].CALLED);
		row.find("td[rel=language]").html(recordList[rIndex].LANGUAGE);
		row.find("td[rel=notetime]").html(recordList[rIndex].NOTETIME);

		RowSelected(row);

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
		language : g_language
	});
}

$(function()
{
	AjaxGet(g_url,getParameter(),dataProcess);

	$("select[name=language]").change(function()
	{
		g_language = $(this).val();
		g_currentPage = 1;
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#btnRefresh").click(function()
	{
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#btnSelect").click(function()
	{
		g_currentPage = 1;
		g_language = $("select[name=language]").val();

		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#btnEdit").click(function()
	{
		var checkedVal = CheckBoxSelect(true);
		if (checkedVal != "")
		{
			window.location.href = 'typeedit.php?id='+checkedVal;
		}
	});

	$("#btnDelete").click(function()
	{
		var checkedVal = CheckBoxSelect();
		if (checkedVal != "")
		{
			if (window.confirm("确定要删除吗？"))
			{
				var cascade = false;
				if (window.confirm("是否要将分类下的图片一起删除？"))
				{
					cascade = true;
				}

				var data = $.param({
					action : 'del',
					id : checkedVal,
					cascade : cascade
				});

				AjaxSet("typesave.php",data,function(data)
				{
					AjaxGet(g_url,getParameter(),dataProcess);
				});
			}
		}
	});

	$("#btnImportType").click(function()
	{
		var left = $(window).width()/2-250;
		var top = $(window).height()/2-100;
		window.open('importtype.php','import','left='+left+',top='+top+',width=500,height=200');
	});

	$("#chk").click(CheckAll);
})