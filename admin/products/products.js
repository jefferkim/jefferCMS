var g_url = "products.json.php";
var g_currentPage = 1;
var g_pageCounts = 11;
var g_show = "";
var g_commend = "";
var g_type = "";
var g_keyword = "";
function dataProcess(data)
{
	$("#tablist").find("tbody").empty();

	var recordList = data['data'];
	var recordLength = recordList.length;

	for (rIndex=0; rIndex<recordLength; rIndex++)
	{
		if(rIndex%2==0){
		
		var row = $('<tr><td align="center" valign="middle" rel="chk"></td><td height="30" align="center" valign="middle" rel="id"></td><td align="center" valign="middle" rel="ordernum"></td><td align="center" valign="middle" rel="name"></td><td align="center" valign="middle" rel="picurl"></td><td align="center" valign="middle" rel="language"></td><td align="center" valign="middle" rel="isshow"></td><td align="center" valign="middle" rel="iscommend"></td><td align="center" valign="middle" rel="orderby"></td><td align="center" valign="middle"><a  href="javascript:;" onclick="Edit_id('+recordList[rIndex].ID+')"><img src="../images/33.gif" width="14" height="14" class="img_ico">修改</a> <a href="javascript:;" onclick="Del_id('+recordList[rIndex].ID+')"><img src="../images/11.gif" width="14" height="14" class="img_ico">删除</a> <a href="#" onclick="MyWin.Create('+ recordList[rIndex].ID +','+"'yes'"+','+"'产品相关图片'"+','+"'[pg]../imgture/imgture.php?pid='"+','+"'800'"+','+"'480'"+');"><img src="../images/44.gif" width="14" height="14" class="img_ico">相关图片</a></td></tr>');
		
		}else{
			
		var row = $('<tr class="two_tr"><td align="center" valign="middle" rel="chk"></td><td height="30" align="center" valign="middle" rel="id"></td><td align="center" valign="middle" rel="ordernum"></td><td align="center" valign="middle" rel="name"></td><td align="center" valign="middle" rel="picurl"></td><td align="center" valign="middle" rel="language"></td><td align="center" valign="middle" rel="isshow"></td><td align="center" valign="middle" rel="iscommend"></td><td align="center" valign="middle" rel="orderby"></td><td align="center" valign="middle"><a  href="javascript:;" onclick="Edit_id('+recordList[rIndex].ID+')"><img src="../images/33.gif" width="14" height="14" class="img_ico">修改</a> <a href="javascript:;" onclick="Del_id('+recordList[rIndex].ID+')"><img src="../images/11.gif" width="14" height="14" class="img_ico">删除</a> <a href="#" onclick="MyWin.Create('+ recordList[rIndex].ID +','+"'yes'"+','+"'产品相关图片'"+','+"'[pg]../imgture/imgture.php?pid='"+','+"'800'"+','+"'480'"+');"><img src="../images/44.gif" width="14" height="14" class="img_ico">相关图片</a></td></tr>');	
			
		}

		row.find("td[rel=chk]").html('<input type="checkbox" name="chk" value="'+ recordList[rIndex].ID +'">');
		row.find("td[rel=id]").html(recordList[rIndex].ID);
		row.find("td[rel=ordernum]").html('<input type="hidden" name="pid" value="'+ recordList[rIndex].ID +'"><input type="text" size="3" name="ordernum" value="'+ recordList[rIndex].ORDERBY +'" class="sys_input" style=" width:40px;">');
		row.find("td[rel=name]").html('<input type="text" name="pname" value="'+ recordList[rIndex].PRONAME +'" class="sys_input" style=" width:160px;">');
		row.find("td[rel=picurl]").html('<a href="#" onclick="MyWin.Create('+ recordList[rIndex].ID +','+"'yes'"+','+"'产品小图修改'"+','+"'[pg]../extupload/propic.php?id='"+','+"'542'"+','+"'188'"+');">' + recordList[rIndex].SMALLPIC + '</a>');
		row.find("td[rel=language]").html(recordList[rIndex].LANGUAGE);
		row.find("td[rel=isshow]").html(EchoShow(recordList[rIndex].ISSHOW));
		row.find("td[rel=iscommend]").html(EchoShow(recordList[rIndex].ISCOMMEND));
		row.find("td[rel=orderby]").html(getOrderByTable(recordList[rIndex].ID,"productset.php",function(data){AjaxGet(g_url,getParameter(),dataProcess)}));

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
		num_display_entries : 4,
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

function ChangeProductsType(lan)
{
	ChangeType("typeselectlist.json.php",$.param({language:lan}),$("select[name=type]"),true);
}

$(function()
{
	AjaxGet(g_url,getParameter(),dataProcess);
	ChangeProductsType($("select[name=language]").val());

	$("select[name=language]").change(function()
	{
		ChangeProductsType($(this).val());
		g_language = $(this).val();
		g_type = "";
		g_currentPage = 1;
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("select[name=type]").change(function()
	{
		g_type = $(this).val();
		g_currentPage = 1;
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("select[name=selShow]").change(function()
	{
		g_show = $(this).val();
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
			AjaxSet("productset.php",$.param({action:'order',id:checkedId.join(','),order:checkedOrderVal.join(','),pname:checkedProVal.join('|')}),function(data)
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


function Del_id(id){
	AjaxSetConfirm("确定要删除选中的产品吗？","productset.php",$.param({action:'del',id:id}),function(data)
				{
					AjaxGet(g_url,getParameter(),dataProcess);
				});

};

function Edit_id(id){
	
	window.open('productedit.php?id='+id,'proedit','top=0,left=0,scrollbars=1,width='+ $(window).width() +',height='+$(window).height());
	
};