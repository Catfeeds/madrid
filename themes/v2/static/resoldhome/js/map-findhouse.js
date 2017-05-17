/**
 * Created by Administrator on 2016/10/26.
 */

$(function () {


    map = new BMap.Map("allmap", {enableMapClick: false});
    var point = new BMap.Point(119.977842, 31.817282);
    map.centerAndZoom(point, 12);
    map.enableScrollWheelZoom(false);
    addAreaMarker();
    var zoom = "";

    // 定位
    $(".location").click(function () {

        var geolocation = new BMap.Geolocation();
        geolocation.getCurrentPosition(function (r) {
            if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                var mk = new BMap.Marker(r.point);
                map.addOverlay(mk);
                map.panTo(r.point);
            }
        }, {enableHighAccuracy: true})

    });
    // 放大地图
    map.addEventListener("zoomend", function () {

        // console.log(map.getZoom());
        //清除所有标注
        var overLays = map.getOverlays();
        if (overLays.length > 0) {
            for (var i = 0; i < overLays.length; i++) {
                map.removeOverlay(overLays[i]);
            }
        }
        //放大地图
        if (map.getZoom() >= 15) {


            /* if (overLays.length > 0) {
             for (var i = 0; i < overLays.length; i++) {
             map.removeOverlay(overLays[i]);
             }
             }*/
            // getXiaoqu();
        }

        if (map.getZoom() == 13) {

            // 添加街道标注
            if (overLays.length > 0) {
                for (var i = 0; i < overLays.length; i++) {
                    map.removeOverlay(overLays[i]);
                }
            }
            // getAreaAndHouse()
        } else if (map.getZoom() <= 12) {
            if (overLays.length > 0) {
                for (var i = 0; i < overLays.length; i++) {
                    map.removeOverlay(overLays[i]);
                }
            }

            addAreaMarker();

        }
    });
    // 移动地图
    map.addEventListener("dragend", function () {

        //清除所有标注
        var overLays = map.getOverlays();
        /* if (overLays.length > 0) {
         for (var i = 0; i < overLays.length; i++) {
         map.removeOverlay(overLays[i]);
         }
         }*/
        //放大地图
        if (map.getZoom() >= 15) {
            var overLays = map.getOverlays();
            /* if (overLays.length > 0) {
             for (var i = 0; i < overLays.length; i++) {
             map.removeOverlay(overLays[i]);
             }
             }*/

            getXiaoqu();
        }

        if (map.getZoom() == 13) {

            // 添加街道标注
            getAreaAndHouse()
        } else if (map.getZoom() <= 12) {
            addAreaMarker("");

        }

    });

    $(".search-input input").keyup(function () {
        // alert($(this).val());
        var $val = $(this).val();
        $.ajax({
            url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/mapfindlocation",
            type: "get",
            data: {type: 1, kw: $val},
            dataType: "json",
            success: function (data) {
                console.log(data);
            }
        })
    })


});


// 添加区标注
function addAreaMarker() {
    $.ajax({
            type: "get",
            async: true,
            url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/mapfindarea",
            data: {"type": 1},
            dataType: "json",
            success: function (data) {
                if (data.status != "success") {
                    return;
                }

                var result = data.data;
                var str = "";
                for (var i = 0; i < result.lists.length; i++) {
                    var over = new SquareOverlay(new BMap.Point(result.lists[i]["lng"], result.lists[i]["lat"]), 90, result.lists[i]["name"], result.lists[i]["num"]);
                    map.addOverlay(over);
                    str += "<li><a href='javascript:;'><span class='con-span-1'>"
                        + result.lists[i]['name']
                        + "</span><span class='con-span-2'>"
                        + result.lists[i]['num'] + "万套" + "<img src='images/arrow.png'>"
                        + "</span></a></li>";

                    over.addEventListener('click', (function (data) {

                        return function () {
                            map.setCenter(new BMap.Point(data["lng"], data["lat"]));
                            map.setZoom(13);
                            addStreetMarker(data["name"], data["id"]);
                        };
                    })(result.lists[i]));
                }

                var header = "<div class='map-title'><p><img src='images/home_icon.png'>"
                    + "共" + "<span>" + result.total + "</span>"
                    + "套相关房源" +
                    "</p></div>";
                var content = "<div class='map-content'><ul>" + str + "</ul></div>";

                var mapList = "<div class='map-list-box'>" + header + content + "</div>";

                $(".map-list ").html(mapList);
                // 点击事件
                $(".map-list .map-content ul li").bind("click", function () {
                    map.setCenter(new BMap.Point(result.lists[$(this).index()]['lng'], result.lists[$(this).index()]['lat']));
                    map.setZoom(13);
                    addStreetMarker(result.lists[$(this).index()]["name"], result.lists[$(this).index()]["id"]);
                });

            }
        }
    )
}

