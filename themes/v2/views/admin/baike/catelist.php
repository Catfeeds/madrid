<?php
$this->pageTitle = '知识库分类列表';
$this->breadcrumbs = array('知识库分类管理',$this->pageTitle);
?>
<!-- <div class="table-toolbar">
    <div class="btn-group pull-right">
        <a href="<?php //echo $this->createUrl('cateEdit') ?>" class="btn green">
            添加分类 <i class="fa fa-plus"></i>
        </a>
    </div>
</div> -->
<table class="table table-bordered table-striped table-condensed flip-content table-hover">
    <thead class="flip-content">
    <tr>
        <th class="text-center">id</th>
        <th class="text-center" style="width: 50px">排序</th>
        <th class="text-center">分类名称</th>
        <th class="text-center">归属</th>
        <th class="text-center">拼音</th>
        <th class="text-center">状态</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $v): ?>
        <tr>
            <td style="text-center"><?php echo $v['id'] ?></td>
            <td style="text-center" class="warning sort_edit" data-id="<?php echo $v['id'] ?>"><?php echo $v['sort'] ?></td>
            <td ><?php echo $v['name'] ?></td>
            <td class="text-center"><?php echo BaikeCateExt::getXinfangBelong($v['belong']); ?></td>
            <td class="text-center"><?php echo $v['pinyin'] ?></td>
            <td class="text-center"><?php echo CHtml::ajaxLink(BaikeCateExt::$status[$v['status']],$this->createUrl('ajaxChangeBaikeCateStatus'), array('type'=>'post', 'data'=>array('id'=>$v['id']),'success'=>'function(data){location.reload()}'), array('class'=>'btn btn-sm '.BaikeCateExt::$statusStyle[$v['status']])); ?></td>
            <td class="text-center">
                <a href="<?php echo $this->createUrl('cateEdit',array('id'=>$v['id'])) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>
<script type="text/javascript">
    <?php Tools::startJs(); ?>
        //----排序开始---
        function set_sort(_this, id, sort){
            $.getJSON('<?php echo $this->createUrl('AjaxBaikeCateSort')?>',{id:id,sort:sort},function(dt){
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
