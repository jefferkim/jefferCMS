$(function()
{
	$("li[class*=producttype]").click(function()
	{
		for(i=1; i<10; i++)
		{
			var obj = $("#producttype0").find("li[class=producttype"+ i +"]");
			if (obj)
			{
				obj.hide();
			}
		}

		var i = parseInt($(this).attr("class").replace("producttype",""))+1;
		//alert(i);
		var obj = $(this).next().find("ul");
		if (obj.html() != null)
		{
			obj.find(".producttype" + i).show();
		}
		else
		{
			window.location.href = $(this).find("a").attr("href");
		}

		return false;
	}/*,function()
	{
		var i = parseInt($(this).attr("class").replace("producttype",""))+1;
		var obj = $(this).next().find("ul");
		if (obj.html() != null)
		{
			obj.find(".producttype" + i).hide();
		}
		else
		{
			window.location.href = $(this).find("a").attr("href");
		}
	}*/);
})