// 添加街道标注
function addStreetMarker(name, id) {
    var str = "";
    $.ajax({
        type: "get",
        url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/mapfindstreet",
        data: {"area": id, "type": 1},
        dataType: "json",
        success: function (data) {
            // console.log(data);
            if (data.status != "success") {
                return;
            }
            var result = data.data;
            // console.log(result);

            for (var i = 0; i < result.lists.length; i++) {
                var over = new SquareOverlay(new BMap.Point(result.lists[i]["lng"], result.lists[i]["lat"]), 90, result.lists[i]["name"], result.lists[i]["num"]);
                map.addOverlay(over);
                str += "<li><a href='javascript:;'><span class='con-span-1'>"
                    + result.lists[i]['name'] + "</span><span class='con-span-2'>"
                    + result.lists[i]['num'] + "万套" + "<img src='images/arrow.png'>"
                    + "</span></a></li>";
                over.addEventListener("click", (function (data) {
                    return function () {
                        map.setCenter(new BMap.Point(data["lng"], data["lat"]));
                        map.setZoom(15);
                        addXiaoquMarker(data["name"], data["id"])
                    }
                })(result.lists[i]));
            }

            var header = "<div class='street-title'><p>"
                + "<span class='street-name'>" + name + "</span>"
                + "共" + "<span>" + result.total + "</span>"
                + "套相关房源" +
                "</p></div>";
            var footer = "<div class='street-footer'><a href='#'><p>" + "查看更多&nbsp;>" + "</p></a></div>";
            var content = "<div class='street-content'><ul>" + str + "</ul></div>";
            var map_list = "<div class='map-list-box'>" + header + content + footer + "</div>";

            $(".map-list").html(map_list);

            $(".map-list .street-content ul li").bind("click", function () {
                map.setCenter(new BMap.Point(result.lists[$(this).index()]['lng'], result.lists[$(this).index()]['lat']));
                map.setZoom(15);
                addXiaoquMarker(result.lists[$(this).index()]['name'], result.lists[$(this).index()]['id']);

            });
        }
    });
}


