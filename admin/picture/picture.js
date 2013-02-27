var g_url = "picturelist.json.php";
var g_currentPage = 1;
var g_pageCounts = 9;
var g_type = "";

function dataProcess(data)
{
	$("#tablist").find("tbody").empty();
	var recordList = data['data'];
	var recordLength = recordList.length;

	for (rIndex=0; rIndex<recordLength; rIndex++)
	{
		
		if(rIndex%2==0){
			
				var row = $('<tr><td align="center" valign="middle" rel="chk"></td><td height="30" align="center" valign="middle" rel="id"></td><td align="center" valign="middle" rel="order"></td><td align="left" style="padding-left:5px;" valign="middle" rel="name"></td><td align="center" valign="middle" rel="type"></td><td align="center" valign="middle" rel="language"></td> <td align="center" valign="middle" rel="isshow"></td><td align="center" valign="middle" rel="iscommend"></td><td align="center" valign="middle" rel="spic"></td><td align="center" valign="middle" rel="orderby"></td><td align="center" valign="middle"><a  href="javascript:;" onclick="Edit_id('+recordList[rIndex].ID+')"><img src="../images/33.gif" width="14" height="14" class="img_ico">修改</a> <a href="javascript:;" onclick="Del_id('+recordList[rIndex].ID+')"><img src="../images/11.gif" width="14" height="14" class="img_ico">删除</a></td></tr>');
			
		}else{
			
		var row = $('<tr class="two_tr"><td align="center" valign="middle" rel="chk"></td><td height="30" align="center" valign="middle" rel="id"></td><td align="center" valign="middle" rel="order"></td><td align="left" style="padding-left:5px;" valign="middle" rel="name"></td><td align="center" valign="middle" rel="type"></td><td align="center" valign="middle" rel="language"></td> <td align="center" valign="middle" rel="isshow"></td><td align="center" valign="middle" rel="iscommend"></td><td align="center" valign="middle" rel="spic"></td><td align="center" valign="middle" rel="orderby"></td><td align="center" valign="middle"><a  href="javascript:;" onclick="Edit_id('+recordList[rIndex].ID+')"><img src="../images/33.gif" width="14" height="14" class="img_ico">修改</a> <a href="javascript:;" onclick="Del_id('+recordList[rIndex].ID+')"><img src="../images/11.gif" width="14" height="14" class="img_ico">删除</a></td></tr>');
		}
		
		
		row.find("td[rel=chk]").html('<input type="checkbox" name="chk" value="'+ recordList[rIndex].ID +'">');
		row.find("td[rel=id]").html(recordList[rIndex].ID);
        row.find("td[rel=order]").html('<input type="hidden"  name="pid" value="'+recordList[rIndex].ID+'"><input type="text" name="order" value="'+ recordList[rIndex].ORDERBY +'"  class="sys_input" style=" width:50px;">');
		row.find("td[rel=name]").html('<input type="text" name="pname" value="'+ recordList[rIndex].PICNAME +'" class="sys_input" style=" width:120px;">');
		row.find("td[rel=type]").html(recordList[rIndex].TYPEID);
		row.find("td[rel=language]").html(recordList[rIndex].LANGUAGE);
		row.find("td[rel=isshow]").html(EchoShow(recordList[rIndex].ISSHOW));
		row.find("td[rel=iscommend]").html(EchoShow(recordList[rIndex].ISCOMMEND));
		row.find("td[rel=spic]").html('<a href="#" onclick="MyWin.Create('+ recordList[rIndex].ID +');">' + recordList[rIndex].PICURL + '</a>');
		row.find("td[rel=orderby]").html(getOrderByTable(recordList[rIndex].ID,"pictureset.php",function(data){AjaxGet(g_url,getParameter(),dataProcess)}));

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
	return $.param({
		page : g_currentPage,
		pagecounts : g_pageCounts,
		type : g_type,
		language : g_language
	});
}

function ChangePicType(lan)
{
	ChangeType("typelist.json.php",$.param({language:lan}),$("select[name=type]"),true);
}

$(function()
{
	AjaxGet(g_url,getParameter(),dataProcess);
	ChangePicType($("select[name=language]").val());

	$("select[name=language]").change(function()
	{
		ChangePicType($(this).val());
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

	$("#btnRefresh").click(function()
	{
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#chk").click(CheckAll);

	$("#btnSelect").click(function()
	{
		g_language = $("select[name=language]").val();
		g_type = $("select[name=type]").val();
		g_currentPage = 1;

		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#btnEdit").click(function()
	{
		var checkedVal = CheckBoxSelect(true);
		if (checkedVal != "")
		{
		window.open('picedit.php?id='+checkedVal,'picedit','top=0,left=0,scrollbars=1,width='+ $(window).width() +',height='+$(window).height());
		}
	});

	$("#btnShow").click(function()
	{
		var checkedVal = CheckBoxSelect(false);
		if (checkedVal != "")
		{
			AjaxSetConfirm("确定要设置为显示吗？","pictureset.php",$.param({action:'show',id:checkedVal}),function()
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
		}
	});

	$("#btnHide").click(function()
	{
		var checkedVal = CheckBoxSelect(false);
		if (checkedVal != "")
		{
			AjaxSetConfirm("确定要设置为隐藏吗？","pictureset.php",$.param({action:'hide',id:checkedVal}),function()
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
			AjaxSetConfirm("确定要删除吗？","pictureset.php",$.param({action:'del',id:checkedVal}),function()
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
			AjaxSetConfirm("确定要推荐吗?","pictureset.php",$.param({action:'commend',id:checkedVal}),function()
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
			AjaxSetConfirm("确定要取消推荐吗?","pictureset.php",$.param({action:'uncommend',id:checkedVal}),function()
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
		}
	});

	$("#btnImport").click(function()
	{
		var left = $(window).width()/2-250;
		var top = $(window).height()/2-100;
		window.open('importpicture.php','import','left='+left+',top='+top+',width=500,height=200');
	});

    $("#btnOrder").click(function()
    {
        var id_array = Array();
        var order_array = Array();
		var pname_array = Array();

        $("input[name=pid]").each(function()
        {
            id_array.push($(this).val());
        });
        $("input[name=order]").each(function()
        {
            order_array.push($(this).val());
        });
		
        $("input[name=pname]").each(function()
		{
			pname_array.push($(this).val());
		});
		
        if ((id_array.length == order_array.length) && (id_array.length == pname_array.length) && id_array.length > 0)
        {
            AjaxSet("pictureset.php",$.param({action:'order',id:id_array.join(','),order:order_array.join(','),panme:pname_array.join(',')}),function(data)
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
        }
    });
})

function Del_id(id){
	
	AjaxSetConfirm("确定要删除吗？","pictureset.php",$.param({action:'del',id:id}),function()
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
	
};

function Edit_id(id){
window.open('picedit.php?id='+id,'picedit','top=0,left=0,scrollbars=1,width='+ $(window).width() +',height='+$(window).height());
};