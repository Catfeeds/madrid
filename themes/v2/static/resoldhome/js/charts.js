/**
 * Created by Administrator on 2016/11/3.
 */


function addCharts(id, title, data,xData,yData ) {
    var myChart = echarts.init(document.getElementById(id));
// 指定图表的配置项和数据
    var option = {
        title: {
            left: 'center',
            text: title,
            textStyle: {
                color: "#3e576f",
                fontSize: "12",
                fontWeight: 'normal'
            },
            top: "20"
        },
        tooltip: {},
        legend: {
            show: "false"
        },
        xAxis: {
            data: xData
        },
        yAxis: {
            data:yData
        },
        series: [{
            name: '房价',
            type: 'line',
            data: data,
            itemStyle: {
                normal: {
                    color: '#7492b6'
                }
            }
        }]
    };

// 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
}