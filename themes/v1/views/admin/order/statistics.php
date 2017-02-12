<?php
$this->pageTitle = '集客统计';
$this->breadcrumbs = array('集客管理',$this->pageTitle);
?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-1">日期筛选</label>
            <div class="col-md-3">
                <div class="input-group" id="defaultrange">
                    <input type="text" class="form-control" readonly="readonly">
                    <span class="input-group-btn">
                    <button class="btn default date-range-toggle" type="button"><i class="fa fa-calendar"></i></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="portlet-body">
    <div class="tabbable-line">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="<?php echo $this->createUrl('statistics', array('type' => 'ddltj')) ?>#" class="ajaxify start" data-toggle="tab">订单量统计</a>
            </li>
            <li>
                <a href="<?php echo $this->createUrl('statistics', array('type' => 'yhltj')) ?>#" class="ajaxify" data-toggle="tab">用户量统计</a>
            </li>
            <li>
                <a href="<?php echo $this->createUrl('statistics', array('type' => 'lytj')) ?>#" class="ajaxify" data-toggle="tab">来源分布统计</a>
            </li>
            <li>
                <a href="<?php echo $this->createUrl('statistics', array('type' => 'ddlxtj')) ?>#" class="ajaxify" data-toggle="tab">订单类型统计</a>
            </li>
            <li>
                <a href="<?php echo $this->createUrl('statistics', array('type' => 'yxlpph')) ?>#" class="ajaxify" data-toggle="tab">意向楼盘排行</a>
            </li>
        </ul>

    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="page-content-body"></div>
    </div>
</div>

<script type="text/javascript">
    <?php Tools::startJs(); ?>
        $(document).ready(function(){
            $(".ajaxify.start").click();
            $('.ajaxify').click(function(){
                $("#defaultrange input").val('');
            });

            $("#defaultrange").daterangepicker({
                opens : "right", //日期选择框的弹出位置
                format: "YYYY/MM/DD",
                separator: " - ",
                startDate: moment().startOf("month"),
                endDate: moment(),
                minDate: "2012-01-01",
                maxDate: "2018-12-31",
                ranges : {
                    //"最近1小时": [moment().subtract("hours",1), moment()],
                    "今日": [moment().startOf("day"), moment().startOf("day")],
                    "昨日": [moment().subtract("days", 1).startOf("day"), moment().subtract("days", 1).endOf("day")],
                    "最近7日": [moment().subtract("days", 6), moment()],
                    "最近30日": [moment().subtract("days", 29), moment()]
                },
                pluginEvents :[

                ],

                locale: {
                    applyLabel: "确定",
                    cancelLabel: "取消",
                    fromLabel: "开始日期",
                    toLabel: "截止日期",
                    customRangeLabel: "自定义",
                    daysOfWeek: ["日", "一", "二", "三", "四", "五", "六"],
                    monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                    firstDay: 1
                }
            });
            $("#defaultrange").on("apply.daterangepicker",function(ev,picker){
                $("#defaultrange input").val(picker.startDate.format("YYYY/MM/DD") + " - " + picker.endDate.format("YYYY/MM/DD"));
                var ajaxUrl = $(".active>.ajaxify").attr("href");
                $.ajax({
                    url: ajaxUrl,
                    type: "get",
                    dataType: "html",
                    data: {time:picker.startDate.format("YYYY/MM/DD") + " - " + picker.endDate.format("YYYY/MM/DD")},
                    success: function(data){
                        $(".page-content-body").html(data);
                    }
                });
            });
        });
    <?php Tools::endJs('js'); ?>
</script>
<?php

Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css');
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-daterangepicker/daterangepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/scripts/echarts/echarts-all.js', CClientScript::POS_END);
 ?>
