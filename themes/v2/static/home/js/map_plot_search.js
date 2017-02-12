// JavaScript Document

Do.add('autocomplete', {
	path: 'http://static.hualongxiang.com/lib/jquery.autocomplete.js',
    type: 'js'
});

Do.add('bmap', {
    path: 'http://api.map.baidu.com/getscript?v=1.5&ak=415167759dc5861ddbbd14154f760c7e&services=&t=20140102035215',
	type: 'js',
	requires: ['autocomplete']
});



Do(function(){

	Do('bmap',function(){
		//自定义OVERLAY
		function ComplexCustomOverlay(point, text, price, className){
            this._point = point;
            this._text = text;
            if( typeof price != 'undefined')
            {
            	this._price = price;
            }else{
            	this._price = '';
            }
            if( typeof className != 'undefined' ) {
                this._className = className + ' pr';
            } else {
                this._className = 'map_sell_now pr';
            }
            this._div = null;
		}
		ComplexCustomOverlay.prototype = new BMap.Overlay();
		ComplexCustomOverlay.prototype.initialize = function(map){
			this._map = map;

			var div = document.createElement('div');
            div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);
            div.style.position = "absolute";
            div.style.MozUserSelect = "none";
            div.style.whiteSpace = 'nowrap';
            div.className = 'map_find';

            if(this._className == 'map-init pr'){
                var html = '<span class="map-text" style="display:block;">' + this._text + '</span>';
                var div_c = document.createElement('div');
                div_c.className = this._className;
                $(div_c).append(html);
                div.appendChild(div_c);
                var arrow = this._arrow = document.createElement("div");

                arrow.style.position = "absolute";
                arrow.style.width = "11px";
                arrow.style.height = "10px";
                arrow.style.top = "25px";
                arrow.style.left = "35px";
                arrow.style.overflow = "hidden";
                div.appendChild(arrow);
            }else{


                var div_c = document.createElement('div');
                div_c.className = this._className;
                var html = '<span class="left map_icon"></span><span class="mid map_icon">' + this._text + '<span class="priceinfo" style="display:none">' + this._price + '</span></span><span class="right map_icon"></span><span class="arrow map_icon"></span>';
                $(div_c).append(html);
                div.appendChild(div_c);

                var arrow = this._arrow = document.createElement("div");
                arrow.style.position = "absolute";
                arrow.style.width = "11px";
                arrow.style.height = "10px";
                arrow.style.top = "22px";
                arrow.style.left = "10px";
                arrow.style.overflow = "hidden";
                div.appendChild(arrow);

                var tmp = div.childNodes;
                var btn = tmp[0];
                var price = btn.childNodes[1].childNodes[1];

                btn.onmouseover = function() {
                    btn.className = 'map_sell_hover pr';
                    div.style.zIndex = 999;
                    price.style.display = 'inline';

                }

                btn.onmouseout = (function(i) {
                    return function(){
                        btn.className = i;
                        div.style.zIndex = 900;
                        price.style.display = 'none';
                    }
                })(this._className)


                btn.onclick = function() {

                }

            }

			map.getPanes().labelPane.appendChild(div);

			this._div = div;

			return div;
		}
		ComplexCustomOverlay.prototype.draw = function(){
			var map = this._map;
			var pixel = map.pointToOverlayPixel(this._point);
			this._div.style.left = pixel.x - parseInt(this._arrow.style.left) + "px";
			this._div.style.top  = pixel.y - 40 + "px";
		}
		ComplexCustomOverlay.prototype.addEventListener = function(event,custom_method){
			if( this._div ) {
				this._div['on'+event] = custom_method;
			}
		}


		//初始化地图标注
		function initMapOverLays(){
			$.ajax({
				'url' : getAreaInfoUrl,
				'type' : 'get',
				'data' : condition,
				'dataType' : 'json',
				'success' : function( data ) {
					if( data.length > 0 ){
						for( var i=0; i<data.length; i++ ){
							if( data[i]['lng'] > 0 && data[i]['lat'] > 0 && data[i]['num'] > 0) {
								var title = '<p>' + data[i]['name'] + '</p><p>' + data[i]['num'] + '</p>';

								var overLay = new ComplexCustomOverlay(new BMap.Point(data[i]['lng'],data[i]['lat']), title,'','map-init');
								map.addOverlay( overLay );

								overLay.addEventListener('click',(function(data){
									return function(){
										var id =data['id'];
										$('.search_area[data-id="'+id+'"]').click();
									}
								})(data[i]));
							}
						}
					}
				}
			});
		}

		//打开新窗口
		function openWindow(data){
			window.open('http://house.hualongxiang.com/' + data['pinyin']);
		}

		//小区信息框
		function plotInfoWindow( data ) {
			//小区链接
			var plot_url = data['url'];
			//小区名
			var plot_name = data['name'];
			//小区状态
			var plot_status_span = '';
			if( data['sale_status'] == '待售' ) {
				plot_status_span = '<a class=" sell_status map_icon sell_pre">待售</a>';
			} else if( data['sale_status'] == '在售' ) {
				plot_status_span = '<a class="sell_status map_icon sell_now">在售</a>';
			} else {
				plot_status_span = '<a class=" sell_status map_icon sell_out">尾盘</a>';
			}

			//小区售价
			var plot_pay_span = '';
			if( data['price'] > 0 ){
				unit = data['unit'];
				plot_pay_span = '<span class="fw rc fs16">'+data['price']+'</span>' + unit;
			} else {
				plot_pay_span = '<span class="fw rc fs16">暂无均价</span>';
			}
			//开盘时间
			var plot_opendate = data['open_time'];
			//小区地址
			var plot_address = data['address'].substr(0,18);
			//小区电话
			var plot_phone = data['phone'];
			//小区图片
			var plot_image = data['image'];
			//楼盘信息
			var plot_info_url = data['link']['[楼盘信息]'];
			//户型图
			var plot_room_pic = data['link']['[户型图]'];
			//相册
			var plot_pic_url = data['link']['[相册]'];
			//楼盘咨询
			var plot_daogou_url = data['link']['[楼盘资讯]'];
			//问答
			var plot_ask_url = data['link']['[问答]'];

			var html = '<div class="new_house_pop"><div class=""><a href="'+plot_url+'" target="_blank" class="fw fs16 bc fl mr10">'+plot_name+'</a>'+plot_status_span+'<a href="'+plot_url+'" target="_blank" class="fl tuan map_icon ml5">我要团购</a></div><div class="blank10"></div><dl><dt><a href="'+plot_url+'" target="_blank"><img src="'+plot_image+'" width="120px" height="90px"></a></dt><dd><p>参考售价：'+plot_pay_span+'</p><p>开盘时间：'+plot_opendate+'</p><p>楼盘地址：'+plot_address+'</p><p>咨询电话：<span class="fw rc fs16">'+plot_phone+'</span></p></dd></dl><div class="blank15"></div><div class="tags"><a href="'+plot_info_url+'" target="_blank">[楼盘信息]</a><a href="'+plot_room_pic+'" target="_blank">[户型图]</a><a href="'+plot_pic_url+'" target="_blank">[相册]</a><a href="'+plot_daogou_url+'" target="_blank">[楼盘资讯]</a><a href="'+plot_ask_url+'" target="_blank">[问答]</a><a href="'+plot_url+'" target="_blank">[业主小区]</a> </div><div class="clear"></div></div>';

			//不含有手机图标
			var opts = {
				'enableMessage' : false,
				'offset' : new BMap.Size( 10 , -20),
			}

			var infoWindow = new BMap.InfoWindow(html,opts);

			return infoWindow;
		}

		//获取地图范围内的小区,并在当前地图中标注
		function getMapPlots() {
			var center = map.getCenter();
			var current_bounds = map.getBounds();
			var sw_point = current_bounds.getSouthWest();
			var ne_point = current_bounds.getNorthEast();

			var distance = map.getDistance(sw_point,ne_point);

			$.ajax({
				'url' : getPlotInfoUrl,
				'type' : 'get',
				'data' : $.extend({},condition,{lng:center.lng,lat:center.lat,distance:distance}),
				'dataType' : 'json',
				'success' : function(data){
					if( data.length > 0 ) {
						for( var i = 0; i < data.length; i++) {
							var title = data[i]['name'];
							var className = '';
							var price;

							if( data[i]['price'] > 0 ){
								unit = data[i]['unit'];
								price = ' | 均价' + data[i]['price'] + unit;
							} else {
								price = ' | 暂无均价';
							}

                            if( data[i]['sale_status'] ==  '待售' ) {
                                className = 'map_sell_pre';
                            } else if( data[i]['sale_status'] == '在售' ) {
                                className = 'map_sell_now';
                            } else {
                                className = 'map_sell_out';
                            }

							var overLay = new ComplexCustomOverlay( new BMap.Point(data[i]['lng'], data[i]['lat']), title, price, className );

							var infoWindow = plotInfoWindow( data[i] );

							map.addOverlay( overLay );

							if($('body').attr('id')=='mini'){
								overLay.addEventListener('click', (function(i){
									return function(){
										window.open(data[i]['url'],'_blank');
									}
								})(i));
							}else{
								//从新房列表跳转过来查看指定的房源，默认弹出
								(function(m,n,a,i){
									if(location.hash && parseFloat(lng)==parseFloat(n) && parseFloat(lat)==parseFloat(a) && close){
										m.openInfoWindow(i , new BMap.Point(n , a));
										close = false;
									}
								})(map,data[i]['lng'],data[i]['lat'],infoWindow);

								overLay.addEventListener('click', (function(m,n,a,i) {
									return function() {
										m.openInfoWindow(i , new BMap.Point(n , a));
									}
								})(map,data[i]['lng'],data[i]['lat'],infoWindow));
							}
						}
					}
				}
			});
		}

		var map_div_width = $('#map').width();
		var map_div_height = $('#map').height();

		var condition = {
			'wuye' : 0,
			'price' : 0,
			'tese' : 0,
			'area' : 0
		};

		var map = new BMap.Map('map' , {
            'enableMapClick' : false
        });

		//初始化地图
		var locateArr = location.hash.substring(1).split(",");

		if(location.hash){
			var lng = locateArr[0];
			var lat = locateArr[1];
			map.setZoom(12);
			map.centerAndZoom( new BMap.Point(lng,lat) ,18);
			var close = true
		}else{
			map.centerAndZoom(cityName);
		}


		//获取地图缩放层级
		var zoom = '';

		//允许滚轮缩放
		map.enableScrollWheelZoom();

		//监听时间:LOAD
		map.addEventListener('load' , function(){
			zoom = map.getZoom();
			initMapOverLays();
		});

		//缩放监听事件
		map.addEventListener('zoomend', function() {
			var overLays = map.getOverlays();

			//清除所有标注 OVERLAYS
			if( overLays.length > 0 ){
				for( var i=0; i<overLays.length; i++ ) {
					map.removeOverlay(overLays[i]);
				}
			}

			//放大地图
			if( map.getZoom() > zoom ) {
				//开始获取小区
				getMapPlots();
			} else {
				//缩小地图
				initMapOverLays();
			}
		});

		//拖动监听事件
		map.addEventListener('dragend' , function(){
			if( map.getZoom() > zoom ) {
				var overLays = map.getOverlays();
				//清除所有标注 OVERLAYS
				if( overLays.length > 0 ) {
					for( var i=0; i<overLays.length; i++ ) {
						map.removeOverlay( overLays[i] );
					}
				}
				//生成新的标注
				getMapPlots();
			}
		});

        //初始化不限样式
        $('.inforight').each(function(index){
            if( index > 0 ){
                $(this).find('a').first().css({
                    'font-weight':'bold',
                    'color' : '#D80000'
                });
            }
        });

        //搜索条件样式
        $('.search_left_condition').bind('click',function(){
            $(this).css({
                'font-weight':'bold',
                'color':'#D80000'
            }).siblings().css({
                    'font-weight':'normal',
                    'color':'#0446BE'
                });
        });

		//搜索物业
		$('.search_wuye').bind('click' , function(){
			condition['wuye'] = $(this).data('id');

			var overLays = map.getOverlays();

			//清除所有标注 OVERLAYS
			if( overLays.length > 0 ){
				for( var i=0; i<overLays.length; i++ ) {
					map.removeOverlay(overLays[i]);
				}
			}
			if(map.getZoom() <= zoom) map.setZoom(13);

			getMapPlots();
		});

		//搜索价格
		$('.search_price').bind('click',function(){
			condition['price'] = $(this).data('id');

			var overLays = map.getOverlays();

			//清除所有标注 OVERLAYS
			if( overLays.length > 0 ){
				for( var i=0; i<overLays.length; i++ ) {
					map.removeOverlay(overLays[i]);
				}
			}

			getMapPlots();
		});

		//搜搜特色
		$('.search_tese').bind('click' , function(){
			condition['tese'] = $(this).data('id');
			var overLays = map.getOverlays();

			//清除所有标注 OVERLAYS
			if( overLays.length > 0 ){
				for( var i=0; i<overLays.length; i++ ) {
					map.removeOverlay(overLays[i]);
				}
			}
			if(map.getZoom() <= zoom) map.setZoom(13);

			getMapPlots();
		});

		//快速定位
		$('.search_area').bind('click', function(){
			condition['area'] = $(this).data('id');
			var overLays = map.getOverlays();

			//清除所有标注 OVERLAYS
			if( overLays.length > 0 ){
				for( var i=0; i<overLays.length; i++ ) {
					map.removeOverlay(overLays[i]);
				}
			}

			if( $(this).data('lat') > 0 && $(this).data('lng') > 0 ) {
				map.setCenter(new BMap.Point($(this).data('lng') , $(this).data('lat')));
				map.setZoom(14);
			}

			getMapPlots();
		});

		//搜索条件样式
		$('.search_left_condition').bind('click',function(){
			$(this).css({
				'font-weight':'bold',
				'color':'#D80000'
			}).siblings().css({
				'font-weight':'normal',
				'color':'#0446BE'
			});
		});


		//autocomplete
		$('#plot_map_search').autocomplete(searchPlotInfoUrl,{
			minChars: 1,
			resultsClass: "fang_search_box",
			selectFirst: true,
			width: 310,
			scrollHeight : 'auto',
			autoFill: false,
			dataType: 'json',
            extraParams:{kw:function() { return $('#plot_map_search').val();}},
			formatItem : function(data, i, n, value) {
                //BUG
                if($('#action-selected').text() !== '新房') return;

				if ( i == 1 ) {
					return '<span class="r_c mb5 db pr10 pl10">请点击选择的小区</span><p><a class="c_link fl">' + data.name + '</a><span class="gc9 fr">' + data.address + '</span></p>';
				}else{
					return '<p><a class="c_link fl">' + data.name + '</a><span class="gc9 fr">' + data.address + '</span></p>';
				}
			},
			parse: function(data) {
				var parsed = [];
				for( var i = 0; i < data.length ; i ++ ){
					parsed[parsed.length] = {
						data : data[i],
						value : data[i].name + data[i].address,
						result : data[i].name
					}
				}
				return parsed;
			}
		}).result(function(event,item){
			if( item['lat'] > 0 && item['lng'] > 0 ){
				condition = '';
				map.setCenter(new BMap.Point(item['lng'] , item['lat']));
				map.setZoom(18);
			}
		}).bind('focus',function(){
            if( $(this).val() == '请输入楼盘关键词' ){
                $(this).val('');
            }
        }).bind('blur',function(){
            if( $(this).val() == '' ){
                $(this).val('请输入楼盘关键词');
            }
        });
        $('#searchbut').click(function() {
            var $form = $(this).closest('form');
            var url = $form.prop('action');
            if(url){

            }else{
                return false;
            }
        });

            //头部搜索下拉
            (function() {
                var $searchselect = $('#search-select');
                var $actionselected = $('#action-selected');
                var $actionselect = $searchselect.find('.action-select');

                $searchselect.hover(function() {
                    $actionselect.show();
                },function() {
                    $actionselect.hide();
                });

                //点击后回调
                $actionselect.find('li').click(function() {
                    var url = $(this).data('url');
                    $actionselected.text($(this).text());
                    $('#plot_map_search').val('');
                    $actionselect.hide();
                    $actionselected.closest('form').prop('action', url ? url : '');
                });

                $('body').click(function() {
                    $actionselect.hide();
                });
            })();

	});
});
