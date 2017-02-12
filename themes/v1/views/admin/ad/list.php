<?php
$this->pageTitle = '广告管理';
$this->breadcrumbs = array($this->pageTitle);
?>

<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline" action="" method="get">
            <?php if($this->siteConfig['enableSubstation']): ?>
                <div class="form-group">
                    <?php echo CHtml::dropDownList('substation', $substation, CHtml::listData($this->substations,'area_id','name'),array('class'=>'form-control','encode'=>false,'submit'=>'')); ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
    <div class="btn-group pull-right">
        <a class="btn default reset_ad" data-toggle="modal" href="#basic">添加广告</a>
        <?php //echo CHtml::ajaxLink('更新首页<i class="fa fa-external-link"></i>',$this->createUrl('/home/index/build'),array('success'=>'function(d){if(d.code==1){toastr.success(d.msg)}else{toastr.error("更新失败，请重试")}}'), array('class'=>'btn green')); ?>
            <!-- <a href="<?php echo $this->createUrl('/home/index/active') ?>" target="_blank" class="btn red">
                预览首页 <i class="fa fa-external-link"></i>
            </a> -->
    </div>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th width="">百度广告id</th>
            <th>投放位置</th>
            <th>广告尺寸类型</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $v): ?>
        <tr>
            <td><?php echo $v->bd_id.($v->note?'('.$v->note.')':''); ?></td>
            <td><?php echo BaiduAdExt::$position[$v->position]['name']; ?></td>
            <td><?php echo BaiduAdExt::$size[$v->size]; ?></td>
            <td>
                <?php echo CHtml::htmlButton('<i class="fa fa-edit"></i>编辑', array('data-toggle'=>'modal','href'=>'#basic','onclick'=>'js:changeSize("'.$v->position.'");$.get("'.$this->createUrl('ajaxEdit',['id'=>$v->id]).'",function(d){for(var k in d){$("#BaiduAdExt_"+k).val(d[k]);}});$("form").attr("action","'.$this->createUrl('/admin/ad/edit', array('id'=>$v->id)).'")', 'class'=>'btn btn-xs green')); ?>
                <?php echo CHtml::ajaxLink('<i class="fa fa-times"></i>删除', $this->createUrl('/admin/ad/ajaxDel'), array('type'=>'post','data'=>array('id'=>$v->id),'success'=>'js:function(d){if(d.code){location.reload()}else{toastr.error("删除失败！")}}'), array('class'=>'btn btn-xs red', 'data-toggle'=>'confirmation', 'data-title'=>'确认删除？','data-btn-ok-label'=>'确认','data-btn-cancel-label'=>'取消','data-popout'=>true));
                 ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>

<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
<?php $form = $this->beginWidget('HouseForm', array('htmlOptions'=>array('class'=>'form-horizontal'))); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">添加广告</h4>
            </div>
            <div class="modal-body">
                <div class="note note-info">
                    <h4 class="block">广告尺寸说明</h4>
                    <p>
                        【大幅降落】宽1150px，高不限，限添加一个<br>
                        【通栏】宽1150px，高60px，每个位置个数不限<br>
                        【中尺寸通栏】宽760px，高90px，仅适用首页中尺寸通栏<br>
                        【首页右侧banner、新房列表页右侧banner尺寸】宽230px，高不限<br>
                        【其他页右侧banner尺寸】宽300px，高不限<br>
                        <!-- 【二分之一尺寸】宽495px，高60px，每个位置个不限<br>
                        【三分之一尺寸】宽325px，高60px，每个位置个数不限<br>
                        【四分之一尺寸】宽245px，高60px，每个位置个数不限<br>
                        【六分之一尺寸】宽160px，高160px，每个位置个数不限<br> -->
                    </p>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">投放位置</label>
                    <div class="col-md-7">
                        <?php echo $form->dropDownList($model, 'position', $position, array('class'=>'form-control','onchange'=>'changeSize($(this).val())')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">尺寸类型</label>
                    <div class="col-md-7">
                        <?php echo $form->dropDownList($model, 'size', BaiduAdExt::$size, array('class'=>'form-control')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">广告id</label>
                    <div class="col-md-7">
                        <?php echo $form->textField($model, 'bd_id', array('class'=>'form-control')); ?>
                    </div>
                    <div class="col-md-3"><?php echo $form->error($model, 'bd_id'); ?></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">上传flash</label>
                    <div class="col-md-7">
                        <?php $this->widget('FileUpload',array('model'=>$model, 'attribute'=>'swf_url','callback'=>'function(d){if(d.code){$("#BaiduAdExt_swf_url").val(d.msg.url);}else{toastr.error("上传失败")}}')); ?>
                    </div>
                    <div class="col-md-3"><?php echo $form->error($model, 'swf_url'); ?></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">flash链接</label>
                    <div class="col-md-7">
                        <?php echo $form->textField($model, 'swf_url', array('class'=>'form-control')); ?>
                    </div>
                    <div class="col-md-3"><?php echo $form->error($model, 'swf_url'); ?></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">排序</label>
                    <div class="col-md-7">
                        <?php echo $form->textField($model, 'sort', array('class'=>'form-control')); ?>
                    </div>
                    <div class="col-md-3"><?php echo $form->error($model, 'sort'); ?></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">备注</label>
                    <div class="col-md-7">
                        <?php echo $form->textField($model, 'note', array('class'=>'form-control')); ?>
                    </div>
                    <div class="col-md-3"><?php echo $form->error($model, 'note'); ?></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">自定义代码</label>
                    <div class="col-md-7">
                        <?php echo $form->textArea($model, 'code', array('class'=>'form-control')); ?>
                    </div>
                    <div class="col-md-3"><?php echo $form->error($model, 'code'); ?></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn blue">保存</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
<?php $this->endWidget(); ?>
</div>


<script type="text/javascript">
<?php Tools::startJs(); ?>
    $(".reset_ad").click(function(){
        $("form").attr("action", "");
        $("input").val("");
    });

    //初始化下拉框操作
    $("#BaiduAdExt_position").change();

    //切换select框，二级联动
    function changeSize(position){
        <?php
            foreach(BaiduAdExt::$position as $k=>$v)
            {
                foreach($v['size'] as $vv)
                {
                    $size[$k][] = array('name'=>BaiduAdExt::$size[$vv], 'value'=>$vv);
                }
            }
            echo 'var size='.CJSON::encode($size).';';
        ?>
        data_size = size[position];
        optionstring = '';
        for(var item in data_size)
        {
            optionstring += "<option value=\""+data_size[item].value +"\" >"+ data_size[item].name +"</option>";
        }
        jQuery("#BaiduAdExt_size").html(optionstring);
    }
<?php Tools::endJs('js'); ?>
</script>
