<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-bar-chart font-green-haze"></i>
            <span class="caption-subject bold uppercase font-green-haze"> 订单量统计 </span>
            <span class="caption-helper">显示指定时间段内的集客收集量（默认本月初至今）</span>
        </div>
    </div>
    <div class="portlet-body">
        <div id="ddltj" class="chart" style="height: 800;">
        </div>
    </div>
</div>

<script type="text/javascript">
    var myChart = echarts.init(document.getElementById("ddltj"));
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
                boundaryGap : false,
                data : <?php echo CJSON::encode($data['xAxis']); ?>,
            }
        ],
        yAxis : [
            {
                type : 'value',
                axisLabel : {
                    formatter: '{value}单'
                }
            }
        ],
        series : [
            {
                name: '订单量',
                type:'line',
                data:<?php echo CJSON::encode($data['series']); ?>,
                <?php if($data['series']): ?>
                markPoint : {
                    data : [
                        {type:'max', 'name':'最大值'},
                        {type:'min', 'name':'最小值'},
                    ]
                },
                <?php endif; ?>
               /* markLine : {
                    data : [
                        {type : 'average', name : '平均值'}
                    ]
                }*/
            }
        ]
    };
    myChart.setOption(options); 
</script>