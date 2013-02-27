var g_url = "fieldlist.json.php";

function dataProcess(data)
{
	$("#tablist").find("tbody").empty();

	var recordList = data;
	var recordLength = recordList.length;

	for (rIndex=0; rIndex<recordLength; rIndex++)
	{
		if(rIndex%2==0){
	
		var row = $('<tr><td align="center" valign="middle" rel="chk"></td><td height="30" align="center" valign="middle" rel="id"></td><td align="center" valign="middle"rel="name"></td><td align="center" valign="middle" rel="field"></td><td align="center" valign="middle" rel="datatype"></td><td align="center" valign="middle" rel="uitype"></td><td align="center" valign="middle" rel="defaultvalue"></td><td align="center" valign="middle"><a href="#" onclick="del_id('+recordList[rIndex].ID+');"><img src="../images/11.gif" width="14" height="14" class="img_ico">删除</a></td></tr>');
		}else{
			
			var row = $('<tr class="two_tr"><td align="center" valign="middle" rel="chk"></td><td height="30" align="center" valign="middle" rel="id"></td><td align="center" valign="middle"rel="name"></td><td align="center" valign="middle" rel="field"></td><td align="center" valign="middle" rel="datatype"></td><td align="center" valign="middle" rel="uitype"></td><td align="center" valign="middle" rel="defaultvalue"></td><td align="center" valign="middle"><a href="#" onclick="del_id('+recordList[rIndex].ID+');"><img src="../images/11.gif" width="14" height="14" class="img_ico">删除</a></td></tr>');
			
		}

		row.find("td[rel=chk]").html('<input type="checkbox" name="chk" value="'+ recordList[rIndex].ID +'">');
		row.find("td[rel=id]").html(recordList[rIndex].ID);
		row.find("td[rel=name]").html(recordList[rIndex].CALLED);
		row.find("td[rel=field]").html(recordList[rIndex].FIELDNAME);
		row.find("td[rel=datatype]").html(recordList[rIndex].DATATYPE);
		row.find("td[rel=uitype]").html(recordList[rIndex].UITYPE);
		row.find("td[rel=defaultvalue]").html(recordList[rIndex].DEFAULTVALUE);

		RowSelected(row);

		$("#tablist").append(row);
	}
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
	return $.param({table:tableName});
}

$(function()
{
	AjaxGet(g_url,getParameter(),dataProcess);

	$("#btnRefresh").click(function()
	{
		AjaxGet(g_url,getParameter(),dataProcess);
	});

	$("#btnDelete").click(function()
	{
		var checkedVal = CheckBoxSelect(true);
		if (checkedVal != "")
		{
			AjaxSetConfirm("确定要删除吗？","fieldsave.php",$.param({action:'del',id:checkedVal}),function(data)
			{
				AjaxGet(g_url,getParameter(),dataProcess);
			});
		}
	});
})


function del_id(id){
	
	
	AjaxSetConfirm("确定要删除吗？","fieldsave.php",$.param({action:'del',id:id}),
	
	function(data){
				AjaxGet(g_url,getParameter(),dataProcess);
			});
	
}