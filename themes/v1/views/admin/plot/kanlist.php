<?php
$this->pageTitle = '看房团';
$this->breadcrumbs = array($this->pageTitle);
?>
    <div class="table-toolbar">
        <div class="btn-group pull-left">
            <form class="form-inline">
                <div class="form-group">
                    <?php echo CHtml::dropDownList('type',empty($_GET['type'])?'':$_GET['type'],array('title'=>'标题','id'=>'ID'),array('class'=>'form-control','encode'=>false)); ?>
                </div>
                <div class="form-group">
                    <?php echo CHtml::textField('value',empty($_GET['value'])?'':$_GET['value'],array('class'=>'form-control')) ?>
                </div>
                <button type="submit" class="btn blue">搜索</button>
            </form>
        </div>
        <div class="btn-group pull-right">
            <a href="<?php echo $this->createUrl('kanedit'); ?>" class="btn green">
                添加看房团 <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>

    <table class="table table-bordered table-striped table-condensed flip-content">
        <thead class="flip-content">
        <tr>
            <th width="35px"><input type="checkbox"></th>
            <th class="text-center">id</th>
            <th class="text-center" style="width: 50px">排序</th>
            <th class="text-center">标题</th>
            <th class="text-center">楼盘</th>
            <th class="text-center">报名</th>
            <th class="text-center">相册编辑</th>
            <th class="text-center">状态</th>
            <th class="text-center">是否推荐</th>
            <th class="text-center">截止时间</th>
            <th class="text-center">添加时间</th>
            <th class="text-center">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($list as $v): ?>
            <tr>
                <td class="text-center"><input type="checkbox" name="item[]" value="<?php echo $v->id; ?>" class="checkboxes"></td>
                <td style="text-align:center;vertical-align: middle"><?php echo $v->id; ?></td>
                <td class="warning sort_edit" data-id="<?php echo $v->id?>" style="text-align:center;vertical-align: middle"><?php echo $v->sort ?></td>
                <td style="text-align:center;vertical-align: middle"><?php echo $v->title; ?></td>
                <td style="vertical-align: middle;width: 25%">
                    <?php
                        echo implode(' ， ',CHtml::listData($v->plots, 'id', 'title'));
                     ?>
                </td>
                <td style="text-align:center;vertical-align: middle"><a href="<?php echo $this->createUrl('/admin/order/list',['type'=>'看房团','spm_c'=>$v->id]); ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 报名人数：<?php echo $v->kanNum; ?> </a></td>
                <td style="text-align:center;vertical-align: middle">
                    <?php echo CHtml::Link('看房相册 : '.PlotKanImgExt::model()->count(array('condition'=>'kan_id = :kan_id','params'=>array(':kan_id'=>$v->id))),$this->createUrl('/admin/plot/kanimg',array('kid'=>$v->id)), array('class'=>'btn btn-sm btn btn-xs btn-primary')); ?>
                </td>
                <td style="text-align:center;vertical-align: middle">
                    <?php echo CHtml::ajaxLink(PlotKanExt::$status[$v->status],$this->createUrl('ajaxKanStatus'), array('type'=>'post', 'data'=>array('ids'=>$v->id, 'status'=>$v->status),'success'=>'function(data){location.reload()}'), array('class'=>'btn btn-sm '.PlotExt::$statusStyle[$v->status])); ?>
                </td>
                <td style="text-align:center;vertical-align: middle">
                    <?php echo CHtml::ajaxLink(PlotKanExt::$is_recommend[$v->is_recommend],$this->createUrl('ajaxKanRecom'), array('type'=>'post', 'data'=>array('id'=>$v->id),'success'=>'function(data){location.reload()}'), array('class'=>'btn btn-sm '.PlotExt::$statusStyle[$v->is_recommend])); ?>
                </td>
                <td style="text-align:center;vertical-align: middle"><?php echo ($v->expire > 0) ? date('Y-m-d',$v->expire) : '暂无';?></td>
                <td style="text-align:center;vertical-align: middle"><?php echo ($v->created > 0) ? date('Y-m-d',$v->created) : '暂无';?></td>
                <td style="text-align:center;vertical-align: middle">
                    <a href="<?php echo $this->createUrl('/admin/plot/kanedit',array('id'=>$v->id)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 修改 </a>
                    <?php echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs yellow', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('kandel'),'type'=>'get','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="form-group">
        <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
        <?php echo CHtml::ajaxButton('启用所选', $this->createUrl('ajaxKanStatus'), array('data'=>array('ids'=>'js:getChecked()', 'status'=>0),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')); ?>
        <?php echo !isset($_GET['status']) ? CHtml::ajaxButton('禁用所选', $this->createUrl('ajaxKanStatus'), array('data'=>array('ids'=>'js:getChecked()', 'status'=>1),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')) : ''; ?>
    </div>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>

    <!-- 弹窗 -->
    <div class="modal fade" id="Admin">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="panel-title">
                        <span id="fade-title"></span>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    </h3>
                </div>
                <div class="modal-body">
                    <iframe id="AdminIframe" width="100%" height="100%" scrolling="no" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script language="JavaScript">
        setInterval(function(){
            $("#AdminIframe").height($("#AdminIframe").contents().find("body").height());
            var $panel_title = $('#fade-title');
            $panel_title.html($("#AdminIframe").contents().find("title").html());
        },200);
        function do_admin(ts){
            $('#AdminIframe').attr('src',ts.data("url")).load(function(){
                self = this;
                //延时100毫秒设定高度
                $("#Admin").modal({ show: true, keyboard:false });
                $("#Admin .modal-dialog").css({width:"800px"});
            });
        }
        function set_sort(_this, id, sort){
            $.getJSON('<?php echo $this->createUrl('/admin/plot/EditKanSort')?>',{id:id,sort:sort},function(dt){
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
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js', CClientScript::POS_END);
?>
