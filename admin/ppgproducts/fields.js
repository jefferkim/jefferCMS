var g_url = "fieldlist.json.php";

function dataProcess(data)
{
	$("#table1").find("tbody").empty();

	var recordList = data;
	var recordLength = recordList.length;

	for (rIndex=0; rIndex<recordLength; rIndex++)
	{
		var row = $('<tr align="center" valign="middle"><td width="22" height="25" rel="chk"></td><td></td><td rel="id"></td><td></td><td rel="name"></td><td></td><td rel="field"></td><td></td><td rel="datatype"></td><td></td><td rel="uitype"></td><td></td><td rel="defaultvalue"></td></tr>');

		row.find("td[rel=chk]").html('<input type="checkbox" name="chk" value="'+ recordList[rIndex].ID +'">');
		row.find("td[rel=id]").html(recordList[rIndex].ID);
		row.find("td[rel=name]").html(recordList[rIndex].CALLED);
		row.find("td[rel=field]").html(recordList[rIndex].FIELDNAME);
		row.find("td[rel=datatype]").html(recordList[rIndex].DATATYPE);
		row.find("td[rel=uitype]").html(recordList[rIndex].UITYPE);
		row.find("td[rel=defaultvalue]").html(recordList[rIndex].DEFAULTVALUE);

		RowSelected(row);

		$("#table1").append(row);
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
	return $.param({});
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