<?php
/**
 * Created by PhpStorm.
 * User: wanggris
 * Date: 15-9-11
 * Time: 下午2:54
 */

$this->pageTitle = '图片相册';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
    <form method="get" action="<?php $this->createUrl('/admin/plot/imagelist')?>">
        <div class="btn-group">
            <?php echo CHtml::dropDownList('type',$type,$ctype,array('class'=>'form-control','encode'=>false)); ?>
        </div>

        <input name="hid" value="<?php echo Yii::app()->request->getParam('hid',0) ?>" type="hidden"/>
        <button type="submit" class="btn blue">搜索</button>
    </form>
    <div class="btn-group pull-right">
        <?php echo CHtml::link('批量添加图片 <i class="fa fa-plus"></i>', $this->createUrl('plot/imageadd',array('hid'=>$hid)),array('class'=>'btn green'));
        ?>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th class="text-center"><input type="checkbox"></th>
        <th style="width: 50px" class="text-center">排序</th>
        <th class="text-center">ID</th>
        <th class="text-center">图片名称</th>
        <th class="text-center">类别</th>
        <th class="text-center">预览</th>
        <th class="text-center">是否封面</th>
        <th class="text-center">添加时间</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $v):?>
        <tr>
            <td style="text-align:center;vertical-align: middle"><input type="checkbox" name="item[]" value="<?php echo $v->id ?>" class="checkboxes"></td>
            <td class="warning sort_edit" data-id="<?php echo $v->id?>" style="text-align:center;vertical-align: middle"><?php echo $v->sort;?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->id;?></td>
            <td style="text-align:center;vertical-align: middle;width: 10%;"><?php echo $v->title;?></td>
            <td style="text-align:center;vertical-align: middle">
                <?php echo isset($tags[$v->type]) ? $tags[$v->type]->name : '-';?>
            </td>

            <td style="text-align:center;vertical-align: middle">
                <?php echo CHtml::link(CHtml::image(ImageTools::fixImage($v->url,'100','75'),'',array('width'=>'100px','height'=>'75px')),ImageTools::fixImage($v->url), array('target'=>'_blank'));?>
            </td>
            <td style="text-align:center;vertical-align: middle">
                <?php
                    echo CHtml::htmlButton(PlotimgExt::$isCover[$v->is_cover], array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs '.($v->is_cover == 1?'green':'red'), 'data-title'=>'是否设为封面？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('/admin/plot/ajaxSetCover'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
                ?>
            </td>
            <td style="text-align:center;vertical-align: middle"><?php echo date('Y-m-d',$v->created);?></td>
            <td style="text-align:center;vertical-align: middle">
                <a href="<?php echo $this->createUrl('/admin/plot/imageedit',array('id'=>$v->id,'hid'=>$hid)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                <?php
                echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('/admin/plot/ajaxImageDel'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('ids'=>$v->id))));
                ?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>
<div class="form-group">
    <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
    <?php echo  CHtml::ajaxButton('删除所选', $this->createUrl('/admin/plot/ajaxImageDel'), array('data'=>array('ids'=>'js:getChecked()'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm', 'data-toggle'=>'confirmation', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true)); ?>
</div>
<script>
    function set_sort(_this, id, sort){
        $.getJSON('<?php echo $this->createUrl('/admin/plot/editimagesort')?>',{id:id,sort:sort},function(dt){
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
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/jquery-mixitup/jquery.mixitup.min.js',CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/fancybox/source/jquery.fancybox.pack.js',CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js', CClientScript::POS_END);
?>
