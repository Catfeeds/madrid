var theme_url = '/themes/v2/static/resoldhome/';
Do.add('jquery.nicescroll',{
    type : 'js',
    path : basedir + 'jquery.nicescroll.min.js'
});
Do.add('highcharts',{
    type : 'js',
    path : basedir + 'highcharts.js'
});
Do.add('template',{
    type : 'js',
    path : basedir + 'template.js'
});
Do.add('underscore',{
    type : 'js',
    path : basedir + 'underscore-min.js'
})

Do.add('SuperSlide',{
    type : 'js',
    path : basedir + 'jquery.SuperSlide.2.1.1.js'
});
Do.add('jqueryui',{
    type : 'js',
    path : basedir + 'jquery-ui-1.12.1.custom/jquery-ui.min.js'
});
Do.add('validform',{
    type:'js',
    path: basedir + 'validform.min.js'
});
Do.add('select2-css',{
    type:'css',
    path:basedir + 'select2/select2.css'
});
Do.add('select2',{
    type:'js',
    path:basedir + 'select2/select2.min.js',
    requires : ['select2-css']
});
Do.add('BMap',{
    type : 'js',
    path : 'http://api.map.baidu.com/getscript?v=2.0&ak=srGiaQruHjU9pu4s3QVnLYnC&services=&t=20150812134435'
})
Do.add('layer',{
    type : 'js',
    path : basedir + 'layer/layer.js',
    requires : ['layer-css']
})
Do.add('layer-css',{
    type : 'css',
    path : basedir + 'layer/skin/layer.css'
})

//轮播
Do('SuperSlide',function() {
    if($(".hot-areas").length > 0){
        $(".hot-areas").slide({ titCell:".r-s-tab li", mainCell:".r-tab-content",delayTime:0 });
    }
    if($(".change-box").length > 0){
        $(".change-box").slide({ titCell:".s-tab li", mainCell:".tab-content",delayTime:0 });
    }
    if($(".esf-slider").length > 0){
        $(".esf-slider").slide({ titCell:".smallImg li", mainCell:".bigImg", effect:"fold", autoPlay:true,delayTime:200,
            startFun:function(i,p){
                if(i==0){ $(".esf-slider .pre-btn").click() } else if( i%4==0 ){ $(".esf-slider .next-btn").click()}
            }
        });
        $(".esf-slider .smallScroll").slide({ mainCell:"ul",delayTime:100,vis:4,scroll:4,effect:"left",autoPage:true,prevCell:".pre-btn",nextCell:".next-btn",pnLoop:false });
    }
    if($(".chat-content").length > 0){
        $(".chat-content").slide({ titCell:".common-nav li", mainCell:".chat-box",trigger:"click" });
    }
});

