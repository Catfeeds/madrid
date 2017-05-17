<?php
$this->pageTitle = '知识库标签列表';
$this->breadcrumbs = array('知识库标签管理',$this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-right">
        <a href="<?php echo $this->createUrl('tagEdit') ?>" class="btn green">
            添加标签 <i class="fa fa-plus"></i>
        </a>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content table-hover">
    <thead class="flip-content">
    <tr>
        <th width="35px"><input type="checkbox"></th>
        <th class="text-center">id</th>
        <th class="text-center" style="width: 50px">排序</th>
        <th class="text-center">标签名称</th>
        <th class="text-center">标签分类</th>
        <th class="text-center">推荐</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $v): ?>
        <tr>
            <td><input class="checkboxes" type="checkbox" name="item[]" value="<?php echo $v->id ?>"></td>
            <td class="text-center"><?php echo $v->id ?></td>
            <td class="text-center warning sort_edit" data-id="<?php echo $v->id ?>"><?php echo $v['sort'] ?></td>
            <td class="text-center"><?php echo $v->name ?></td>
            <td class="text-center"><?php echo Yii::app()->params['baikeTagCate'][$v->cate] ?></td>
            <td class="text-center"><?php echo CHtml::ajaxLink($v->getIsRecommendatory()?'已推荐':'未推荐',$this->createUrl('ajaxRecomBaikeTag'), array('type'=>'post', 'data'=>array('id'=>$v->id),'success'=>'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}'), array('class'=>'btn btn-sm '.$v->getStatusStyle())); ?></td>
            <td class="text-center">
                <?php
                echo CHtml::htmlButton('<i class="fa fa-times"></i> 删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('ajaxBaikeTagDel'),'type'=>'post','success'=>'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}','data'=>array('ids'=>$v->id))));
                 ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="form-group">
    <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
    <?php echo CHtml::ajaxButton('推荐所选', $this->createUrl('ajaxRecomBaikeTag'), array('data'=>array('id'=>'js:getChecked()','type'=>'1'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')); ?>
    <?php echo !isset($_GET['status']) ? CHtml::ajaxButton('取消推荐所选', $this->createUrl('ajaxRecomBaikeTag'), array('data'=>array('id'=>'js:getChecked()','type'=>'0'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')) : ''; ?>
    <?php echo !isset($_GET['status']) ? CHtml::ajaxButton('删除所选', $this->createUrl('ajaxBaikeTagDel'), array('data'=>array('ids'=>'js:getChecked()'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm', 'data-toggle'=>'confirmation', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true)) : ''; ?>
</div>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>
<script type="text/javascript">
    <?php Tools::startJs(); ?>
        //----排序开始---
        function set_sort(_this, id, sort){
            $.getJSON('<?php echo $this->createUrl('AjaxBaikeTagSort')?>',{id:id,sort:sort},function(dt){
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
$checkbox = '
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
        $("#aid").val(ids);
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
Yii::app()->clientScript->registerScript('sel', $checkbox, CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js', CClientScript::POS_END);
?>
