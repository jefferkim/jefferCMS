$(function()
{
    $("li[class*=producttype]").mouseover(
        function(){
            $("li[class*=producttype]").hide();
            $("li[class=producttype0]").show();
            var level = $(this).attr("class").replace("producttype","");
            if (level > 0)
                $(this).parent().find("li").show();

            $(this).next().find("li").show();
            var temp = $(this);
            for(index = level; index > 0; index--)
            {
                //alert(temp.html());
                temp.parent().find(".producttype"+ index).show();
			    temp = temp.parent().parent();
            }
        });
});