//  添加小区标注
function addXiaoquMarker(name, id) {

    $.ajax({
        type: "get",
        url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/mapfindplot",
        data: {"street": id, "type": 1},
        dataType: "json",
        success: function (data) {
            console.log(data);
            if (data.status != "success") return;
            var result = data.data;
            // console.log(result);
            var str = "";
            if (result.length == 0) return;
            for (var i = 0; i < result.lists.length; i++) {
                var icon = new BMap.Icon('./images/marker_icon.png', new BMap.Size(20, 32), {
                    anchor: new BMap.Size(10, 30)
                });
                var mkr = new BMap.Marker(new BMap.Point(result.lists[i]["lng"], result.lists[i]["lat"]), {
                    icon: icon
                });
                map.addOverlay(mkr);

                mkr.addEventListener("click", (function (data, t) {
                    return function () {
                        var overlays = map.getOverlays();
                        for (var i = 0; i < overlays.length; i++) {
                            if (overlays[i] instanceof AddWindow) {
                                map.removeOverlay(overlays[i])
                            }
                        }
                        map.setCenter(new BMap.Point(data["lng"], data["lat"]));
                        map.setZoom(15);
                        addXiaoquDetail(data["name"], data["id"]);
                        var over = new AddWindow(new BMap.Point(data["lng"], data["lat"]), 155, data["name"], data["esf_price"], data["num"]);
                        map.addOverlay(over);
                    }
                })(result.lists[i], result));

                str += "<li><a href='javascript:;'><span class='con-span-1'>"
                    + result.lists[i]['name'] + "</span><span class='con-span-2'>"
                    + result.lists[i]['num'] + "万套" + "<img src='images/arrow.png'>"
                    + "</span></a></li>";

            }

            var header = "<div class='street-title'><p>"
                + "<span class='street-name'>" + name + "</span>"
                + "共" + "<span>" + result.total + "</span>"
                + "套相关房源" +
                "</p></div>";
            var footer = "<div class='street-footer'><a href='#'><p>" + "查看更多&nbsp;>" + "</p></a></div>";
            var content = "<div class='street-content'><ul>" + str + "</ul></div>";
            var map_list = "<div class='map-list-box'>" + header + content + footer + "</div>";


            $(".map-list ").html(map_list);

            $(".map-list .street-content ul li").bind("click", function () {

                var $index = $(this).index();
                var overlays = map.getOverlays();
                for (var i = 0; i < overlays.length; i++) {
                    if (overlays[i] instanceof AddWindow) {
                        map.removeOverlay(overLays[i])
                    }
                }
                map.setCenter(new BMap.Point(result.lists[$index]['lng'], result.lists[$index]['lat']));
                map.setZoom(15);
                addXiaoquDetail(result.lists[$index]["name"], result.lists[$index]["id"]);
                var over = new AddWindow(new BMap.Point(result.lists[$index]['lng'], result.lists[$index]['lat']), 155, result.lists[$index]["name"], result.lists[$index]["esf_price"], result.lists[$index]["num"]);
                map.addOverlay(over);
            });
        }
    });


}

function addMarker(lng, lat, data) {
    var icon = new BMap.Icon('./images/marker_icon.png', new BMap.Size(20, 32), {
        anchor: new BMap.Size(10, 30)
    });
    var mkr = new BMap.Marker(new BMap.Point(lng, lat), {
        icon: icon
    });
    mkr.addEventListener("click", function () {
        var over = new SquareOverlay(new BMap.Point(lng, lat), 155, data["name"], data[$index]["num"]);
        map.addOverlay(over);
    })
}


