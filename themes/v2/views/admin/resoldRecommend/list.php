<?php
$this->pageTitle = '推荐内容管理';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            <?php echo CHtml::dropDownList('t', $t,array(1=>'标题',2=>'推荐人'),array('class'=>'form-control')) ?>
            <div class="form-group">
                <?php echo CHtml::textField('str', $str, array('class'=>'form-control')) ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('cid', $cid, CHtml::listData(Tools::menuMake($this->recomCate,-1,'id'),'id','name'),array('class'=>'form-control','encode'=>false,'empty'=>'--推荐位--','submit'=>'')); ?>
            </div>
            <?php if(SM::globalConfig()->enableSubstation()): ?>
                <div class="form-group">
                    <?php echo CHtml::dropDownList('substation', $substation, CHtml::listData($this->substations,'area_id','name'),array('class'=>'form-control','encode'=>false,'submit'=>'')); ?>
                </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-warning">搜索 <i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="pull-right">
        <a href="<?php echo $this->createUrl('edit') ?>" class="btn blue">
            添加推荐 <i class="fa fa-plus"></i>
        </a>
    </div>
</div>


<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th></th>
        <th class="text-center">id</th>
        <th class="text-center" style="width: 50px">排序</th>
        <th class="text-center">推荐名称</th>
        <th class="text-center">推荐位</th>
        <th class="text-center">推荐人</th>
        <th class="text-center">推荐时间</th>
        <th class="text-center">修改时间</th>
        <th class="text-center">状态</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($list as $v): ?>
        <tr>
            <td class="text-center"><input type="checkbox" name="item[]" value="<?php echo $v['id'] ?>" class="checkboxes"></td>
            <td class="text-center"><?php echo $v->id ?></td>
            <td class="warning sort_edit" data-id="<?php echo $v->id?>" style="text-align:center;vertical-align: middle"><?php echo $v->sort ?></td>
            <td class="text-center"><?php echo $v->title ?></td>
            <td class="text-center"><?php echo $v->cate ? $v->cate->name : '(无分类)'; ?></td>
            <td class="text-center"><?php echo $v->author ?></td>
            <td class="text-center"><?php echo date('Y-m-d H:i', $v->created) ?></td>
            <td class="text-center"><?php echo $v->updated ? date('Y-m-d H:i', $v->updated) : '未修改' ?></td>
            <td class="text-center">
                <?php echo CHtml::ajaxLink(ResoldRecomExt::$status[$v->status]['name'],$this->createUrl('/admin/resoldRecommend/ajaxRecomStatus'), array('type'=>'post', 'data'=>array('ids'=>$v->id, 'status'=>$v->status),'success'=>'function(data){location.reload()}'), array('class'=>'btn btn-sm '.ResoldRecomExt::$status[$v->status]['class'])); ?>
            </td>
            <td class="text-center">
                <a href="<?php echo $this->createUrl('edit',array('id'=>$v['id'])) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                <?php
                    echo CHtml::htmlButton('<i class="fa fa-times"></i> 删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('/admin/resoldRecommend/ajaxDelRecom'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('ids'=>$v->id))));
                 ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="form-group">
    <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
    <?php echo CHtml::ajaxButton('启用所选', $this->createUrl('/admin/resoldRecommend/ajaxRecomStatus'), array('data'=>array('ids'=>'js:getChecked()','status'=>0),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')); ?>
    <?php echo CHtml::ajaxButton('禁用所选', $this->createUrl('/admin/resoldRecommend/ajaxRecomStatus'), array('data'=>array('ids'=>'js:getChecked()','status'=>1),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')); ?>
    <?php echo  CHtml::ajaxButton('删除所选', $this->createUrl('/admin/resoldRecommend/ajaxDelRecom'), array('data'=>array('ids'=>'js:getChecked()'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm', 'data-toggle'=>'confirmation', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true)); ?>
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
?>


<script type="text/javascript">
    <?php Tools::startJs(); ?>
        //----排序开始---
        function set_sort(_this, id, sort){
            $.getJSON('<?php echo $this->createUrl('ajaxRecomSort')?>',{id:id,sort:sort},function(dt){
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
