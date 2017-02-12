<?php
$this->pageTitle = '学校区域';
$this->breadcrumbs = array('房源管理','学区房列表');
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            <div class="form-group">
                <?php echo CHtml::dropDownList('type',empty($_GET['type'])?'':$_GET['type'],array('title'=>'学校区域','id'=>'ID'),array('class'=>'form-control','encode'=>false)); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::textField('value',empty($_GET['value'])?'':$_GET['value'],array('class'=>'form-control')) ?>
            </div>
            <button type="submit" class="btn blue">搜索</button>
        </form>
    </div>
    <div class="btn-group pull-right">
        <a href="<?php echo $this->createUrl('/admin/school/areaedit')?>" class="btn green">
            添加学区 <i class="fa fa-plus"></i>
        </a>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th class="text-center">id</th>
        <th class="text-center" style="width: 50px">排序</th>
        <th class="text-center">学校区域</th>
        <th class="text-center">状态</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($data as $v):?>
        <tr>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->id; ?></td>
            <td class="warning sort_edit" data-id="<?php echo $v->id?>" style="text-align:center;vertical-align: middle"><?php echo $v->sort ?></td>
            <td style="text-align:center;vertical-align: middle"><?php echo $v->areaInfo->name; ?></td>
            <td style="text-align:center;vertical-align: middle">
                <?php echo CHtml::ajaxLink(SchoolExt::$status[$v->status],$this->createUrl('ajaxSchoolRelStatus'), array('type'=>'post', 'data'=>array('id'=>$v->id, 'status'=>$v->status==1?0:1),'success'=>'function(data){location.reload()}'), array('class'=>'btn btn-sm '.PlotExt::$statusStyle[$v->status])); ?>
            </td>
            <td style="text-align:center;vertical-align: middle">
                <a href="<?php echo $this->createUrl('/admin/school/areaedit',array('id'=>$v->id))?>" class="btn default btn-xs green"><i class="fa fa-edit"></i>修改</a>
                <?php
                    echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs yellow', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('/admin/school/areaDel'),'type'=>'post','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));
                ?>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>
    <script type="text/javascript">
        function set_sort(_this, id, sort){
            $.getJSON('<?php echo $this->createUrl('/admin/school/EditSchoolAreaSort')?>',{id:id,sort:sort},function(dt){
                _this.parent().html(dt.sort);
                location.reload();
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
        ?>
