$(function()
{
	$("li[class*=producttype]").mouseover(function()
	{
		var i = parseInt($(this).attr("class").replace("producttype",""))+1;
		//alert(i);
		var obj = $(this).next().find("ul");
		if (obj.html() != null)
		{
			var panel = obj.find(".producttype" + i);
            panel.show();
		}

		//return false;
	});
})