//添加具体小区的
function addXiaoquDetail(name, id) {

    // console.log(name, id);
    $.ajax({
        type: "get",
        url: "http://hjhouse.hualongxiang.com/api/resoldWapApi/plotmap",
        data: {"hid": id, "type": 1},
        dataType: "json",
        success: function (data) {
            console.log(data);
            var result = data.data;
            // console.log(result);
            // console.log(result.info);
            if (result.length == 0) return;
            var str = "";
            for (var i = 0; i < result.info.length; i++) {
                str += "<div class='content'><div class='house-list'>"
                    + "<img src=" + result.info[i]["image"] + ">"
                    + "<div class='con-name'>"
                    + "<p class='pri'>" + result.info[i]["title"] + "</p>"
                    + "<p class='huxing'><span>" + result.info[i]["bedroom"] + "室" + result.info[i]["bathroom"] + "厅" + result.info[i]["livingroom"] + "卫" + "</span>"
                    + "<span>" + result.info[i]["size"] + "㎡" + "</span>"
                    + "<span class='last-span'>" + result.info[i]["ave_price"] + "元/平" + "</span></p>"
                    + "</div></div></div>";


            }

            var header = "<div class='xiaoqu-title'><div class='xiaoqu-header'><div class='xiaoqu'>"
                    + "<ul><li class='xiaoqu-name'>" + name + "</li><li class='xiaoqu-area'>" + result["area"] + "</li><li class='xiaoqu-road'>" + result["street"] + "</li></ul></div>"
                    + "<div class='number'>"
                    + "<ul>"
                    + "<li class='esf'>" + "二手房：" + "<span>" + result["esf_count"] + "</span>" + "</li>"
                    + "<li class='zf'>" + "租房：" + "<span>" + result["zf_count"] + "</span>" + "</li>"
                    + "</ul>"
                    + "</div>"
                    + "</div>"
                    + '<div class="price">'
                    + '<span class="num">' + result.info[0]["ave_price"] + '</span><span class="len">元/平</span>'
                    + '</div>'
                    + "</div>"
                ;


            var condition = '<div class="condition">'
                + '<ul>'
                + '<li class="default active"><a href="javascript:;">默认</a></li>'
                + '<li class="new" data-value="1"><a href="javascript:;">最新</a></li>'
                + '<li class="prc" data-value="2"><a href="javascript:;">价格</a></li>'
                + '<li class="find-all">共找到<span> ' + result["esf_count"] + '</span>套房源</li>'
                + '</ul>'
                + '</div>';

            var content = '<div class="content-box">' + str + '</div>';
            $(".map-list").html(header + condition + content);
            // 最新按钮点击事件
            $(".map-list .condition .default").click(function () {
                $(this).addClass("active").siblings().removeClass("active");
                getListAjax(id)
            });
            $(".map-list .condition .new").click(function () {
                $(this).addClass("active").siblings().removeClass("active");
                var sort = $(this).attr("data-value");
                getListAjax(id, sort, 1, 1);
            });
            $(".map-list .condition .prc").click(function () {
                $(this).addClass("active").siblings().removeClass("active");
                var sort = $(this).attr("data-value");
                getListAjax(id, sort, 1, 1);
            });


        }

    })


}


function getListAjax(id, type) {
    var type = type || 1;
    var sort = sort || 0;
    var page = page || 0;

    $.ajax({
        type: "get",
        url: "http://hjhouse.hualongxiang.com/api/resoldWapApi/plotmap",
        data: {"hid": id, "type": type, "sort": sort, "page": page},
        dataType: "json",
        success: function (data) {
            // console.log(data);
            var result = data.data;
            console.log(result);
            // var source = '{{each result as value}}'
            //     + '{{}}';
            var str = '';
            for (var i = 0; i < result.info.length; i++) {
                str += "<div class='content'><div class='house-list'>"
                    + "<img src=" + result.info[i]["image"] + ">"
                    + "<div class='con-name'>"
                    + "<p class='pri'>" + result.info[i]["title"] + "</p>"
                    + "<p class='huxing'><span>" + result.info[i]["bedroom"] + "室" + result.info[i]["bathroom"] + "厅" + result.info[i]["livingroom"] + "卫" + "</span>"
                    + "<span>" + result.info[i]["size"] + "㎡" + "</span>"
                    + "<span class='last-span'>" + result.info[i]["ave_price"] + "元/平" + "</span></p>"
                    + "</div></div></div>";
            }
            $(".find-all span").text(result["esf_count"]);
            $(".content-box").html(str);

        }
    })
}

