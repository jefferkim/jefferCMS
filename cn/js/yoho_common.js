$(window).bind("resize", function() {
    baseWidth = $("#main").width();
    minSize = "1002";
    maxSize = "1600";
    if (baseWidth <= maxSize && baseWidth >= minSize) {
        $(".content").width("100%")
    } else {
        if (baseWidth > maxSize) {
            $(".content").width(maxSize)
        } else {
            $(".content").width(minSize)
        }
    }
    resizeAction()
});
$(document).ready(function() {
    resizeAction();
    colorPopupCreate();
    headerBrandOpen();
});

function resizeAction() {
    goodsListResize();
    indexRanking();
    dzRanking()
}

function colorPopupCreate() {
    popID = "#colorPopBox";
    THUMBWIDTH = 64;
    OPENSPEED = 250;
    COLORSPEED = 200;
    var l = 0;
    if (jQuery.browser.version == "6.0" || jQuery.browser.version == "7.0") {
        var j = "old"
    }
    if (j == "old") {
        COLORSPEED = 0
    }
    if (!$(".popstatus").val()) {
        $(popID).after('<input type="hidden" class="popstatus" value="off" />')
    }
    $(".list").hover(function() {
        thisBox = this;
        if ($(thisBox).find(".colorList").html()) {
            idx = $(".list").index(thisBox);
            $(thisBox).mousemove(function(a) {
                if ($(".popstatus").val() == "off") {
                    clearTimeout(l);
                    l = setTimeout(h, OPENSPEED)
                }
            });
            $(popID).hover(function() {
                $(".popstatus").val("on")
            }, function() {
                g("over")
            })
        } else {
            g("over")
        }
    }, function() {
        if ($(".popstatus").val() == "off") {
            g("over")
        } else {
            g()
        }
    });
    function h() {
        clearTimeout(l);
        $(thisBox).children().each(
            function() {
                if ($(this).attr("class") == "expansion") {
                    $(popID + " ." + $(this).attr("class") + " a").hide();
                    $(
                        popID + " ." + $(this).attr("class") + " a:eq("
                        + idx + ")").show()
                } else {
                    $(popID + " ." + $(this).attr("class")).html(
                        $(this).html())
                }
            });
        $(popID + " .color").html(
            k($(thisBox).find(".colorList img:first").attr("alt"))).hide();
        $(popID + " .colorList").html($(thisBox).find(".colorList").html());
        i = 0;
        row = 4;
        var a = thumb = new Array();
        $(popID + " .colorList").find("a").each(function(b) {
            a[b] = new Image();
            a[b].src = $(this).attr("rel");
            thumb[b] = new Image();
            thumb[b].src = $(this).find("img").attr("src");
            $(this).wrap("<li></li>")
        });
        for (i = 0; i < $(popID + " .colorList").find("li").size(); i = i + row) {
            $(popID + " .colorList").find("li").slice(i, i + row).wrapAll(
                '<ul style="float: left; width: ' + (THUMBWIDTH + 1)
                + 'px;"></ul>')
        }
        $(popID + " .colorList")
        .html(
            '<div class="cf">' + $(popID + " .colorList").html()
            + "</div>");
        ulSize = $(popID + " .colorList").find("ul").size();
        colorListWidth = ulSize * (THUMBWIDTH) + ulSize;
        if (j == "old") {
            windowSize = $(thisBox).width() + colorListWidth + 16;
            $(popID).width(windowSize)
        }
        $(popID + " .colorList").width(0);
        $(popID + " .colorList > div").width(colorListWidth);
        pos = $(thisBox).offset();
        spw = 60;
        $(popID + " .innerDetail").width($(thisBox).width()).height(
            $(thisBox).height());
        if ($("body").width() < ($(thisBox).width() + pos.left + colorListWidth + spw)) {
            pos.left = $("body").width() - $(thisBox).width() - colorListWidth
            - spw
        }
        $(popID).css({
            top : pos.top + "px",
            left : pos.left + "px"
        });
        $(".popstatus").val("on");
        $(popID).show();
        $(popID + " .color").fadeIn(COLORSPEED);
        $(popID + " .colorList")
        .animate(
        {
            width : colorListWidth + "px"
        },
        COLORSPEED,
        function() {
            $(popID + " .colorList ul")
            .find("li")
            .each(
                function() {
                    $(this)
                    .find("a")
                    .mouseover(
                        function() {
                            $(
                                popID
                                + " .thumb img")
                            .attr(
                                "src",
                                $(
                                    this)
                                .attr(
                                    "rel"));
                            $(
                                popID
                                + " .color")
                            .html(
                                k($(
                                    this)
                                .find(
                                    "img")
                                .attr(
                                    "alt")))
                        })
                })
        })
    }
    function g(a) {
        $(".popstatus").val("off");
        clearTimeout(l);
        $(popID + " .color").clearQueue();
        $(popID + " .colorList").clearQueue();
        if (a) {
            $(popID + " .colorList").width(0);
            $(popID + " .color").html("").hide();
            $(popID).hide()
        }
    }
    function k(a) {

        return a
    }
}



