/**
 * Created by Administrator on 2016/11/1.
 */

Do.add('highcharts',{
    type : 'js',
    path : basedir + 'highcharts.js'
});

Do(function () {
        $(function () {

            $(".extend-box .close").click(function () {
                $(".assort-distance").addClass("fixed-side");

                $(".close-assort ").show();
                $(".extend-box").hide();
            });

            $(" .close-assort ").click(function () {
                $(".assort-distance").removeClass("fixed-side");

                $(".close-assort ").hide();
                $(".extend-box").show();
            });

            var $mapLabel = $(".map-label .clearSonAttr li");
            var $bmapKeyword = $("#bmap-keyword");
            var $resultCount = $("#result-count");

            var url = location.href;
            // alert(url);

            //标注
            var mars = [];
            $(".map-label li").on("click", function () {

                $bmapKeyword.text($(this).children("a").children("i").text());
                var overlays = map.getOverlays();
                for (var i = 0; i < overlays.length; i++) {
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
                        mars = [];
                        // 判断状态是否正确
                        if (local.getStatus() == BMAP_STATUS_SUCCESS) {
                            // console.log(results);
                            temp = results.wr;
                            // console.log(results);
                            var str = "";
                            for (var i = 0; i < temp.length; i++) {
                                (function (i) {
                                    var $index = $(this).index();
                                    var dis = parseInt(map.getDistance(point, temp[i].point));
                                    // console.log(parseInt(map.getDistance(point, temp[i].point)));
                                    str += "<li><span class='digit'>" + (i + 1) + '.' + "</span><span class='text'>" + temp[i].title + "</span><span class='distance'>" + dis + '米' + "</span></li>"

                                })(i);
                                mars.push(addMarker(temp[i], map));
                            }
                            $(".extend-box ul").html("").append(str);
                            $("#result-count").text("(" + temp.length + ")");
                            $(".extend-box ul li").bind("click", function () {
                                var $index = $(this).index();
                                mars[$index][0].openInfoWindow(mars[$index][1], temp[$index].point);
                                map.setCenter( mars[$index][0].point);
                            })
                        }


                    }

                };
                //创建搜索
                var local = new BMap.LocalSearch(point, options);
                // var searchName = $(".adress-list .list-header span").text();
                local.searchNearby($bmapKeyword.text(), point);

            });

        });

        var map = new BMap.Map("ui-map-box", {enableMapClick: false});

// 需要
        map.centerAndZoom(new BMap.Point(119.975549, 31.818144), 15);
        var point = new BMap.Point(119.975549, 31.818144);
        var marker = new BMap.Marker(point);  // 创建标注
        map.addOverlay(marker);
        var circle = new BMap.Circle(point, 2000, {
            fillColor: "blue",
            strokeWeight: 1,
            fillOpacity: 0.1,
            strokeOpacity: 0.1
        });
        map.addOverlay(circle);


        $(function () {

            var $bmapKeyword = $("#bmap-keyword");

            var options = {
                onSearchComplete: function (results) {
                    var temp = [];
                    var mars = [];
                    // 判断状态是否正确
                    if (local.getStatus() == BMAP_STATUS_SUCCESS) {
                        temp = results.wr;
                        var str = "";
                        for (var i = 0; i < temp.length; i++) {

                            (function (i) {
                                var $index = $(this).index();
                                var dis = parseInt(map.getDistance(point, temp[i].point));
                                // console.log(parseInt(map.getDistance(point, temp[i].point)));

                                str += "<li><span class='digit'>" + (i + 1) + '.' + "</span><span class='text'>" + temp[i].title + "</span><span class='distance'>" + dis + "</span></li>";
                                map.openInfoWindow(temp[i].point);
                            })(i);
                            mars.push(addMarker(temp[i], map));
                        }
                        $(".extend-box ul").html("").append(str);
                        $("#result-count").text("(" + temp.length + ")");

                        $(".extend-box ul li").bind("click", function () {
                            var $index = $(this).index();
                            mars[$index][0].openInfoWindow(mars[$index][1], temp[$index].point);
                            map.setCenter(mars[$index][0].point);
                        })
                    }
                }

            };

            var local = new BMap.LocalSearch(point, options);
            var searchName = $bmapKeyword.text();
            local.searchNearby(searchName, point);

        });

        function addMarker(arr, map) {
            var detail = arr;

            var icon = new BMap.Icon('./images/markers_02.png', new BMap.Size(20, 25), {
                anchor: new BMap.Size(10, 0)
            });

            var marker = new BMap.Marker(detail.point, {
                icon: icon
            });  // 创建标注
            map.addOverlay(marker);              // 将标注添加到地图中
            var opts = {
                width: 200,     // 信息窗口宽度
                height: 50,     // 信息窗口高度
                title: "<span style='color: #d51938;font-size: 16px'>" + detail.title + "</span>" // 信息窗口标题
            };
            var infoWindow = new BMap.InfoWindow("<span style='color: #333;font-size: 14px'>" + detail.address + "</span>", opts);  // 创建信息窗口对象
            marker.addEventListener("click", function () {
                marker.openInfoWindow(infoWindow, detail.point); //开启信息窗口
                map.setCenter(detail.point);
            });
            return [marker, infoWindow];
        }

// 获取id
        function parseUrl() {
            var url = location.href;
            var i = url.indexOf('?');
            if (i == -1)return;
            var querystr = url.substr(i + 1);
            var arr1 = querystr.split('&');
            var arr2 = new Object();
            for (i in arr1) {
                var ta = arr1[i].split('=');
                arr2[ta[0]] = ta[1];
            }
            return arr2;
        }


    }
);

