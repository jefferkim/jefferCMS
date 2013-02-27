var g_url = "orderlist.json.php";
var g_currentPage = 1;
var g_pageCounts = 15;
var g_startDate = "";
var g_endDate = "";

function Del_id(id){
	
	AjaxSetConfirm("确定要删除吗？","orderset.php",$.param({action:'del',id:id}),function()
			{
				window.location.href="order.php";
			});
	
}

/*function showDetail(id)
{
	AjaxGet("order.json.php",$.param({id:id}),function(data)
	{
		var order = data['order'];
		var detailList = data['details'];
		var detailLength = detailList.length;

		$("#lblName").html(order.NAME);
		$("#lblEmail").html(order.MAIL);
		$("#lblTel").html(order.TEL);
		$("#lblMobile").html(order.MOBILE);
		$("#lblNoteTime").html(order.NOTETIME);
		$("#lblLanguage").html(order.LANGUAGE);
		$("#lblCompany").html(order.COMPANY);
		$("#lblAddress").html(order.ADDRESS);
		$("#lblMemo").html(order.MEMO);

		$("#orderdetails").find("tbody").empty();
		for (rIndex=0; rIndex<detailLength; rIndex++)
		{
			var row = $('<tr><td rel="pname"></td><td rel="num"></td><td rel="price"></td><td rel="memo"></td></tr>');

			row.find("td[rel=pname]").html(detailList[rIndex].PRODUCTNAME);
			row.find("td[rel=num]").html(detailList[rIndex].NUMS);
			row.find("td[rel=price]").html(detailList[rIndex].PRICE);
			row.find("td[rel=memo]").html('<pre class="nostyle">'+ detailList[rIndex].MEMO +'</pre>');

			$("#orderdetails").append(row);
		}

		var detail = $("#details").clone();
		var customer = data['customer'];
		var customerLength = customer.length;
		for (rIndex = 0; rIndex<customerLength; rIndex++)
		{
			detail.find("table:first").append("<tr><td>"+ customer[rIndex][0] +"：</td><td colspan='3'>"+ customer[rIndex][1] +"</td></tr>");
		}

		$.prompt(detail.html(),{
			buttons:{关闭:'Close'}
		});
	});
}
*/



function getParameter()
{
	return $.param({page:g_currentPage,pagecounts:g_pageCounts,language:g_language,startdate:g_startDate,enddate:g_endDate});
}

$(function()
{
	$("input[name=startdate]").datepicker();
	$("input[name=enddate]").datepicker();

	AjaxGet(g_url,getParameter(),dataProcess);

	$("#btnRefresh").click(function()
	{
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#chk").click(CheckAll);

	$("#btnSelect").click(function()
	{
		g_language = $("select[name=language]").val();
		g_startDate = $("input[name=startdate]").val();
		g_endDate = $("input[name=enddate]").val();
		g_currentPage = 1;

		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#btnDelete").click(function()
	{
		var checkedVal = CheckBoxSelect();
		if (checkedVal != "")
		{
			AjaxSetConfirm("确定要删除吗？","orderset.php",$.param({action:'del',id:checkedVal}),function(data)
			{
				window.location.href="order.php";
			});
		}
	});
});