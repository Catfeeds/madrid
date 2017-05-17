<?php
/**
 * User: fanqi
 * Date: 2016/8/10
 * Time: 11:44
 */
$this->pageTitle = '租房列表';
$this->breadcrumbs = array($this->pageTitle);
?>
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
                <?php echo CHtml::dropDownList('category', $category, Yii::app()->params['category'], array('class' => 'form-control chose_select', 'encode' => false, 'prompt' => '--房源类型--')); ?>
            </div>
            <?php echo CHtml::dropDownList('expire', $expire, [1=>'未过期房源',2=>'已过期房源'], array('class' => 'form-control chose_select', 'encode' => false, 'prompt' => '--是否过期--')); ?>

            <?php if($hid):?>
                <input type="hidden" name="hid" value="<?=$hid?>"/>
            <?php endif;?>

            <button type="submit" class="btn blue"><i class="fa fa-search"></i> 搜索</button>
            <a class="btn yellow" onclick="removeOptions()"><i class="fa fa-trash"></i>&nbsp;清空</a>
        </form>
    </div>
    <div class="pull-right">
        <a href="<?php echo $this->createUrl('zfEdit') ?>" class="btn green">
            添加租房 <i class="fa fa-plus"></i>
        </a>
        <?php if($hid):?>
                <a href="<?php echo $this->createUrl('/admin/resoldPlot/list') ?>" class="btn blue">
                    返回
                </a>
            <?php endif;?>
    </div>
