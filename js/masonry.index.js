$(document).ready($onresize = function(){
    var Winh = $(window).width(), Wimg = $(".item").width() + 38,
    Wsidebar = $(".aside").width() + 24;
    var mainWidth = Winh - Wsidebar;
    var imgBs = mainWidth % Wimg;  //imgBs为最多放下图片后剩下的余数
    var a = Math.floor( imgBs / 2); //余数平分即为外边距大小
    $(".container").css("margin-left", a );
    $(".container").css("margin-right", a );

    });
$(window).bind("resize", $onresize);