Do('highcharts',function () {

    // 获取价格走势
    $.ajax({
        type: "get",
        url: "http://hjhouse.hualongxiang.com/api/resoldwapapi/plotchart?hid=",
        data: ({"hid": 2552}),
        dataType: "json",
        success: function (data) {
            // console.log(data);
            var result = data.data;
            // console.log(result);

            charts("#chat-1", result.categories,result.datas.lpj);
            charts("#chat-2",result.categories,result.datas.qyj);
            charts("#chat-3",result.categories,result.datas.ctj);
        }
    });
    function charts(id, categories, detail) {
        $(id).highcharts({
            title: {
                text: categories[0]+"至"+ categories[categories.length-1],
                y:20,
                margin:20,
                style: {
                    color: '#4572a7',
                    fontSize: '12px'
                }
            },
            legend: {
                enabled: false
            },
            yAxis: {
                title: null,
                gridLineDashStyle: 'Dot',
                gridLineColor: "#dfdfdf",
                gridLineWidth: 1,
                lineWidth: 1,
                lineColor: "#666",
                //maxTickInterval:100000,
                minTickInterval: 2000
                // categories: categories
            },
            tooltip: {
                valueSuffix: '元'
            },
            credits: {
                enabled: false // 禁用版权信息
            },
            xAxis: {
                gridLineDashStyle: 'Dot',
                gridLineColor: "#dfdfdf",
                gridLineWidth: 1,
                lineWidth: 1,
                lineColor: "#666",
                startOnTick: true,
                tickmarkPlacement: 'on',
                // minTickInterval:1,
                categories: categories
            },
            series: [
                {
                    name: detail.title,
                    data: detail.data,
                    color: "#4572a7"
                }]
        })
    }

});
Do(function () {
    $(".jubao-btn").click(function () {
        var $pop = $("<iframe id='pop' style='position: absolute;top: 0;left: 0;' width='100%' height='100%' scrolling=no frameborder=no src='http://hjhouse.hualongxiang.com/eshouse-html-2016/pop.html'></iframe>");

        // $("body").css({"overflow":"hidden"});
        $("body").append($pop);

    });

});

