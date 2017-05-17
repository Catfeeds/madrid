<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-bar-chart font-green-haze"></i>
            <span class="caption-subject bold uppercase font-green-haze"> 意向楼盘排行 </span>
            <span class="caption-helper">显示指定时间段内参与分销的意向楼盘排行（默认本月初至今）</span>
        </div>
    </div>
    <div class="portlet-body">
        <div id="yxlpph" class="chart" style="min-height:300px">
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#yxlpph').css('height', <?php echo count($data['series'])*25+60; ?>);
    var myChart = echarts.init(document.getElementById("yxlpph"));
    var options = {
        tooltip : {
            trigger: 'axis'
        },
        toolbox: {
            show : true,
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                magicType: {show: true, type: ['line', 'bar']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : false,
        xAxis : [
            {
                type : 'value',
                boundaryGap : [0, 0.01]
            }
        ],
        yAxis :
            {
                type : 'category',
                data : <?php echo CJSON::encode($data['yAxis']); ?>,
                boundaryGap: true,
            },
        series : [
            {
                name:'意向人数',
                type:'bar',
                data:<?php echo CJSON::encode($data['series']); ?>,
                datail:{
                    height:40,
                }
            },
        ]
    };
    myChart.setOption(options);
</script>
