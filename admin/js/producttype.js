$(function()
{
	/*$(".producttype > li").mouseover(function()
	{
		$(this).find("ul:first").show();
	}).mouseout(function()
	{
		$(this).find("ul:first").hide();
	});*/
	$(".producttype li").toggle(function()
	{
		if ($(this).find("ul:first").html() != null)
		{
			$(this).find("ul:first").show();
		}
		else
		{
			window.location.href = $(this).find("a").attr("href");
		}
	},function()
	{
		if ($(this).find("ul:first").html() != null)
		{
			$(this).find("ul:first").hide();
		}
		else
		{
			window.location.href = $(this).find("a").attr("href");
		}
	});
});