function goodsListResize() {

    if ($("ul").hasClass("searchResultList")) {
        stageName = ".searchResultList";
        minSize=200
        boxResizeSetting()
    }
}

function boxResizeSetting() {
    stageSize = $(stageName).width();
    lineSpace = Math.floor(stageSize / minSize);
    baseSize = Math.ceil(stageSize / lineSpace);
    overSize = baseSize * lineSpace - stageSize;
    $(stageName).each(function() {
        liCount = $(this).children().size();
        i = 0;
        $(this).children().each(function() {
            i++;
            val = lineSpace;
            if (lineSpace < i) {
                i = 1
            }
            if (i <= overSize) {
                $(this).width(baseSize - 1)
            } else {
                $(this).width(baseSize)
            }
        })
    })
}



function indexRanking() {
    stageID = "#yohoRanking";
    col3set = "760";
    col4set = "1000";
    thisSize = $(stageID).width();
    if (thisSize < col3set) {
        $(stageID).find(".pickupList li").width("33%")
    } else {
        if (thisSize > col3set && thisSize < col4set) {
            if (jQuery.browser.version == "6.0"
                || jQuery.browser.version == "7.0") {
                $(stageID).find(".pickupList li").width("24.7%")
            } else {
                $(stageID).find(".pickupList li").width("25%")
            }
        } else {
            if (jQuery.browser.version == "6.0"
                || jQuery.browser.version == "7.0") {
                $(stageID).find(".pickupList li").width("19.7%")
            } else {
                $(stageID).find(".pickupList li").width("20%")
            }
        }
    }
}



function dzRanking() {
    stageID = "#dzRanking";
    col8set = "1000";
    col9set = "1111";
    thisSize = $(stageID).width();
    // alert(thisSize);
    if (thisSize < col8set) {
        $(stageID).find("li").width("12.5%")
    } else {
        if (thisSize > col8set && thisSize < col9set) {
            if (jQuery.browser.version == "6.0"
                || jQuery.browser.version == "7.0") {
                $(stageID).find("li").width("10.7%")
            } else {
                $(stageID).find("li").width("11%")
            }
        } else {
            if (jQuery.browser.version == "6.0"
                || jQuery.browser.version == "7.0") {
                $(stageID).find("li").width("9.7%")
            } else {
                $(stageID).find("li").width("10%")
            }
        }
    }
}


function ie6WidthKeep() {
    if (jQuery.browser.version == "6.0") {
        baseWidth = $("html").width();
        if (baseWidth <= "1600" && baseWidth >= "990") {
            $(".liquidFix").width("100%")
        } else {
            if (baseWidth > "1280") {
                $(".liquidFix").width(1600)
            } else {
                $(".liquidFix").width(990)
            }
        }
    }
};

function headerBrandOpen() {
    $('#headerbrand').hide();
    $('.tab_brand').click(function() {
        $(this).toggleClass("tab_brand_act");
        $('#headerbrand').slideToggle(300, function() {
            $('.closelink a').click(function() {
                $('#headerbrand').slideUp(300);
                $(".tab_brand").removeClass("tab_brand_act");
                return false;
            });
        });
        return false;

    });
}

/* 下拉菜单 */
function showMenu(act, flag) {
    $("#menu" + flag).css('display', 'block');
    $("#" + act).attr('className', 'over');
}
function hideMenu(act, flag) {
    $("#menu" + flag).css('display', 'none');
    $("#" + act).attr('className', '');
}

function hideMenuHit(act, flag) {
    $("#menu" + flag).css('display', 'none');
    //$("#" + act).attr('className', '');
}


//表单验证
function validateRight(str, id){
    $("#"+id+"_dl").attr('class','tips-box-error');
    $("#c_"+id).hide('fast');
    if( id == 'phone' &&  $('#mobile').val() != '' ){
        $("#phone_dl").removeClass();
        return "&nbsp;";
    }else if(id == 'mobile' &&  $('#phone').val() != '' ){
        $("#mobile_dl").removeClass();
        return "&nbsp;";
    }else{
        return '<span class="tips-error" id="error_'+id+'">'+str+'</span>';
    }
}