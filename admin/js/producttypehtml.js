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

		var uarr = location.pathname.split("/");
		var path = uarr[uarr.length-1];
		var url = path;

		var typediv = $("ul[class=producttype]");
		var temp = typediv.find("a[href="+ url +"]");
		if (temp == "undefined")
		{
			return;
		}
		var level = temp.parent().attr("class").replace("producttype","");
		for(index=level; index>0; index--)
		{
			temp.parent().find(".producttype"+index).show();
			temp = temp.parent().parent();
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