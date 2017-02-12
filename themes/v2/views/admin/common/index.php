<?php
$this->pageTitle = '房产数据营销后台欢迎您';
?>
<style type="text/css">
    .page-content{
       background: #F1F3FA;
    }
    </style>
<div class="row">
    <div class="col-lg-4 col-md-4">
        <div class="dashboard-stat blue-madison">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <?php echo $price&&$price->data[0] ? '￥'.$price->data[0] : '无'; ?>
                </div>
                <div class="desc">
                    上月新盘均价
                </div>
            </div>
            <a class="more" href="<?php echo $this->createUrl('plot/priceTrendList')?>">
                查看更多 <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="dashboard-stat red-intense">
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <?php echo $plotNum; ?>
                </div>
                <div class="desc">
                    在线新盘数
                </div>
            </div>
            <a class="more" href="<?php echo $this->createUrl('plot/list')?>">
                查看更多 <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="dashboard-stat green-haze">
            <div class="visual">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="details">
                <div class="number">
                    <?php echo $userNum; ?>
                </div>
                <div class="desc">
                    今日集客数
                </div>
            </div>
            <a class="more" href="<?php echo $this->createUrl('order/list')?>">
                查看更多 <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <i class="icon-bar-chart font-green-sharp font-red-sunglo"></i>
                    <span class="caption-subject bold uppercase">集客统计</span>
                </div>
                <div class="actions">
                    <a href="<?php echo $this->createUrl('order/statistics') ?>" class="btn btn-default btn-sm"><i class="fa fa-search"></i>更多</a>
                </div>
            </div>
            <div class="portlet-body">
                <div id="jkltj" style="height:270px"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
		<div class="portlet light bordered" style="height:365px">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-share font-blue-steel hide"></i>
					<span class="caption-subject font-blue-steel bold uppercase">待回答问题</span>
				</div>
				<div class="actions">
					<a href="<?php echo $this->createUrl('ask/list') ?>" class="btn btn-default btn-sm"><i class="fa fa-search"></i>更多</a>
				</div>
			</div>
			<div class="portlet-body">
				<ul class="feeds">
                    <?php foreach($question as $v): ?>
					<li>
						<div class="col1">
							<a class="cont" href="<?php echo $this->createUrl('ask/edit',['id'=>$v->id]); ?>" target="_blank">
								<div class="cont-col1">
									<div class="label label-sm label-danger">
										<i class="fa fa-question"></i>
									</div>
								</div>
								<div class="cont-col2">
									<div class="desc">
										 <?php echo Tools::u8_title_substr($v->question,60); ?>
									</div>
								</div>
							</a>
						</div>
						<div class="col2">
							<div class="date">
                                <?php echo Tools::friendlyDate($v->created,'mohu'); ?>
							</div>
						</div>
					</li>
                    <?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-12">
    	<div class="portlet light bordered">
    		<div class="portlet-title">
    			<div class="caption">
    				<i class="icon-cursor font-purple-intense hide"></i>
    				<span class="caption-subject font-purple-intense bold uppercase">买房顾问统计</span>
    			</div>
    		</div>
    		<div class="portlet-body">
    			<div id="mfgw" style="height:250px">

    			</div>
    		</div>
    	</div>
    </div>
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-share font-blue-steel hide"></i>
                    <span class="caption-subject font-black-steel bold uppercase">升级公告</span>
                </div>
                <div class="actions">
					<a href="http://www.hangjiayun.com/product/house#upgrade" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-search"></i>更多</a>
				</div>
            </div>
            <div class="portlet-body">
                <div style="height:250px">
                    <div class="scroller" style="height: 250px;" data-always-visible="1" data-rail-visible1="1" data-handle-color="#D7DCE2">

                         <ul class="feeds">
                        <?php foreach($announcement as $v): ?>
                        <li>
                            <?php echo $v; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScriptFile('/static/global/scripts/echarts/echarts-all.js', CClientScript::POS_END);
?>
<script type="text/javascript">
    <?php Tools::startJs(); ?>
    var myChart = echarts.init(document.getElementById("jkltj"));
    myChart.setOption({
        grid:{
            x:30,
            x2:0,
            y2:25
        },
        title : {
            text: "",
            subtext: ""
        },
        tooltip : {
            trigger: "axis",
            formatter: "{b}<br>集客参与数：{c}",
        },
        toolbox: {
            show : true,
            feature : {
                dataView : {show: true, readOnly: true},
                magicType: {
                    show: true,
                    type: ["line","bar"],
                },
                restore : {show: true},
                saveAsImage : {show: true}
            },
        padding: 0,
        },
        xAxis :
            {
                type : "category",
                name: "日期",
                data : <?php echo CJSON::encode($chart['xAxis']) ?>
            }
        ,
        yAxis :
            {
                type : "value",
                name: "集客参与数",
                axisLabel : {
                    formatter: "{value}单"
                }
            },
        axis :{
            axisLine:{
                show: true,
                lineStyle:{
                    color: "#48b",
                    width: 2,
                    type: "solid"
                }
            }
        },
        series : [
            {
                type:"line",
                data: <?php echo CJSON::encode($chart['series']); ?>
            }
        ]
    });
    window.onresize = myChart.resize;

    //圆形图
    var labelTop = {
    normal : {
        label : {
            show : true,
            position : 'center',
            formatter : '{b}',
            textStyle: {
                baseline : 'bottom'
            }
        },
        labelLine : {
            show : false
        }
    }
};
    var labelFromatter = {
        normal : {
            label : {
                formatter : function (params){
                    return 100 - params.value + '%'
                },
                textStyle: {
                    baseline : 'top'
                }
            }
        },
    }
    var labelBottom = {
        normal : {
            color: '#ccc',
            label : {
                show : true,
                position : 'center'
            },
            labelLine : {
                show : false
            }
        },
        emphasis: {
            color: 'rgba(0,0,0,0)'
        }
    };
    var radius = [50, 60];//外圆与内圆半径
    var pieChart = echarts.init(document.getElementById('mfgw'));
    pieChart.setOption({
    legend: {
        x : 'center',
        y : 'bottom',
        data:[
            '本月成交率','本月带看率','本月集客分配率'
        ]
    },

    toolbox: {
        show : true,
        feature : {
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    series : [
        {
            type : 'pie',
            center : ['16%', '50%'],//圆中心点x和y
            radius : radius,
            itemStyle : labelFromatter,
            data : [
                {name:'other', value:<?php echo 100-$chartData['chengjiaolv']; ?>, itemStyle : labelBottom},
                {name:'本月成交率', value:<?php echo $chartData['chengjiaolv']; ?>,itemStyle : labelTop}
            ]
        },
        {
            type : 'pie',
            center : ['48%', '50%'],
            radius : radius,
            itemStyle : labelFromatter,
            data : [
                {name:'other', value:<?php echo 100-$chartData['daikanlv']; ?>, itemStyle : labelBottom},
                {name:'本月带看率', value:<?php echo $chartData['daikanlv']; ?>,itemStyle : labelTop}
            ]
        },
        {
            type : 'pie',
            center : ['80%', '50%'],
            radius : radius,
            itemStyle : labelFromatter,
            data : [
                {name:'other', value:<?php echo 100-$chartData['fenpeilv']; ?>, itemStyle : labelBottom},
                {name:'本月集客分配率', value:<?php echo $chartData['fenpeilv']; ?>,itemStyle : labelTop}
            ]
        }
    ]
});
    <?php Tools::endJs('js'); ?>
</script>
