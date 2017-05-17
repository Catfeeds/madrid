/**
 * Created by Administrator on 2016/10/25.
 */
Do.add('SuperSlide',{
    type : 'js',
    path : basedir + 'jquery.SuperSlide.2.1.1.js'
});
Do('SuperSlide',function () {
    $(function () {
        //大图切换
        jQuery(".picFocus").slide({
            titCell: ".small-img li", mainCell: ".bd", effect: "fold", autoPlay: false, delayTime: 200, prevCell: ".prev", nextCell: ".next", pnLoop: false,
            startFun: function (i, p) {
                //控制小图自动翻页
                if (i == 0) {
                    jQuery(".picFocus .list-prev").click()
                } else if (i % 5 == 0) {
                    jQuery(".picFocus .list-next").click()
                }
            }
        });

        //小图左滚动切换
        jQuery(".picFocus .hd").slide({
            mainCell: "ul",
            delayTime: 100,
            vis: 5,
            scroll: 5,
            effect: "left",
            autoPage: true,
            prevCell: ".list-prev",
            nextCell: ".list-next",
            pnLoop: false
        });

    });
})