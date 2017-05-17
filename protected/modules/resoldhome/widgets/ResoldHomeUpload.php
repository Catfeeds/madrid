<?php
/**
 *
 * User: jt
 * Date: 2016/11/6 12:38
 */
class ResoldHomeUpload extends FileUpload{

    public $multi = true;
    public $file_name;
    public $value;
    //封面
    public $cover;
    public $fileSize = 10000000;
    public $fileNumberLimit = 9;

    public function init()
    {
        if($this->url === null)
            $this->url = $this->controller->createUrl('/api/file/upload');
        if($this->file_name === null)
            $this->file_name = 'image';
        if(is_array($this->value)  && $hasNum = count($this->value)){
            $this->fileNumberLimit = ($this->fileNumberLimit - $hasNum <= 0)  ? 0 : ($this->fileNumberLimit - $hasNum);
         }
        $this->param = array_merge( array(
            'filename' => $this->inputName,
            'width' => $this->width,
            'height' => $this->height,
            'mode' => $this->mode,
            'wm' => $this->waterMark?1:0,
        ),$this->param);
        if($this->callback=='' && $this->file_name)
        {
            $this->callback = "function(file , data){
                var file_id = file.id;
				if(data.code!=1){
					alert('上传失败，请重新尝试');
					uploader".$this->id.".removeFile( file.id ); // 删除上传失败的文件
					return;
				}
				$('#singlePic".$this->id." ul').append('<li id=\"fileBox_'+file_id+'\"><img class=\"image\" src=\'\' style=\'cursor: pointer\'/><span class=\'delete-btn\'></span></li>');
                $('#fileBox_'+file_id).find('img').attr('src',data.msg.url);
                $('.upload-img-list .delete-btn').on('click',function(){
                    $(this).parent().remove();  
                    uploader".$this->id.".removeFile( file.id );
                });
			";
            $inputClass = 'resold_file_image';
            $this->callback .= "
                $('#singlePic".$this->id." ul').find('#fileBox_'+file_id).append('".CHtml::hiddenField($this->file_name,'',array('id'=>false,'class'=>$inputClass))."');
			        $('#fileBox_'+file_id).find('.".$inputClass."').val(data.msg.pic);
			    }";
        }

        if($this->multi==false&&$this->removeCallback=='')
            $this->removeCallback = "$('#singlePic ul').html('')";
    }

    public function run(){
        $this->render('upload');
    }
}