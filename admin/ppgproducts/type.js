var g_currentPage = 1;
var g_pageCounts = 15;
var g_type = "";
var g_url = "typelist.json.php";

function dataProcess(data)
{
	$("#table1").find("tbody").empty();

	var recordList = data['data'];
	var recordLength = recordList.length;

	for (rIndex=0; rIndex<recordLength; rIndex++)
	{
		var row = $('<tr align="center" valign="middle"><td width="22" height="25" valign="middle" rel="chkbox"></td><td width="8" height="25"></td><td width="68" height="25" rel="id"></td><td width="8" height="25"></td><td width="271" height="25" rel="called"></td><td width="8" height="25"></td><td width="10%" height="25" rel="isshow"></td><td width="8" height="25"></td><td width="10%" height="25" rel="language"></td><td width="8" height="25"></td><td width="250" height="25" rel="parent"></td><td width="8" height="25"></td><td width="50" height="25" rel="order"></td></tr>');

		row.find("td[rel=chkbox]").html('<input type="checkbox" name="chk" value="'+ recordList[rIndex].ID +'">');
		row.find("td[rel=id]").html(recordList[rIndex].ID);
		row.find("td[rel=called]").html(recordList[rIndex].CALLED);
		row.find("td[rel=isshow]").html(EchoShow(recordList[rIndex].ISSHOW));
		row.find("td[rel=language]").html(recordList[rIndex].LANGUAGE);
		row.find("td[rel=parent]").html(recordList[rIndex].PARENTPATH);
		row.find("td[rel=order]").html(getOrderByTable(recordList[rIndex].ID,"typeset.php",function(data){AjaxGet(g_url,getParameter(),dataProcess)}));

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
	return $.param({page:g_currentPage,pagecounts:g_pageCounts,language:g_language,type:g_type});
}

$(function()
{
	AjaxGet(g_url,getParameter(),dataProcess);

	$("#chk").click(CheckAll);

	$("#btnRefresh").click(function()
	{
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#btnSelect").click(function()
	{
		g_currentPage = 1;
		g_language = $("select[name='language']").val();
		//g_type = $("select[name='type']").val();

		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#btnShow").click(function()
	{
		var checkedVal = CheckBoxSelect(true);
		if (checkedVal != "")
		{
			if (window.confirm("确定要设置为显示吗？"))
			{
				var data = "action=show";
				if (window.confirm("是否要把所有的子分类及其产品也设置为显示？"))
				{
					data += "&cascade=true";
				}
				data += "&id="+checkedVal;
				AjaxSet("typeset.php",data,function(data)
				{
					AjaxGet(g_url,getParameter(),dataProcess);
				});
			}
		}
	});

	$("#btnUnShow").click(function()
	{
		var checkedVal = CheckBoxSelect(true);
		if (checkedVal != "")
		{
			if (window.confirm("确定要设置为隐藏吗？"))
			{
				var data = "action=unshow";
				if (window.confirm("是否要把所有子分类及其产品也设置为隐藏？"))
				{
					data += "&cascade=true";
				}

				data += "&id="+checkedVal;
				AjaxSet("typeset.php",data,function(data)
				{
					AjaxGet(g_url,getParameter(),dataProcess);
				});
			}
		}
	});

	$("#btnEdit").click(function()
	{
		var checkedVal = CheckBoxSelect(true)
		if (checkedVal != "")
		{
			window.open('typeedit.php?id='+checkedVal,'typeedit','top=0,left=0,width='+$(window).width()+',height='+$(window).height());
		}
	});

	$("#btnDelete").click(function()
	{
		var checkedVal = CheckBoxSelect(true);
		if (checkedVal != "")
		{
			if (window.confirm("确定要删除吗？"))
			{
				var data = "action=del";
				if (window.confirm("是否要把所有子分类及其产品全部删除？"))
				{
					data += "&cascade=true";
				}
				data += "&id="+checkedVal;

				AjaxSet("typeset.php",data,function(data)
				{
					AjaxGet(g_url,getParameter(),dataProcess);
				});
			}
		}
	});
})