<?php
$this->pageTitle = '资讯列表';
$this->breadcrumbs = array('资讯管理', $this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            标题
            <div class="form-group">
                <?php echo CHtml::textField('title', empty($_GET['title']) ? '' : $_GET['title'], array('class' => 'form-control')) ?>
            </div>
            发布人
            <div class="form-group">
                <?php echo CHtml::textField('author', empty($_GET['author']) ? '' : $_GET['author'], array('class' => 'form-control')) ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('cid', empty($_GET['cid']) ? '' : $_GET['cid'], CHtml::listData(Tools::menuMake(ArticleCateExt::model()->normal()->findAll()), 'id', 'name'), array('class' => 'form-control', 'encode' => false, 'empty' => '分类')); ?>
            </div>
            <button type="submit" class="btn btn-warning">搜索 <i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="pull-right">
        <a href="<?php echo $this->createUrl('edit') ?>" class="btn blue">
            添加文章 <i class="fa fa-plus"></i>
        </a>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
        <tr>
            <th width="35px"><input type="checkbox"></th>
            <th class="text-center">id</th>
<!--            <th class="text-center" style="width: 50px">排序</th>-->
            <th class="text-center">标题</th>
            <th class="text-center">浏览量</th>
            <th class="text-center">分类</th>
            <th class="text-center">发布人</th>
            <th class="text-center">最后编辑人</th>
            <th class="text-center">发布时间</th>
            <th class="text-center">状态</th>
            <th class="text-center">操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($data as $v): ?>
        <tr>
            <td><input class="checkboxes" type="checkbox" name="item[]" value="<?php echo $v->id ?>"></td>
            <td><?php echo $v->id ?></td>
<!--            <td class="warning sort_edit" data-id="--><?php //echo $v->id?><!--" style="text-align:center;vertical-align: middle">--><?php //echo $v->sort ?><!--</td>-->
            <td><a href="<?php echo (isset($v->url) && !empty($v->url)) ? $v->url : $this->createUrl('/home/news/detail',array('articleid'=>$v->id))?>" target="_blank"><?php echo $v->title; ?></a></td>
            <td class="text-center"><?php echo $v->hits; ?></td>
            <td class="text-center"><?php echo $v->cate ? $v->cate->name : '（无分类）'; ?></td>
            <td class="text-center"><?php echo $v->author; ?></td>
            <td class="text-center"><?php echo $v->editor ? $v->editor : '-'; ?></td>
            <td class="text-center"><?php echo date('Y-m-d',$v->show_time); ?></td>
            <td class="text-center"><?php echo CHtml::ajaxLink(ArticleExt::$status[$v->status],$this->createUrl('ajaxChangeStatus'), array('type'=>'post', 'data'=>array('id'=>$v->id),'success'=>'function(data){location.reload()}'), array('class'=>'btn btn-sm '.ArticleExt::$statusStyle[$v->status])); ?></td>
            <td>
                <a href="<?php echo $this->createUrl('edit',array('id'=>$v->id,'referrer'=>Yii::app()->request->url)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                <?php echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('ajaxArticleDel'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));?>
                <a href="<?php echo $this->createUrl('setsession',array('id'=>$v->id)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 推荐 </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="form-group">
    <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
    <?php echo CHtml::ajaxButton('启用所选', $this->createUrl('ajaxChangeStatus'), array('data'=>array('id'=>'js:getChecked()'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')); ?>
    <?php echo !isset($_GET['status']) ? CHtml::ajaxButton('禁用所选', $this->createUrl('ajaxChangeStatus'), array('data'=>array('id'=>'js:getChecked()'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')) : ''; ?>
    <?php echo !isset($_GET['status']) ? CHtml::ajaxButton('删除所选', $this->createUrl('ajaxArticleDel'), array('data'=>array('id'=>'js:getChecked()'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm', 'data-toggle'=>'confirmation', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true)) : ''; ?>
    <?php echo !isset($_GET['status']) ? CHtml::ajaxButton('批量关联楼盘', $this->createUrl('ajaxPlotRelated'), array('data'=>array('id'=>'js:getChecked()'),'type'=>'post', 'success'=>'function(data){location.reload()}',
    'beforeSend'=>'function(){
            if(!getChecked())
                {
                    toastr.error("请至少选择一项！");
                    return false;
                }else{
                    plotRelated();
                }
            }'),
    array('class'=>'btn btn-success btn-sm related')) : ''; ?>
<?php $form = $this->beginWidget('HouseForm', array('htmlOptions' => array('class' => 'form-horizontal'))) ?>
    <div class=" drop-down" style="display:none">
        <?php
        foreach ($data as $key) {
            echo $form->multiAutocomplete($key, 'plot',array(),$this->createUrl('/admin/plot/ajaxGetHouse'), array('class'=>'form-control'));
            break;
        }
         ?>
         <input type="hidden" name="aid" id="aid" value="">
         <button type="submit" class="btn btn-success btn-sm ">确定</button>
         <button type="button" class="btn btn-success btn-sm " onclick="cancelChecked()">取消</button>
    </div>

    <?php $this->endWidget() ?>

</div>

<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>
    <script language="JavaScript">
        function set_sort(_this, id, sort){
            $.getJSON('<?php echo $this->createUrl('EditArticleSort')?>',{id:id,sort:sort},function(dt){
                _this.parent().html(dt.sort);
            });
        }
        function plotRelated(){
            // alert(111);
            $(".drop-down").css('display','block');
        }
        function do_sort(ts){
            if(ts.which == 13){
                _this = $(ts.target);
                sort = _this.val();
                id = _this.parent().data('id');
                set_sort(_this, id, sort);
            }
        }
        function cancelChecked(){
            $(".select2-search-choice").remove();
            $(".drop-down").css('display','none');
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
