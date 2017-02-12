/**
 * Created by Administrator on 2016/10/29.
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


    $(".dropdown_toggle").hover(function () {
        $(this).siblings(".dropdown-menu").show();
    }, function () {
        $(this).siblings(".dropdown-menu").hide();
    });
    $(".dropdown-menu").hover(function () {
        $(this).show();
    }, function () {
        $(this).hide();
    });

    $(".dropdown_toggle").hover(function () {
        $(this).siblings(".dropdown-menu").show();
    }, function () {
        $(this).siblings(".dropdown-menu").hide();
    });
    $(".dropdown-menu").hover(function () {
        $(this).show();
    }, function () {
        $(this).hide();
    });

    //列表
    $(".right-list").on("click", function () {
        $(".map-list").show();
    });


    var data =[];
    //定位
    $(".location").click(function () {
         map = new BMap.Map("allmap", {enableMapClick:false});
        var point = new BMap.Point(119.977842, 31.817282);
        map.centerAndZoom(point,13);

        var geolocation = new BMap.Geolocation();
        geolocation.getCurrentPosition(function(r){
            if(this.getStatus() == BMAP_STATUS_SUCCESS){
                var mk = new BMap.Marker(r.point);
                map.addOverlay(mk);
                map.panTo(r.point);

                addMap(map,new BMap.Point(119.978305, 31.836874),"新北区fdfdfdf",2);


            }
            else {
                alert('failed'+this.getStatus());
            }
        },{enableHighAccuracy: true})
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
    $(".dropdown-menu ").click(function () {
        $(this).hide();
    });


    $(".more-select").on("click", function () {
        if($(".last-ul ").css("display")=="none"){
            $(".wapper").height("40px");
        }else{
            $(".wapper").height("80px");
        }
    });


});




window.onload = function () {

    addMap();

};

function addMap(map, point, area, num){
// function addMap() {
    // 百度地图API功能

    if (!map) {
        var map = new BMap.Map("allmap", {enableMapClick:false});
        var point = new BMap.Point(119.977842, 31.817282);
        map.centerAndZoom(point, 12);
    }

    function myFun(result) {
        var cityName = result.name;
        map.setCenter(cityName);
    }

    var myCity = new BMap.LocalCity();
    myCity.get(myFun);

    map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放


    // 定义自定义覆盖物的构造函数
    /*
     * center 中心点
     * length，容器长度
     *name 地区名
     * num 数量
     *
     * */
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
        var div = document.createElement("div");
        div.setAttribute("class", "map-view");
        var name = document.createElement("div");
        name.setAttribute("class", "map-yuan-name");
        var num = document.createElement("div");
        num.setAttribute("class", "map-yuan-num");
        name.innerHTML = this._name;
        num.innerHTML = this._num;
        div.appendChild(name);
        div.appendChild(num);
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
    // var mySquare1 = new SquareOverlay(new BMap.Point(119.978305, 31.836874), "新北区", "1.2万套");
    var mySquare2 = new SquareOverlay(new BMap.Point(119.906441, 31.808893), "钟楼区", "1.2万套");
    var mySquare3 = new SquareOverlay(new BMap.Point(119.949272, 31.707205), "武进区", "1.3万套");
    var mySquare4 = new SquareOverlay(new BMap.Point(119.602598, 31.728583), "金坛市", "买完了");
    map.addOverlay(mySquare);
    // map.addOverlay(mySquare1);
    map.addOverlay(mySquare2);
    map.addOverlay(mySquare3);
    map.addOverlay(mySquare4);

}