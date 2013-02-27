var g_currentPage = 1;
var g_pageCounts = 9;
var g_newsType = "";
var g_parent = 0;
var g_url = "newslist.json.php"

function dataProcess(data)
{
	$("#tablist").find("tbody").empty();

	var recordList = data['data'];
	var recordLength = recordList.length;

	for (rIndex = 0; rIndex<recordLength; rIndex++)
	{
		
		if(rIndex%2==0){
			var row = $('<tr><td align="center" height="30" valign="middle"rel=chkbox></td><td height="23" align="center" valign="middle" rel=id></td><td  align="center" valign="middle" rel=ordernum></td><td  align="left" style="padding-left:10px;" valign="middle" rel=title></td><td  align="center" valign="middle" rel=types></td><td  align="center" valign="middle" rel=language></td><td  align="center" valign="middle" rel=show></td><td  align="center" valign="middle" rel=commend></td><td  align="center" valign="middle" rel=date></td><td  align="center" valign="middle"rel=sort></td><td align="center" valign="middle"><a  href="javascript:;" onclick="Edit_id('+recordList[rIndex].ID+')"><img src="../images/33.gif" width="14" height="14" class="img_ico">修改</a> <a href="javascript:;" onclick="Del_id('+recordList[rIndex].ID+')"><img src="../images/11.gif" width="14" height="14" class="img_ico">删除</a></td></tr>');
			
		}else{
			var row = $('<tr class="two_tr"><td align="center" height="30" valign="middle"rel=chkbox></td><td height="23" align="center" valign="middle" rel=id></td><td  align="center" valign="middle" rel=ordernum></td><td  align="left" style="padding-left:10px;" valign="middle" rel=title></td><td  align="center" valign="middle" rel=types></td><td  align="center" valign="middle" rel=language></td><td  align="center" valign="middle" rel=show></td><td  align="center" valign="middle" rel=commend></td><td  align="center" valign="middle" rel=date></td><td  align="center" valign="middle"rel=sort></td><td align="center" valign="middle"><a  href="javascript:;" onclick="Edit_id('+recordList[rIndex].ID+')"><img src="../images/33.gif" width="14" height="14" class="img_ico">修改</a> <a href="javascript:;" onclick="Del_id('+recordList[rIndex].ID+')"><img src="../images/11.gif" width="14" height="14" class="img_ico">删除</a></td></tr>');


		}
		row.find("td[rel=chkbox]").html('<input type="checkbox" id="chk'+ recordList[rIndex].ID +'" value="'+ recordList[rIndex].ID +'">');
		row.find("td[rel=id]").html(recordList[rIndex].ID);
        row.find("td[rel=ordernum]").html('<input type="hidden" name="nid" value="'+ recordList[rIndex].ID +'"><input type="text" size="5" name="ordernum" value="'+ recordList[rIndex].ORDERBY +'" class="sys_input" style=" width:60px;">');
		row.find("td[rel=title]").html(recordList[rIndex].TITLE);
		row.find("td[rel=types]").html(recordList[rIndex].NEWTYPE);
		row.find("td[rel=language]").html(recordList[rIndex].LANGUAGE);
		row.find("td[rel=show]").html(EchoShow(recordList[rIndex].ISSHOW));
		row.find("td[rel=commend]").html(EchoShow(recordList[rIndex].ISCOMMEND));
		row.find("td[rel=date]").html(recordList[rIndex].NOTETIME);
		row.find("td[rel=sort]").html(getOrderByTable(recordList[rIndex].ID,"newsset.php",function(data){AjaxGet(g_url,getParameter(),dataProcess)}));

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
		num_display_entries : 8,
		num_edge_entries: 1, //边缘页数
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
	return $.param({page:g_currentPage,pagecounts:g_pageCounts,language:g_language,newstype:g_newsType,parent:g_parent});
}

function ChangeNewsType(lan)
{
	ChangeType("typelist.json.php",$.param({language:lan}),$("select[name=type]"),true);
}

$(function()
{
	AjaxGet(g_url,getParameter(),dataProcess);
	ChangeNewsType($("select[name=language]").val());

	$("select[name=language]").change(function()
	{
		ChangeNewsType($(this).val());
		g_language = $(this).val();
		g_newsType = "";
		g_currentPage = 1;
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("select[name=type]").change(function()
	{
		g_newsType = $(this).val();
		g_currentPage = 1;
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#chk").click(CheckAll);

	$("#btnSelect").click(function()
	{
		g_language = $("#language").val();
		g_newsType = $("#type").val();
		g_currentPage = 1;

		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#btnEdit").click(function()
	{
		var checkedVal = CheckBoxSelect(true);

		if (checkedVal != "")
		{
			window.open('newsedit.php?id='+checkedVal,'edit','top=0,left=0,scrollbars=1,width='+$(window).width()+',height='+$(window).height());
		}
	});

	$("#btnShow").click(function()
	{
		var checkedVal = CheckBoxSelect(false);
		if (checkedVal != "")
		{
			AjaxSetConfirm("确定设置显示吗？",'newsset.php',$.param({action:'show',id:checkedVal}),function(data)
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
		}
	});

	$("#btnUnShow").click(function()
	{
		var checkedVal = CheckBoxSelect(false);
		if (checkedVal != "")
		{
			AjaxSetConfirm("确定设置为隐藏吗？",'newsset.php',$.param({action:'unshow',id:checkedVal}),function(data)
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
		}
	});

	$("#btnCommend").click(function()
	{
		var checkedVal = CheckBoxSelect(false);
		if (checkedVal != "")
		{
			AjaxSetConfirm("确定设置为推荐吗？",'newsset.php',$.param({action:'commend',id:checkedVal}),function(data)
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
		}
	});

	$("#btnUnCommend").click(function()
	{
		var checkedVal = CheckBoxSelect(false);
		if (checkedVal != "")
		{
			AjaxSetConfirm("确定取消推荐吗？",'newsset.php',$.param({action:'uncommend',id:checkedVal}),function(data)
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
		}
	});

	$("#btnDelete").click(function()
	{
		var checkedVal = CheckBoxSelect(false);
		if (checkedVal != "")
		{
			AjaxSetConfirm("确定要删除吗？",'newsset.php',$.param({action:'del',id:checkedVal}),function(data)
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
		}
	});

    $("#btnOrder").click(function()
	{
		var checkedId = Array();
		var checkedOrderVal = Array();
		var checkedProVal = Array();

		$("input[name=nid]").each(function()
		{
			checkedId.push($(this).val());
		});
		$("input[name=ordernum]").each(function()
		{
			checkedOrderVal.push($(this).val());
		});


		if ((checkedId.length == checkedOrderVal.length) && checkedId.length > 0)
		{
			AjaxSet("newsset.php",$.param({action:'order',id:checkedId.join(','),order:checkedOrderVal.join(',')}),function(data)
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
		}
	});

	$("#btnRefresh").click(function()
	{
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#btnImport").click(function()
	{
		var left = $(window).width()/2-250;
		var top = $(window).height()/2-100;
		window.open('importnews.php','import','left='+left+',top='+top+',width=500,height=200');
	});
});

function Del_id(id){
	
	AjaxSetConfirm("确定要删除吗？","newsset.php",$.param({action:'del',id:id}),function()
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
	
};

function Edit_id(id){
	
window.open('newsedit.php?id='+id,'edit','top=0,left=0,scrollbars=1,width='+$(window).width()+',height='+$(window).height());
	
};