// 拖动地图时添加小区或区
function getAreaAndHouse() {
    var center = map.getCenter();
    var current_bounds = map.getBounds();
    var sw_point = current_bounds.getSouthWest();
    var ne_point = current_bounds.getNorthEast();
    var dis = map.getDistance(sw_point, ne_point);

    $.ajax({
        url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/mapfindlocation",
        data: {"distance": dis, "lng": center.lng, "lat": center.lat, "type": 1},
        dataType: "json",
        success: function (data) {
            console.log(data);
            var result = data.data;
            // console.log(result);
            var str = "";
            if (result.length == 0) return;
            var overLays = map.getOverlays();
            for (var i = 0; i < result.areas.length; i++) {

                var over = new SquareOverlay(new BMap.Point(result.areas[i]["lng"], result.areas[i]["lat"]), 90, result.areas[i]["name"], result.areas[i]["num"]);

                map.addOverlay(over);
                str += "<li><a href='javascript:;'><span class='con-span-1'>"
                    + result.areas[i]['name']
                    + "</span><span class='con-span-2'>"
                    + result.areas[i]['num'] + "万套" + "<img src='images/arrow.png'>"
                    + "</span></a></li>";

                over.addEventListener('click', (function (data) {
                    return function () {
                        map.setCenter(new BMap.Point(data["lng"], data["lat"]));
                        map.setZoom(14);
                        addStreetMarker(data["name"], data["id"]);
                    };
                })(result.areas[i]));
            }
            var header = "<div class='street-title'><p>"
                + "<span class='street-name'>" + name + "</span>"
                + "共" + "<span>" + result.total + "</span>"
                + "套相关房源" +
                "</p></div>";
            var footer = "<div class='street-footer'><a href='#'><p>" + "查看更多&nbsp;>" + "</p></a></div>";
            var content = "<div class='street-content'><ul>" + str + "</ul></div>";
            var map_list = "<div class='map-list-box'>" + header + content + footer + "</div>";

            $(".map-list").html(map_list);

            $(".map-list .street-content ul li").bind("click", function () {
                map.setCenter(new BMap.Point(result.areas[$(this).index()]['lng'], result.areas[$(this).index()]['lat']));
                map.setZoom(14);
                addXiaoquMarker(result.areas[$(this).index()]['name'], result.areas[$(this).index()]['id']);

            });
        }
    })
}
function getXiaoqu() {
    var center = map.getCenter();
    var current_bounds = map.getBounds();
    var sw_point = current_bounds.getSouthWest();
    var ne_point = current_bounds.getNorthEast();
    var dis = map.getDistance(sw_point, ne_point);

    $.ajax({
        url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/mapfindlocation",
        data: {"distance": dis, "lng": center.lng, "lat": center.lat, "type": 2},
        dataType: "json",
        success: function (data) {
            var result = data.data;
            var str = "";
            var overlays = map.getOverlays();
            for (var i = 0; i < result.areas.length; i++) {

                var icon = new BMap.Icon('./images/marker_icon.png', new BMap.Size(20, 32), {
                    anchor: new BMap.Size(10, 30)
                });
                var mkr = new BMap.Marker(new BMap.Point(result.areas[i]["lng"], result.areas[i]["lat"]), {
                    icon: icon
                });
                /*  for (var i = 0; i < overlays.length; i++) {
                 if (overlays[i] === mkr) return;

                 }*/

                map.addOverlay(mkr);

                mkr.addEventListener("click", (function (data, t) {
                    return function () {
                        var overlays = map.getOverlays();
                        for (var i = 0; i < overlays.length; i++) {
                            if (overlays[i] instanceof AddWindow) {
                                map.removeOverlay(overlays[i])
                            }
                        }
                        map.setCenter(new BMap.Point(data["lng"], data["lat"]));
                        map.setZoom(15);
                        addXiaoquDetail(data["name"], data["id"]);
                        var over = new AddWindow(new BMap.Point(data["lng"], data["lat"]), 155, data["name"], data["esf_price"], data["num"]);
                        map.addOverlay(over);
                    }
                })(result.areas[i], result));

                str += "<li><a href='javascript:;'><span class='con-span-1'>"
                    + result.areas[i]['name'] + "</span><span class='con-span-2'>"
                    + result.areas[i]['num'] + "万套" + "<img src='images/arrow.png'>"
                    + "</span></a></li>";

            }

            var header = "<div class='street-title'><p>"
                + "<span class='street-name'>" + name + "</span>"
                + "共" + "<span>" + result.total + "</span>"
                + "套相关房源" +
                "</p></div>";
            var footer = "<div class='street-footer'><a href='#'><p>" + "查看更多&nbsp;>" + "</p></a></div>";
            var content = "<div class='street-content'><ul>" + str + "</ul></div>";
            // var map_list = "<div class='map-list-box'>"+ header+ content+ footer+"</div>";


            // $(".map-list ").html(map_list);

            $(".map-list .street-content ul li").bind("click", function () {

                var $index = $(this).index();
                var overlays = map.getOverlays();
                for (var i = 0; i < overlays.length; i++) {
                    if (overlays[i] instanceof AddWindow) {
                        map.removeOverlay(overLays[i])
                    }
                }
                map.setCenter(new BMap.Point(result.areas[$index]['lng'], result.areas[$index]['lat']));
                map.setZoom(14);
                addXiaoquDetail(result.areas[$index]["name"], result.areas[$index]["id"]);
                var over = new AddWindow(new BMap.Point(result.areas[$index]['lng'], result.areas[$index]['lat']), 155, result.areas[$index]["name"], result.areas[$index]["esf_price"], result.areas[$index]["num"]);
                map.addOverlay(over);
            });
        }
    })
}


