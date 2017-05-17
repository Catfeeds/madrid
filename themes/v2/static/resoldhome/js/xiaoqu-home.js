/**
 * Created by Administrator on 2016/10/26.
 */


Do.add('SuperSlide',{
    type : 'js',
    path : basedir + 'jquery.SuperSlide.2.1.1.js'
});

Do('SuperSlide',function () {
    jQuery(".slideBox").slide({mainCell: ".bd ul", autoPlay: true});
});

Do(function () {
    $(function () {

        $(".map-list-close").click(function () {
            $(".adress-list").hide();
            $(".show-map-list").show();
        });

        $(".show-map-list").click(function () {
            $(".adress-list").show();
            $(".show-map-list").hide();
        });

        $(".adress-list ul li").click(function () {
            alert($(this).text());
        });




        $(".map-tip .map-tip-ul li").click(function () {
            // alert;
            $("#search-name").text($(this).text());

            var overlays = map.getOverlays();
            for (var i = 0; i <overlays.length; i++){
                console.log(overlays[i]);
                map.removeOverlay(overlays[i])
            }

            var circle = new BMap.Circle(point, 2000, {
                fillColor: "blue",
                strokeWeight: 1,
                fillOpacity: 0.1,
                strokeOpacity: 0.1
            });
            map.addOverlay(circle);
            var marker = new BMap.Marker(point);  // 创建标注
            map.addOverlay(marker);


            var options = {
                onSearchComplete: function (results) {
                    var temp = [];

                    //
                    var mars = [];
                    // 判断状态是否正确
                    if (local.getStatus() == BMAP_STATUS_SUCCESS) {
                        // console.log(results);
                        temp = results.wr;
                        console.log(temp);
                        var str = "";
                        for (var i = 0; i < temp.length; i++) {
                            (function (i) {
                                // var $index = $(this).index();
                                // alert($index);
                                var dis = parseInt(map.getDistance(point, temp[i].point));
                                console.log(parseInt(map.getDistance(point, temp[i].point)));
                                str += "<li><a href='javascript:;'>" + (i + 1) + "." + temp[i].title + dis + "米" + "</a></li>";

                            })(i);

                            mars.push(addMarker(temp[i], map));

                        }
                        $(".adress-list .map-ul-box ul ").html(str);
                        $("#search-number").html("(" + temp.length + ")");

                        $(".adress-list .map-ul-box li").bind("click", function () {
                            var $index = $(this).index();
                            mars[$index][0].openInfoWindow(mars[$index][1],temp[$index].point);
                            map.setCenter( mars[$index][0].point);
                        })

                    }
                    $(".map-ul-box ul li").click(function () {
                        var $index = $(this).index();
                        // console.log(marks[$index]);

                    })
                }

            };
            //创建搜索
            var local = new BMap.LocalSearch(point, options);
            var searchName = $("#search-name").text();
            local.searchNearby(searchName, point);
        });
    });

//  小区地图
    var map = new BMap.Map("allmap", {enableMapClick: false});


    map.centerAndZoom(new BMap.Point(119.975549, 31.818144), 16);
    var point = new BMap.Point(119.975549, 31.818144);
    var circle = new BMap.Circle(point, 2000, {
        fillColor: "blue",
        strokeWeight: 1,
        fillOpacity: 0.1,
        strokeOpacity: 0.1
    });
    map.addOverlay(circle);
    var marker = new BMap.Marker(point);  // 创建标注
    map.addOverlay(marker);

    var options = {
        onSearchComplete: function (results) {
            var temp = [];
            var mars = [];
            // 判断状态是否正确
            if (local.getStatus() == BMAP_STATUS_SUCCESS) {
                console.log(results);
                temp = results.wr;
                // console.log(results);
                var str = "";
                for (var i = 0; i < temp.length; i++) {

                    (function (i) {
                        var $index = $(this).index();

                        var dis = parseInt(map.getDistance(point, temp[i].point));
                        console.log(parseInt(map.getDistance(point, temp[i].point)));

                        // $(".adress-list ul li a").eq(i).html(i + 1 + "." + temp[i].title + dis + '米');
                        str += "<li><a href='javascript:;'>" + (i + 1) + "." + temp[i].title + dis + "米" + "</a></li>";

                    })(i);
                    mars.push(addMarker(temp[i], map));
                }


                $(".adress-list .map-ul-box ul ").html(str);
                $(".adress-list .map-ul-box li").bind("click", function () {
                    var $index = $(this).index();
                    mars[$index][0].openInfoWindow(mars[$index][1],temp[$index].point);
                    map.setCenter(mars[$index][0].point)
                })
            }
        }
    };

    var local = new BMap.LocalSearch(point, options);

    var searchName = $("#search-name").text();

    local.searchNearby(searchName, point);

    function addMarker(arr, map) {
        var detail = arr;

        var icon = new BMap.Icon('./images/markers_02.png', new BMap.Size(20, 25), {
            anchor: new BMap.Size(10, 0)
        });
        var marker = new BMap.Marker(detail.point,{
            icon:icon
        });  // 创建标注
        map.addOverlay(marker);              // 将标注添加到地图中
        map.centerAndZoom(point, 15);
        var opts = {
            width: 200,     // 信息窗口宽度
            height: 50,     // 信息窗口高度
            title: "<span style='color: #d51938;font-size: 16px'>" + detail.title + "</span>" // 信息窗口标题
        };
        var infoWindow = new BMap.InfoWindow("<span style='color: #333;font-size: 14px'>" + detail.address + "</span>", opts);  // 创建信息窗口对象
        marker.addEventListener("click", function () {
            marker.openInfoWindow(infoWindow, detail.point); //开启信息窗口

            map.setCenter(marker.point);
        });

        return [marker, infoWindow];
    }
});

