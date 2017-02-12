<?php
$this->pageTitle = '学区房';
$this->breadcrumbs = array('房源管理','学区房列表');
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            <div class="form-group">
                <?php echo CHtml::dropDownList('type',empty($_GET['type'])?'':$_GET['type'],array('name'=>'学校','id'=>'ID'),array('class'=>'form-control','encode'=>false)); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::textField('value',empty($_GET['value'])?'':$_GET['value'],array('class'=>'form-control')) ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('stype',$stype,SchoolExt::$type,array('class'=>'form-control','empty'=>'学校类型','encode'=>false)); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('area',$area,$areas,array('class'=>'form-control','empty'=>'全部区域','encode'=>false)); ?>
            </div>
            <button type="submit" class="btn blue">搜索</button>
        </form>
    </div>
    <div class="btn-group pull-right">
        <a href="<?php echo $this->createUrl('/admin/school/edit',array('referrer'=>Yii::app()->request->url))?>" class="btn green">
            添加学校 <i class="fa fa-plus"></i>
        </a>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th width="35px"><input type="checkbox"></th>
        <th class="text-center">id</th>
        <th class="text-center">学校</th>
        <th class="text-center">类型</th>
        <th class="text-center">区域</th>
        <th class="text-center">学区房</th>
        <th class="text-center">状态</th>
        <th class="text-center">推荐</th>
        <th class="text-center">添加时间</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $v): ?>
        <tr>
            <td class="text-center"><input type="checkbox" name="item[]" value="<?php echo $v->id; ?>" class="checkboxes"></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->id; ?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->name; ?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo SchoolExt::$type[$v->type]; ?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->areaInfo ? $v->areaInfo->name : '-' ?></td>
            <td style="text-align:center;vertical-align: middle">
                <a href="<?php echo $this->createUrl('rel',array('id'=>$v->id))?>" class="btn btn-xs blue ">管理<span>[<?php echo count(SchoolPlotRelExt::model()->findAll('sid = :sid',array(':sid'=>$v->id)))?>]</span></a>
            </td>
            <td style="text-align:center;vertical-align: middle">
                <?php echo CHtml::ajaxLink(SchoolExt::$status[$v->status],$this->createUrl('ajaxStatus'), array('type'=>'post', 'data'=>array('id'=>$v->id, 'status'=>$v->status==1?0:1),'success'=>'function(data){location.reload()}'), array('class'=>'btn btn-sm '.PlotExt::$statusStyle[$v->status])); ?>
            </td>
            <td style="text-align:center;vertical-align: middle">
                <?php echo CHtml::ajaxLink(SchoolExt::$recommend[$v->recommend != 0 ? 1 : 0],$this->createUrl('ajaxRecom'), array('type'=>'post', 'data'=>array('id'=>$v->id, 'recommend'=>$v->recommend != 0 ? 0 : time()),'success'=>'function(data){location.reload()}'), array('class'=>'btn btn-sm '.PlotExt::$statusStyle[$v->recommend != 0 ? 1 : 0])); ?>
            </td>
            <td style="text-align:center;vertical-align: middle"><?php echo ($v->created > 0) ? date('Y-m-d',$v->created) : '暂无';?></td>
            <td style="text-align:center;vertical-align: middle">
                <a href="<?php echo $this->createUrl('edit',array('id'=>$v->id,'referrer'=>Yii::app()->request->url)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 修改 </a>
                <?php
                    echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('del'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
                 ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="form-group">
    <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
    <?php echo CHtml::ajaxButton('启用/禁用所选', $this->createUrl('/admin/school/ajaxRecomStatus'), array('data'=>array('ids'=>'js:getChecked()','status'=>0),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')); ?>
    <?php echo  CHtml::ajaxButton('删除所选', $this->createUrl('/admin/school/ajaxDelRecom'), array('data'=>array('ids'=>'js:getChecked()'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm', 'data-toggle'=>'confirmation', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true)); ?>
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