// 定义自定义覆盖物的构造函数
/*
 * center 中心点
 * length，容器长度
 *name 地区名
 * num 数量
 *
 * */
function SquareOverlay(center, length, name, num) {
    this._center = center;
    this._length = length;
    this._name = name;
    this._num = num;
}

// 继承API的BMap.Overlay
SquareOverlay.prototype = new BMap.Overlay();
// 实现初始化方法
SquareOverlay.prototype.initialize = function (map) {
// 保存map对象实例
    this._map = map;
    var div = document.createElement("div");
    div.setAttribute("class", "map-view");
    var name = document.createElement("div");
    name.setAttribute("class", "map-yuan-name");
    var num = document.createElement("div");
    num.setAttribute("class", "map-yuan-num");
    name.innerHTML = this._name;
    num.innerHTML = this._num + "万套";
    div.appendChild(name);
    div.appendChild(num);

// 将div添加到覆盖物容器中
    map.getPanes().markerPane.appendChild(div);

// 保存div实例
    this._div = div;
    return div;
};
// 实现绘制方法
SquareOverlay.prototype.draw = function () {
// 根据地理坐标转换为像素坐标，并设置给容器

    var position = this._map.pointToOverlayPixel(this._center);
    this._div.style.left = position.x - this._length / 2 + "px";
    this._div.style.top = position.y - this._length / 2 + "px";
};
// 添加点击事件
SquareOverlay.prototype.addEventListener = function (event, fun) {
    this._div["on" + event] = fun
};


function AddWindow(center, length, name, price, num) {
    this._center = center;
    this._length = length;
    this._name = name;
    this._price = price;
    this._num = num;

}
AddWindow.prototype = new BMap.Overlay();

AddWindow.prototype.initialize = function (map) {
    this._map = map;

    var div = document.createElement("div");
    div.setAttribute("class", "map-marker-msg");

    var content = document.createElement("div");
    content.setAttribute("class", "map-view-contnet");
    var name = document.createElement("p");
    name.setAttribute("class", "map-view-p");
    name.innerText = this._name;

    var price = document.createElement("p");
    price.innerHTML = "均价：" + "<span class='map-num'>" + parseInt(this._price) + "</span>" + "元/平";
    var esf = document.createElement("p");
    esf.innerHTML = "二手房：" + "<span class='map-num'>" + this._num + "</span>" + "套";
    var spanNum = document.createElement("span");
    spanNum.setAttribute("class", "map-num");
    spanNum.innerText = this._num;

    var arrow = document.createElement("div");
    arrow.setAttribute("class", "arrow");
    var arrowD = document.createElement("div");
    arrowD.setAttribute("class", "arrow-d");

    content.appendChild(name);
    content.appendChild(price);
    content.appendChild(esf);
    content.appendChild(arrow);
    content.appendChild(arrowD);
    div.appendChild(content);

    map.getPanes().markerPane.appendChild(div);

// 保存div实例
    this._div = div;
    return div;
};
AddWindow.prototype.draw = function () {
    var position = this._map.pointToOverlayPixel(this._center);
    this._div.style.left = position.x - this._length / 2 - 45 + "px";
    this._div.style.top = position.y - this._length / 2 - 80 + "px";
};










