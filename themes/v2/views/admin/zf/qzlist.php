<?php
/**
 * User: fanqi
 * Date: 2016/8/10
 * Time: 11:43
 */
$this->pageTitle = '求租列表';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            <div class="form-group">
                <?php echo CHtml::dropDownList('type', $type, array('title' => '标题', 'user' => '作者', 'xq' => '小区','phone'=>'电话', 'uid' => 'uid'), array('class' => 'form-control', 'encode' => false)); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::textField('value', $value, array('class' => 'form-control chose_text')) ?>
            </div>
            <!--            时间脚本 begin-->
            <?php Yii::app()->controller->widget("DaterangepickerWidget",['time'=>$time,'params'=>['class'=>'form-control chose_text','placeholder'=>'--添加时间--']]);?>
            <!--            时间脚本 end-->
            <div class="form-group">
                <?php echo CHtml::dropDownList('category', $category, Yii::app()->params['category'], array('class' => 'form-control chose_select', 'encode' => false, 'prompt' => '--房源类型--')); ?>
            </div>
            <?php echo CHtml::dropDownList('status',$status,Yii::app()->params['qzStatus'],array('class'=>'form-control chose_select','encode'=>false,'prompt'=>'--审核状态--')); ?>

            <button type="submit" class="btn blue"><i class="fa fa-search"></i> 搜索</button>
            <a class="btn yellow" onclick="removeOptions()"><i class="fa fa-trash"></i>&nbsp;清空</a>
        </form>
    </div>
    <div class="pull-right">
            
        <a href="<?php echo $this->createUrl('qzEdit') ?>" class="btn green">
            添加求租 <i class="fa fa-plus"></i>
        </a>
    </div>
    
</div>
<table class="table table-bordered table-striped table-condensed flip-content table-hover">
    <thead class="flip-content">
    <tr>
        <th width="35px"><input type="checkbox"></th>
        <th class="text-center">ID</th>
        <th class="text-center">标题</th>
        <th class="text-center">作者</th>
        <th class="text-center">电话</th>
        <th class="text-center">楼盘</th>
        <!-- <th class="text-center">房型</th> -->
        <th class="text-center">价格</th>
        <th class="text-center">发布时间</th>
        <th class="text-center">ip</th>
        <th class="text-center">状态</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($list as $k => $v): ?>
        <tr>
            <td class="text-center"><input type="checkbox" name="item[]" value="<?php echo $v['id'] ?>"
                                           class="checkboxes"></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->id; ?></td>
            <td class="text-center"><a target="_blank" href="<?=$this->createUrl('/resoldhome/qz/detail',['id'=>$v->id,'type'=>$v->category])?>"><?= $v->title ?></a></td>
            <td class="text-center"><?= $v->username.' uid:'.$v->uid ?></td>
            <td class="text-center"><?= $v->phone ?></td>
            <td class="text-center"><?php $plots_msg = [];
                if ($plots = $v->plots) foreach ($plots as $key => $value) {
                    $plots_msg[] = $value['plot_name'];
                }
                if ($plots_msg) {
                    echo implode(", ", $plots_msg);
                } else {
                    echo "无";
                } ?></td>
            <!-- <td class="text-center"><?= $v->bedroom . '/' . $v->livingroom . '/' . $v->bathroom ?></td> -->
            <td class="text-center"><?= $v->price ? $v->price . '元/月' : '面议'; ?></td>
            <td class="text-center"><?= date('Y-m-d', $v->created) ?></td>
            <td class="text-center"><?= long2ip($v->ip) ?></td>
            <td class="text-center">
                <div class="btn-group">
                    <button id="btnGroupVerticalDrop1" type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                    <?=Yii::app()->params['qzStatus'][$v->status]?> <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                    <?php foreach(Yii::app()->params['qzStatus'] as $key=>$v1){?>
                        <li>
                            <?=CHtml::ajaxLink($v1,$this->createUrl('qzAjaxStatus',['kw'=>$key=='1'?'open':($key=='2'?'check':($key=='3'?'close':'weitongguo')),'ids'=>$v->id]),['success'=>'function(){location.reload();}'])?>
                        </li>
                      <?php  }?>
                    </ul>
                </div>
            </td>
            <td style="text-align:center;vertical-align: middle">
                <a href="<?php echo $this->createUrl('/admin/zf/qzEdit', array('id' => $v->id)); ?>"
                   class="btn default btn-xs green"><i class="fa fa-edit"></i> 修改 </a>
                <?php
                echo CHtml::htmlButton('删除', array('data-toggle' => 'confirmation', 'class' => 'btn btn-xs yellow', 'data-title' => '确认删除？', 'data-btn-ok-label' => '确认', 'data-btn-cancel-label' => '取消', 'data-popout' => true, 'ajax' => array('url' => $this->createUrl('ajaxDelQz'), 'type' => 'post', 'success' => 'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}', 'data' => array('id' => $v->id))));
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="form-group">
    <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
    <?php echo CHtml::ajaxButton('启用所选', $this->createUrl('/admin/zf/qzAjaxStatus'), array('data' => array('ids' => 'js:getChecked()', 'kw' => 'open'), 'type' => 'post', 'success' => 'function(data){location.reload()}', 'beforeSend' => 'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class' => 'btn btn-success btn-sm')); ?>
    <?php echo CHtml::ajaxButton('禁用所选', $this->createUrl('/admin/zf/qzAjaxStatus'), array('data' => array('ids' => 'js:getChecked()', 'kw' => 'close'), 'type' => 'post', 'success' => 'function(data){location.reload()}', 'beforeSend' => 'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class' => 'btn btn-success btn-sm')); ?>
