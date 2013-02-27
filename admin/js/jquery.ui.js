// JavaScript Document

var changlocal = {
	refreshed:function(d){
		window.parent.frames[d].location.reload();
	},
	exit:function(){
		if(confirm('确定退出么？')){
			top.location.replace("logout.php");
		}
	},
	winReload:function(){
		top.location.replace("main.php");
	}
}
$(function(){
	$("#topIMG td:not(:first)").find("a").mouseover(function(){
		var cur = $(this).children("img").attr("src");
		var imgstr = cur.split("/")[1];
		var named = imgstr.split(".")[0];
		$(this).find("img").attr("src","images/"+ named +"_x.gif");
	}).mouseout(function(){
		var swapd = $(this).children("img").attr("src");
		$(this).find("img").attr("src",swapd.replace("_x",""));
	});	   
});


function frameToggle(){
	var fs = parent.document.getElementsByTagName("frameset")[1];
	if(fs.cols=='171,*')
	{
		fs.cols = '0,*';
	}
	else
	{
		fs.cols = '171,*';
	}
}

$(function(){
	$("#btm").find(".menulistbar").find("li").bind("mouseover",function(){
		$(this).addClass("current");																
	}).bind("mouseout",function(){
		$(this).removeClass("current");
	}).bind("click",function(){
		var index = $("#btm").find(".menulistbar").find("li").index(this);
		$("#btm").find(".menulistbar").find("li").each(function(i){
			if(i!=index){
				$(this).removeClass("current2");
			}else{
				$(this).addClass("current2");
			}				  
		});	
	}).find("a").each(function(){
		if($(this).attr("target")==''){
			$(this).attr("target","main");
		}
	});
	
	$("#btm").find(".lic1").children("a").click(function(){
		var menui = $("#btm").find(".lic1").children("a").index(this);
		$("#btm").find(".lic1").children("a").each(function(i){
			if(i==menui){
				$("#btm").find(".menulistbar").eq(i).parent().css("display","block");
			}else{
				$("#btm").find(".menulistbar").eq(i).parent().css("display","none");
			}												
		});											 
	});  
	
});

(function($) {
    $.extend($.fn, {
        getCss: function(key) {
            var v = parseInt(this.css(key));
            if (isNaN(v))
                return false;
            return v;
        }
    });
    $.fn.Drags = function(opts) {
        var ps = $.extend({
            zIndex: 20,
            opacity: .7,
            handler: null,
            onMove: function() { },
            onDrop: function() { }
        }, opts);
        var dragndrop = {
            drag: function(e) {
                var dragData = e.data.dragData;
                dragData.target.css({
                    left: dragData.left + e.pageX - dragData.offLeft,
                    top: dragData.top + e.pageY - dragData.offTop
                });
                dragData.handler.css({ cursor: 'move' });
                dragData.onMove(e);
            },
            drop: function(e) {
                var dragData = e.data.dragData;
                dragData.target.css(dragData.oldCss); //.css({ 'opacity': '' });
                dragData.handler.css('cursor', dragData.oldCss.cursor);
                dragData.onDrop(e);
                $().unbind('mousemove', dragndrop.drag)
                    .unbind('mouseup', dragndrop.drop);
            }
        }
        return this.each(function() {
            var me = this;
            var handler = null;
            if (typeof ps.handler == 'undefined' || ps.handler == null)
                handler = $(me);
            else
                handler = (typeof ps.handler == 'string' ? $(ps.handler, this) : ps.handle);
            handler.bind('mousedown', { e: me }, function(s) {
                var target = $(s.data.e);
                var oldCss = {};
                if (target.css('position') != 'absolute') {
                    try {
                        target.position(oldCss);
                    } catch (ex) { }
                    target.css('position', 'absolute');
                }
                oldCss.cursor = target.css('cursor') || 'default';
                oldCss.opacity = target.getCss('opacity') || 1;
                var dragData = {
                    left: oldCss.left || target.getCss('left') || 0,
                    top: oldCss.top || target.getCss('top') || 0,
                    width: target.width() || target.getCss('width'),
                    height: target.height() || target.getCss('height'),
                    offLeft: s.pageX,
                    offTop: s.pageY,
                    oldCss: oldCss,
                    onMove: ps.onMove,
                    onDrop: ps.onDrop,
                    handler: handler,
                    target: target
                }
                target.css('opacity', ps.opacity);
                $().bind('mousemove', { dragData: dragData }, dragndrop.drag)
                    .bind('mouseup', { dragData: dragData }, dragndrop.drop);
            });
        });
    }
})(jQuery);

function copyToClipboard(txt){
    if (window.clipboardData) {
        window.clipboardData.clearData();
        window.clipboardData.setData("Text", txt);
    }
    else 
        if (navigator.userAgent.indexOf("Opera") != -1) {
            window.location = txt;
        }
        else 
            if (window.netscape) {
                try {
                    netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
                } 
                catch (e) {
                    alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将'signed.applets.codebase_principal_support'设置为'true'");
                }
                var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
                if (!clip) 
                    return;
                var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
                if (!trans) 
                    return;
                trans.addDataFlavor('text/unicode');
                var str = new Object();
                var len = new Object();
                var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
                var copytext = txt;
                str.data = copytext;
                trans.setTransferData("text/unicode", str, copytext.length * 2);
                var clipid = Components.interfaces.nsIClipboard;
                if (!clip) 
                    return false;
                clip.setData(trans, null, clipid.kGlobalClipboard);
            }
	//alert("复制成功");
}

