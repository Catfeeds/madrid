	var map = new BMap.Map("fullmap");
	map.centerAndZoom(new BMap.Point(116.384, 39.925), 14);

	map.addControl(new BMap.ZoomControl());  //添加地图缩放控件
	var marker1 = new BMap.Marker(new BMap.Point(116.384, 39.925));  //创建标注
	map.addOverlay(marker1);                 // 将标注添加到地图中
	//创建信息窗口
	var infoWindow1 = new BMap.InfoWindow("普通标注");
	marker1.addEventListener("click", function(){this.openInfoWindow(infoWindow1);});

