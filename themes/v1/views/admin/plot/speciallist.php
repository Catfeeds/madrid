<?php
$this->pageTitle = '特价房';
$this->breadcrumbs = array('房源管理','特价房列表');
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            <div class="form-group">
                <?php echo CHtml::dropDownList('type',empty($_GET['type'])?'':$_GET['type'],array('title'=>'名称','id'=>'ID'),array('class'=>'form-control','encode'=>false)); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::textField('value',empty($_GET['value'])?'':$_GET['value'],array('class'=>'form-control')) ?>
            </div>
            <button type="submit" class="btn blue">搜索</button>
        </form>
    </div>
    <div class="btn-group pull-right">
        <a href="<?php echo $this->createAbsoluteUrl('specialedit',array('referrer'=>Yii::app()->request->url)) ?>" class="btn green">
            添加特价房 <i class="fa fa-plus"></i>
        </a>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th width="35px"><input type="checkbox"></th>
        <th class="text-center">id</th>
        <th class="text-center" style="width: 50px">排序</th>
		<th class="text-center">楼盘名称</th>
        <th class="text-center">标题</th>
        <th class="text-center">房号</th>
        <th class="text-center">面积</th>
        <th class="text-center">特价</th>
        <th class="text-center">状态</th>
        <th class="text-center">是否推荐</th>
        <th class="text-center">截至时间</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $v): ?>
        <tr>
            <td class="text-center"><input type="checkbox" name="item[]" value="<?php echo $v->id;?>"></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->id; ?></td>
            <td class="warning sort_edit" style="text-align:center;vertical-align: middle" data-id="<?php echo $v->id?>"><?php echo $v->sort ?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->plot['title']; ?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->title; ?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->room; ?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->size; ?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->price_new ? $v->price_new.PlotExt::$unit($v->price_unit) : '暂无' ?></td>
            <td style="text-align:center;vertical-align: middle">
                <?php if(in_array($v->status,array(0,1))):?>
                <?php echo CHtml::ajaxLink(HousesSpecialExt::$status[$v->status],$this->createAbsoluteUrl('speciallist'), array('type'=>'post', 'data'=>array('id'=>$v->id, 'status'=>$v->status==1?0:1),'success'=>'function(data){location.reload()}'), array('class'=>'btn btn-sm '.HousesLibExt::$statusStyle[$v->status])); ?>
                <?php else:?>
                    <a class="btn btn-sm " href="javascript:;" ><?php echo HousesSpecialExt::$status[$v->status];?></a>
                <?php endif;?>
            </td>
            <td style="text-align:center;vertical-align: middle">
                <?php echo CHtml::ajaxLink(HousesSpecialExt::$is_recommend[$v->is_recommend],$this->createAbsoluteUrl('speciallist'), array('type'=>'post', 'data'=>array('id'=>$v->id, 'is_recommend'=>$v->is_recommend==1?0:1),'success'=>'function(data){location.reload()}'), array('class'=>'btn btn-sm '.HousesLibExt::$statusStyle[$v->is_recommend])); ?>
            </td>
			<td style="text-align:center;vertical-align: middle"><?php echo ($v->end_time > 0) ? date('Y-m-d',$v->end_time) : '暂无';?></td>
            <td style="text-align:center;vertical-align: middle">
                <a href="<?php echo $this->createAbsoluteUrl('/admin/house/specialedit',array('id'=>$v->id,'referrer'=>Yii::app()->request->url)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 修改 </a>
                <?php
					echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs yellow', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createAbsoluteUrl('specialdel'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
                 ?>
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
Yii::app()->clientScript->registerScript('sort_edit',$js);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js', CClientScript::POS_END);
?>
