<?php
$this->pageTitle = '激活池';
$this->breadcrumbs = array('集客管理',$this->pageTitle);
?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            小提示：该页面仅当集客模式为 <b>平均分单模式</b> 下才有效，列表中的用户是<b>被买房顾问评定为失效或者休眠的并且编辑评定为非无效</b>用户，后台编辑可通过查看该列表再次回访用户后，可重新激活分配给买房顾问，提高用户数据的有效率。
        </div>
    </div>
</div>
<form method="get" action="">
    <div class="table-toolbar form-inline">
        <div class="btn-group pull-left">
            <div class="form-group">
                <?php echo CHtml::dropDownList('t', $t, array('name'=>'姓名', 'phone'=>'电话','qq'=>'QQ'), array('class'=>'form-control')); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::textField('str', $str, array('class'=>'form-control')); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('visit_status', $visit_status, $visitStatusArr, array('class'=>'form-control', 'prompt'=>'--回访状态--')); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('progress', $progress, UserExt::$progress, array('class'=>'form-control', 'prompt'=>'--购房进度--')); ?>
            </div>
            <div class="form-group">
                <button type="submit" class="btn green">搜索 </button>
            </div>
        </div>
    </div>
</form>

<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th class="text-center" width="2%">id</th>
        <th class="text-center" width="7%">姓名</th>
        <th class="text-center" width="10%">电话</th>
        <th class="text-center" width="25%">意向楼盘</th>
        <th class="text-center" width="7%">回访状态</th>
        <th class="text-center" width="7%">买房顾问</th>
        <th class="text-center" width="6%">看房状态</th>
        <th class="text-center" width="7%">购房进度</th>
        <!-- <th class="text-center" width="7%">发短信</th> -->
        <th class="text-center">最新订单时间</th>
        <th class="text-center">用户创建时间</th>
        <th class="text-center" width="8%">操作</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($list as $v): ?>
        <tr>
            <td class="text-center"><?php echo $v->id; ?></td>
            <td class="text-center"><?php echo $v->name; ?></td>
            <td class="text-center"><?php echo $v->phone;?></td>
            <td class="text-center">
                <?php
                    foreach($v->yxlp as $k=>$plot)
                    {
                        echo $k ? '，'.$plot->title : $plot->title;
                    }
                ?>
            </td>
            <td class="text-center"><?php echo UserExt::$visitStatus[$v->visit_status]?></td>
            <td class="text-center"><?php echo $v->staff ? $v->staff->username : '-'; ?></td>
            <td class="text-center"><?php echo UserExt::$staffStatus[$v->staff_status]; ?></td>
            <td class="text-center"><?php echo UserExt::$progress[$v->progress]; ?></td>
            <!-- <td class="text-center">发短信</td> -->
            <td class="text-center"><?php echo $v->new_order ? date('Y-m-d H:i',$v->new_order) : '-'; ?></td>
            <td class="text-center"><?php echo $v->created ? date('Y-m-d H:i',$v->created) : '-'; ?></td>
            <td class="text-center">
                <?php
                echo CHtml::htmlButton('<i class="fa fa-edit"></i>管理', array('data-url'=>$this->createUrl('/admin/user/detail', array('phone'=>$v->phone)),'class'=>'btn default btn-xs green','onclick'=>'show_detail(this)'));
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)); ?>

<div class="modal fade" id="detail" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">loading...</h4>
            </div>
            <div class="modal-body" style="padding: 0">
                <iframe src="" width="100%" height="100%" scrolling="no" frameborder="0"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn blue" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
<?php Tools::startJs(); ?>
    var width = $('.page-content').width();
    //弹出模态框函数
    function show_detail(obj){
        $("#detail iframe").attr('src', $(obj).data('url'));
    }

    //监听模态框内iframe加载情况，及时调整模态框大小
    $("#detail iframe").on('load', function(){
        resizeModal();
    });

    function resizeModal(){
        var height = $("#detail iframe").contents().find('html').height();
        $('.modal-title').text($("#detail iframe")[0].contentDocument.title);//修改模态框标题
        $('.modal-dialog').width(width);//宽度扩展.modal_dialog
        $("#detail").modal({show:true}).resize();
        $("#detail iframe").height(height).resize();
    }

    //====================日期控件=========================
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
    Tools::endJs('js');
    Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css');
    Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-daterangepicker/moment.min.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-daterangepicker/daterangepicker.js', CClientScript::POS_END);
?>
</script>
