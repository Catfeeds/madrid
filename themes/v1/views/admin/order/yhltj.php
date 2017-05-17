<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-bar-chart font-green-haze"></i>
            <span class="caption-subject bold uppercase font-green-haze"> 用户量统计 </span>
            <span class="caption-helper">显示指定时间段内的不同状态的用户量（默认本月初至今）</span>
        </div>
    </div>
    <div class="portlet-body">
        <div id="yhltj" class="chart" style="height: 500px;">
        </div>
    </div>
</div>

<script type="text/javascript">
    var myChart = echarts.init(document.getElementById("yhltj"));
    var options = {
            tooltip : {
                trigger: 'axis'
            },
            toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    data : <?php echo CJSON::encode(array_keys($data)); ?>
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    name : '数量',
                }
            ],
            series : [
                {
                    name:'数量',
                    type:'bar',
                    data:<?php echo CJSON::encode(array_values($data)); ?>,
                },
            ]
        };
    myChart.setOption(options);
</script>
