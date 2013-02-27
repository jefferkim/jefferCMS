var g_url = "memberlist.json.php";
var g_currentPage = 1;
var g_pageCounts = 15;
var g_name = "";

function dataProcess(data)
{
	$("#table1").find("tbody").empty();

	var recordList = data['data'];
	var recordLength = recordList.length;

	for (rIndex=0; rIndex<recordLength; rIndex++)
	{
		var row = $('<tr align="center" valign="middle"><td width="22" height="25" valign="middle" rel="chk"></td><td width="8" height="25"></td><td width="68" height="25" rel="id"></td><td width="8" height="25"></td><td width="120" height="25" rel="name"></td><td width="8" height="25"></td><td width="271" height="25" rel="cardnum"></td><td width="8" height="25"></td><td width="80" height="25" rel="zy"></td><td width="8" height="25"></td><td width="80" height="25" rel="cj"></td></tr>');

		row.find("td[rel=chk]").html('<input type="checkbox" name="chk" value="'+ recordList[rIndex].ID +'">');
		row.find("td[rel=id]").html(recordList[rIndex].ID);
		row.find("td[rel=name]").html(recordList[rIndex].NAME);
		row.find("td[rel=cardnum]").html(recordList[rIndex].CARDNUM);
		row.find("td[rel=zy]").html(recordList[rIndex].ZY);
        row.find("td[rel=cj]").html(recordList[rIndex].CJ);

		RowSelected(row);

		$("#table1").append(row);
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
	return $.param({page:g_currentPage,pagecounts:g_pageCounts,language:g_language,name:g_name});
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

	$("#chk").click(CheckAll);

	$("#btnRefresh").click(function()
	{
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#btnEdit").click(function()
	{
		var checkedVal = CheckBoxSelect(true);
		if (checkedVal != "")
		{
			window.open('memberedit.php?id='+checkedVal,'memberedit','top=0,left=0,scrollbars=1,width='+ $(window).width() +',height='+$(window).height());
		}
	});

	$("#btnDelete").click(function()
	{
		var checkedVal = CheckBoxSelect(false);
		if (checkedVal != "")
		{
			AjaxSetConfirm("确定要删除吗？","memberset.php",$.param({action:'del',id:checkedVal}),function(data)
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
		}
	});


	$("#btnSelect").click(function()
	{
		g_language = $("select[name=language]").val();
		g_name = $("input[name=username]").val();
		g_currentPage = 1;

		AjaxGet(g_url,getParameter(),dataProcess);
	});
});