$(function()
{
	/*$("li[class*=producttype]").toggle(function()
	{
		var i = parseInt($(this).attr("class").replace("producttype",""))+1;
		var obj = $(this).next().find("ul");
		if (obj.html() != null)
		{
			obj.find(".producttype"+i).show();
		}
		else
		{
			window.location.href = $(this).find("a").attr("href");
		}
	},function()
	{
		var i = parseInt($(this).attr("class").replace("producttype",""))+1;
		var obj = $(this).next().find("ul");
		if (obj.html() != null)
		{
			for (index=i; index<10; index++)
			{
				var temp = obj.find(".producttype"+index);
				if (temp != null)
				{
					temp.hide();
				}
			}
		}
		else
		{
			window.location.href = $(this).find("a").attr("href");
		}
	});*/

	var tid = QueryString("tid");
	if (tid != null)
	{
		//$("a[href*=tid="+ tid +"]").parent().parent().parent().find("li[class*=producttype]").show();
        var uarr = location.pathname.split("/");
        var path = uarr[uarr.length-1];
        var url = path + location.search;
        var typediv = $("ul[class=producttype]");
		var temp = typediv.find("a[href="+ url +"]");
		if (temp == "undefined")
		{
			return;
		}
		var tarr = temp.attr("href").split("?");
		var url = tarr[0];
        var param_arr = tarr[1].split("&");
        var param_arr1 = new Array();
        for(itmp=0; itmp<param_arr.length; itmp++)
        {
            if (param_arr[itmp] != "tid="+tid)
            {
                param_arr1.push(param_arr[itmp]);
            }
        }
        var param_tmp = param_arr1.join('&');
        if (param_tmp != "")
		    temp = typediv.find("a[href="+ url +"?tid="+ tid +"&"+ param_tmp +"]").parent();
        else
            temp = typediv.find("a[href="+ url +"?tid="+ tid +"]").parent();

        var cls_arr = temp.attr("class").split(' ');
        var i = parseInt(cls_arr[0].replace('producttype',''));
        var level = 0;
        if (!isNaN(i))
            level = i + 1;
		var child = $("#producttype"+tid);
		if (child != null)
		{
			child.find(".producttype"+ level).show();
		}

		/*temp = temp.parent();*/

		for (index=i; index>0; index--)
		{
			temp.parent().find(".producttype"+ index).show();
			temp = temp.parent().parent();
		}
	}
});

function QueryString(fieldName)
{
  var urlString = document.location.search;
  if(urlString != null)
  {
	   var typeQu = fieldName+"=";
	   var urlEnd = urlString.indexOf(typeQu);
	   if(urlEnd != -1)
	   {
			var paramsUrl = urlString.substring(urlEnd+typeQu.length);
			var isEnd =  paramsUrl.indexOf('&');
			if(isEnd != -1)
			{
				 return paramsUrl.substring(0, isEnd);
			}
			else
			{
				return paramsUrl;
			}
	   }
	   else
	   {
			return null;
	   }
  }
 else
 {
	return null;
 }
}