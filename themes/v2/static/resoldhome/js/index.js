Do.add('SuperSlide',{
    type : 'js',
    path : basedir + 'jquery.SuperSlide.2.1.1.js'
});
Do('SuperSlide',function() {
    $(".hot-areas").slide({ titCell:".r-s-tab li", mainCell:".r-tab-content",delayTime:0 });
    $(".change-box").slide({ titCell:".s-tab li", mainCell:".tab-content",delayTime:0 });
})

Do(function(){
    $(".dropdown_toggle").hover(function(){
            $(this).siblings(".dropdown-menu").show();
        },function(){
            $(this).siblings(".dropdown-menu").hide();
        });
        $(".dropdown-menu").hover(function(){
            $(this).show();
        },function(){
            $(this).hide();
        });
    $(".sort-btn").hover(function(){
        $(this).siblings(".tips-notice").show();
        },function(){
            $(this).siblings(".tips-notice").hide();
        });


})