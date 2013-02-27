//更改语言时的分类连动
function ChangeType(typeUrl,param,typeObj,appendEmpty)
{
	AjaxGet(typeUrl,param,function(data)
	{
		typeList = data['data'];
		typeObj.empty();
		if (appendEmpty)
		{
			typeObj.append('<option value="">请选择</option>');
		}
		for (i=0; i<typeList.length; i++)
		{
			typeObj.append('<option value="'+ typeList[i].ID +'">'+ typeList[i].CALLED +'('+ typeList[i].LANGUAGE +')</option>');
		}
	});
}

//
function CheckLinker(linker,single,idparam)
{
	var checkedVal = CheckBoxSelect(single);

	if (checkedVal != "")
	{
		window.location.href = linker + '&' + idparam + '=' + checkedVal;
	}
}

function CheckOperation(linker,single,idparam,showalert)
{
	var checkedVal = CheckBoxSelect(single);
	
	if (checkedVal != "")
	{
		if (showalert)
		{
			if (!window.confirm('确定执行此操作吗？'))
			{
				return;
			}
		}
		window.location.href = linker + '&' + idparam + '=' + checkedVal;
	}
}

//选中全部多选框

function CheckAll()
{
	$("input[type=checkbox]").each(function()
	{
		if ($(this).attr("checked"))
		{
			$(this).attr("checked",false);
			$(this).parent().parent().removeClass("selectedtr");
		}
		else
		{
			$(this).attr("checked",true);
			$(this).parent().parent().addClass("selectedtr");
		}
	});
}


//选中行时更改颜色
function RowSelected(row)
{
	row.find("td:not(:first)").click(function()
	{
		var input = $(this).parent().find("input[type='checkbox']");
		if (input.attr("checked"))
		{
			input.attr("checked",false);
			$(this).parent().removeClass("selectedtr");
		}
		else
		{
			input.attr("checked",true);
			$(this).parent().addClass("selectedtr");
		}
	});
	row.find("td input[type='checkbox']").click(function(){
		if($(this).attr("checked")){
			$(this).parent().parent().addClass("selectedtr");
		}else{
			$(this).parent().parent().removeClass("selectedtr");
		}
	});
	row.mouseover(function(){
		if($(this).attr("class") !='selectedtr'){
			$(this).addClass("c1");
		}											   
	}).mouseout(function(){
		if($(this).attr("class") !='selectedtr'){
			$(this).removeClass("c1");
		}											   
	});
}

//清除页面上输入框里的内容
function ClearInput()
{
	$("input[type=text]").each(function()
	{
		$(this).val('');
	});

	$("textarea").each(function()
	{
		$(this).val('');
	});
}

//输出是否
function EchoShow(val)
{
	retStr = "";
	if (val == 1)
	{
		retStr = "是";
	}
	else
	{
		retStr = "否";
	}

	return retStr;
}

//排序移动
function move(id,action,url,process)
{
	var data = "action="+ action +"&id="+id;
	AjaxSet(url,data,process);
}

//排序上移一位
function movePrev(id,url,process)
{
	move(id,"moveprev",url,process);
}

//排序下移一位
function moveNext(id,url,process)
{
	move(id,"movenext",url,process);
}

//排序移到首位
function moveFirst(id,url,process)
{
	move(id,"movefirst",url,process);
}

//排序移到未位
function moveLast(id,url,process)
{
	move(id,"movelast",url,process);
}

//返回一个包含排序点击连接的表格
function getOrderByTable(id,url,process)
{
	var retStr = "<table border='0' cellspacing='0' cellpadding='0'><tr><td><a href='javascript:;' onclick='movePrev(\""+ id +"\",\""+ url +"\","+ process +")'><img src='../images/arrow2.jpg' width='8' height='6' border='0' /></a></td><td width=1></td><td><a href='javascript:;' onclick='moveFirst(\""+ id +"\",\""+ url +"\","+ process +")'><img src='../images/arrow.jpg' width='8' height='8' border='0'/></a></td></tr><tr><td height=3></td></tr><tr><td><a href='javascript:;' onclick='moveNext(\""+ id +"\",\""+ url +"\","+ process +")'><img src='../images/arrow3.jpg' width='8' height='6' border='0' /></a></td><td width=1></td><td><a href='javascript:;' onclick='moveLast(\""+ id +"\",\""+ url +"\","+ process +")'><img src='../images/arrow1.jpg' width='8' height='8' border='0' /></a></td></tr></table>";

	return retStr;
}

//选择多选框，并返回选中的值，多个值之间用逗号分隔开
function CheckBoxSelect(single)
{
	var checkedCount = 0;
	var checkedVal = "";

	$("input[type=checkbox]").each(function()
	{
		if ($(this).attr("checked"))
		{
			if (checkedCount == 0)
			{
				checkedVal = $(this).val();
			}
			else
			{
				checkedVal += "," + $(this).val();
			}
			checkedCount++;
		}
	});

	if (checkedCount < 1)
	{
		alert("必须选择一项才能操作");
		return "";
	}
	if (single && checkedCount >1)
	{
		alert("只能选择一项进行操作");
		return "";
	}

	return checkedVal;
}

//对选中的checkbox以ajax方式设置
function AjaxSetConfirm(msg,url,data,process)
{
	if (window.confirm(msg))
	{
		AjaxSet(url,data,process);
	}
}

//提交
function AjaxSet(url,data,process)
{
	$.ajax({
		type : 'POST',
		url : url,
		data : data,
		dataType : "json",
		success : process,
		error : function()
		{
			alert("连接超时，请重新登录");
		}
	});
}

//ajax方式读取数据列表
function AjaxGet(url,data,processFunction)
{
	$.ajax({
		type : "POST",
		url : url,
		data : data,
		dataType : "json",
		success : processFunction,
		error : function()
		{
			alert("连接超时，请重新登录");
		}
	});
}
//ajax方式读取页面HTML内容
function AjaxGetCHTML(url,data,processFunction)
{
	$.ajax({
			type : 'post',
			url : url,
			data : data,
			dataType : 'text',
			success : processFunction,
			error : function()
			{
				alert("连接超时，请重新登录");
			}
		});
}

$(document).ajaxStart(function(){$.blockUI({message:'<div style="display: block;" id="loadingd"><div id="loading_msg" class="loading-indicator">正在载入，请稍候...</div></div>',css:{width:'160px',border:'none'},overlayCSS:{opacity:'0'}});}).ajaxStop($.unblockUI);

function Hashtable()
{
	this._hash        = new Object();
    this.add        = function(key,value){
                        if(typeof(key)!="undefined"){
                            if(this.contains(key)==false){
                                this._hash[key]=typeof(value)=="undefined"?null:value;
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    }
    this.remove        = function(key){delete this._hash[key];}
    this.count        = function(){var i=0;for(var k in this._hash){i++;} return i;}
    this.items        = function(key){return this._hash[key];}
    this.contains    = function(key){ return typeof(this._hash[key])!="undefined";}
    this.clear        = function(){for(var k in this._hash){delete this._hash[k];}}

}
