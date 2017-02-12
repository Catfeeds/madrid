/**
 * Created by Administrator on 2016/10/27.
 */
$(function () {
    $(".more-select").on("click", function () {
        $(".last-ul").toggle();
    });
    var flag;
    $(".more-select").click(function () {
        if (!flag) {
            flag = true;
            $(this).text("收起条件");

        } else {
            flag = false;
            $(this).text("更多条件");
        }
    });




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

    /*  下拉选中效果 */
    $("a").click(function (e) {
        e.preventDefault();//取消默认行为
    });
    $(".filter_sel_box>li").each(function(){
        $(this).click(function(){
            var val = $(this).children().html();
            var str = '<span class="caret list-icon"></span>';
            $(this).parent().siblings().html(val+str);
        });
    });
//点击选项后隐藏
    $(".dropdown-menu li").click(function () {
        $(this).hide();
        alert($(this).text());
    });


    $(".more-select").on("click", function () {
        if($(".last-ul ").css("display")=="block"){
            $(".wapper").height("80px");
        }else{
            $(".wapper").height("40px");
        }
    });




    $(".select-box .right-list").click(function () {
        $(".map-box .map-list").show()
    });

    $(".location").click(function () {
        var map = new BMap.Map("allmap");
        var point = new BMap.Point(119.956547, 31.77052, {enableMapClick: false});
        map.centerAndZoom(point, 13);
        map.enableScrollWheelZoom(true);

        var geolocation = new BMap.Geolocation();
        geolocation.getCurrentPosition(function(r){
            if(this.getStatus() == BMAP_STATUS_SUCCESS){
                var mk = new BMap.Marker(r.point);
                map.addOverlay(mk);
                map.panTo(r.point);
            }
            else {
                alert('failed'+this.getStatus());
            }
        },{enableHighAccuracy: true})
    });




})
;

window.onload = function () {
    // 百度地图API功能
    var map = new BMap.Map("allmap");
    var point = new BMap.Point(119.956547, 31.77052, {enableMapClick: false});

    map.centerAndZoom(point, 13);
    map.enableScrollWheelZoom(true);




    /*
     * 标注
     *
     * */

    var icon = new BMap.Icon('./images/marker_icon.png', new BMap.Size(20, 32), {
        anchor: new BMap.Size(10, 30)
    });

    var mkr = new BMap.Marker(new BMap.Point(119.956547, 31.77052), {
        icon: icon
    });
    map.addOverlay(mkr);

    var flag = false;
    var msg = $("<div class='map-marker-msg'><div class='map-view-contnet'><p class='map-view-p'>九州新世界</p><p>均价：<span class='map-num'>9876</span>元/平</p><p>二手房：<span class='map-num'>123</span>套</p><div class='arrow'></div><div class='arrow-d'></div></div></div>");
    var top = msg.position().top;
    // alert(top);
    if (top === 0) {
    }


    mkr.addEventListener('click', function (e) {
        if (!flag) {
            flag = true;
            //转换坐标
            var tip = map.pointToPixel(e.point);
            // console.log(tip);
            msg.css({"top": tip.y - 140, "left": tip.x - 115});
            $(".map-box").append(msg);
        };
    });

    map.addEventListener("dragstart", function () {

    });

    map.addEventListener("moving", function () {
        // $(".map-marker-msg").remove();
        flag = false;
        var tip = map.pointToPixel(mkr.point);
        msg.css({"top": tip.y - 155, "left": tip.x - 115});
        console.log(map.pointToPixel(mkr.point));
        // alert(123)
        var top = msg.position().top;
        // alert(top);
        if (top <= 1) {
            $(".map-marker-msg").toggle();
        }
    });

    map.addEventListener("moveend", function () {
        flag = false;
        var tip = map.pointToPixel(mkr.point);
        msg.css({"top": tip.y - 155, "left": tip.x - 115});
        console.log(map.pointToPixel(mkr.point));
    });


    map.addEventListener("zoomstart", function () {
        // $(".map-marker-msg").remove();
        // flag = false;
    });

    map.addEventListener("zoomend", function () {
        var tip = map.pointToPixel(mkr.point);
        msg.css({"top": tip.y - 155, "left": tip.x - 115});

    });


};

function addmap(map,title,num) {
    function SquareOverlay(center, name, num) {
        this._center = center;
        this._length = 90;
        this._name = name;
        this._num = num;
    }

// 继承API的BMap.Overlay
    SquareOverlay.prototype = new BMap.Overlay();
// 实现初始化方法
    SquareOverlay.prototype.initialize = function (map) {
// 保存map对象实例
        this._map = map;
        // 创建div元素，作为自定义覆盖物的容器
        var div = $("<div class='map-marker-msg'><div class='map-view-contnet'><p class='map-view-p'>+ title +</p><p>均价：<span class='map-num'>+num+</span>元/平</p><p>二手房：<span class='map-num'>123</span>套</p><div class='arrow'></div><div class='arrow-d'></div></div></div>")
// 将div添加到覆盖物容器中
        map.getPanes().markerPane.appendChild(div);
// 保存div实例
        this._div = div;
// 需要将div元素作为方法的返回值，当调用该覆盖物的show、
// hide方法，或者对覆盖物进行移除时，API都将操作此元素。
        return div;
    };
    // 实现绘制方法
    SquareOverlay.prototype.draw = function () {
// 根据地理坐标转换为像素坐标，并设置给容器
        var position = this._map.pointToOverlayPixel(this._center);
        this._div.style.left = position.x - this._length / 2 + "px";
        this._div.style.top = position.y - this._length / 2 + "px";
    };
    var mySquare = new SquareOverlay(point, area, num+"万套");
    map.addOverlay(mySquare);
}