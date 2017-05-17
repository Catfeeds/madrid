<?php
$this->pageTitle = '订单列表';
$this->breadcrumbs = array('集客管理',$this->pageTitle);
?>

<table class="table table-bordered table-hover text-center" id="sample_2">
    <thead>
    <tr class="text-center">
        <th class="text-center"> 订单总数 </th>
        <th class="text-center"> 今日订单 </th>
        <th class="text-center"> 本月订单 </th>
        <th class="text-center"> 本季订单 </th>
        <th class="text-center"> 已处理 </th>
    </tr>
    </thead>
    <tbody>
    <tr class="">
        <td><?php echo OrderExt::model()->count(); ?></td>
        <td><?php echo OrderExt::model()->today()->count(); ?></td>
        <td><?php echo OrderExt::model()->thisMonth()->count(); ?></td>
        <td><?php echo OrderExt::model()->thisSeason()->count(); ?></td>
        <td><?php echo OrderExt::model()->handled()->count(); ?></td>
    </tr>
    </tbody><thead>
    <tr>
        <th class="text-center"> 未处理 </th>
        <th class="text-center"> 看房团 </th>
        <th class="text-center"> 特价房 </th>
        <th class="text-center"> <?php echo $this->t('特惠团'); ?> </th>
        <th class="text-center"> 优惠通知 </th>
    </tr>
    </thead>
    <tbody><tr class="odd gradeX">
        <td><?php echo OrderExt::model()->unhandled()->count(); ?></td>
        <td><?php echo OrderExt::model()->spmB('看房团')->count(); ?></td>
        <td><?php echo OrderExt::model()->spmB('特价房')->count(); ?></td>
        <td><?php echo OrderExt::model()->spmB('特惠团')->count(); ?></td>
        <td><?php echo OrderExt::model()->spmB('优惠通知')->count(); ?></td>
    </tr>
    </tbody>
</table>
<?php if($spm_c&&Yii::app()->request->getUrlReferrer()): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group pull-right">
                <?php echo CHtml::link('返回',Yii::app()->request->getUrlReferrer(),array('class'=>'btn blue-hoki')); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline" method="get" action="">
                <div class="form-group">
                <?php echo CHtml::dropDownList('t', $t, array('name'=>'姓名', 'phone'=>'电话'), array('class'=>'form-control')); ?>
                </div>
                <div class="form-group">
                <?php echo CHtml::textField('str', $str, array('class'=>'form-control')); ?>
                </div>
                <div class="form-group">
                    <div class="input-group" id="defaultrange">
                        <?php echo CHtml::textField('time', $time, array('class'=>'form-control','placeholder'=>'订单提交时间' ,'readOnly'=>true)); ?>
                        <span class="input-group-btn">
                            <button class="btn default date-range-toggle" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo CHtml::dropDownList('source', $source, array_combine(OrderExt::$source,$this->t(OrderExt::$source)), array('class'=>'form-control', 'prompt'=>'--来源--')); ?>
                </div>
                <div class="form-group">
                    <?php echo CHtml::dropDownList('status', $status, OrderExt::$status, array('class'=>'form-control', 'prompt'=>'--订单状态--')); ?>
                </div>
                <?php echo CHtml::hiddenField('spm_c', $spm_c); ?>
                <div class="form-group">
                    <?php echo CHtml::dropDownList('type', $type, $orderType, array('class'=>'form-control media', 'prompt'=>'--订单类型--')); ?>
                </div>
                <button type="submit" class="btn green">搜索 </button>
        </form>
    </div>
    <div class="pull-right">
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
            录入/导出 <i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
                <li>
                    <?php echo CHtml::link('导出excel',array_merge(array('order/list','export'=>1),$_GET),array('class'=>'btn')); ?>
                </li>
                <li>
                    <?php echo CHtml::link('录入订单',array('order/add'),array('class'=>'btn'));  ?>
                </li>
            </ul>
        </div>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th class="text-center" width="5%">id</th>
        <th class="text-center" width="10%">姓名</th>
        <th class="text-center">电话</th>
        <th class="text-center" width="10%">来源</th>
        <th class="text-center" width="10%">类型</th>
        <!-- <th class="text-center" width="10%">意向楼盘</th> -->
        <th class="text-center" width="7%">分配管家</th>
        <th class="text-center" width="7%">处理状态</th>
        <th class="text-center">提交时间</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($data as $v): ?>
        <tr>
            <td class="text-center"><?php echo $v->id; ?></td>
            <td class="text-center"><?php echo $v->name; ?></td>
            <td class="text-center"><?php echo $v->phone; ?></td>
            <td class="text-center"><?php echo $v->spm_a; ?></td>
            <td class="text-center"><?php echo $v->spm_b; ?></td>
            <!-- <td class="text-center"><?php echo '无'; ?></td> -->
            <td class="text-center"><?php echo $v->user && $v->user->staff ? $v->user->staff->username : '未分配'; ?></td>
            <td class="text-center"><?php echo CHtml::tag('span', array('class'=>OrderExt::$statusStyle[$v->status]),OrderExt::$status[$v->status]); ?></td>
            <td class="text-center"><?php echo date('Y-m-d H:i:s', $v->created); ?></td>
            <td class="text-center">
                <div class="popovers btn btn-primary btn-xs" data-content="<?php echo $v->note ? $v->note : '无'; ?>" data-placement="left" data-trigger="hover">订单备注</div>
                <?php
                echo CHtml::htmlButton('<i class="fa fa-edit"></i>管理', array('data-url'=>$this->createUrl('/admin/user/detail', array('phone'=>$v->phone)),'class'=>'btn default btn-xs green','onclick'=>'show_detail(this)'));
                echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('/admin/order/ajaxDel'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
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
        $("#detail iframe").width(width-10).attr('src', $(obj).data('url'));
    }

    //监听模态框内iframe加载情况，及时调整模态框大小
    $("#detail iframe").on('load', function(){
        resizeModal();
    });

    function resizeModal(){
        var height = $("#detail iframe").contents().find('html').height();
        $('.modal-title').text($("#detail iframe")[0].contentDocument.title);//修改模态框标题
        $('.modal-dialog').width(width);//宽度扩展.modal_dialog
        $('.modal-body').height(height);//高度扩展.modal-body
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
