<?php
$this->pageTitle = '特价房';
$this->breadcrumbs = array('房源管理','特价房列表');
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            <div class="form-group">
                <?php echo CHtml::dropDownList('type',empty($_GET['type'])?'':$_GET['type'],array('title'=>'标题','plotTitle'=>'楼盘名'),array('class'=>'form-control','encode'=>false)); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::textField('value',empty($_GET['value'])?'':$_GET['value'],array('class'=>'form-control')) ?>
            </div>
            <button type="submit" class="btn blue">搜索</button>
        </form>
    </div>
    <div class="btn-group pull-right">
        <a href="<?php echo $this->createUrl('/admin/plotSpecial/edit',array('referrer'=>Yii::app()->request->url)) ?>" class="btn green">
            添加特价房 <i class="fa fa-plus"></i>
        </a>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th width="35px"><input type="checkbox"></th>
        <th class="text-center">id</th>
        <!-- <th class="text-center" style="width: 50px">排序</th> -->
        <th class="text-center">楼盘名称</th>
        <th class="text-center">标题</th>
        <th class="text-center">房号</th>
<!--        <th class="text-center">面积</th>-->
        <th class="text-center">特价</th>
        <th class="text-center">状态</th>
        <th class="text-center">是否推荐</th>
        <th class="text-center">截至时间</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php if(isset($data) && !empty($data)):?>
    <?php foreach($data as $v): ?>
        <tr>
            <td class="text-center"><input type="checkbox" name="item[]" value="<?php echo $v->id;?>" class="checkboxes"></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->id; ?></td>
            <!-- <td class="warning sort_edit" style="text-align:center;vertical-align: middle" data-id="<?php echo $v->id?>"><?php echo $v->sort ?></td> -->
            <td style="text-align:center;vertical-align: middle"><?php echo $v->plot->title; ?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->title; ?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->room; ?></td>
<!--            <td style="text-align:center;vertical-align: middle">--><?php //echo $v->size; ?><!--</td>-->
            <td style="text-align:center;vertical-align: middle"><?php echo $v->price_new ? $v->price_new.'万元/套' : '暂无' ?></td>
            <td style="text-align:center;vertical-align: middle">
                <?php if(in_array($v->status,array(0,1))):?>
                <?php echo CHtml::ajaxLink(PlotSpecialExt::$status[$v->status],$this->createUrl('list'), array('type'=>'post', 'data'=>array('id'=>$v->id, 'status'=>$v->status==1?0:1),'success'=>'function(data){location.reload()}'), array('class'=>'btn btn-sm '.PlotExt::$statusStyle[$v->status])); ?>
                <?php else:?>
                    <a class="btn btn-sm " href="javascript:;" ><?php echo PlotSpecialExt::$status[$v->status];?></a>
                <?php endif;?>
            </td>
            <td style="text-align:center;vertical-align: middle">
                <?php echo CHtml::ajaxLink(($v->recommend == 0) ? '否' : '是',$this->createUrl('list'), array('type'=>'post', 'data'=>array('id'=>$v->id, 'recommend'=>($v->recommend!=0) ? 0 : time()),'success'=>'function(data){location.reload()}'), array('class'=>'btn btn-sm '.PlotExt::$statusStyle[$v->recommend == 0 ? 0 : 1 ])); ?>
            </td>
            <td style="text-align:center;vertical-align: middle"><?php echo ($v->end_time > 0) ? date('Y-m-d',$v->end_time) : '暂无';?></td>
            <td style="text-align:center;vertical-align: middle">
                <a href="<?php echo $this->createUrl('/admin/order/list',['type'=>'特价房','spm_c'=>$v->id]); ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 集客人数：<?php echo $v->fangNum; ?> </a>
                <a href="<?php echo $this->createUrl('/admin/plotSpecial/edit',array('id'=>$v->id,'referrer'=>Yii::app()->request->url)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 修改 </a>
                <?php
                    echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs yellow', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('del'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
                 ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="11" style="text-align:center;vertical-align: middle">未搜索到相关信息</td>
        </tr>
    <?php endif;?>
    </tbody>
</table>
<div class="form-group">
    <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
    <?php echo CHtml::ajaxButton('启用所选', $this->createUrl('/admin/plotSpecial/ajaxRecomStatus'), array('data'=>array('ids'=>'js:getChecked()','status'=>0),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')); ?>
    <?php echo CHtml::ajaxButton('禁用所选', $this->createUrl('/admin/plotSpecial/ajaxRecomStatus'), array('data'=>array('ids'=>'js:getChecked()','status'=>1),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')); ?>
    <?php echo  CHtml::ajaxButton('删除所选', $this->createUrl('/admin/plotSpecial/ajaxDelRecom'), array('data'=>array('ids'=>'js:getChecked()'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm', 'data-toggle'=>'confirmation', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true)); ?>
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

<script>
<?php Tools::startJs(); ?>
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
        $.getJSON('<?php echo $this->createUrl('/admin/plot/EditSpecialSort')?>',{id:id,sort:sort},function(dt){
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
    var getChecked  = function(){
        var ids = "";
        $(".checkboxes").each(function(){
            if($(this).parents('span').hasClass("checked")){
                if(ids == ''){
                    ids = $(this).val();
                } else {
                    ids = ids + ',' + $(this).val();
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

    $("#hname").on("dblclick",function(){
        var hnames = $(".hname");
        console.log(hnames);
        hnames.each(function(){
            var _this = $(this);
            $.getJSON("<?php echo $this->createUrl('/api/houses/getsearch') ?>",{key:_this.html()},function(dt){
                _this.append(" (" + dt.msg[1].length + ")");
            });
        });
    });
    <?php Tools::endJs('js') ?>
</script>