Do(function(){
    Do('layer',function() {
        var $ok_content = $('.j-ok-dialog');
        var $error_content = $('.j-error-dialog');

        $ok_content.find('.closed').click(function() {
            location.href = $ok_content.find('.list-url').attr('href');
        });
        window.gDialog = {
            'ok' : function(msg,info_url,list_url,input_url) {
                $ok_content.find('.text').text(msg);
                $ok_content.find('.info-url').attr('href',info_url);
                $ok_content.find('.list-url').attr('href',list_url);
                $ok_content.find('.input-url').attr('href',input_url);
                layer.open({
                    skin : 'layer-popup',
                    area:['590px','284px'],
                    title : false,
                    content: $ok_content,
                    type:1,
                    closeBtn : 0
                });
            },
            'error' : function(msg) {
                layer.msg(msg);
            },
            'loading':function () {
                layer.load(2, {shade: false});
            },
            'closeAll' : function (type) {
                layer.closeAll(type);
            }
        };
    });

    $('.sub-nav').mouseenter(function(){
        $(this).find('.cbox').addClass('current');
        $(this).find('.lis').show();
    }).mouseleave(function(){
        $(this).find('.cbox').removeClass('current');
        $(this).find('.lis').hide();
    });
    $('.gotoTop').click(function() {
        $('html,body').animate({scrollTop:0},500);
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
    $(".sort-btn").hover(function(){
        $(this).siblings(".tips-notice").show();
    },function(){
        $(this).siblings(".tips-notice").hide();
    });

    if($('.bdsharebuttonbox').length>0){
        window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
    }
    Do('select2',function () {
        $.fn.select2.locales['zh-CN'] = {
            formatNoMatches: function () { return "没有找到匹配小区"; },
            formatInputTooShort: function (input, min) { var n = min - input.length; return "请输入小区名称";},
            formatInputTooLong: function (input, max) { var n = input.length - max; return "搜索的名称过长，请删掉" + n + "个字符";},
            formatSelectionTooBig: function (limit) { return "你只能选择最多" + limit + "项"; },
            formatLoadMore: function (pageNumber) { return "加载结果中…"; },
            formatSearching: function () { return "搜索中…"; }
        };
        $.extend($.fn.select2.defaults, $.fn.select2.locales['zh-CN']);
        $(".js-plot-select2").select2({
            ajax: {
                url: "/resoldhome/common/ajaxGetPlot",
                dataType: "json",
                delay: 250,
                data: function (keyword) {
                    return {
                        kw: keyword
                    };
                },
                results: function(data, page) {
                    return data;
                } // 构造返回结果
            },

            formatSelection: function(item) {
                return item.name;//注意此处的name，要和ajax返回数组的键值一样
            }, // 选择结果中的显示
            formatResult: function(item) {
                return item.name;//注意此处的name
            }, // 搜索列表中的显示
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 1,
            templateSelection: function (repo) {
                return repo.full_name || repo.text;
            },
            initSelection: function(element, callback){
                callback({id:element.val(),name:element.data('name')});
            }
        });
    });

    Do('validform',function () {
        var valid_form = $('.valid-form');
        var isFloat = /(^[0]\.{1}\d{1,2}$)|(^[1-9]\d*\.{1}\d{1,2}$)|(^[1-9]{1}\d*$)|(^[0]{1}$)/;
        var hxReg = /^[0-9]$/;
        var rentReg = /^[0-9](\d{1,5})?$/;
        var codeReg = /^\d{4}$/;
        var form = valid_form.Validform({
            postonce:true,
            ajaxPost:true,
            showAllError:true,
            tiptype:function (msg,o,cssctl) {
                var objtip = o.obj.closest('.option').find('.ui-errormsg');
                if(o.type == 3){
                    // cssctl(objtip,o.type);
                    if(objtip.length){
                        objtip.text(msg);
                    }else{
                        window.gDialog.error(msg);
                    }
                }
                if(o.type == 2){
                    objtip.text('');
                }
            },
            datatype:{
                "price" : function(gets,obj,curform,regxp) {
                    if(isFloat.test(gets)){
                        if(gets >= 0 && gets <=  100000){return true;}
                    }
                    return false;
                },
                "size" : function (gets,obj,curform,regxp) {
                    if(isFloat.test(gets)){
                        if(gets >= 2 && gets <=  10000){return true;}
                    }
                    return false;
                },
                "hx" : function (gets,obj,curform,regxp){
                    var category = curform.find('input[name="category"]:checked').val();
                    if(category == 1){
                        return hxReg.test(gets);
                    }
                    return true;
                },
                "floor" : function (gets,obj,curform,regxp) {
                    var msg = true;
                    obj.parent().children('input').each(function () {
                        var value = $(this).val();
                        if(value == ''){
                            msg = $(this).data('name')+'不能为空';
                            return false;
                        }
                        if(value == 0){
                            msg =   $(this).data('name')+'请填写除0外的数字';
                            return false;
                        }
                        if(value < -99 || value > 99){
                            msg = $(this).data('name')+'在-99到99之间';
                            return false;
                        }
                    });
                    return msg;
                },
                "floors" : function (gets , obj , curform , regxp) {
                    var floor = obj.siblings("input[name='floor']").val();
                    if(Number(gets) < Number(floor)){
                        return '总楼层不能小于所在楼层';
                    }
                    return true;
                },
                "rent" : function (gets , obj , curform , regxp) {
                    return rentReg.test(gets);
                },
                "code" : function (gets , obj , curform , regxp) {
                    if(realPhone != '' && $('input[name="phone"]').val() == realPhone)
                        return true;
                    return codeReg.test(gets);
                },
                "jyxm" : function (gets , obj , curform , regxp) {
                    var category = curform.find('input[name="category"]:checked').val();
                    if(category == 2){
                        var msg = '经营项目不能为空';
                        obj.closest('ul').find('input').each(function () {
                            if($(this).is(":checked")){
                                return msg = true;
                            }
                        });
                        return msg;
                    }
                    return true;
                },
                "ts" : function (gets , obj , curform , regxp) {
                       var count = 0 ;
                       obj.closest('ul').find('input').each(function () {
                            if($(this).is(":checked")){
                                count++;
                            }
                       })
                       return count > 5 ? false : true ;
                },
                'qwhx' : function (gets , obj , curform , regxp) {
                    var category = curform.find('input[name="category"]:checked').val();
                    if(category == 1){
                        var msg = '期望户型不能为空';
                        obj.closest('ul').find('input').each(function () {
                            if($(this).is(":checked")){
                                return msg = true;
                            }
                        });
                        return msg;
                    }
                    return true;
                },
                // 'yxlp' : function (gets , obj , curform , regxp) {
                //     var msg = '请选择意向楼盘';
                //     console.log(obj.parent());
                //     obj.parent().children("input").each(function () {
                //         if($(this).val()){
                //             return msg = true;
                //         }
                //     })
                //     return msg;
                // }
            },
            beforeSubmit:function(curform){
                gDialog.loading();
            },
            callback:function(res){
                gDialog.closeAll('loading');
                if(res.code){
                    gDialog.ok(res.msg,res.data.info_url,res.data.list_url,res.data.input_url);
                    $(".dialog").show();
                }else{
                    alert(res.msg);
                }
                return true;
            }
        });
        $('#send-code').on('click',function(){
            if(form.check(false, 'input[name="phone"]')) {
                var data = {
                    'phone' : $("input[name='phone']").val(),
                    'origin' : $(this).data('origin')
                };
                showTime(this, 60 , data);
            }
        });
        $('input[name="phone"]').keyup(function () {
             if($(this).val() == realPhone && realPhone != ''){
                 $(".ercode").hide();
             }else{
                 $(".ercode").show();
             }
        })
    });
    function showTime(btn, time , data) {
        time = time === undefined ? 60 : time;
        if (!$(btn).hasClass('dis-get')) {
            $.post('/api/resoldwapapi/sms',data, function (res) {
                if (res.status=='success') {
                    var IntervalName = setInterval(function () {
                        $(btn).addClass('dis-get');
                        $(btn).text(time + 's');
                        if (--time < 0) {
                            $(btn).removeClass('dis-get').text('获取验证码');
                            clearInterval(IntervalName);
                        }
                    }, 1000);
                    window.gDialog.error('发送成功');
                } else {
                    alert(res.msg);
                }
            }, 'json');
        }
    }

    $(".u-radio-group label input[name='category']").on('change',function () {
        var category =  $(this).val();
        if(category == 1){
            $("#wuye-fee").hide();
        }else{
            $("#wuye-fee").show();
        }
        for(var i=0;i<=3;i++){
            if(category == i){
                $(".display-"+i).show();
            }else{
                $(".display-"+i).hide();
            }
        }
    });

    $(".j-refresh").on('click',function () {
        $.ajax({
            type:'post',
            dataType:'json',
            url:$(this).data('url'),
            data:{'id' : $(this).data('id')},
            success:function(res){
                alert(res.msg);
                if(res.code)
                    location.reload();
            }
        })
    });

    $(".j-delete").on('click',function () {
        if(confirm("确定要删除这条房源吗?"))
        {
            $.ajax({
                type:'get',
                dataType:'json',
                url:$(this).data('url'),
                success:function(res){
                    alert(res.msg);
                    if(res.code)
                        location.reload();
                }
            })
        }
    });

    var $area = $("#area");
    if($area.length) {
        $.ajax({
            type: "post",
            url: "/resoldhome/common/getstreet",
            data: {
                area_id: $area.val()
            },
            dataType: "json",
            success: function (res) {
                if (res.code === false) {
                    window.gDialog.error(res.msg);
                    return false;
                }
                var streetList = '<option value="0">不限</option>';
                for (var i in res.data) {
                    streetList += '<option value="' + res.data[i].id + '">' + res.data[i].name + '</option>';
                }
                $("#street").html(streetList);
            }
        });
        $area.on('selectmenuchange', function () {
            var area_id = $(this).val();
            if (area_id == 0) {
                $("#street").html('<option value="0">不限</option>');
                return false;
            }
            $.ajax({
                type: "post",
                url: "/resoldhome/common/getstreet",
                data: {
                    area_id: area_id
                },
                dataType: "json",
                success: function (res) {
                    if (res.code === false) {
                        alert(res.msg);
                        return false;
                    }
                    var streetList = '<option value="0">不限</option>';
                    for (var i in res.data) {
                        streetList += '<option value="' + res.data[i].id + '">' + res.data[i].name + '</option>';
                    }
                    $("#street").html(streetList).selectmenu('refresh');
                }
            });
            return true;
        });
    }


});

Do('jqueryui',function() {
    //所有的select 使用selectmenu
    $('body').addClass('ui-esf');
    $('select').each(function() {
        var $self = $(this);
        var default_width = 88;
        $self.selectmenu().selectmenu('widget').css('width',$self.data('width') || default_width);
    });

    //替换checkbox样式
    $('input[type="checkbox"]').each(function() {
        var $self = $(this);
        $self.wrap('<span class="u-checkbox"></span>');
        var $parent = $self.parent();
        refresh($self);
        $parent.parent().click(function() {
            $self.prop('checked',!$self.prop('checked')).triggerHandler('change');
            return false;
        });
        $self.change(function() {
            refresh($self);
        });
        function refresh($checkbox){
            //初始化判断
            if($checkbox.is(':checked')){
                $checkbox.parent().addClass('checked');
            }else{
                $checkbox.parent().removeClass('checked');
            }
        }
    });

    //替换radio样式
    $('input[type="radio"]').each(function() {
        var $self = $(this);
        $self.wrap('<span class="u-radio"></span>');
        var $ele = $self.parent();
        var $group_radios = $("input[name=" + $self.attr('name')+ "]");
        //初始化判断
        refresh($self);

        $ele.parent().bind('click',function() {
            $group_radios.prop('checked',false).trigger('change');
            $self.prop('checked',true).trigger('change');
        });

        $self.change(function() {
            refresh($self);
        });

        function refresh($radio){
            //初始化判断
            if($radio.is(':checked')){
                $radio.parent().addClass('checked');
            }else{
                $radio.parent().removeClass('checked');
            }
        }
    });
});


//地图
Do('BMap',function () {
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
                    //console.log(overlays[i]);
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
                            for(var i = 0;i<results.getCurrentNumPois();i++){
                                temp.push(results.getPoi(i));
                            }
                            // console.log(results);
                            //temp = results.xr;
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
        var $ui_map_box = $('#ui-map-box');
        var lat = $ui_map_box.data('lat');
        var lng = $ui_map_box.data('lng');

// 需要
        map.centerAndZoom(new BMap.Point(lng, lat), 15);
        var point = new BMap.Point(lng, lat);
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
                        //temp = results.xr;
                        for(var i = 0;i<results.getCurrentNumPois();i++){
                            temp.push(results.getPoi(i));
                        }
                        var str = "";
                        for (var i = 0; i < temp.length; i++) {

                            (function (i) {
                                var $index = $(this).index();
                                var dis = parseInt(map.getDistance(point, temp[i].point));
                                // console.log(parseInt(map.getDistance(point, temp[i].point)));

                                str += "<li><span class='digit'>" + (i + 1) + '.' + "</span><span class='text'>" + temp[i].title + "</span><span class='distance'>" + dis + "米</span></li>";
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

            var icon = new BMap.Icon(theme_url + 'images/markers_02.png', new BMap.Size(20, 25), {
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
//图表
Do('highcharts','underscore',function () {
    var $price = $('.price-box-wrapper');
    if($price.length == 0) return;
    var id = $price.data('id') || 85;
    var $junjia = $price.find('.junjia');
    var $last_month = $price.find('.last_month');
    var $last_year = $price.find('.last_year');

    // 获取价格走势
    $.ajax({
        type: "get",
        url: "/api/resoldwapapi/plotchart",
        data: ({"hid": id}),
        dataType: "json",
        success: function (data) {
            // console.log(data);


            var result = data.data;
            var last_month_price = result.lastMonthP;
            var last_year_price = result.lastYearP;
            var junjia_price = result.price;

            if(last_month_price > 0){
                $last_month.addClass('up');
            }else if(last_month_price < 0){
                $last_month.addClass('down');
            }

            if(last_year_price > 0){
                $last_year.addClass('up');
            }else if(last_year_price < 0){
                $last_year.addClass('down');
            }
            $last_month.find('em').text(last_month_price + '%');
            $last_year.find('em').text(last_year_price + '%');
            $junjia.text(junjia_price);

            charts("#chat-1", result.categories,result.datas.lpj);
            charts("#chat-2",result.categories,result.datas.qyj);
            charts("#chat-3",result.categories,result.datas.ctj);
        }
    });
    function charts(id, categories, detail) {
        $(id).highcharts({
            title: {
                text: categories[0]+"至"+ categories[categories.length-1] + '均价',
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
                title: {
                    text: '均价'
                },
                gridLineDashStyle: 'Dot',
                gridLineColor: "#dfdfdf",
                gridLineWidth: 1,
                lineWidth: 1,
                lineColor: "#666",
                //maxTickInterval:100000,
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
                    data: _.map(detail.data,function(o) {
                        return o * 1e3;
                    }),
                    color: "#4572a7"
                }]
        })
    }

});
//弹框
Do('layer','validform',function () {
    $('.j-report-btn').click(function() {
        var $pop_tpl = $('#pop-tpl');
        var infoid = $(this).data('infoid');
        var type = $(this).data('type');
        var infoname = $(this).data('infoname');

        if($pop_tpl){
            var pop_tpl = $pop_tpl.html();
            var $dom = $(pop_tpl).appendTo('body');

            $dom.find('form').Validform({
                tipSweep : true,
                tiptype : function(msg,o,cssctl) {
                    if(o.type===3){
                        alert(msg);
                    }
                },
                beforeSubmit : function() {
                    var url = '/api/resoldWapApi/esfreport';
                    //神代码
                    $.post(url,{
                        'content' : $('#post_content').val(),
                        'infoid' : infoid,
                        'infoname' : infoname,
                        'code' : $('.yzm-btn').prev().val(),
                        'phone' : $('#post_phone').val(),
                        'reason' : $('.post_reason:checked').data('reason'),
                        'type' : type
                    },function(obj) {
                        alert(obj.msg);
                        if(obj['status'] === 'success'){
                            $dom.find('.popup-close').click();
                        }
                    });
                }
            });
            $dom.find('.popup-close').click(function() {
                layer.closeAll();
                $dom.remove();
            });
            $dom.find('.yzm-btn').click(function() {
                var $self = $(this);
                if($self.hasClass('disabled')) return;
                var phone = $('#post_phone').val();
                api.myMod_userApi.sms(phone).done(function(obj) {
                    if(obj.status == 'success'){
                        var t = 60;
                        var default_text = $self.val();
                        $(this).addClass('disabled');
                        var tid = setInterval(function() {
                            $self.val(t-- + 's');
                            if(t == 0){
                                clearInterval(tid);
                                $self.val(default_text)
                                $self.removeClass('disabled');
                            }
                        },1e3);
                    }else{
                        alert(obj.msg);
                    }
                });

            });
            layer.open({
                skin : 'layer-popup',
                area:['550px','380px'],
                title : false,
                content: $dom,
                'closeBtn' : 0,
                type:1
            });
        }
    })
});



function urm_login(){

}

//全站通用
Do(function() {
    window.api = {};
    api.siteCommon = {
        //小区价格走势
        'plotchart' : function(hid) {
            var url = '/api/resoldwapapi/plotchart';
            var $resource = $.get(url,{
                'hid'  : hid
            });
            return $resource;
        },
        //用户接口
        'commonUser' : function() {
            var url = '/api/resoldwapapi/commonuser';
            var $resource = $.get(url);
            return $resource;
        },
        //站点配置
        'siteConfig' : function() {
            var url = '/api/resoldwapapi/commonsiteconfig';
            var $resource = $.get(url,{
            });
            return $resource;
        }
    };
    api.myMod_userLogin = {
        'urm_login' : function() {
            api.siteCommon.siteConfig().done(function(obj) {
                if(obj['status'] == 'success'){
                    var data = obj.data;
                    var href = location.href;
                    location.href = data.login_url + href;
                }
            });
        },
    };
    api.myMod_userApi = {
        'add_fav' : function(fid,category) {
            var url = '/api/userapi/mycollectadd';
            var $resource = $.post(url,{
                'fid' : fid,
                'category' : category
            });
            return $resource;
        },
        'is_fav' : function(fid,category) {
            var url = '/api/userApi/mycollectcheck';
            var $resource = $.get(url,{
                'fid' : fid,
                'category' : category
            });
            return $resource;
        },
        'delete_myfav' : function(id) {
            var url = ' /api/userapi/mycollectdelete';
            var $resource = $.post(url,{
                'id' : id
            });
            return $resource;
        },
        'sms' : function(phone) {
            origin = '举报';
            var url = '/api/resoldwapapi/sms';
            var $resource = $.post(url,{
                'phone' : phone,
                'origin' : origin
            });
            return $resource;
        }
    };

    //地图接口
    api.myMod_map = {
        'area' : function(type) {
            var url = '/api/resoldwapapi/mapfindarea';
            var $resource = $.get(url,{
                'type' : type
            });
            return $resource;
        },
        'rangefind' : function(distance,kw,lat,lng,type,level) {
            var url = '/api/resoldwapapi/mapfindlocation';
            var $resource = $.get(url,{
                'points' : distance,
                'kw' : kw,
                'lat' : lat,
                'lng' : lng,
                'type' : type,
                'level' : level
            });
            return $resource;
        },
        'plotinfo' : function(type,hid,filter_arr) {
            var url = '/api/resoldwapapi/plotmap';
            var params = $.extend({},{
                'hid' : hid,
                'type' : type
            },filter_arr);
            var $resource = $.get(url,params);
            return $resource;
        }
    };
    //验证码接口
    
    api.jubaoModel = {
        'jubao_form' : function(data) {
            var url = '/api/resoldWapApi/esfreport';
            var $resource = $.post(url,{
                'content' : data['content'],
                'infoid':data['infoid'],
                'infoname':data['infoname'],
                'phone':data['phone'],
                'reason':data['reason'],
                'type' : data['type'],
                'code' : data['code'],
            });
            return $resource;
        }
    };
    //举报接口
    api.myDialog = {
        'show' : function(msg) {
            alert(msg);
        }
    }
});


//收藏
Do(function() {
    var $favbtn = $('.j-fav-btn');
    if($favbtn.length > 0){
            
        $favbtn.each(function() {
            var $self = $(this);
            var fid = $self.data('fid');
            var category = $self.data('category');
            var is_fav = 0;
            var id = 0;

            api.myMod_userApi.is_fav(fid,category).done(function(obj) {
                if(obj['status'] === 'success'){
                    is_fav = obj.data.code;
                    if(is_fav){
                        id = obj.data.id;
                        $self.addClass('is_fav');
                    }
                    $self.click(function() {
                        if(is_fav){
                            api.myMod_userApi.delete_myfav(id).done(function(obj) {
                                api.myDialog.show(obj.msg);
                                if(obj['status'] === 'success'){
                                    is_fav = 0;
                                    id = 0;
                                    $self.removeClass('is_fav');
                                }
                            });
                        }else{
                            api.myMod_userApi.add_fav(fid,category).done(function(obj) {
                                api.myDialog.show(obj.msg);
                                if(obj['status'] === 'success'){
                                    is_fav = 1;
                                    id = obj.data.id;
                                    $self.addClass('is_fav');
                                }
                            });
                        }
                    })
                }else{
                    $self.click(function() {
                        alert('您尚未登录');
                    });
                }
            });
        })    
    }
});
//搜索
Do('template',function () {
    var tid = null;
    $(".search-box .search-input input").keyup(function () {
        var $self = $(this);
        clearTimeout(tid);
        tid = setTimeout(function(){
            get_ajax_info($self);
        },500);         
    });
    function get_ajax_info($self){
        var $searchBox =  $(".search-list-box");
        var $type = $self.data('type');
        // 邻校房不传type
        if($type != undefined && $type > 0) {
            // data-type 二手房：1 租房：2 小区：3 
            var $ajax_link_url = $type == "2" ? '/resoldhome/plot/pzflist' : ($type == "1" ? '/resoldhome/plot/pesflist' : '/resoldhome/plot/index');
            if ($self.val().length >= 2) {
                var $searchWord = $self.val();
                $.ajax({    
                    url: $self.data('url'),
                    type: "get",
                    aynce:"true",
                    data: {'kw':$searchWord,'category':$self.data('category')},
                    dataType: "json",
                    success: function (res) {
                        if(res.data.length) {
                            var info = res.data;
                            var html = '<ul>';
                                for (var i = 0; i < info.length; i++) {
                                    // 二手房跳小区二手房列表页
                                    if($type == "1" && info[i].saling_esf_num > 0) 
                                        html += '<li><a href="'+$ajax_link_url+'?py='+info[i].pinyin+'"><span>'+info[i].name+'<em>'+info[i].area+info[i].street+'</em></span><span class="right">约'+info[i].saling_esf_num+'条房源</span></a></li>';
                                    // 租房跳小区租房列表页
                                    else if($type == "2" && info[i].saling_zf_num > 0)
                                        html += '<li><a href="'+$ajax_link_url+'?py='+info[i].pinyin+'"><span>'+info[i].name+'<em>'+info[i].area+info[i].street+'</em></span><span class="right">约'+info[i].saling_zf_num+'条房源</span></a></li>';
                                    // 小区跳小区首页
                                    else if(info[i].saling_esf_num > 0) 
                                        html += '<li><a href="'+$ajax_link_url+'?py='+info[i].pinyin+'"><span>'+info[i].name+'<em>'+info[i].area+info[i].street+'</em></span><span class="right">约'+info[i].saling_esf_num+'条房源</span></a></li>';
                                }
                            html += '</ul>';
                            $searchBox.html(html);
                            $searchBox.show();
                        }else{
                            $searchBox.empty();
                            $searchBox.hide();
                        }
                    }
                })
            } else {
                $searchBox.empty();
                $searchBox.hide();
            }
        } else {
            // 邻校房
            if ($self.val()) {
                var $searchWord = $self.val();
                $.ajax({
                    url: $self.data('url'),
                    type: "get",
                    aynce:"true",
                    data: {'kw':$searchWord},
                    dataType: "json",
                    success: function (res) {
                        if(res.data.length) {
                            var html = template($self.data('template'), res);
                            $searchBox.html(html);
                            $searchBox.show();
                        }else{
                            $searchBox.hide();
                        }
                    }
                })
            } else {
                $searchBox.hide();
            }
        }
    }

});
//地图找房
Do('BMap','template','jquery.nicescroll',function () {
    var myMap = function() {
        var map = null;
        var mapContainer = 'allmap';
        var cityName = typeof pc_city_name == 'undefined' ? '常州' : pc_city_name;
        var areazoom = 12;
        var streetzoom = 15;
        var plotzoom = 16;
        var cache = {};
        var type = map_type ? map_type : 1;
        var $panel = $('.map-list-box');
        var is_show_detail = false;
        var $filter_box = $('.map-select-box .left-box');
        var filter_arr = {
            //关键词
            'sort' : 0
        };
        var my_location = null;
        var $map_container = null;
        init_filter_arr();
        function init_filter_arr(){
            var filters = $('.map-select-box').find('.filter').each(function(k,o) {
                var $self = $(this);
                var $text = $self.find('.dropdown_toggle');
                var $droplist = $self.find('.filter_sel_box');
                var key = $self.data('name');
                var origin_text = $self.find('.dropdown_toggle').text();
                var obj = {
                    'key' : key,
                    'origin_text' : origin_text,
                    'value' : 0
                };
                $self.data(obj);
                $self.on('click','a',function() {
                    var $ele= $(this);
                    var text = $ele.text();
                    var value = $ele.data('id');
                    $self.data('value',value);
                    $droplist.hide();
                    $text.html(text + '<span class="caret list-icon"></span>');
                    var filters = get_filter_arr();
                    if(is_show_detail){
                        var plot = $panel.data('plot');
                        refresh_plot_detail(plot);
                    }
                    return false;
                });
            });
            $('.map-select-box').find('.delete-all').click(function() {
                filters.each(function(k,o) {
                    var $self = $(this);
                    var $text = $self.find('.dropdown_toggle');
                    $self.data('value',0);
                    $text.html($self.data('origin_text') + '<span class="caret list-icon"></span>');
                });
                if(is_show_detail){
                    var plot = $panel.data('plot');
                    refresh_plot_detail(plot);
                }
            });

        }
        function show_filter(){
            $filter_box.show();
        }
        function hide_filter(){
            $filter_box.hide();
        }
        function render_now(){
            if(my_location){
                map.removeOverlay(mk);
                var mk = myLocationOverlay('我的位置',my_location);
                map.addOverlay(mk);
            }
        }
        //本地定位
        function location_now(){
            var geolocation = new BMap.Geolocation();
            geolocation.getCurrentPosition(function(r){
                if(this.getStatus() == BMAP_STATUS_SUCCESS){
                    my_location = r.point;
                    map.centerAndZoom(r.point,plotzoom);
                    render_now();
                }
                else {
                    alert('failed'+this.getStatus());
                }        
            },{enableHighAccuracy: true})
        }
        //设置筛选条件
        function get_filter_arr(){
            $('.map-select-box').find('.filter').map(function(k,o) {
                var $self = $(o);
                var key = $self.data('key');
                var value = $self.data('value');
                filter_arr[key] = value;
            });
            return filter_arr;
        }
        //设置筛选条件
        function set_filter_arr(key,value){
            filter_arr[key] = value;
        }
        //初始化
        this.init = function() {
            $map_container = $('#allmap');
            if($map_container.length == 0) return;
            $map_container.parent().height($(window).height() - 200);
            $('body').css('overflow','hidden');
            this.init_map();
            init_panel();
            map.addEventListener('zoomend', function () {
                map.clearOverlays();
                clear_cache();
                repaint();
            });

            map.addEventListener('dragend', function (e) {
                setTimeout(function() {
                    repaint();
                },1e3);
            });
        };

        //初始化地图
        this.init_map = function() {

            map = new BMap.Map(mapContainer,{minZoom:areazoom - 2,maxZoom:plotzoom + 2,enableMapClick:false});
            map.disableDoubleClickZoom();
	        var bottom_right_navigation = new BMap.NavigationControl({anchor: BMAP_ANCHOR_BOTTOM_RIGHT});
            var bottom_right_control = new BMap.ScaleControl({anchor: BMAP_ANCHOR_BOTTOM_RIGHT});
            map.addControl(bottom_right_navigation);
            //map.addControl(bottom_right_control);
            map.centerAndZoom(cityName, areazoom);
            map.enableScrollWheelZoom(true);
        }
        //更多条件切换
        $('.map-select-box .more-select').click(function() {
            $('.last-ul').toggle();
        });
        $('.map-select-box .location').click(function() {
            //location_now();
        });

        //左侧面板事件绑定
        function init_panel(){
            $panel.on('click','.area-item',function() {
                var $self = $(this);
                var id = $self.data('area');
                cache['area_' + id].triggerHandler('click');
            })
            $panel.on('click','.street-item',function() {
                var $self = $(this);
                var id = $self.data('street');
                cache['street_' + id].triggerHandler('click');
            })
            $panel.on('click','.plot-item',function() {
                var $self = $(this);
                var id = $self.data('plot');
                var div = cache['plot_' + id];
                var lng = div.data('lng');
                var lat = div.data('lat');
                map.centerAndZoom(new BMap.Point(lng,lat),plotzoom);
                div.triggerHandler('click');
            })
            //排序默认
            $panel.on('click','.mdetail-box .sort_normal',function() {
                set_filter_arr('sort',0);
                var plot = $panel.data('plot');
                refresh_plot_detail(plot);
                return false;
            });
            //排序最新
            $panel.on('click','.mdetail-box .sort_new',function() {
                set_filter_arr('sort',1);
                var plot = $panel.data('plot');
                refresh_plot_detail(plot);
                return false;
            });
            //排序价格
            $panel.on('click','.mdetail-box .sort_price',function() {
                var $self = $(this);
                var is_toggle = $self.hasClass('on');
                if(is_toggle){
                    if($self.find('em').hasClass('down')){
                        set_filter_arr('sort',3);
                    }else {
                        set_filter_arr('sort',2);
                    }
                }else{
                    if($self.find('em').hasClass('down')){
                        set_filter_arr('sort',2);
                    }else {
                        set_filter_arr('sort',3);
                    }
                }
                var plot = $panel.data('plot');
                refresh_plot_detail(plot);
                return false;
            });

        }

        function refresh_plot_detail(plot){
            var filter = get_filter_arr();
            api.myMod_map.plotinfo(type,plot,filter).done(function(obj) {
                if(check_is_plotzoom()){
                    show_filter();
                    obj.data.pageCount = new Array(obj.data.pageCount);
                    $panel.data('plot',plot);
                    var data = $.extend({},obj.data,{
                        'filter' : filter
                    });
                    //console.log(data);
                    template_plot_detail(data);
                }
            })
        }
        function repaint(){
            //清除所有标注 OVERLAYS
            var zoom = map.getZoom();
            if(zoom >= plotzoom){
                find_plot_range();
            }
            if(zoom < plotzoom && zoom > areazoom){
                if(is_open_street == 1){
                    is_show_detail = false;
                    find_street_range();
                }else{
                    find_plot_range();
                }
            }
            if(zoom <= areazoom){
                is_show_detail = false;
                find_area_range();
            }
            if(is_show_detail){
                show_filter();
            }else{
                hide_filter();
            }
            //render_now();
        }

        function check_is_plotzoom(){
            var zoom = map.getZoom();
            if(is_open_street == 1){
                if(zoom >= plotzoom){
                    return true;
                }else{
                    return false;
                }
            }else{
                if(zoom > areazoom){
                    return true;
                }else{
                    return false;
                }
            }
        }
        function check_is_streetzoom(){
            var zoom = map.getZoom();
            if(zoom < plotzoom && zoom > areazoom){
                return true;
            }else{
                return false;
            }
        }
        function check_is_areazoom(){
            var zoom = map.getZoom();
            if(zoom <= areazoom){
                return true
            }else{
                return false;
            }
        }
        //初始化区域
        function find_area_range() {
            api.myMod_map.area(type).done(function(obj) {
                if(check_is_areazoom()){
                    init_area(obj.data);
                }
            })
        }
        //初始化街道
        function find_street_range() {
            var obj = get_point_distance();

            var distance = obj.distance;
            var kw = '';
            var lat = obj.lat;
            var lng = obj.lng;
            var level = 1;
            api.myMod_map.rangefind(distance,kw,lat,lng,type,level).done(function(obj) {
                if(obj.data.areas){
                    var data =  {
                        'lists' : obj.data.areas || [],
                        'total' : obj.data.count || 0
                    };
                    if(check_is_streetzoom()){
                        init_street(data);
                    }
                }
            });
        }
        //初始化小区
        function find_plot_range() {
            var obj = get_point_distance();
            var distance = obj.distance;
            var kw = '';
            var lat = obj.lat;
            var lng = obj.lng;
            var level = 2;
            api.myMod_map.rangefind(distance,kw,lat,lng,type,level).done(function(obj) {
                var data =  {
                    'lists' : obj.data.areas || [],
                    'total' : obj.data.count || 0
                };
                if(check_is_plotzoom()){
                    init_plot(data);
                }
            });
        }
        //获取小区房源信息
        function get_plot_info(hid){
            api.myMod_map.plotinfo(type,hid,filter_arr)
        }
        //初始化标注小区
        function init_plot(data){
            var lists = data.lists || [];
            var total = data.total;

            if(!is_show_detail){
                template_plot(data);
            }
            for(var i=0,len=lists.length;i<len;i++){
                var plot = lists[i];
                var name = plot.name;
                var id = plot.id;
                var lng = plot.lng;
                var lat = plot.lat;
                var num = plot.num;
                var price = +plot.ave_price;
                var price_str = "<span class='em'>" + price + "</span> 元/平";
                if(price == 0){
                    price_str = '面议';
                }
                var content = "<div class='map-marker map-plot' data-plot=" + id + "><div class='info'><div class='name'>" + name + "<span class='em'>(" + num + ")</span></div></div></div></div>";
                var point = new BMap.Point(lng,lat);
                var overlay = new myOverlay(point,content);
                if(is_cache(id)){
                    continue;
                }else{
                    cache_id(id,true);
                }
                map.addOverlay(overlay);
                cache['plot_' + id] = overlay.getDiv();
                overlay.getDiv().data({
                    'lng' : lng,
                    'lat' : lat
                });
                overlay.getDiv().on('click',function() {
                    var $self = $(this);
                    var plot = $self.data('plot');
                    $('.mapopen').removeClass('mapopen');
                    $self.addClass('mapopen');
                    is_show_detail = true;
                    refresh_plot_detail(plot);
                });

            };
        }

        //初始化区域标注
        function init_area(data) {
            var lists = data.lists;
            var total = data.total;
            template_area(data);
            for(var i=0,len=lists.length;i<len;i++){
                var area = lists[i];
                var name = area.name;
                var lng = area.lng;
                var lat = area.lat;
                var num = area.num;
                var id = area.id;
                if(is_cache(id)){
                    continue;
                }else{
                    cache_id(id,true);
                }
                var content = "<div class='map-marker map-area' data-lng =" + lng + " data-lat=" + lat + "><p class='name'>" + name + "</p><p class='num'>" + num + "套</p></div>";
                var point = new BMap.Point(lng,lat);
                var overlay = new myOverlay(point,content);
                map.addOverlay(overlay);
                cache['area_' + id] = overlay.getDiv();
                //点击时间读取街道信息
                overlay.getDiv().on('click',function() {
                    map.clearOverlays();
                    var lng = $(this).data('lng');
                    var lat = $(this).data('lat');
                    var point = new BMap.Point(lng,lat);
                    setTimeout(function() {
                        map.centerAndZoom(point,streetzoom);
                    },10);
                });
            }
        }

        //初始化街道标注
        function init_street(data){
            var lists = data.lists;
            var total = data.total;
            template_street(data);
            for(var i=0,len=lists.length;i<len;i++){
                var street = lists[i];
                var name = street.name;
                var id = street.id;
                var lng = street.lng;
                var lat = street.lat;
                var num = street.num;
                if(is_cache(id)){
                    continue;
                }else{
                    cache_id(id,true);
                }
                var content = "<div class='map-marker map-street' data-lng=" + lng + " data-lat=" + lat + " data-street=" + id + "><p class='name'>" + name + "</p><p class='num'>" + num + "套</p></div>";
                var point = new BMap.Point(lng,lat);
                var overlay = new myOverlay(point,content);

                map.addOverlay(overlay);
                cache['street_' + id] = overlay.getDiv();
                overlay.getDiv().on('click',function() {
                    map.clearOverlays();
                    var lng = $(this).data('lng');
                    var lat = $(this).data('lat');
                    var point = new BMap.Point(lng,lat);
                    setTimeout(function() {
                        map.centerAndZoom(point, plotzoom);
                    },10);
                });

            }
        }
        //获取中心点与距离
        function get_point_distance(){
            var center = map.getCenter();
            var current_bounds = map.getBounds();
            var height = $(window).height() - 200;
            var width = $(window).width();
            var main_left = (width - 1150) / 2;
            if(main_left < 0) main_left = 0;
            var left_top_point= new BMap.Pixel(
                 0,
                 0
            );
            var right_bottom_point = new BMap.Pixel(
                width,
                height
            );
            var right_top_point = new BMap.Pixel(
                width,
                height
            );
            var left_bottom_point = new BMap.Pixel(
                0,
                height
            );
            var left_top = map.pixelToPoint(left_top_point);
            var right_top = map.pixelToPoint(right_top_point);
            var right_bottom = map.pixelToPoint(right_bottom_point);
            var left_bottom = map.pixelToPoint(left_bottom_point);
            left_top = {
                'lat' : left_top['lat'],
                'lng' : left_top['lng']
            };
            left_bottom = {
                'lat' : left_bottom['lat'],
                'lng' : left_bottom['lng']
            };
            right_top = {
                'lat' : right_top['lat'],
                'lng' : right_top['lng']
            };
            right_bottom = {
                'lat' : right_bottom['lat'],
                'lng' : right_bottom['lng']
            };

            //var sw_point = current_bounds.getSouthWest();
            //var ne_point = current_bounds.getNorthEast();
            var points = {
                'left_top' : left_top,
                'right_top' : right_top,
                'left_bottom' : left_bottom,
                'right_bottom' : right_bottom
            };
            return {
                'lng' : center.lng,
                'lat' : center.lat,
                'distance' : points
            };
        }
        function myLocationOverlay(text,point){
            // 复杂的自定义覆盖物
            function ComplexCustomOverlay(point, text){
              this._point = point;
              this._text = text;
            }
            ComplexCustomOverlay.prototype = new BMap.Overlay();
            ComplexCustomOverlay.prototype.initialize = function(map){
              this._map = map;
              var div = this._div = document.createElement("div");
              div.style.position = "absolute";
              div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);
              div.style.backgroundColor = "#EE5D5B";
              div.style.border = "1px solid #BC3B3A";
              div.style.color = "white";
              div.style.height = "18px";
              div.style.padding = "2px";
              div.style.lineHeight = "18px";
              div.style.whiteSpace = "nowrap";
              div.style.MozUserSelect = "none";
              div.style.fontSize = "12px"
              var span = this._span = document.createElement("span");
              div.appendChild(span);
              span.appendChild(document.createTextNode(this._text));      
              var that = this;

              var arrow = this._arrow = document.createElement("div");
              arrow.style.background = "url(http://map.baidu.com/fwmap/upload/r/map/fwmap/static/house/images/label.png) no-repeat";
              arrow.style.position = "absolute";
              arrow.style.width = "11px";
              arrow.style.height = "10px";
              arrow.style.top = "22px";
              arrow.style.left = "10px";
              arrow.style.overflow = "hidden";
              div.appendChild(arrow);
             
              map.getPanes().labelPane.appendChild(div);
              
              return div;
            }
            ComplexCustomOverlay.prototype.draw = function(){
              var map = this._map;
              var pixel = map.pointToOverlayPixel(this._point);
              this._div.style.left = pixel.x - parseInt(this._arrow.style.left) + "px";
              this._div.style.top  = pixel.y - 30 + "px";
            }
            return new ComplexCustomOverlay(point,text);
        }
        function refresh_scroll($panel){
            $('.nicescroll-rails').remove();
            $panel.find('.j-nicescroll').niceScroll({
                cursorcolor: "#ccc",//#CC0071 光标颜色
                cursoropacitymax: 1, //改变不透明度非常光标处于活动状态（scrollabar“可见”状态），范围从1到0
                touchbehavior: false, //使光标拖动滚动像在台式电脑触摸设备
                cursorwidth: "5px", //像素光标的宽度
                cursorborder: "0", // 游标边框css定义
                cursorborderradius: "5px",//以像素为光标边界半径
                autohidemode: false //是否隐藏滚动条
            });
        }
        //获取区域模版
        function template_area(data) {
            var tpl = 'area-tpl';
            var html = template(tpl,data);
            $panel.html(html);
            refresh_scroll($panel);
        }
        //获取街道模版
        function template_street(data) {
            var tpl = 'street-tpl';
            var html = template(tpl,data);
            $panel.html(html);
            refresh_scroll($panel);
        }
        //获取小区模版
        function template_plot(data) {
            var tpl = 'plot-tpl';
            var html = template(tpl,data);
            $panel.html(html); 
            refresh_scroll($panel);
        }
        //小区详情
        function template_plot_detail(data){
            if(type == 1){
                var tpl = 'plot-detail-tpl';
            }
            if(type == 2){
                var tpl = 'plot-zu-detail-tpl';
            }
            var html = template(tpl,data);
            $panel.html(html); 
            refresh_scroll($panel);
        }

        //是否缓存了
        function is_cache(id){
            return cache[id] === true;
        }
        //缓存数据
        function cache_id(id,data){
            cache[id] = data;
        }

        function clear_cache(){
            cache = {};
        }
        //区域的样式
        function myOverlay(point,content){
            this.point = point;
            this.content = content;
        }
        myOverlay.prototype = new BMap.Overlay();
        myOverlay.prototype.initialize = function(map) {
            this.map = map;
            var div = this.div = $(this.content);
            div[0].style.zIndex = BMap.Overlay.getZIndex(9999);

            map.getPanes().mapPane.appendChild(div[0]);
            return div[0];
        }
        myOverlay.prototype.getDiv = function() {
            return this.div;
        }
        myOverlay.prototype.draw = function() {
            var map = this.map;
            var pixel = map.pointToOverlayPixel(this.point);
            this.div.css({
                left : pixel.x,
                top : pixel.y
            })
        }
    };

    if($('#allmap').length)
        new myMap().init();

    // 控制二手房、租房、求租、求购列表页筛选的显示
    // 如果子元素为空 父元素将不显示
    var filterList = $('.category-select').children('dl');
    if(filterList.length > 0) {
        for (var i = 0; i < filterList.length; i++) {
            if($(filterList[i]).children('dd').html().replace(/(^\s*)|(\s*$)/g,'') == "") {
                $(filterList[i]).css('display','none');
            }
        }
    }
});
