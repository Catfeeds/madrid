<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-bar-chart font-green-haze"></i>
            <span class="caption-subject bold uppercase font-green-haze"> 来源统计 </span>
            <span class="caption-helper">展示集客表单来源分布情况（默认本月初至今）</span>
        </div>
    </div>
    <div class="portlet-body">
        <div id="lytj" class="chart" style="height: 800;">
        </div>
    </div>
</div>

<script type="text/javascript">
    var myChart = echarts.init(document.getElementById("lytj"));
    var options = {
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            orient : 'vertical',
            x : 'left',
            data:<?php echo CJSON::encode($data['legend']); ?>
        },
        toolbox: {
            show : true,
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                magicType : {
                    show: true, 
                    type: ['pie', 'funnel'],
                    option: {
                        funnel: {
                            x: '25%',
                            width: '50%',
                            funnelAlign: 'left',
                            max: 1548
                        }
                    }
                },
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        series : [
            {
                name:'访问来源',
                type:'pie',
                radius : '55%',
                center: ['50%', '60%'],
                data:<?php echo CJSON::encode($data['series']); ?>
            }
        ]
    };

    myChart.setOption(options); 
</script>