</div>
<div class="portlet-body">
    <table class="table table-bordered table-striped table-condensed flip-content table-hover">
        <thead>
        <tr role="row">
            <th width="35px"><input type="checkbox"></th>
            <th class="text-center">排序</th>
            <th class="text-center">ID</th>
            <th class="text-center">标题</th>
            <th class="text-center">浏览</th>
            <th class="text-center">作者</th>
            <th class="text-center">来源</th>
            <th class="text-center">楼盘</th>
            <th class="text-center">房型</th>
            <th class="text-center">租金</th>
            <th class="text-center">发布时间</th>
            <th class="text-center">刷新时间</th>
            <th class="text-center">上/下架</th>
            <th class="text-center">状态</th>
            <th class="text-center">电话确认</th>
            <th class="text-center">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($list as $k => $v): ?>
            <tr style="height: 60px">
                <td class="text-center"><input type="checkbox" name="item[]" value="<?php echo $v['id'] ?>"
                                               class="checkboxes"></td>
                <td style="text-align:center;vertical-align: middle" class="warning sort_edit"
                    data-id="<?php echo $v['id'] ?>"><?php echo $v['sort'] ?></td>
                <td style="text-align:center;vertical-align: middle"><?php echo $v->id; //id?></td>
                <td style="text-align:center;vertical-align: middle"><a target="_blank" href="<?=$this->createUrl('/resoldhome/zf/info',['id'=>$v->id])?>"><acronym title="<?=$v->title?>"><?= Tools::u8_title_substr($v->title,30).'</acronym></a><br>'.long2ip($v->ip)?></td>
                <td style="text-align:center;vertical-align: middle"><?php echo $v->hits; //浏览量?></td>
                <td style="text-align:center;vertical-align: middle"><?= $v->username.' UID:'.$v->uid.'<br>电话:'.$v->phone  ?></td>
                <td style="text-align:center;vertical-align: middle"><?php echo $v->source ? Yii::app()->params['source'][$v->source] : '无'; //信息来源?></td>
                <td style="text-align:center;vertical-align: middle"><?php echo $v->plot_name; //楼盘名称?></td>
                <td style="text-align:center;vertical-align: middle"><?php echo $v->bedroom . "/" . $v->livingroom . "/" . $v->bathroom . "/" . $v->cookroom; ?></td>
                <td style="text-align:center;vertical-align: middle"><?php echo $v->price ? $v->price : '面议'; //租金?></td>
                <td style="text-align:center;vertical-align: middle"><?= date('Y-m-d', $v->created) ?></td>
                <td style="text-align:center;vertical-align: middle"><?=date('Y-m-d H:i:s',$v->refresh_time).'<br>'.((time()-$v->expire_time)>SM::resoldConfig()->resoldExpireTime()*86400?'<span style="color:red">已到期</span>':'')?></td>
                <td style="text-align:center;vertical-align: middle">
                    <div class="btn-group">
                        <button id="btnGroupVerticalDrop1" type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <?=$v->sale_status?Yii::app()->params['saleStatus'][$v->sale_status]:'销售状态'?> <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="btnGroupVerticalDrop1">
                            <?php foreach(Yii::app()->params['saleStatus'] as $key=>$v1){?>
                                <li>
                                    <?=CHtml::ajaxLink($v1,$this->createUrl('zfAjaxStatus',['kw'=>$v1=='上架'?'shangjia':($v1=='下架'?'xiajia':'huishou'),'ids'=>$v->id]),['success'=>'function(){location.reload();}'])?>
                                </li>
                            <?php  }?>
                        </ul>
                    </div>
                </td>
                <td style="text-align:center;vertical-align: middle;margin-right: 0">
                    <div class="btn-group">
                        <button id="btnGroupVerticalDrop1" type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <?=Yii::app()->params['checkStatus'][$v->status]?> <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <?php foreach(Yii::app()->params['checkStatus'] as $key=>$v1){?>
                                <li>
                                    <?=CHtml::ajaxLink($v1,$this->createUrl('zfAjaxStatus',['kw'=>$v1=='正常'?'open':($v1=='未通过'?'close':($v1=='审核中'?'check':'weishenhe')),'ids'=>$v->id]),['success'=>'function(){location.reload();}'])?>
                                </li>
                            <?php  }?>
                        </ul>
                    </div>
                </td>
                <td style="text-align:center;vertical-align: middle"><?= $v->contacted ? '已确认' : CHtml::ajaxLink('进行确认', $this->createUrl('phoneCheck'), array('data' => array('phone_check' => 1, 'fid' => $v->id), 'type' => 'post', 'success' => 'function(data){location.reload()}')) ?></td>
                <td style="text-align:center;vertical-align: middle;width: 130px;">

                    <a class="btn btn-xs blue" style="margin-right: 0" href="<?php echo $this->createUrl('/admin/resoldRecommend/edit', array('fid' => $v->id,'type'=>2)); ?>">推荐</a>
                    <a href="<?php echo $this->createUrl('/admin/zf/zfEdit', array('id' => $v->id)); ?>"
                       class="btn default btn-xs green" style="margin-right: 0">修改 </a>
                    <?php
                    echo CHtml::htmlButton('删除', array('data-toggle' => 'confirmation', 'class' => 'btn btn-xs yellow','style'=>'margin-right:0', 'data-title' => '确认删除？', 'data-btn-ok-label' => '确认', 'data-btn-cancel-label' => '取消', 'data-popout' => true, 'ajax' => array('url' => $this->createUrl('ajaxDelZf'), 'type' => 'post', 'success' => 'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}', 'data' => array('id' => $v->id))));
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="form-group">
    <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
    <?php echo CHtml::ajaxButton('启用所选', $this->createUrl('/admin/zf/zfAjaxStatus'), array('data' => array('ids' => 'js:getChecked()', 'kw' => 'open'), 'type' => 'post', 'success' => 'function(data){location.reload()}', 'beforeSend' => 'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class' => 'btn btn-success btn-sm')); ?>
    <?php echo CHtml::ajaxButton('禁用所选', $this->createUrl('/admin/zf/zfAjaxStatus'), array('data' => array('ids' => 'js:getChecked()', 'kw' => 'close'), 'type' => 'post', 'success' => 'function(data){location.reload()}', 'beforeSend' => 'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class' => 'btn btn-success btn-sm')); ?>
    <?php echo CHtml::ajaxButton('上架所选', $this->createUrl('/admin/zf/zfAjaxStatus'), array('data' => array('ids' => 'js:getChecked()', 'kw' => 'shangjia'), 'type' => 'post', 'success' => 'function(data){location.reload()}', 'beforeSend' => 'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class' => 'btn btn-success btn-sm')); ?>
    <?php echo CHtml::ajaxButton('下架所选', $this->createUrl('/admin/zf/zfAjaxStatus'), array('data' => array('ids' => 'js:getChecked()', 'kw' => 'xiajia'), 'type' => 'post', 'success' => 'function(data){location.reload()}', 'beforeSend' => 'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class' => 'btn btn-success btn-sm')); ?>
</div>
<?php $this->widget('AdminLinkPager', array('pages' => $pager)); ?>
<script>
    <?php Tools::startJs(); ?>
    function set_sort(_this, id, sort) {
        $.getJSON('<?php echo $this->createUrl('/admin/zf/ajaxZfSort')?>', {id: id, sort: sort}, function (dt) {
            _this.parent().html(sort);
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
    $(".group-checkable").click(function () {
        var set = $(this).attr("data-set");
        $(set).each(function () {
            $(this).attr("checked", !$(this).attr("checked"));
        });
        $.uniform.update(set);
    });
    //清空选项
    function removeOptions() {
        $('.chose_text').val('');
        $('.chose_select').val('');
    }
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
    <?php
    Tools::endJs('js');
    ?>
</script>
