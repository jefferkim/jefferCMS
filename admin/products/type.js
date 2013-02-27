var g_currentPage = 1;
var g_pageCounts = 9;
var g_type = "";
var g_url = "typelist.json.php";

function dataProcess(data)
{
	$("#tablist").find("tbody").empty();

	var recordList = data['data'];
	var recordLength = recordList.length;

	for (rIndex=0; rIndex<recordLength; rIndex++)
	{
		
		if(rIndex%2==0){
			
			var row = $('<tr><td align="center" valign="middle" rel="chkbox"></td><td height="30" align="center" valign="middle" rel="id"></td> <td align="left" style="padding-left:10px;" valign="middle" rel="called"></td><td align="center" valign="middle" rel="isshow"></td><td align="center" valign="middle" rel="language"></td><td align="center" valign="middle" rel="parent"></td><td align="center" valign="middle" rel="order"></td><td align="center" valign="middle"><a  href="javascript:;" onclick="Edit_id('+recordList[rIndex].ID+')"><img src="../images/33.gif" width="14" height="14" class="img_ico">修改</a> <a href="javascript:;" onclick="Del_id('+recordList[rIndex].ID+')"><img src="../images/11.gif" width="14" height="14" class="img_ico">删除</a></td></tr>');
			
		}else{
		var row = $('<tr class="two_tr"><td align="center" valign="middle" rel="chkbox"></td><td height="30" align="center" valign="middle" rel="id"></td> <td align="left" style="padding-left:10px;" valign="middle" rel="called"></td><td align="center" valign="middle" rel="isshow"></td><td align="center" valign="middle" rel="language"></td><td align="center" valign="middle" rel="parent"></td><td align="center" valign="middle" rel="order"></td><td align="center" valign="middle"><a  href="javascript:;" onclick="Edit_id('+recordList[rIndex].ID+')"><img src="../images/33.gif" width="14" height="14" class="img_ico">修改</a> <a href="javascript:;" onclick="Del_id('+recordList[rIndex].ID+')"><img src="../images/11.gif" width="14" height="14" class="img_ico">删除</a></td></tr>');
		}
		row.find("td[rel=chkbox]").html('<input type="checkbox" name="chk" value="'+ recordList[rIndex].ID +'">');
		row.find("td[rel=id]").html(recordList[rIndex].ID);
		row.find("td[rel=called]").html(recordList[rIndex].CALLED);
		row.find("td[rel=isshow]").html(EchoShow(recordList[rIndex].ISSHOW));
		row.find("td[rel=language]").html(recordList[rIndex].LANGUAGE);
		row.find("td[rel=parent]").html(recordList[rIndex].PARENTPATH);
		row.find("td[rel=order]").html(getOrderByTable(recordList[rIndex].ID,"typeset.php",function(data){AjaxGet(g_url,getParameter(),dataProcess)}));

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
	return $.param({page:g_currentPage,pagecounts:g_pageCounts,language:g_language,type:g_type});
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

	$("#btnSelect").click(function()
	{
		g_currentPage = 1;
		g_language = $("input[name='language']").val();
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
			window.open('typeedit.php?id='+checkedVal,'typeedit','top=0,left=0,scrollbars=1,width='+$(window).width()+',height='+$(window).height());
		}
	});

	$("#btnDelete").click(function()
	{
		var checkedVal = CheckBoxSelect(false);
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

	$("#btnImportType").click(function()
	{
		var left = $(window).width()/2-250;
		var top = $(window).height()/2-100;
		window.open('productimporttype.php','import','left='+left+',top='+top+',width=500,height=200');
	});
})


function Del_id(id){
	
			if (window.confirm("确定要删除吗？"))
			{
				var data = "action=del";
				if (window.confirm("是否要把所有子分类及其产品全部删除？"))
				{
					data += "&cascade=true";
				}
				data += "&id="+id;

				AjaxSet("typeset.php",data,function(data)
				{
					AjaxGet(g_url,getParameter(),dataProcess);
				});
			}
	
	
};

function Edit_id(id){
	
		window.open('typeedit.php?id='+id,'typeedit','top=0,left=0,scrollbars=1,width='+$(window).width()+',height='+$(window).height());
	
};