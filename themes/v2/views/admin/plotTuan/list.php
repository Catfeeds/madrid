<?php
$this->pageTitle = $this->t('特惠团');
$this->breadcrumbs = array('房源管理',$this->t('特惠团').'列表');
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            <div class="form-group">
                <?php echo CHtml::dropDownList('type',empty($_GET['type'])?'':$_GET['type'],array('title'=>'标题','id'=>'ID'),array('class'=>'form-control','encode'=>false)); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::textField('value',empty($_GET['value'])?'':$_GET['value'],array('class'=>'form-control')) ?>
            </div>
            <button type="submit" class="btn blue">搜索</button>
        </form>
    </div>
    <div class="btn-group pull-right">
        <a href="<?php echo $this->createUrl('edit',array('referrer'=>Yii::app()->request->url)) ?>" class="btn green">
            添加特惠团 <i class="fa fa-plus"></i>
        </a>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th width="35px"><input type="checkbox"></th>
        <th class="text-center">id</th>
        <th class="text-center" style="width: 50px">排序</th>
<!--        <th class="text-center" style="width: 50px">排序</th>-->
        <th class="text-center">楼盘名称</th>
        <th class="text-center">标题</th>
        <th class="text-center">截止时间</th>
        <th class="text-center">添加时间</th>
        <th class="text-center">状态</th>
        <th class="text-center">是否推荐</th>
        <th class="text-center">集客</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $v): ?>
       <tr>
            <td><input type="checkbox" name="item[]" value="<?php echo $v->id; ?>" class="checkboxes"></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->id; ?></td>
            <td class="warning sort_edit" data-id="<?php echo $v->id?>" style="text-align:center;vertical-align: middle"><?php echo $v->sort ?></td>
<!--            <td class="warning sort_edit" data-id="--><?php //echo $v->id?><!--" style="text-align:center;vertical-align: middle">--><?php //echo $v->sort ?><!--</td>-->
            <td style="text-align:center;vertical-align: middle"><?php echo $v->plot ? CHtml::link($v->plot->title,$v->url,array('target'=>'_blank')): ''; ?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->title; ?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo ($v->end_time > 0) ? date('Y-m-d',$v->end_time) : '暂无';?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo ($v->created > 0) ? date('Y-m-d',$v->created) : '暂无';?></td>
            <td style="text-align:center;vertical-align: middle">
                <?php echo CHtml::ajaxLink(PlotTuanExt::$status[$v->status],$this->createUrl('AjaxStatusRecom'), array('type'=>'post', 'data'=>array('id'=>$v->id),'success'=>'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}'), array('class'=>'btn btn-sm '.PlotExt::$statusStyle[$v->status])); ?>
            </td>
           <td style="text-align:center;vertical-align: middle">
                <?php echo CHtml::ajaxLink(PlotTuanExt::$recommend[$v->recommend],$this->createUrl('AjaxStatusRecom'), array('type'=>'post', 'data'=>array('id'=>$v->id,'recom'=>'recom'),'success'=>'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}'), array('class'=>'btn btn-sm '.PlotExt::$statusStyle[$v->recommend])); ?>
            </td>
            <td class="text-center">
                <a href="<?php echo $this->createUrl('/admin/order/list',['type'=>'特惠团','spm_c'=>$v->id]); ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 报名人数：<?php echo $v->tuanNum; ?> </a>
            </td>
            <td style="text-align:center;vertical-align: middle">
                <a href="<?php echo $this->createUrl('/admin/plotTuan/edit',array('id'=>$v->id,'referrer'=>Yii::app()->request->url)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 修改 </a>
                <?php
                        echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs yellow', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('del'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
                 ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="form-group">
    <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
    <?php echo CHtml::ajaxButton('启用所选', $this->createUrl('/admin/plotTuan/ajaxRecomStatus'), array('data'=>array('ids'=>'js:getChecked()','status'=>0),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')); ?>
    <?php echo CHtml::ajaxButton('禁用所选', $this->createUrl('/admin/plotTuan/ajaxRecomStatus'), array('data'=>array('ids'=>'js:getChecked()','status'=>1),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')); ?>
    <?php echo  CHtml::ajaxButton('删除所选', $this->createUrl('/admin/plotTuan/ajaxDelRecom'), array('data'=>array('ids'=>'js:getChecked()'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm', 'data-toggle'=>'confirmation', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true)); ?>
</div>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>

<?php
$js = '
    var getChecked  = function(){
        var ids = "";
        $(".checkboxes").each(function(){
            if($(this).parents(\'span\').hasClass("checked")){
                if(ids == \'\'){
                    ids = $(this).val();
                } else {
                    ids = ids + \',\' + $(this).val();
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

';
Yii::app()->clientScript->registerScript('sel', $js, CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js', CClientScript::POS_END);
?>
<script>
<?php Tools::startJs(); ?>
    function set_sort(_this, id, sort){
        $.getJSON("<?php echo $this->createUrl('/admin/plotTuan/ajaxPlotTuanSort');?>",{id:id,sort:sort},function(dt){
            _this.parent().html(dt.sort);
        });
    }
    function do_sort(ts){
        if(ts.which == 13){
            _this = $(ts.target);
            sort = _this.val();
            id = _this.parent().data('id');
            set_sort(_this, id, sort);
        }
    }

    $(document).on('click',function(e){
          var target = $(e.target);
          if(!target.hasClass('sort_edit')){
             $('.sort_edit').trigger($.Event( 'keypress', 13 ));
          }
    });
    $('.sort_edit').click(function(){
        if($(this).find('input').length <1){
            $(this).html('<input type=\"text\" value=\"' + $(this).html() + '\" class=\"form-control input-sm sort_edit\" onkeypress=\"return do_sort(event)\" onblur=\"set_sort($(this),$(this).parent().data(\'id\'),$(this).val())\">');
            $(this).find('input').select();
        }
    });
    <?php Tools::endJs('js') ?>
</script>
