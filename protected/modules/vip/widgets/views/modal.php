<!-- 刷新操作弹窗 -->
<div class="modal fade" id="Admin" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <iframe id="AdminIframe" width="100%" height="100%" scrolling="no" frameborder="0">
                </iframe>
                <form class="form-inline" method="post" action="">
                <input type="hidden" class="fid" name="fid"/>
                <div class="form-group">
                    <label class="col-md-4 control-label text-nowrap">请选择到期时间</label>
                    <div class="col-md-6">
                        <div class="input-group date form_datetime">
                            <input type="text" class="form-control" id="expire" name="expire"/>
                            <span class="input-group-btn">
                              <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                           </span>
                        </div>
                    </div>
                </div>
                    <button type="button" class="btn default" data-dismiss="modal">取消</button>
                    <button type="submit" class="refresh btn blue">刷新</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- 预约操作弹窗 -->
<div class="modal fade" id="Appoint" data-backdrop="static">
    <form action="#" method="post" class="form-horizontal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title yy">预约刷新</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="fid" class="appfid"/>
                    <div style="display: inline-flex;">
                        <div style="width: 50px;margin-left: 10px">
                            <div class="btn-group" id="chose_hour" data-toggle="buttons">
                                <?php for ($i=0; $i < 24; $i++) { ?>
                                    <label style="margin: 0" class="btn btn-xs blue">
                                        <input type="radio" name="hour" value="<?=$i?>" class="toggle"> <?=(($i<10)?'0'.$i:$i).'点'?> </label>
                                <?php }?>
                            </div>
                        </div>
                        <div  style="margin-left:10px;width: 50px">
                            <div class="btn-group" id="chose_min" data-toggle="buttons">
                                <?php for ($i=0; $i < 60; $i+=5) { ?>
                                    <label class="btn btn-xs blue" style="margin: 0;">
                                        <input type="radio" name="min" value="<?=$i?>" class="toggle"> <?=(($i<10)?'0'.$i:$i).'分'?> </label>
                                <?php }?>
                            </div>
                            <br>
                        </div>
                        <div style="margin-top:248px;margin-left:10px;width: 80px">
                            <a class="addAppoint btn green">添加<i class="fa fa-plus"></i></a>
                        </div>
                        <div style="width: 280px;">
                            <div id="app_res" style="border: solid;border-color: rgba(160, 160, 160, 0.68); overflow-y: scroll;height: 396px;border-width: 2px;">
                                <?php if($staff->nowAppoints) foreach ($staff->nowAppoints as $key => $v) { ?>
                                    <div class="appointed" style="display:none;margin-left: 20px;font-size:12px; height:20px;width:200px">预约刷新中：<?=date('Y-m-d H:i',$v->appoint_time)?><input type="hidden" class="appointedfid" value="<?=$v->fid?>"/></div>
                                <?php }?>
                            </div>
                            <div style="margin-top: 20px;margin-left: 60px" class="form-group">
                                选择预约天数：<select name="appday">
                                    <option value="1">今天</option>
                                    <?php for ($i=2; $i < 9; $i++) { ?>
                                        <option value="<?=$i?>"><?=$i.'天'?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="alert alert-danger"><p>套餐剩余预约数：<em id="appnum"><?=$staff->getCanAppointNum()?></em></p></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    <button class="btn green btn-primary" type="submit">保存</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/esf-add-images.js', CClientScript::POS_END);

Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js', CClientScript::POS_END, array('charset'=> 'utf-8'));

$js = "
            $(function(){
               $('.select2').select({
                  placeholder: '请选择',
                  allowClear: true
               });

                 $('.form_datetime').datetimepicker({
                     autoclose: true,
                     isRTL: Metronic.isRTL(),
                     format: 'yyyy-mm-dd',
                     minView: 'month',
                     language: 'zh-CN',
                     pickerPosition: (Metronic.isRTL() ? 'bottom-right' : 'bottom-left'),
                 });

            });


            ";

Yii::app()->clientScript->registerScript('add',$js,CClientScript::POS_END);
?>
