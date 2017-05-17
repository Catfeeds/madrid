<?php
$this->pageTitle = '楼盘视频编辑';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="portlet-body">
    <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
    <div class="form-body">
        <div class="form-group">
            <label class="col-xs-3 control-label">标题<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-5">
                <?php echo $form->textField($model,'title',array('class'=>'form-control')) ?>
            </div>
            <div class="col-xs-3"><?php echo $form->error($model, 'title') ?></div>
        </div>
<!--        <div class="form-group">-->
<!--            <label class="col-xs-3 control-label">浏览次数<span class="required" aria-required="true">*</span></label>-->
<!--            <div class="col-xs-5">-->
<!--                --><?php //echo $form->textField($model,'views',array('class'=>'form-control')) ?>
<!--            </div>-->
<!--            <div class="col-xs-3">--><?php //echo $form->error($model, 'views') ?><!--</div>-->
<!--        </div>-->

        <?php if($model->id===null):?>
        <div class="form-group" id="container">
            <label class="col-xs-3 control-label">上传视频</label>
            <div class="col-xs-5">
                <button type="button" class="btn blue col-xs-12" id="pickfiles" style="height: 38px;background-color: #00b7ee">选择视频</button>
            </div>
            <div class="col-xs-3"><?php echo $form->error($model, 'url') ?></div>
        </div>
        <div class="form-group">
            <label class="col-xs-1 control-label"></label>
                <table class="table table-striped table-hover text-left"   style="margin-top:20px;width: 850px;display: none;margin-left: 65px;">
                    <thead>
                    <tr>
                        <th class="col-md-4">文件名</th>
                        <th class="col-md-2">文件大小</th>
                        <th class="col-md-6">详情</th>
                    </tr>
                    </thead>
                    <tbody id="fsUploadProgress">
                    </tbody>
                </table>
            <div class="col-xs-3"><?php echo $form->error($model, 'views') ?></div>
        </div>
        <?php endif;?>
        <div class="form-group">
            <label class="col-xs-3 control-label text-nowrap">视频封面</label>
            <div class="col-xs-5">
                <?php $this->widget('FileUpload',array('model'=>$model,'attribute'=>'img','width'=>'300','height'=>'360','inputName'=>'image','preview'=>false,'removeCallback'=>"$('#image').html('')")); ?>
                <div id="singlePicyw1"></div>
            </div>
            <div class="help-inline">默认截取视频中一帧作为视频封面，也可以自己上传封面图</div>
            <div class="col-xs-3"><?php echo $form->error($model, 'img'); ?></div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label"></label>
            <div class="col-xs-5">
                <button type="submit" class="btn green">保存</button>
                <?php echo CHtml::link('返回', $this->createUrl('videoList',array('hid'=>$hid)),array('class'=>'btn green')); ?>
            </div>
            <input type="hidden" name="PlotVideoExt[url]" id="PlotVideoExt_url" value="<?php echo $model->url;?>" required>
            <input type="hidden" name="PlotVideoExt[persistent_id]" id="PlotVideoExt_persistent_id" value="<?php echo $model->persistent_id;?>">
            <input type="hidden" id="PlotVideo_img" name="PlotVideo_img">
        </div>
        <div style="height: 20px"></div>
    </div>
    <?php $this->endWidget(); ?>
    <?php
    Yii::app()->clientScript->registerScriptFile('/static/global/scripts/plupload/moxie.js',CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile('/static/global/scripts/plupload/plupload.dev.js',CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile('/static/global/scripts/qiniu/qiniu.js',CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile('/static/global/scripts/qiniu/ui.js',CClientScript::POS_END);
    ?>
</div>
<script type="text/javascript">
    <?php Tools::startJs(); ?>
//    $('#singlePicyw1').find('img').css('width',300);
    var uploader = Qiniu.uploader({
        runtimes: 'html5,flash,html4',      // 上传模式，依次退化
        browse_button: 'pickfiles',         // 上传选择的点选按钮，必需
        uptoken:'<?php echo $uptoken?>',    // 上传策略
        get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的uptoken
        domain: '<?php echo Yii::app()->file->host?>',     // bucket域名，下载资源时用到，必需
        container: 'container',             // 上传区域DOM ID，默认是browser_button的父元素
        max_file_size: '1000mb',             // 最大文件体积限制
        flash_swf_url: '/static/global/scripts/plupload/Moxie.swf',  //引入flash，相对路径
        max_retries: 3,                     // 上传失败最大重试次数
        dragdrop: true,                     // 开启可拖曳上传
        drop_element: 'container',          // 拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
        chunk_size: '4mb',                  // 分块上传时，每块的体积
        auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传
        multi_selection:false,              // 是否多选
        unique_names:true,                  // 为每个文件生成唯一的名字key，避免七牛的同名文件不处理
        filters: {
            mime_types: [
                {title: "files", extensions: "mpg,m4v,mp4,flv,3gp,mov,avi,rmvb,mkv,wmv"},
            ],
            prevent_duplicates: true //不允许选取重复文件
        },
        init: {
            /**
             * 文件加入到队列，处理相关的事情
             */
            'FilesAdded': function(up, files) {
                $('table').show();
                plupload.each(files, function(file) {
                    var progress = new FileProgress(file, 'fsUploadProgress');
                    progress.setStatus("等待...");
                    progress.bindUploadCancel(up);
                });
            },
            /**
             * 每个文件上传前，处理相关的事情
             */
            'BeforeUpload': function(up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                if (up.runtime === 'html5' && chunk_size) {
                    progress.setChunkProgess(chunk_size);
                }
            },
            /**
             * 每个文件上传时，处理相关的事情
             */
            'UploadProgress': function(up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                progress.setProgress(file.percent + "%", file.speed, chunk_size);
            },
            /**
             * 每个文件上传成功后，处理相关的事情,其中info是文件上传成功后，服务端返回的json，形式如：
             * {
             *     "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
             *     "key": "gogopher.jpg"
             * }
             */
            'FileUploaded': function(up, file, info) {
                console.log(info);
                var domain = up.getOption('domain');
                var res = $.parseJSON(info);
                $('#PlotVideoExt_url').val(res.key);
                $('#PlotVideoExt_persistent_id').val(res.persistentId);
                $('#PlotVideo_img').val(res.key+'?vframe/jpg/offset/10');
                var progress = new FileProgress(file, 'fsUploadProgress');
                progress.setComplete(up, info);
            },
            /**
             * 上传出错时，处理相关的事情
             */
            'Error': function(up, err, errTip) {
                $('table').show();
                var progress = new FileProgress(err.file, 'fsUploadProgress');
                progress.setError();
                progress.setStatus(errTip);
            },
            /**
             * 队列文件处理完毕后，处理相关的事情
             */
            'UploadComplete': function() {},
        }
    });
    <?php Tools::endJs('js'); ?>
</script>
