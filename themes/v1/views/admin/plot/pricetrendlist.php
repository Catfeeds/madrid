<?php
$this->pageTitle = '价格走势';
$this->breadcrumbs = array('房源管理','价格走势列表');
?>

<div class="table-toolbar">
    <div class="btn-group pull-right">
        <a href="<?php echo $this->createUrl('pricetrendedit') ?>" class="btn green">
            添加价格走势 <i class="fa fa-plus"></i>
        </a>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th class="text-center" style="width: 80px">时间</th>
        <th class="text-center">价格走势</th>
        <th class="text-center" style="width: 150px">操作</th>
    </tr>
    </thead>
    <tbody>
       <?php foreach ($data as $v): ?>
        <tr>
            <td class="text-center"><?php echo $v->formatTime; ?></td>
			<td class="text-center">
				<?php foreach ($v->data as $key=>$val): ?>
					<?php if ($key == 0): ?>
						市:
					<?php elseif (isset($area[$key])): ?>
						<?php echo ' | '.$area[$key]->name; ?>:
					<?php
                        else:
                            continue;
                        endif;
                    ?>
					<?php echo $val?$val.' 元/㎡':'未填'; ?>
				<?php endforeach;?>
			</td>
            <td class="text-center">
                <a href="<?php echo $this->createUrl('/admin/plot/pricetrendedit', array('id'=>$v->id, 'referrer'=>Yii::app()->request->url)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 修改 </a>
                <?php echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs yellow', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true, 'ajax'=>array('url'=>$this->createAbsoluteUrl('pricetrenddel'), 'type'=>'post', 'success'=>'function(data){location.reload()}', 'data'=>array('id'=>$v->id))));?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
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
        $.getJSON('<?php echo $this->createAbsoluteUrl('/admin/plot/EditSpecialSort')?>',{id:id,sort:sort},function(dt){
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
Yii::app()->clientScript->registerScript('sort_edit', $js);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js', CClientScript::POS_END);
?>
