Do(function(){
    $('.close').click(function(){
        $('.map_l').hide("fast");
        $(".map_r").animate({marginLeft:"0px"},function(){
            $('.close').css({'display':'none'});
            $('.open').css({'display':'block','left':'0px'});
            $("#map").css({'width':'100%'});
        });
    });
    $('.open').click(function(){
        $('.map_l').show("slow");
        $(".map_r").animate({marginLeft:"337px"},function(){
            $('.open').css({'display':'none'});
            $('.close').css({'display':'block'});
            $("#map").css({'width':'100%'});
        });
    });

    var map_top = $('.map_r').position().top;
    var window_height = $(window).height();
    $('#map').height(window_height - map_top - 20);
});