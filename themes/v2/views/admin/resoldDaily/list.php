<?php
$this->pageTitle = '每日价格统计';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            <div class="form-group">
                <div class="input-group" id="defaultrange">
                    <?php echo CHtml::textField('time', $time, array('class'=>'form-control','placeholder'=>'请选择时间' ,'readOnly'=>true)); ?>
                    <span class="input-group-btn">
                        <button class="btn default date-range-toggle" type="button"><i class="fa fa-calendar"></i></button>
                    </span>
                </div>
            </div>
            <button type="submit" class="btn blue">搜索</button>
        </form>
    </div>
</div>
   <table class="table table-bordered table-striped table-condensed flip-content table-hover">
    <thead class="flip-content">
    <tr>
        <th class="text-center">日期</th>  
        <th class="text-center">二手房挂牌均价</th> 
        <th class="text-center">二手房挂牌总面积</th>    
        <th class="text-center">二手房数量</th>   
        <th class="text-center">租房挂牌均价</th>  
        <th class="text-center">租房挂牌总面积</th> 
        <th class="text-center">租房数量</th>    
        <th class="text-center">板块数据</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($list as $k=>$v): ?>
        <tr>
            <td class="text-center"><?=date('Y-m-d',$v->date)?></td>
            <td class="text-center"><?=$v->esf_price?></td>
            <td class="text-center"><?=$v->esf_size?></td>
            <td class="text-center"><?=$v->esf_num?></td>
            <td class="text-center"><?=$v->zf_price?></td>
            <td class="text-center"><?=$v->zf_size?></td>
            <td class="text-center"><?=$v->zf_num?></td>
            <td class="text-center"><a data-url="<?php echo $this->createUrl('/admin/resoldDaily/area',array('id'=> $v->id))?>" onclick="do_admin($(this))">点击查看区域数据</a></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

<?php $this->widget('AdminLinkPager', array('pages'=>$page)); ?>


<!-- 弹窗 -->
<div class="modal fade" id="Admin" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="panel-title">
                    <span id="fade-title"></span>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </h3>
            </div>
            <div class="modal-body">

                <iframe id="AdminIframe" width="100%" height="100%" scrolling="no" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
<?php Tools::startJs(); ?>
setInterval(function(){
        $('#AdminIframe').height($('#AdminIframe').contents().find('body').height());
        var $panel_title = $('#fade-title');
        $panel_title.html($('#AdminIframe').contents().find('title').html());
    },200);
    function do_admin(ts){
        $('#AdminIframe').attr('src',ts.data('url')).load(function(){
            self = this;
            //延时100毫秒设定高度
            $('#Admin').modal({ show: true, keyboard:false });
            $('#Admin .modal-dialog').css({width:'1000px'});
        });
    }
    //弹出模态框函数
    function show_detail(obj){
        $("#detail iframe").width(width-10).attr('src', $(obj).data('url'));
    }

    //监听模态框内iframe加载情况，及时调整模态框大小
    $("#detail iframe").on('load', function(){
        resizeModal();
    });
    $(document).ready(function(){
        $("#defaultrange").daterangepicker({
            opens : "right", //日期选择框的弹出位置
            format: "YYYY-MM-DD",
            separator: " - ",
            startDate: moment().startOf("month"),
            endDate: moment(),
            minDate: "2012-01-01",
            maxDate: "2020-12-31",
            ranges : {
                //"最近1小时": [moment().subtract("hours",1), moment()],
                "今日": [moment().startOf("day"), moment().startOf("day")],
                "昨日": [moment().subtract("days", 1).startOf("day"), moment().subtract("days", 1).endOf("day")],
                "最近7日": [moment().subtract("days", 6), moment()],
                "最近30日": [moment().subtract("days", 29), moment()]
            },


            locale: {
                applyLabel: "确定",
                cancelLabel: "清除",
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
            $("#start").val(picker.startDate.format("YYYY-MM-DD"));
            $("#end").val(picker.endDate.format("YYYY-MM-DD"));
        });
        $("#defaultrange").on("cancel.daterangepicker",function(ev,picker){
            $(this).find('input').val('');
        });
    });
<?php

Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css');
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-daterangepicker/daterangepicker.js', CClientScript::POS_END);
Tools::endJs('js');
?>
</script>
