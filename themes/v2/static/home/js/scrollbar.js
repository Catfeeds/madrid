Do.ready(function(){
	if(Browser.ie == "6.0"){
		$('#scrollbar').attr('style', 'position:absolute;left:expression(eval(document.documentElement.scrollLeft+document.documentElement.clientWidth-this.offsetWidth)-(parseInt(this.currentStyle.marginLeft,0)||0)-(parseInt(this.currentStyle.marginRight,0)||0));top:expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight-this.offsetHeight-(parseInt(this.currentStyle.marginTop,0)||0)-(parseInt(this.currentStyle.marginBottom,0)||100)))');
		//$('#bbs_client').attr('style', 'position:absolute;left:expression(eval(document.documentElement.scrollLeft+document.documentElement.clientWidth-this.offsetWidth)-(parseInt(this.currentStyle.marginLeft,0)||0)-(parseInt(this.currentStyle.marginRight,0)||10));top:expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight-this.offsetHeight-(parseInt(this.currentStyle.marginTop,0)||200)-(parseInt(this.currentStyle.marginBottom,0)||0)))');//
	}
    $(".online-service").hover(function(){
        $(this).parents().addClass("open-box");
    });
    $("#scrollbar").find(".close").on("click", function(){
        $(this).parents().removeClass("open-box");
    });
    var offsetTop = $(window).scrollTop();
    if (offsetTop > 200) {
        $('#scrollbar').find('.gotop').addClass('go');
    }
    $(window).scroll(function () {
        var offsetTop = $(window).scrollTop();
        if (offsetTop > 200) {
            $('#scrollbar').find('.gotop').addClass('go');
        } else {
            $('#scrollbar').find('.gotop').removeClass('go');
        }
    });

    $('#scrollbar').delegate('.gotop','click',function(){
        if($(this).hasClass("go")){
            if (Browser.ie){
                $('html,body').scrollTop(0);
            }else{
                obody = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
                obody.animate({
                    scrollTop: 0
                }, 500);
            }
        }
        return false;
    })

    $('#scrollbar').find(".suspend").on("mouseenter",function(){
        $(this).siblings("div").show();
    })
    $('#scrollbar').find(".suspend").on("mouseleave",function(){
        $(this).siblings("div").hide();
    })
    $('#scrollbar').find(".suspend").siblings("div").mouseenter(function(){
        $(this).show();
    })
    $('#scrollbar').find(".suspend").siblings("div").mouseleave(function(){
        $(this).hide();
    })
})
