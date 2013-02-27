$(function()
{
	$("li[class*=producttype]").toggle(function()
	{
		var i = parseInt($(this).attr("class").replace("producttype",""))+1;
		//alert(i);
		//alert($(this).next().html());
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
	},function()
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
	});
})