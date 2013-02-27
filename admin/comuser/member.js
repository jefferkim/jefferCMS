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
		var row = $('<tr align="center" valign="middle"><td width="22" height="25" valign="middle" rel="chk"></td><td width="8" height="25"></td><td width="68" height="25" rel="id"></td><td width="8" height="25"></td><td width="120" height="25" rel="username"></td><td width="8" height="25"></td><td width="120" height="25" rel="name"></td><td width="8" height="25"></td><td width="10%" height="25" rel="islock"></td><td width="8" height="25"></td><td width="10%" height="25" rel="iscommend"></td><td width="8" height="25"></td><td width="10%" height="25" rel="isexcellent"></td><td width="8" height="25"></td><td width="271" height="25" rel="company"></td><td width="8" height="25"></td><td width="80" height="25" rel="notetime"></td></tr>');

		row.find("td[rel=chk]").html('<input type="checkbox" name="chk" value="'+ recordList[rIndex].ID +'">');
		row.find("td[rel=id]").html(recordList[rIndex].ID);
		row.find("td[rel=username]").html('<a href="javascript:;" onclick="showDetail('+ recordList[rIndex].ID +')">' + recordList[rIndex].USERNAME + '</a>');
		row.find("td[rel=name]").html(recordList[rIndex].CALLED);
		row.find("td[rel=islock]").html(EchoShow(recordList[rIndex].ISLOCK));
		row.find("td[rel=iscommend]").html(EchoShow(recordList[rIndex].ISCOMMEND));
		row.find("td[rel=isexcellent]").html(EchoShow(recordList[rIndex].ISEXCELLENT));
		row.find("td[rel=company]").html(recordList[rIndex].COMPANY);
		row.find("td[rel=notetime]").html(recordList[rIndex].NOTETIME);

		RowSelected(row);

		$("#table1").append(row);
	}

	setPagination(data['counts'],data['pageCounts'],data['page']-1);
}

function showDetail(id)
{
	AjaxGet("member.json.php",$.param({id:id}),function(data)
	{
		var member = data['member'];
		$("#lblUserName").html(member.USERNAME);
		//$("#lblPassword").html(member.PASSWORD);
		$("#lblName").html(member.CALLED);
		$("#lblTel").html(member.TEL);
		$("#lblFax").html(member.FAX);
		$("#lblMobil").html(member.MOBILE);
		$("#lblMail").html(member.MAIL);
		$("#lblCompany").html(member.COMPANY);
		$("#lblAddress").html(member.ADDRESS);

		var detail = $("#details").clone();

		var customer = data['customer'];
		var customerLength = customer.length;
		for (rIndex = 0; rIndex<customerLength; rIndex++)
		{
			detail.find("table").append("<tr><td>"+ customer[rIndex][0] +"：</td><td>"+ customer[rIndex][1] +"</td></tr>");
		}
		$.prompt(detail.html(),{
			buttons:{关闭:'Close'}
		});
	});
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

	$("#btnLock").click(function()
	{
		var checkedVal = CheckBoxSelect(false);
		if (checkedVal != "")
		{
			AjaxSetConfirm("确定要锁定吗？","memberset.php",$.param({action:'lock',id:checkedVal}),function(data)
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
		}
	});

	$("#btnUnLock").click(function()
	{
		var checkedVal = CheckBoxSelect(false);
		if (checkedVal != "")
		{
			AjaxSetConfirm("确定要解除锁定吗？","memberset.php",$.param({action:'unlock',id:checkedVal}),function(data)
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
			AjaxSetConfirm("确定要设置为推荐会员吗？","memberset.php",$.param({action:'commend',id:checkedVal}),function(data)
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
			AjaxSetConfirm("确定要解除推荐会员吗？","memberset.php",$.param({action:'uncommend',id:checkedVal}),function(data)
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
		}
	});

	$("#btnExcellent").click(function()
	{
		var checkedVal = CheckBoxSelect(false);
		if (checkedVal != "")
		{
			AjaxSetConfirm("确定要设置为优秀会员吗？","memberset.php",$.param({action:'excellent',id:checkedVal}),function(data)
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
		}
	});

	$("#btnUnExcellent").click(function()
	{
		var checkedVal = CheckBoxSelect(false);
		if (checkedVal != "")
		{
			AjaxSetConfirm("确定要解除优秀会员吗？","memberset.php",$.param({action:'unexcellent',id:checkedVal}),function(data)
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