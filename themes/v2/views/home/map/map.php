<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <style type="text/css">
            body, html{width: 100%;height: 100%;margin:0;font-family:"微软雅黑";}		
        </style>
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=415167759dc5861ddbbd14154f760c7e"></script>
        <title>城市坐标定位</title>
    </head>
    <body>
        <div id="allmap" style='width:100%;height:100%;margin:0;padding:0'></div>
    </body>
</html>
<script type="text/javascript">
    // 百度地图API功能
    var map = new BMap.Map("allmap");

<?php if (isset($lng) && !empty($lng)&&isset($lat) && !empty($lat)) { ?>
    var point = new BMap.Point(<?php echo $lng ?>, <?php echo $lat ?>);
        map.centerAndZoom(point, 14);// 用城市名设置地图中心点
<?php } ?>

<?php if (isset($school) && !empty($school)) {
    foreach ($school as $v) { ?>
            var marker1 = new BMap.Marker(new BMap.Point(<?php echo $v->map_lng ?>, <?php echo $v->map_lat ?>));
            var icon = new BMap.Icon('/static/home/images/map_mark.png', new BMap.Size(25, 33), {imageOffset: new BMap.Size(-100, -115), anchor: new BMap.Size(10, 33)});
            marker1.setIcon(icon);
            map.addOverlay(marker1);
            addfunc(" <?php echo $v->name ?><br><br>电话： <?php echo $v->phone ?> <br>地址： <?php echo $v->address ?>");
    <?php }
} ?>

    function addfunc(pointid) {
        var infowindow1 = new BMap.InfoWindow(pointid, {enableMessage: false});
        marker1.addEventListener("click", function() {
            this.openInfoWindow(infowindow1);
        });
    }

</script>
