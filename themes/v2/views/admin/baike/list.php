<?php
$this->pageTitle = '知识库列表';
$this->breadcrumbs = array('知识库管理', $this->pageTitle);
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
                <?php echo CHtml::dropDownList('cid', empty($_GET['cid']) ? '' : $_GET['cid'], CHtml::listData(Tools::menuMake(BaikeCateExt::model()->enabled()->findAll()), 'id', 'name'), array('class' => 'form-control', 'encode' => false, 'empty' => '分类')); ?>
            </div>
            <button type="submit" class="btn btn-warning">搜索 <i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="pull-right">
     <div class="btn-group">
        <button id="btnGroupVerticalDrop5" type="button" class="btn yellow dropdown-toggle" data-toggle="dropdown">
        拉取云端共享数据 <i class="fa fa-cloud-download"></i>
        </button>
        <ul class="dropdown-menu" role="menu" aria-labelledby="btnGroupVerticalDrop5">
            <li>
                <?php echo CHtml::ajaxLink('拉取20个',$this->createUrl('AjaxPullData',['num'=>20]), array('success'=>'function(data){location.reload()}'), array('class'=>'btn')); ?>
            </li>
            <li>
                <?php echo CHtml::ajaxLink('拉取50个',$this->createUrl('AjaxPullData',['num'=>50]), array('success'=>'function(data){location.reload()}'), array('class'=>'btn')); ?>
            </li>
            <li>
                <?php echo CHtml::ajaxLink('拉取100个',$this->createUrl('AjaxPullData',['num'=>100]), array('success'=>'function(data){location.reload()}'), array('class'=>'btn')); ?>
            </li>
        </ul>
    </div>
            <?php echo CHtml::link('添加文章 <i class="fa fa-plus"></i>',SM::urmConfig()->siteID=='hualongxiang'?'http://yun.hangjiayun.com':$this->createUrl('edit'), array('class'=>'btn blue','target'=>SM::urmConfig()->siteID=='hualongxiang'?'_blank':'')); ?>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
        <tr>
            <th width="35px"><input type="checkbox"></th>
            <th class="text-center">id</th>
<!--            <th class="text-center" style="width: 50px">排序</th>-->
            <th class="text-center">标题</th>
            <th class="text-center">分类</th>
            <th class="text-center">发布人</th>
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
            <td><a href="<?php echo $v->link ? $v->link : $this->createUrl('/home/baike/detail',array('id'=>$v->id))?>" target="_blank"><?php echo $v->title; ?></a></td>
            <td class="text-center"><?php echo $v->cate ? $v->cate->name : '（无分类）'; ?></td>
            <td class="text-center"><?php echo $v->author; ?></td>
            <td class="text-center"><?php echo date('Y-m-d',$v->created); ?></td>
            <td class="text-center"><?php echo CHtml::ajaxLink(BaikeExt::$status[$v->status],$this->createUrl('ajaxChangeBaikeStatus'), array('type'=>'post', 'data'=>array('ids'=>$v->id),'success'=>'function(data){location.reload()}'), array('class'=>'btn btn-xs '.BaikeExt::$statusStyle[$v->status])); ?></td>
            <td>
                <a href="<?php echo $this->createUrl('edit',array('id'=>$v->id,'referrer'=>Yii::app()->request->url)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                <?php echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('ajaxBaikeDel'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('ids'=>$v->id))));?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="form-group">
    <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
    <?php echo CHtml::ajaxButton('启用所选', $this->createUrl('ajaxChangeBaikeStatus'), array('data'=>array('ids'=>'js:getChecked()','type'=>'1'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')); ?>
    <?php echo !isset($_GET['status']) ? CHtml::ajaxButton('禁用所选', $this->createUrl('ajaxChangeBaikeStatus'), array('data'=>array('ids'=>'js:getChecked()','type'=>'0'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')) : ''; ?>
    <?php echo !isset($_GET['status']) ? CHtml::ajaxButton('删除所选', $this->createUrl('ajaxBaikeDel'), array('data'=>array('ids'=>'js:getChecked()'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm', 'data-toggle'=>'confirmation', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true)) : ''; ?>
</div>

<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>
    <script language="JavaScript">
        function set_sort(_this, id, sort){
            $.getJSON('<?php echo $this->createUrl('EditBaikeSort')?>',{id:id,sort:sort},function(dt){
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
