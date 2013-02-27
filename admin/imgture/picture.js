var g_url = "picturelist.json.php";
var g_currentPage = 1;
var g_pageCounts = 12;	

var pid = "";

function dataProcess(data)
{
	var jsonStr="";
	var recordList = data['data'];
	var recordLength = recordList.length;
	for (rIndex=0; rIndex<recordLength; rIndex++)
	{
		 
        jsonStr += '<li><a href="javascript:void(0)" class="pic_a" rel="example1"><img src="../../upload/'+recordList[rIndex].PICURL+'"/></a><a class="del_a" href="javascript:;" onclick="Del_id('+recordList[rIndex].ID+')"><img src="../uploadify/cancel.png" width="16" height="16" class="img_ico" style=" width:16px; height:16px; display:block"></a></li>'; 

	}
	$("#tablist").html(jsonStr);

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
	return $.param({
		page : g_currentPage,
		pagecounts : g_pageCounts,
		pid :proid,
		language : g_language
	});
}

function getRefresh(){
	    
		AjaxGet(g_url,getParameter(),dataProcess);
	
}

$(function()
{
	AjaxGet(g_url,getParameter(),dataProcess);
	$("select[name=language]").change(function()
	{
		g_language = $(this).val();
		
		pid =$("input[name=proid").val;
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

        $("input[name=pid]").each(function()
        {
            id_array.push($(this).val());
        });
        $("input[name=order]").each(function()
        {
            order_array.push($(this).val());
        });

        if (id_array.length == order_array.length)
        {
            AjaxSet("pictureset.php",$.param({action:'order',id:id_array.join(','),order:order_array.join(',')}),function(data)
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
	
}
