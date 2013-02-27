var g_url = "memberlist.json.php";
var g_currentPage = 1;
var g_pageCounts = 15;
var g_name = "";

function dataProcess(data)
{
	$("#tablist").find("tbody").empty();

	var recordList = data['data'];
	var recordLength = recordList.length;

	for (rIndex=0; rIndex<recordLength; rIndex++)
	{
		
		if(rIndex%2==0){
					var row = $('<tr><td align="center" valign="middle" rel="chk"></td><td height="30" align="center" valign="middle" rel="id"></td><td align="left" style="padding-left:10px;" valign="middle" rel="username"></td><td align="center" valign="middle" rel="name"></td><td align="center" valign="middle" rel="islock"></td><td align="center" valign="middle" rel="company"></td><td align="center" valign="middle" rel="notetime"></td><td align="center" valign="middle"><a  href="javascript:;" onclick="Edit_id('+recordList[rIndex].ID+')"><img src="../images/33.gif" width="14" height="14" class="img_ico">修改</a> <a href="javascript:;" onclick="Del_id('+recordList[rIndex].ID+')"><img src="../images/11.gif" width="14" height="14" class="img_ico">删除</a></td></tr>');
		}else{
			
		var row = $('<tr class="two_tr"><td align="center" valign="middle" rel="chk"></td><td height="30" align="center" valign="middle" rel="id"></td><td align="left" style="padding-left:10px;" valign="middle" rel="username"></td><td align="center" valign="middle" rel="name"></td><td align="center" valign="middle" rel="islock"></td><td align="center" valign="middle" rel="company"></td><td align="center" valign="middle" rel="notetime"></td><td align="center" valign="middle"><a  href="javascript:;" onclick="Edit_id('+recordList[rIndex].ID+')"><img src="../images/33.gif" width="14" height="14" class="img_ico">修改</a> <a href="javascript:;" onclick="Del_id('+recordList[rIndex].ID+')"><img src="../images/11.gif" width="14" height="14" class="img_ico">删除</a></td></tr>');
       
		}
		row.find("td[rel=chk]").html('<input type="checkbox" name="chk" value="'+ recordList[rIndex].ID +'">');
		row.find("td[rel=id]").html(recordList[rIndex].ID);
		row.find("td[rel=username]").html('<a href="javascript:;" onclick="showDetail('+ recordList[rIndex].ID +')">' + recordList[rIndex].USERNAME + '</a>');
		row.find("td[rel=name]").html(recordList[rIndex].CALLED);
		row.find("td[rel=islock]").html(EchoShow(recordList[rIndex].ISLOCK));
		row.find("td[rel=company]").html(recordList[rIndex].COMPANY);
		row.find("td[rel=notetime]").html(recordList[rIndex].NOTETIME);

		RowSelected(row);

		$("#tablist").append(row);
	}

	setPagination(data['counts'],data['pageCounts'],data['page']-1);
}

/*function showDetail(id)
{
	AjaxGet("member.json.php",$.param({id:id}),function(data)
	{
		var member = data['member'];
		$("#lblUserName").html(member.USERNAME);
		$("#lblPassword").html(member.PASSWORD);
		$("#lblName").html(member.CALLED);
		$("#lblTel").html(member.TEL);
		$("#lblMobil").html(member.MOBILE);
		$("#lblMail").html(member.MAIL);
		$("#lblCompany").html(member.COMPANY);

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
*/

function showDetail(id) {
	AjaxGetCHTML("member.json.php",$.param({id:id}),function(data)
	{
		$(".dragDiv2").html(data);									 
	});
	var bH = $(document).height();
	var bW = $(document).width();
	$('<div id="fullbg"></div>').appendTo("body");
	$('<div class="dragDiv2"></div>').appendTo("body");
	$("#fullbg").css({ width: bW, height: bH});
	$(".dragDiv2").css({"display":"block","width":500+"px"})
	.css("left",(($(document).width())/2-(parseInt($(".dragDiv2").width())/2))+"px")
	.css("top",80+"px");
}

function closeBg() {
	$("#fullbg").remove();
	$(".dragDiv2").remove();
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
				window.open('memberedit.php?id='+checkedVal,'edit','top=0,left=0,scrollbars=1,width='+$(window).width()+',height='+$(window).height());

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

	$("#btnLock").click(function()
	{
		var checkedVal = CheckBoxSelect(false);
		if (checkedVal != "")
		{
			AjaxSetConfirm("确定要锁定吗？","memberset.php",$.param({action:'lock',id:checkedVal}),function()
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
			AjaxSetConfirm("确定要解除锁定吗？","memberset.php",$.param({action:'unlock',id:checkedVal}),function()
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

function Del_id(id){
	
	AjaxSetConfirm("确定要删除吗？","memberset.php",$.param({action:'del',id:id}),function()
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
	
};

function Edit_id(id){
window.open('memberedit.php?id='+id,'edit','top=0,left=0,scrollbars=1,width='+ $(window).width() +',height='+$(window).height());
};