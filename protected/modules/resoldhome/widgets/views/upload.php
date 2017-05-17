<?php
Yii::app()->clientScript->registerScriptFile($this->controller->staticPath."/js/jquery-1.10.2.min.js",CClientScript::POS_END);
//webuploader CSS
Yii::app()->clientScript->registerCssFile($this->controller->staticPath."/style/webuploader.css");
//webuploader JS
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/webuploader/webuploader.js',CClientScript::POS_END);
?>
<div class="select-img btns" id="uploader<?php echo $this->id; ?>">请选择图片上传</div>
<div class="select-btn" id="picker<?php echo $this->id; ?>">浏览文件</div>
<div class="upload-img-list" id="singlePic<?php echo $this->id; ?>">
    <ul>
        <?php if($this->value): ?>
            <?php if(is_array($this->value)): ?>
            <?php foreach ($this->value as $item): ?>
            <li>
                <img class="image" src="<?php echo ImageTools::fixImage($item,$this->width,$this->height,$this->mode); ?>" style="cursor: pointer">
                <span class="delete-btn"></span>
                <?php if($item == $this->cover): ?>
                     <span class="cover-btn"></span>
                <?php endif; ?>
                <input class="resold_file_image" type="hidden" value="<?php echo $item; ?>" name="images[]">
            </li>
            <?php endforeach; ?>
            <?php endif; ?>
        <?php endif ?>
    </ul>
    <input type="hidden" value="<?php echo $this->cover ?>" name="image" class="resold_file_cover">
</div>

<?php
$js = '
    if ( !WebUploader.Uploader.support() ) {
        alert( \'Web Uploader 不支持您的浏览器！如果你使用的是IE浏览器，请尝试升级 flash 播放器\');
        throw new Error( \'WebUploader does not support the browser you are using.\' );
    }
	// 初始化Web Uploader
	var uploader'.$this->id.' = WebUploader.create({

	    // 选完文件后，是否自动上传。
	    auto: true,
        //paste在实例多个按钮时只需要设置一次，否则DOM结构会出现错位
	    '.($this->id=='yw1'?'paste: document.body,':'').'
        compress : null,
	    // swf文件路径
	    swf: "/static/global/plugins/webuploader/Uploader.swf",

	    // 文件接收服务端。
	    server: "'.$this->url.'",
	    fileSingleSizeLimit: '.$this->fileSize.',
        fileNumLimit:"'.$this->fileNumberLimit.'",
	    // 选择文件的按钮。可选。
	    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
	    pick: {id:"#picker'.$this->id.'",multiple:'.($this->multi?'true':'false').'},
	    fileVal:"'.$this->inputName.'",
	    formData:'.CJSON::encode($this->param).',
	    // 只允许选择图片文件。
	    accept: {
	        title: "Images",
	        extensions: "gif,jpg,jpeg,bmp,png,swf",
	        mimeTypes: "image/jpg,image/jpeg,image/png,image/gif,image/bmp"
	    }
	});
';
if(!empty($this->callback))
    $js .= '
		//回调函数
		uploader'.$this->id.'.on( "uploadSuccess", function( file , data ) {
		    $("#uploader'.$this->id.'").text("上传成功!");
			callback'.$this->id.'(file , data);
		});
		uploader'.$this->id.'.on("uploadBeforeSend",function( object , data , headers ){
		    $("#uploader'.$this->id.'").text("正在上传中...");
		});
		var callback'.$this->id.' = '.$this->callback.';
		uploader'.$this->id.'.on("uploadError",function( file, reason ){
		    alert("上传失败");
		});
		//选择文件错误触发事件;
        uploader'.$this->id.'.on("error", function( code ) {
            var text = "";
            switch( code ) {
                case  "F_DUPLICATE" : text = "该文件已经被选择了!" ;
                break;
                case  "Q_EXCEED_NUM_LIMIT" : text = "最多上传9张图片!" ;
                break;
                case  "F_EXCEED_SIZE" : text = "文件大小超过限制!";
                break;
                case  "Q_EXCEED_SIZE_LIMIT" : text = "所有文件总大小超过限制!";
                break;
                case "Q_TYPE_DENIED" : text = "文件类型不正确或者是空文件!";
                break;
                default : text = "未知错误!";
                break;	
            }
            alert( text );
        });
        $(".upload-img-list").on("click",".delete-btn",function(){
              $(this).parent().remove();  
        });
        $(document).on("click","#singlePic'.$this->id.' ul li .image",function(){
             if($(this).siblings(".cover-btn").length == 0){
                $(this).after("<span class=\"cover-btn\"></span>");
             }
             $(this).parent("li").siblings("li").each(function(){
                $(this).find(".cover-btn").remove();
             })
             $("#singlePic'.$this->id.' .resold_file_cover").val($(this).siblings(".resold_file_image").val());
             return false;
	    })
	';
Yii::app()->clientScript->registerScript($this->id,$js,CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/scripts/qiniu.js',CClientScript::POS_END);//七牛js
?>

