var g_url = "joblist.json.php";
var g_currentPage = 1;
var g_pageCounts = 9;

function dataProcess(data)
{
	$("#tablist").find("tbody").empty();

	var recordList = data['data'];
	var recordLength = recordList.length;

	for (rIndex=0; rIndex<recordLength; rIndex++)
	{
		
		
		if(rIndex%2==0){
			
					var row = $('<tr><td  align="center" valign="middle" rel="chk"></td> <td height="30" align="center" valign="middle" rel="id"></td><td  align="left" style="padding-left:10px;" valign="middle" rel="position"></td><td  align="center" valign="middle" rel="language"></td><td  align="center" valign="middle" rel="isshow"></td><td width="8%" align="center" valign="middle" rel="iscommend"></td><td align="center" valign="middle" rel="notetime"></td><td  align="center" valign="middle" rel="endtime"></td><td width="10%" align="center" valign="middle" rel="orderby"></td><td align="center" valign="middle"><a  href="javascript:;" onclick="Edit_id('+recordList[rIndex].ID+')"><img src="../images/33.gif" width="14" height="14" class="img_ico">修改</a> <a href="javascript:;" onclick="Del_id('+recordList[rIndex].ID+')"><img src="../images/11.gif" width="14" height="14" class="img_ico">删除</a></td></tr></tr>');

		}else{
		var row = $('<tr class="two_tr"><td  align="center" valign="middle" rel="chk"></td> <td height="30" align="center" valign="middle" rel="id"></td><td  align="left" style="padding-left:10px;" valign="middle" rel="position"></td><td  align="center" valign="middle" rel="language"></td><td  align="center" valign="middle" rel="isshow"></td><td width="8%" align="center" valign="middle" rel="iscommend"></td><td align="center" valign="middle" rel="notetime"></td><td  align="center" valign="middle" rel="endtime"></td><td width="10%" align="center" valign="middle" rel="orderby"></td><td align="center" valign="middle"><a  href="javascript:;" onclick="Edit_id('+recordList[rIndex].ID+')"><img src="../images/33.gif" width="14" height="14" class="img_ico">修改</a> <a href="javascript:;" onclick="Del_id('+recordList[rIndex].ID+')"><img src="../images/11.gif" width="14" height="14" class="img_ico">删除</a></td></tr></tr>');
		}
		row.find("td[rel=chk]").html('<input type="checkbox" name="chk" value="'+ recordList[rIndex].ID +'">');
		row.find("td[rel=id]").html(recordList[rIndex].ID);
		row.find("td[rel=position]").html('<a href="javascript:;" onclick="showDetail('+ recordList[rIndex].ID +')">'+ recordList[rIndex].POSITION +'</a>');
		row.find("td[rel=language]").html(recordList[rIndex].LANGUAGE);
		row.find("td[rel=isshow]").html(EchoShow(recordList[rIndex].ISSHOW));
		row.find("td[rel=iscommend]").html(EchoShow(recordList[rIndex].ISCOMMEND));
		row.find("td[rel=notetime]").html(recordList[rIndex].NOTETIME);
		row.find("td[rel=endtime]").html(recordList[rIndex].ENDTIME);
		row.find("td[rel=orderby]").html(getOrderByTable(recordList[rIndex].ID,"jobset.php",function(data){AjaxGet(g_url,getParameter(),dataProcess);}));

		RowSelected(row);

		$("#tablist").append(row);
	}

	setPagination(data['counts'],data['pageCounts'],data['page']-1);
}

/*function showDetail(id)
{
	AjaxGet("job.json.php",$.param({id:id}),function(data)
	{
		$("#lblPosition").html(data.POSITION);
		$("#lblSpecialty").html(data.SPECIALTY);
		$("#lblAge").html(data.AGE);
		$("#lblSex").html(data.SEX);
		$("#lblNum").html(data.NUM);
		$("#lblEducational").html(data.EDUCATIONAL);
		$("#lblExperience").html(data.EXPERIENCE);
		$("#lblSalary").html(data.SALARY);
		$("#lblEndtime").html(data.ENDTIME);
		$("#lblOrderby").html(data.ORDERBY);
		$("#lblLanguage").html(data.LANGUAGE);
		$("#lblShow").html(EchoShow(data.ISSHOW));
		$("#lblMemo").html(data.MEMO);

		$.prompt($("#details").html(),{
			buttons:{关闭:'Close'}
		});
	});
}*/
function showDetail(id) {
	AjaxGetCHTML("job.json.php",$.param({id:id}),function(data)
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
	return $.param({page:g_currentPage,pagecounts:g_pageCounts,language:g_language});
}

function jobSet(action,msg)
{
	var checkedVal = CheckBoxSelect(false);
	if (checkedVal != "")
	{
		AjaxSetConfirm(msg,"jobset.php",$.param({action:action,id:checkedVal}),function(data)
		{
			AjaxGet(g_url,getParameter(),dataProcess);
		});
	}
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
		g_language = $("input[name=language]").val();
		g_currentPage = 1;

		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#btnEdit").click(function()
	{
		var checkedVal = CheckBoxSelect(true);
		if (checkedVal != "")
		{
			window.open('jobedit.php?id='+checkedVal,'jobedit','left=0,top=0,scrollbars=1,width='+ $(window).width() +',height='+$(window).height());
		}
	});

	$("#btnShow").click(function()
	{
		jobSet("show","确定要设置为显示吗？");
	});

	$("#btnHide").click(function()
	{
		jobSet("hide","确定要设置为隐藏吗？");
	});

	$("#btnDelete").click(function()
	{
		jobSet("del","确定要删除吗？");
	});

	$("#btnCommend").click(function()
	{
		jobSet("commend","确定要推荐吗？");
	});

	$("#btnUnCommend").click(function()
	{
		jobSet("uncommend","确定要取消推荐吗？");
	});

	$("#btnCareer").click(function()
	{
		
	});

	$("#btnImport").click(function()
	{
		var left = $(window).width()/2-250;
		var top = $(window).height()/2-100;
		window.open('importjob.php','import','left='+left+',top='+top+',width=500,height=200');
	});
});

function Del_id(id){
	
	AjaxSetConfirm("确定要删除吗？","jobset.php",$.param({action:'del',id:id}),function()
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
	
};

function Edit_id(id){
window.open('jobedit.php?id='+id,'jobedit','left=0,top=0,scrollbars=1,width='+ $(window).width() +',height='+$(window).height());
};