 <?php
$this->pageTitle = '标签管理';
$this->breadcrumbs = array($this->pageTitle);
?>

<div class="portlet-body">
    <?php $form = $this->beginWidget('HouseForm', array('htmlOptions' => array('class' => 'form-horizontal'))) ?>
    <div class="form-body">
    <div class="col-md-12">
        <div class="alert alert-info alert-dismissable">
            <strong>注:</strong>蓝色标签表示开启显示，灰色表示禁用,按住可拖动排序
        </div>
        <!-- BEGIN TAB PORTLET-->
        <?php foreach($list as $k=>$cate):  ?>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-tag"></i><?php echo TagExt::$cate[trim($k)]; ?>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable tabbable-tabdrop">
                    <div class="tab-content">
                            <div class="tab-pane active">
                                <p class="sort_item">
                                    <?php foreach($cate as $v): ?>
                                        <?php echo CHtml::ajaxLink($v->name, $this->createUrl('ajaxStatus'), array('data'=>array('id'=>$v->id, 'status'=>$v->status), 'type'=>'post', 'success'=>'js:function(d){if(d.code){location.reload();}else{toastr.error(d.msg);}}'), array('class'=>TagExt::$statusStyle[$v->status], 'style'=>'margin:10px 2px', 'data-id'=>$v->id)); ?>
                                    <?php endforeach; ?>
                                </p>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach;?>
        <!-- END TAB PORTLET-->
    </div>
</div>
    <?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
<?php Tools::startJs() ?>
    $('.sort_item').sortable({
        update: function(event, ui){
            ids = [];
            $(this).parent().find('a').each(function(){
                ids.push($(this).data('id'));
            });
            $.post('<?php echo $this->createUrl("ajaxSort"); ?>', {sort: ids.join(',')}, function(d){
                if(d.code)
                    toastr.success('修改成功！');
                else
                    toastr.error('修改失败!');
            });
        }
    });
<?php Tools::endJs('dragsort'); ?>
</script>


