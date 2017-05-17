<?php
$this->pageTitle = $this->action->plot->title.'-户型管理';
$this->breadcrumbs = array($this->pageTitle);
 ?>
<div class="table-toolbar">
    <div class="btn-group pull-right">
        <?php echo CHtml::link('添加户型 <i class="fa fa-plus"></i>', $this->createUrl('houseTypeEdit',array('hid'=>$hid)),array('class'=>'btn green')); ?>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th class="text-center" width="40px">id</th>
        <th class="text-center">排序</th>
        <th class="text-center">标题</th>
        <th class="text-center">户型</th>
        <th class="text-center">关联楼栋</th>
        <th class="text-center">面积</th>
        <th class="text-center">参考价</th>
        <th class="text-center">销售状态</th>
        <th class="text-center">是否封面</th>
        <th class="text-center">状态</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $v): ?>
        <tr>
            <td class="text-center"><?php echo $v->id; ?></td>
            <td style="vertical-align: middle" class="warning sort_edit" data-id="<?php echo $v->id ?>"><?php echo $v['sort'] ?></td>
            <td class="text-center"><?php echo $v->title; ?></td>
            <td class="text-center"><?php echo $v->bedroom.'室'.$v->livingroom.'厅'.$v->bathroom.'卫'; ?></td>
            <td class="text-center">
                <?php
                    if($v->buildings){
                        foreach($v->buildings as $k=>$building){
                            echo $k==0 ? $building->name : ','.$building->name;
                        }
                    } else {
                        echo '-';
                    }
                ?>
            </td>
            <td class="text-center"><?php echo $v->size>0 ? $v->size.'㎡' : '-'; ?></td>
            <td class="text-center"><?php echo $v->price>0 ? $v->price.'万' : '-'; ?></td>
            <td class="text-center"><?php echo PlotHouseTypeExt::getSaleStatus($v->sale_status); ?></td>
            <td class="text-center">
                <?php
                echo CHtml::htmlButton(PlotHouseTypeExt::$isCover[$v->is_cover], array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs '.($v->is_cover == 1?'green':'red'), 'data-title'=>'是否设为封面？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('/admin/plot/ajaxSetHouseTypeCover'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
                ?>
            </td>
            <td class="text-center"><?php echo PlotHouseTypeExt::getStatus($v->status); ?></td>
            <td class="text-center">
                <a href="<?php echo $this->createUrl('houseTypeEdit',array('id'=>$v->id,'hid'=>$hid)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                 <?php
                 echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('houseTypeDelete'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
                 ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>
<?php
 Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js', CClientScript::POS_END);
?>
<script type="text/javascript">
    <?php Tools::startJs(); ?>
        //----排序开始---
        function set_sort(_this, id, sort){
            $.getJSON('<?php echo $this->createUrl('AjaxPlotHouseTypeSort')?>',{id:id,sort:sort},function(dt){
                _this.parent().html(dt.msg);
                dt.code ? toastr.success('修改成功') : toastr.error('修改失败');

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
        //----排序结束----
    <?php Tools::endJs('js'); ?>
    </script>