<?php
$this->pageTitle = '二手房列表';
$this->breadcrumbs = array($this->pageTitle);
?>
<style type="text/css">
    .mid{
        text-align:center;vertical-align: middle;
    }
</style>
<div class="table-toolbar">    
    <div class="btn-group pull-left">
        <form class="form-inline">
            <div class="form-group">
                <?php echo CHtml::dropDownList('type', $type, array('title' => '标题', 'username' => '作者', 'xq' => '小区', 'phone' => '电话', 'uid' => 'uid'), array('class' => 'form-control', 'encode' => false)); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::textField('value', $value, array('class' => 'form-control chose_text')) ?>
            </div>
            <!--            时间脚本 begin-->
            <div class="form-group">
                <?= CHtml::dropDownList('time_type', $time_type, ['created' => '添加时间', 'refresh_time' => '刷新时间'], ['class' => 'form-control', 'encode' => false]) ?>
            </div>
            <?php Yii::app()->controller->widget("DaterangepickerWidget",['time'=>$time,'params'=>['class'=>'form-control chose_text']]);?>
            <!--            时间脚本 end-->
            <div class="form-group">
                <?php echo CHtml::dropDownList('checkStatus', $checkStatus, Yii::app()->params['checkStatus'], array('class' => 'form-control chose_select', 'encode' => false, 'prompt' => '--审核状态--')); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('saleStatus', $saleStatus, Yii::app()->params['saleStatus'], array('class' => 'form-control chose_select', 'encode' => false, 'prompt' => '--销售状态--')); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('source', $source, Yii::app()->params['source'], array('class' => 'form-control chose_select', 'encode' => false, 'prompt' => '--来源--')); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('cate', $cate, Yii::app()->params['category'], array('class' => 'form-control chose_select', 'encode' => false, 'prompt' => '--房源类型--')); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('expire', $expire, [1=>'未过期房源',2=>'已过期房源'], array('class' => 'form-control chose_select', 'encode' => false, 'prompt' => '--是否过期--')); ?>
            </div>
            <?php if($hid):?>
                <input type="hidden" name="hid" value="<?=$hid?>"></input>
            <?php endif;?>
            <button type="submit" class="btn blue">搜索</button>
            <a class="btn yellow" onclick="removeOptions()"><i class="fa fa-trash"></i>&nbsp;清空</a>

        </form>
    </div>
    <div class="pull-right">
            
        <a href="<?php echo $this->createUrl('esfEdit') ?>" class="btn green">
            添加二手房 <i class="fa fa-plus"></i>
        </a>
        <?php if($hid):?>
                <a href="<?php echo $this->createUrl('/admin/resoldPlot/list') ?>" class="btn blue">
                    返回
                </a>
            <?php endif;?>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content table-hover">
    <thead class="flip-content">
    <tr>
        <th width="35px"><input type="checkbox"></th>
        <th class="text-center">排序</th>
        <th class="text-center">ID</th>
        <th class="text-center">标题</th>
        <th class="text-center">浏览</th>
        <th class="text-center">作者</th>
        <th class="text-center">来源</th>
        <th class="text-center">楼盘</th>
        <th class="text-center">房型</th>
        <th class="text-center">总价</th>
        <th class="text-center">均价</th>
        <th class="text-center">发布时间</th>
        <th class="text-center">刷新时间</th>
        <!-- <th class="text-center">结束时间</th> -->
        <th class="text-center">上/下架</th>
        <th class="text-center">状态</th>
        <th class="text-center">电话确认</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($list as $k => $v): ?>
        <tr style="height: 60px">
            <td style="text-align:center;vertical-align: middle"><input type="checkbox" name="item[]" value="<?php echo $v['id'] ?>"
                                           class="checkboxes"></td>
            <td style="text-align:center;vertical-align: middle" class="warning sort_edit"
                data-id="<?php echo $v['id'] ?>"><?php echo $v['sort'] ?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->id; ?></td>
            <td style="text-align:center;vertical-align: middle"><a target="_blank" href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$v->id])?>"><acronym title="<?=$v->title?>"><?= Tools::u8_title_substr($v->title,30).'</acronym></a><br>'.'IP:'.long2ip($v->ip).' ' ?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->hits; ?></td>
            <td class="text-center" style="text-align:center;vertical-align: middle"><?= $v->username.' UID:'.$v->uid.'<br>电话:'.$v->phone  ?></td>
            <td class="text-center" style="text-align:center;vertical-align: middle"><?= $v->source ? Yii::app()->params['source'][$v->source] : '无' ?></td>
            <td class="text-center" style="text-align:center;vertical-align: middle"><?= $v->plot_name ?></td>
            <td class="text-center" style="text-align:center;vertical-align: middle"><?= $v->bedroom . '/' . $v->livingroom . '/' . $v->bathroom . '/' . $v->cookroom?></td>
            <td class="text-center" style="text-align:center;vertical-align: middle"><?= (int)$v->price?$v->price: '面议'?></td>
            <td class="text-center" style="text-align:center;vertical-align: middle"><?= $v->ave_price? ($v->ave_price):'面议' ?></td>
            <td class="text-center" style="text-align:center;vertical-align: middle"><?= date('Y-m-d', $v->created) ?></td>
            <td class="text-center" style="text-align:center;vertical-align: middle"><?=date('Y-m-d H:i:s',$v->refresh_time).'<br>'.((time()-$v->expire_time)>SM::resoldConfig()->resoldExpireTime()*86400?'<span style="color:red">已到期</span>':'')?></td>
            <td class="text-center" style="text-align:center;vertical-align: middle">
                <div class="btn-group">
                    <button id="btnGroupVerticalDrop1" type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                    <?=$v->sale_status?Yii::app()->params['saleStatus'][$v->sale_status]:'销售状态'?> <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="btnGroupVerticalDrop1">
                        <?php foreach(Yii::app()->params['saleStatus'] as $key=>$v1){?>
                            <li>
                                <?=CHtml::ajaxLink($v1,$this->createUrl('ajaxStatus',['kw'=>$v1=='上架'?'shangjia':($v1=='下架'?'xiajia':'huishou'),'ids'=>$v->id]),['success'=>'function(){location.reload();}'])?>
                            </li>
                          <?php  }?>
                    </ul>
                </div>
            </td>
            <td class="text-center" style="text-align:center;vertical-align: middle">
                <div class="btn-group">
                    <button id="btnGroupVerticalDrop1" type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                    <?=Yii::app()->params['checkStatus'][$v->status]?> <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                    <?php foreach(Yii::app()->params['checkStatus'] as $key=>$v1){?>
                        <li>
                            <?=CHtml::ajaxLink($v1,$this->createUrl('ajaxStatus',['kw'=>$v1=='正常'?'open':($v1=='未通过'?'close':($v1=='审核中'?'check':'weishenhe')),'ids'=>$v->id]),['success'=>'function(){location.reload();}'])?>
                        </li>
                      <?php  }?>
                    </ul>
                </div>
            </td>

            <td class="text-center" style="text-align:center;vertical-align: middle"><?= $v->contacted ? '已确认' : CHtml::ajaxLink('进行确认', $this->createUrl('phoneCheck'), array('data' => array('phone_check' => 1, 'fid' => $v->id), 'type' => 'post', 'success' => 'function(data){location.reload()}')) ?></td>
            <td style="text-align:center;vertical-align: middle;width: 130px">

                <a class="btn btn-xs blue" style="margin-right: 0" href="<?php echo $this->createUrl('/admin/resoldRecommend/edit', array('fid' => $v->id,'type'=>1)); ?>">推荐</a>
                <a href="<?php echo $this->createUrl('/admin/esf/esfEdit', array('id' => $v->id)); ?>"
                   class="btn default btn-xs green" style="margin-right: 0">修改 </a>
                <?php
                echo CHtml::htmlButton('删除', array('data-toggle' => 'confirmation', 'class' => 'btn btn-xs yellow','style'=>'margin-right: 0', 'data-title' => '确认删除？', 'data-btn-ok-label' => '确认', 'data-btn-cancel-label' => '取消', 'data-popout' => true, 'ajax' => array('url' => $this->createUrl('ajaxDel'), 'type' => 'post', 'success' => 'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}', 'data' => array('id' => $v->id))));
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="form-group">
    <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
    <?php echo CHtml::ajaxButton('启用所选', $this->createUrl('/admin/esf/ajaxStatus'), array('data' => array('ids' => 'js:getChecked()', 'kw' => 'open'), 'type' => 'post', 'success' => 'function(data){location.reload()}', 'beforeSend' => 'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class' => 'btn btn-success btn-sm')); ?>
    <?php echo CHtml::ajaxButton('禁用所选', $this->createUrl('/admin/esf/ajaxStatus'), array('data' => array('ids' => 'js:getChecked()', 'kw' => 'close'), 'type' => 'post', 'success' => 'function(data){location.reload()}', 'beforeSend' => 'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class' => 'btn btn-success btn-sm')); ?>
    <?php echo CHtml::ajaxButton('上架所选', $this->createUrl('/admin/esf/ajaxStatus'), array('data' => array('ids' => 'js:getChecked()', 'kw' => 'shangjia'), 'type' => 'post', 'success' => 'function(data){location.reload()}', 'beforeSend' => 'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class' => 'btn btn-success btn-sm')); ?>
    <?php echo CHtml::ajaxButton('下架所选', $this->createUrl('/admin/esf/ajaxStatus'), array('data' => array('ids' => 'js:getChecked()', 'kw' => 'xiajia'), 'type' => 'post', 'success' => 'function(data){location.reload()}', 'beforeSend' => 'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class' => 'btn btn-success btn-sm')); ?>
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
        $.getJSON('<?php echo $this->createUrl('/admin/esf/ajaxEsfSort')?>', {id: id, sort: sort}, function (dt) {
            location.reload();
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

    $("#hname").on("dblclick", function () {
        var hnames = $(".hname");
        console.log(hnames);
        hnames.each(function () {
            var _this = $(this);
            $.getJSON("<?php echo $this->createUrl('/api/houses/getsearch') ?>", {key: _this.html()}, function (dt) {
                _this.append(" (" + dt.msg[1].length + ")");
            });
        });
    });
    
    <?php
    Tools::endJs('js');
    ?>
</script>
