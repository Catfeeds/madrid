<?php
/**
 * 第二种模板，减少复杂交互，方便点
 */
$this->pageTitle = $model->plot->title.'-楼盘评测';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="portlet-body">
    <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
    <div class="form-body">
        <div class="form-group">
            <label class="col-xs-3 control-label">买房顾问<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-5">
                <?php echo $form->dropDownList($model, 'sid', $staffs, array('class'=>'form-control')); ?>
            </div>
            <div class="col-xs-4"><?php echo $form->error($model, 'sid') ?></div>
        </div>

        <ul class="nav nav-tabs">
            <?php foreach(PlotEvaluateExt::$contentFields as $k=>$field): ?>
            <li <?php if(!$k): ?>class="active"<?php endif;?> data-url="<?php echo $this->createUrl('/admin/plot/evaluate',['hid'=>$model->hid]); ?>#<?php echo $field; ?>">
                <a href="#<?php echo $field; ?>" data-toggle="tab"><?php echo $form->label($model, $field); ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content">
            <?php foreach(PlotEvaluateExt::$contentFields as $k=>$field): ?>
            <!-- 一个分析元素 -->
            <div class="tab-pane fade <?php if(!$k): ?>active in<?php endif; ?>" id="<?php echo $field; ?>">
                <table class="table table-bordered table-striped table-condensed flip-content">
                    <thead class="flip-content">
                    <tr>
                        <th class="text-center" width="180px">小标题</th>
                        <th class="text-center">内容</th>
                        <th class="text-center">配图</th>
                        <th class="text-center">状态</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($model->$field as $index=>$item): ?>
                        <tr>
                            <td class="text-center" style="vertical-align: middle"><?php echo $item->title; ?></td>
                            <td class="text-center" style="vertical-align: middle"><?php echo $item->content; ?></td>
                            <td class="text-center" style="vertical-align: middle"><?php echo $item->image?CHtml::image(ImageTools::fixImage($item->image,0,60,2)):'无'; ?></td>
                            <td class="text-center" style="vertical-align: middle">
                                <a href="<?php echo $this->createUrl('/admin/plot/evaluateItem',array('id'=>$model->id,'field'=>$field,'index'=>$index)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                                <?php
                                echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('/admin/plot/evaluate',['id'=>$model->id,'index'=>$index]),'type'=>'post','success'=>'function(data){location.reload()}')));
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
    <?php Tools::startJs(); ?>
    $(".nav-tabs li").click(function(){
        $("form").attr("action",$(this).data("url"))
    });
    //删除按钮
    $(".fa-trash-o").click(function(){
        $(this).closest(".item").remove();
    });
    //增加按钮
    $(".btn-block").click(function(){

    });
    <?php Tools::endJs('js'); ?>
</script>
