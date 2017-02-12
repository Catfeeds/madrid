Do.add('customSlider', {path: 'js/jquery.yx_rotaion.js', type: 'js'});
Do(function(){
    Do('customSlider', function() {
        $("#slider").yx_rotaion({
            auto:true,
            btn:false,
            title:false,
            during:5000
        });
    })
    function tabs(tabTit,active,tabCon){
        $(tabCon).each(function(){
            $(this).eq(0).show();
        });
        $(tabTit).each(function(){
            $(this).children().eq(0).addClass(active);
        });
        $(tabTit).children().hover(function(){
            $(this).addClass(active).siblings().removeClass(active);
            var index = $(tabTit).children().index(this);
            $(tabCon).eq(index).show().siblings().hide();
        });
    }
    tabs(".s-tab","active",".tab-content");
});
