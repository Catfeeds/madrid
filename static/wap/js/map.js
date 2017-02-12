	// 百度地图API功能
	var mp = new BMap.Map("allmap");
	mp.addControl(new BMap.ZoomControl());   //添加地图缩放控件
	// 复杂的自定义覆盖物
    function ComplexCustomOverlay(point, title, price){
      this._point = point;
      this._title = title;
      this._price = price;
    }
    ComplexCustomOverlay.prototype = new BMap.Overlay();
    ComplexCustomOverlay.prototype.initialize = function(map){
      this._map = map;
      var div = this._div = createMapDiv(this._title,this._price);

      mp.getPanes().labelPane.appendChild(div);
      
      return div;
    }
    ComplexCustomOverlay.prototype.draw = function(){
      var map = this._map;
      var pixel = map.pointToOverlayPixel(this._point);
      var $div = $(this._div);
      var w = $div.width() + 10;
      var h = $div.height() + 10;
      this._div.style.left = pixel.x - 1/2 * w +  'px';
      this._div.style.top = pixel.y - h -20 + 'px';
    }


var point = new BMap.Point(116.404, 39.915);
addMapDot(116.404, 39.915, "望湖御景","6300");

var point = new BMap.Point(116.404, 39.926);
addMapDot(116.404, 39.926, "望湖御景","6300");

var point = new BMap.Point(116.404, 39.938);
addMapDot(116.404, 39.938, "望湖御景","6300");

mp.centerAndZoom(point, 14);

function addMapDot(x, y,title,price){
    var point = new BMap.Point(x, y);
    var myCompOverlay = new ComplexCustomOverlay(point,title,price);
    mp.addOverlay(myCompOverlay);
    mp.centerAndZoom(point, 17);
}

function addMapDotArray(arr){
    for(var i=0,len=arr.length;i<len;i++){
        var obj = arr[i];
        var x = obj.x;
        var y = obj.y;
        var title = obj.title;
        var price = obj.price;
        addMapDot(x,y,title,price);
    }
}
function createMapDiv(title,price){
    var html = '<div class="mapDot">';
    html += '<h3 class="title">' + title + '</h3>';
    html += '<p class="price">' + price + '元/m<sup>2</sup></p>';
    html += '</div>';
    return $(html).get(0);
}

function ajax_map_data(){
    mp.clearOverlays();

    var arr = [];
    for(var i = 0;i < 10; i++){
        var xr = Math.ceil(Math.random() * 10) / 1000;
        var yr = Math.ceil(Math.random() * 10) / 1000;
        var x = 116.404 + xr;
        var y = 39.915 + yr;
        var title = "望湖御景";
        var price = "6300";

        var obj = {
            x : x,
            y : y,
            title : title,
            price : price
        };
        arr.push(obj);
    }


    addMapDotArray(arr);
}

ajax_map_data();

var index = 0;
var start = 0;
var step = 20;
$('.map-loupanlist').find('.iconr').click(function() {
    start += step;
    var sindex = start + 1;
    var eindex = start + step;
    $(this).parent().find('p.index').text('第' + sindex + '-' + eindex + '个楼盘');
    ajax_map_data();
});
$('.map-loupanlist').find('.iconl').click(function() {
    if(start == 0) return;
    start -= step;
    var sindex = start + 1;
    var eindex = start + step;
    $(this).parent().find('p.index').text('第' + sindex + '-' + eindex + '个楼盘');
    ajax_map_data();
});
