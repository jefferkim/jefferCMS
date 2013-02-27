var g_url = "products.json.php";
var g_currentPage = 1;
var g_pageCounts = 15;
var g_show = "";
var g_commend = "";
var g_type = "";
var g_keyword = "";

function dataProcess(data)
{
	$("#table1").find("tbody").empty();

	var recordList = data['data'];
	var recordLength = recordList.length;

	for (rIndex=0; rIndex<recordLength; rIndex++)
	{
		var row = $('<tr align="center" valign="middle"><td width="22" height="25" valign="middle" rel="chk"></td><td width="8" height="25"></td><td width="68" height="25" rel="id"></td><td width="8" height="25"></td><td width="68" height="25" rel="ordernum"></td><td width="8" height="25"></td><td width="271" height="25" rel="name"></td><td width="8" height="25"></td><td width="10%" height="25" rel="language"></td><td width="8" height="25"></td><td width="10%" height="25" rel="isshow"></td><td width="8" height="25"></td><td width="10%" height="25" rel="iscommend"></td><td width="8" height="25"></td><td width="271" height="25" rel="notetime"></td><td width="8" height="25"></td><td width="50" height="25" rel="orderby"></td></tr>');

		row.find("td[rel=chk]").html('<input type="checkbox" name="chk" value="'+ recordList[rIndex].ID +'">');
		row.find("td[rel=id]").html(recordList[rIndex].ID);
		row.find("td[rel=ordernum]").html('<input type="hidden" name="pid" value="'+ recordList[rIndex].ID +'"><input type="text" size="5" name="ordernum" value="'+ recordList[rIndex].ORDERBY +'">');
		row.find("td[rel=name]").html('<input type="text" name="pname" value="'+ recordList[rIndex].PRONAME +'">');
		row.find("td[rel=language]").html(recordList[rIndex].LANGUAGE);
		row.find("td[rel=isshow]").html(EchoShow(recordList[rIndex].ISSHOW));
		row.find("td[rel=iscommend]").html(EchoShow(recordList[rIndex].ISCOMMEND));
		row.find("td[rel=notetime]").html(recordList[rIndex].NOTETIME);
		row.find("td[rel=orderby]").html(getOrderByTable(recordList[rIndex].ID,"productset.php",function(data){AjaxGet(g_url,getParameter(),dataProcess)}));

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
	return $.param({page:g_currentPage,pagecounts:g_pageCounts,language:g_language,type:g_type,show:g_show,commend:g_commend,keyword:g_keyword});
}

function ChangeProductType(lan)
{
	ChangeType("typeselectlist.json.php",$.param({language:lan}),$("select[name=type]"),true);
}

$(function()
{
	AjaxGet(g_url,getParameter(),dataProcess);

	ChangeProductType($("select[name=language]").val());

	$("select[name=language]").change(function()
	{
		ChangeProductType($(this).val());
		g_language = $(this).val();
		g_type = "";
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("select[name=type]").change(function()
	{
		g_type = $(this).val();
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("select[name=selShow]").change(function()
	{
		g_show = $(this).val();
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("select[name=selCommend]").change(function()
	{
		g_commend = $(this).val();
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#chk").click(CheckAll);

	$("#btnEdit").click(function()
	{
		var checkedVal = CheckBoxSelect(true);

		if (checkedVal != "")
		{
			window.open('productedit.php?id='+checkedVal,'proedit','top=0,left=0,scrollbars=1,width='+ $(window).width() +',height='+$(window).height());
		}
	});

	$("#btnDelete").click(function()
	{
		if (window.confirm("确定要删除选中的产品吗？"))
		{
			var checkedVal = CheckBoxSelect(false);
			if (checkedVal != "")
			{
				AjaxSet("productset.php",$.param({action:'del',id:checkedVal}),function(data)
				{
					AjaxGet(g_url,getParameter(),dataProcess);
				});
			}
		}
	});

	$("#btnShow").click(function()
	{
		if (window.confirm("确定要设置为显示吗？"))
		{
			var checkedVal = CheckBoxSelect(false);
			if (checkedVal != "")
			{
				AjaxSet("productset.php",$.param({action:'show',id:checkedVal}),function(data)
				{
					AjaxGet(g_url,getParameter(),dataProcess);
				});
			}
		}
	});

	$("#btnUnShow").click(function()
	{
		if (window.confirm("确定要设置为隐藏吗？"))
		{
			var checkedVal = CheckBoxSelect(false);
			if (checkedVal != "")
			{
				AjaxSet("productset.php",$.param({action:'hide',id:checkedVal}),function(data)
				{
					AjaxGet(g_url,getParameter(),dataProcess);
				});
			}
		}
	});

	$("#btnCommend").click(function()
	{
		if (window.confirm("确定要设置为推荐吗？"))
		{
			var checkedVal = CheckBoxSelect(false);
			if (checkedVal != "")
			{
				AjaxSet("productset.php",$.param({action:'commend',id:checkedVal}),function(data)
				{
					AjaxGet(g_url,getParameter(),dataProcess);
				});
			}
		}
	});

	$("#btnUnCommend").click(function()
	{
		if (window.confirm("确定要取消推荐吗？"))
		{
			var checkedVal = CheckBoxSelect(false);
			if (checkedVal != "")
			{
				AjaxSet("productset.php",$.param({action:'uncommend',id:checkedVal}),function(data)
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
		g_type = $("select[name='type']").val();
		g_show = $("select[name=selShow]").val();
		g_commend = $("select[name=selCommend]").val();
		g_pageCounts = $("input[name=productnums]").val();
		if (parseInt(g_pageCounts) == isNaN)
		{
			g_pageCounts = 15;
		}
		g_keyword = $("input[name=keyword]").val();

		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#btnOrder").click(function()
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
		$("input[name=pname]").each(function()
		{
			checkedProVal.push($(this).val());
		});

		if ((checkedId.length == checkedOrderVal.length) && (checkedId.length == checkedProVal.length) && checkedId.length > 0)
		{
			AjaxSet("productset.php",$.param({action:'order',id:checkedId.join(','),order:checkedOrderVal.join(','),pname:checkedProVal.join(',')}),function(data)
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
		}
	});

	$("#btnImport").click(function()
	{
		var left = $(window).width()/2-250;
		var top = $(window).height()/2-100;
		window.open('productimport.php','import','left='+left+',top='+top+',width=500,height=200');
	});
})