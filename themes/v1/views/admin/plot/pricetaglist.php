<?php
/**
 * Created by PhpStorm.
 * User: wanggris
 * Date: 15-9-11
 * Time: 下午2:54
 */

$this->pageTitle = '价格动态管理';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-right">
        <?php echo CHtml::link('添加价格动态 <i class="fa fa-plus"></i>', $this->createAbsoluteUrl('plot/priceTagedit'),array('class'=>'btn green'));
        ?>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th class="text-center">ID</th>
        <th style="width: 50px" class="text-center">排序</th>
        <th class="text-center">价格标题</th>
        <th class="text-center">状态</th>
        <th class="text-center">更新时间</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $v): ?>
        <tr>
            <td class="text-center"><?php echo $v->id;?></td>
            <td class="warning sort_edit" data-id="<?php echo $v->id?>" style="text-align:center;vertical-align: middle"><?php echo $v->sort;?></td>
            <td class="text-center"><?php echo $v->title?></td>
            <td style="text-align:center;vertical-align: middle">
                <?php echo CHtml::ajaxLink(PlotPricetagExt::$status[$v->status],$this->createUrl('ajaxTagStatus'), array('type'=>'post', 'data'=>array('ids'=>$v->id,'status'=>$v->status),'success'=>'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}'), array('class'=>PlotExt::$statusStyle[$v->status])); ?>
            </td>
            <td class="text-center"><?php echo date('Y-m-d',$v->updated)?></td>
            <td class="text-center">
                <a href="<?php echo $this->createUrl('/admin/plot/pricetagedit',array('id'=>$v->id)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                <?php
                echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('/admin/plot/pricetagdel'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
                ?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>



    <script>
        function set_sort(_this, id, sort){
            $.getJSON('<?php echo $this->createAbsoluteUrl('/admin/plot/ajaxPriceTagSort')?>',{id:id,sort:sort},function(dt){
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
    </script>
<?php
$js = "
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
";
Yii::app()->clientScript->registerScript('sort_edit',$js);
?>