</div>

<?php $this->widget('AdminLinkPager', array('pages' => $pager)); ?>


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
    setInterval(function () {
        $('#AdminIframe').height($('#AdminIframe').contents().find('body').height());
        var $panel_title = $('#fade-title');
        $panel_title.html($('#AdminIframe').contents().find('title').html());
    }, 200);
    function do_admin(ts) {
        $('#AdminIframe').attr('src', ts.data('url')).load(function () {
            self = this;
            //延时100毫秒设定高度
            $('#Admin').modal({show: true, keyboard: false});
            $('#Admin .modal-dialog').css({width: '1000px'});
        });
    }
    function set_sort(_this, id, sort) {
        $.getJSON("<?php echo $this->createUrl('/admin/zf/ajaxQzSort');?>", {id: id, sort: sort}, function (dt) {
            _this.parent().html(dt.sort);
        });
    }
    function do_sort(ts) {
        if (ts.which == 13) {
            _this = $(ts.target);
            sort = _this.val();
            id = _this.parent().data('id');
            set_sort(_this, id, sort);
        }
    }

    $(document).on('click', function (e) {
        var target = $(e.target);
        if (!target.hasClass('sort_edit')) {
            $('.sort_edit').trigger($.Event('keypress', 13));
        }
    });
    $('.sort_edit').click(function () {
        if ($(this).find('input').length < 1) {
            $(this).html('<input type=\"text\" value=\"' + $(this).html() + '\" class=\"form-control input-sm sort_edit\" onkeypress=\"return do_sort(event)\" onblur=\"set_sort($(this),$(this).parent().data(\'id\'),$(this).val())\">');
            $(this).find('input').select();
        }
    });
    var getChecked = function () {
        var ids = "";
        $(".checkboxes").each(function () {
            if ($(this).parents('span').hasClass("checked")) {
                if (ids == '') {
                    ids = $(this).val();
                } else {
                    ids = ids + ',' + $(this).val();
                }
            }
        });
        return ids;
    }

    $(".group-checkable").click(function () {
        var set = $(this).attr("data-set");
        $(set).each(function () {
            $(this).attr("checked", !$(this).attr("checked"));
        });
        $.uniform.update(set);
    });
    //清空选项
    function removeOptions() {
        // alert($('.chose_select').val());
        $('.chose_text').val('');
        $('.chose_select').val('');
    }
    // 预约时间添加的交互，规则：
    // 1. 两次选择时间不得超过30分钟
    // 2. 选择的总数不得超过套餐剩余配额
    var list = new Array();
    $('.addAppoint').click(function(){
        var hour = $('#chose_hour').find('.active').find('.toggle').val()+'';
        var min = $('#chose_min').find('.active').find('.toggle').val()+'';
        transhour = hour;
        transmin = min;
        hour = hour.length==1?('0'+hour):hour;
        min = min.length==1?('0'+min):min;

        //转化分钟戳
        minchuo = parseInt(transhour)*60+parseInt(transmin);
        //判断时间间隔是否小于30分钟
        for(i=0 ;i<list.length ;i++)
        {
            if(list.length>0 && Math.abs(list[i]-minchuo)<30)
            {
                alert('两次预约刷新时间间隔不能小于30分钟');
                return;
            }
        }
        //套餐限额
        if(list.length<parseInt($('#appnum').html()))
            list.push(minchuo);
        else
            alert('套餐配额不足！');

        html = '<div style="margin-left: 20px;font-size:16px; height:30px;width:200px">'+hour+'&nbsp;:&nbsp;'+min+'&nbsp;&nbsp;<a class="btn btn-xs yellow" onclick="moveAppoint(this)">删除</a><input type="hidden" name="appoint_times[]" value="'+hour+':'+min+'"></input></div>';
        $('#app_res').append(html);
    });
    //预约时间单个删除操作
    function moveAppoint(obj)
    {
        $(obj).parent().remove();
    }
    var getChecked  = function(){
        var ids = "";
        $(".checkboxes").each(function(){
            if($(this).parents('span').hasClass("checked")){
                if(ids == ''){
                    ids = $(this).val();
                } else {
                    ids = ids + ',' + $(this).val();
                }
            }
        });
        return ids;
    }
    <?php
    Tools::endJs('js');
    ?>
</script>
