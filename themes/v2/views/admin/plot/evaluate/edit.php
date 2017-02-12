<?php
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
            <div class="col-xs-4"><?php echo $form->error($model, 'sid'); ?></div>
        </div>

        <ul class="nav nav-tabs">
            <?php $k=-1;foreach(PlotEvaluateExt::$contentFields as $field):$k++ ?>
            <li <?php if(!$k): ?>class="active"<?php endif;?> data-url="<?php echo $this->createUrl('/admin/plot/evaluate',['hid'=>$model->hid]); ?>#<?php echo $field; ?>">
                <a href="#<?php echo $field; ?>" data-toggle="tab"><?php echo $form->label($model, $field); ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content">
            <?php $k=-1;foreach(PlotEvaluateExt::$contentFields as $field):$k++;
            $this->widget('ext.ueditor.UeditorWidget',array('id'=>'content'.$field,'name'=>'editor'.$field,'options'=>"toolbars:[['source','fontfamily','fontsize','bold','italic','underline','removeformat','forecolor','justifyleft','justifycenter','justifyright','insertorderedlist','insertunorderedlist','directionalityltr','directionalityrtl','indent','horizontal','insertimage']]"));
            ?>
            <!-- 一个分析元素 -->
            <div class="tab-pane fade <?php if(!$k): ?>active in<?php endif; ?>" id="<?php echo $field; ?>">
                <!-- 分析元素下的一个分析纬度 -->
                <div class="item">
                    <div class="form-group">
                        <label class="col-xs-2 control-label">本项缩略图<span class="required" aria-required="true">*</span></label>
                        <div class="col-xs-4">
                            <?php $this->widget('FileUpload',array('model'=>$model, 'attribute'=>$field.'[image]','mode'=>2,'width'=>300,'id'=>$field)) ?>
                            <span class="help-block">建议尺寸400x400px</span>
                        </div>
                        <div class="col-xs-2"><?php echo $form->error($model, $field.'[image]') ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">内容<span class="required" aria-required="true">*</span></label>
                        <div class="col-xs-8">
                            <div class="margin-bottom-10 help-block">
                                小提示：可以使用编辑器最后一个按钮添加子标题哦。
                            </div>
                            <?php echo $form->textArea($model, $field.'[content]', array('id'=>'content'.$field)); ?>
                        </div>
                        <div class="col-xs-2"><?php echo $form->error($model, $field.'[content]') ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="form-group">
            <label class="col-xs-4 control-label"></label>
            <div class="col-xs-5">
                <button type="submit" class="btn green">保存</button>
            </div>
        </div>

    </div>
    <?php $this->endWidget(); ?>
</div>

<!-- 弹框模板 -->
<div class="hide">
    <div class="portlet-body" id="stitle">
        <div class="form-horizontal">
            <div class="form-body">
               <div class="form-group">
                  <label class="col-xs-2 control-label">子标题</label>
                  <div class="col-xs-6">
                     <input class="form-control" id="child-titles-title" type="text" maxlength="50" value="" />
                  </div>
               </div>
           </div>
        </div>
    </div>
</div>

<?php Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootbox/bootbox.min.js', CClientScript::POS_END); ?>
<script type="text/javascript">
    <?php Tools::startJs(); ?>
    $(".nav-tabs li").click(function(){
        $("form").attr("action",$(this).data("url"))
    });

    UE.registerUI('dialog',function(editor,uiName){
           var tpl=$('#stitle');
            //参考addCustomizeButton.js
            var btn = new UE.ui.Button({
              //   name:'dialogbutton' + uiName,
                name:'添加子标题',
                title:'添加子标题',
                //需要添加的额外样式，指定icon图标，这里默认使用一个重复的icon
                cssRules :'background-position: -460px -40px;',
                onclick:function () {
                    //渲染dialog
                    bootbox.dialog({
                       message: tpl,
                       title: '添加子标题',
                       buttons: {
                          danger: {
                             label: "取消",
                             className: "btn-danger",
                             callback: function() {

                             }
                          },
                          main: {
                             label: "添加",
                             className: "btn-primary",
                             callback: function() {
                                var title = $('#child-titles-title').val();
                                var insert_data = '[stitle]'+title+'[/stitle]';
                                editor.execCommand( 'inserthtml', insert_data);
                                $('#child-titles-title').val('');
                             }
                          }
                       }
                    });
                }
            });

            return btn;
        }/*index 指定添加到工具栏上的那个位置，默认时追加到最后,editorId 指定这个UI是那个编辑器实例上的，默认是页面上所有的编辑器都会添加这个按钮*/);
    <?php Tools::endJs('js'); ?>
</script>
