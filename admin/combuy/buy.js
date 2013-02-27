var g_url = "buylist.json.php";
var g_currentPage = 1;
var g_pageCounts = 15;
var g_commend = "";
var g_keyword = "";

function dataProcess(data)
{
	$("#table1").find("tbody").empty();

	var recordList = data['data'];
	var recordLength = recordList.length;

	for (rIndex=0; rIndex<recordLength; rIndex++)
	{
		var row = $('<tr align="center" valign="middle"><td width="22" height="25" valign="middle" rel="chk"></td><td width="8" height="25"></td><td width="68" height="25" rel="id"></td><td width="8" height="25"></td><td width="271" height="25" rel="name"></td><td width="8" height="25"></td><td width="10%" height="25" rel="picurl"></td><td width="8" height="25"></td><td width="271" height="25" rel="notetime"></td></tr>');

		row.find("td[rel=chk]").html('<input type="checkbox" name="chk" value="'+ recordList[rIndex].ID +'">');
		row.find("td[rel=id]").html(recordList[rIndex].ID);
		//row.find("td[rel=ordernum]").html('<input type="hidden" name="pid" value="'+ recordList[rIndex].ID +'"><input type="text" size="5" name="ordernum" value="'+ recordList[rIndex].ORDERBY +'">');
		row.find("td[rel=name]").html(recordList[rIndex].PRONAME);
		row.find("td[rel=picurl]").html('<a href="'+ rooturl +'/upload/'+ recordList[rIndex].PICURL +'" target="_blank">' + recordList[rIndex].PICURL + '</a>');
		//row.find("td[rel=iscommend]").html(EchoShow(recordList[rIndex].ISCOMMEND));
		row.find("td[rel=notetime]").html(recordList[rIndex].NOTETIME);

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
	return $.param({page:g_currentPage,language:g_language,commend:g_commend,keyword:g_keyword});
}

$(function()
{
	AjaxGet(g_url,getParameter(),dataProcess);
	//ChangeProductsType($("select[name=language]").val());

	$("select[name=language]").change(function()
	{
		//ChangeProductsType($(this).val());
		g_language = $(this).val();
		//g_type = "";
		g_currentPage = 1;
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("select[name=selCommend]").change(function()
	{
		g_commend = $(this).val();
		g_currentPage = 1;
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#chk").click(CheckAll);


	$("#btnDelete").click(function()
	{
		if (window.confirm("确定要删除选中的信息吗？"))
		{
			var checkedVal = CheckBoxSelect(false);
			if (checkedVal != "")
			{
				AjaxSet("buyset.php",$.param({action:'del',id:checkedVal}),function(data)
				{
					AjaxGet(g_url,getParameter(),dataProcess);
				});
			}
		}
	});

	$("#btnRefresh").click(function()
	{
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#btnSelect").click(function()
	{
		g_language = $("select[name='language']").val();
		g_commend = $("select[name=selCommend]").val();
		g_keyword = $("input[name=keyword]").val();

		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#btnOrderBy").click(function()
	{
		
		var checkedId = Array();
		var checkedOrderVal = Array();
		var checkedProVal = Array();

		$("input[name=pid]").each(function()
		{
			checkedId.push($(this).val());
		});
		$("input[name=ordernum]").each(function()
		{
			checkedOrderVal.push($(this).val());
		});

		if ((checkedId.length == checkedOrderVal.length) && checkedId.length > 0)
		{
			AjaxSet("buyset.php",$.param({action:'order',id:checkedId.join(','),order:checkedOrderVal.join(',')}),function(data)
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
		}
	});
})