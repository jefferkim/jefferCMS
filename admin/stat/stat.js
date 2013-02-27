var g_url = "statlist.json.php";
var g_currentPage = 1;
var g_pageCounts = 12;
var g_startDate = "";
var g_endDate = "";
function dataProcess(data)
{
	$("#tablist").find("tbody").empty();

	var recordList = data['data'];
	var recordLength = recordList.length;

	for (rIndex=0; rIndex<recordLength; rIndex++)
	{
		
		if(rIndex%2==0){
		var row = $(' <tr align="center" valign="middle"><td rel="id" height="30"></td><td rel="ip"></td><td rel="dest"></td><td rel="ref" align="left" style="padding-left:10px;"></td><td rel="os"></td><td rel="browser"></td></tr>');
		}else{
			
			var row = $(' <tr align="center" valign="middle" class="two_tr"><td rel="id" height="30"></td><td rel="ip"></td><td rel="dest"></td><td rel="ref" align="left" style="padding-left:10px;"></td><td rel="os"></td><td rel="browser"></td></tr>');
		}

		row.find("td[rel=chk]").html('<input type="checkbox" name="chk" value="'+ recordList[rIndex].ID +'">');
		row.find("td[rel=id]").html(recordList[rIndex].ID);
		row.find("td[rel=ip]").html(recordList[rIndex].IP);
		row.find("td[rel=ref]").html(recordList[rIndex].REFPAGE);
		row.find("td[rel=dest]").html(recordList[rIndex].VIEWPAGE);
		row.find("td[rel=os]").html(recordList[rIndex].OS);
		row.find("td[rel=browser]").html(recordList[rIndex].BROWSER);
		
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
		next_text : ">",
		prev_text : "<",
		callback : function(newpage,container){
			g_currentPage = newpage + 1;
			AjaxGet(g_url,getParameter(),dataProcess);
		}
	});
}

function getParameter()
{
	
	return $.param({
		page:g_currentPage,
		pagecounts:g_pageCounts,
		startdate:g_startDate,
		enddate:g_endDate
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
		g_language = $("select[name=language]").val();
		g_currentPage = 1;

		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#btnEdit").click(function()
	{
		var checkedVal = CheckBoxSelect(true);
		if (checkedVal != "")
		{
			window.open('edit.php?id='+checkedVal,'edit','top=0,left=0,scrollbars=1,width='+$(window).width()+',height='+$(window).height());
			//window.location.href = 'edit.php?id='+checkedVal;
		}
	});

	$("#btnDelete").click(function()
	{
		var checkedVal = CheckBoxSelect(false);
		if (checkedVal != "")
		{
			AjaxSetConfirm("确定要删除吗？","save.php",$.param({action:'del',id:checkedVal}),function()
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
		}
	});

	$("#chk").click(CheckAll);
})

function Del_id(id){
	
	AjaxSetConfirm("确定要删除吗？","save.php",$.param({action:'del',id:id}),function()
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
	
}

function Edit_id(id){
	
	window.open('edit.php?id='+id,'edit','top=0,left=0,scrollbars=1,width='+$(window).width()+',height='+$(window).height());
	
}