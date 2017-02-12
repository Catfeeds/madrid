<?php
/**
 * 问答添加编辑
 * @author 19gris
 * @date 2015-09-23
 */
$this->pageTitle = '编辑/新建问答';
$this->breadcrumbs = array($this->pageTitle);
?>

<?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>

    <div class="form-group">
        <label class="col-md-2 control-label">手机</label>
        <div class="col-md-6">
            <?php echo $form->textField($ask, 'phone', array('class'=>'form-control')); ?>
        </div>
        <div class="col-md-2"><?php echo $form->error($ask, 'phone') ?></div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">称呼</label>
        <div class="col-md-6">
            <?php echo $form->textField($ask, 'name', array('class'=>'form-control')); ?>
        </div>
        <div class="col-md-2"><?php echo $form->error($ask, 'name') ?></div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">分类</label>
        <div class="col-md-6">
            <?php
                echo CHtml::dropDownList('parentCate',$ask->cate&&$ask->cate->parentCate?$ask->cate->parentCate->id:0 ,$parentCate?CHtml::listData($parentCate,'id','name'):array('--请添加分类--') , array(
                        'class'=>'form-control input-inline',
                        'ajax' =>array(
                            'url' => $this->createUrl('ask/ajaxGetCate'),
                            'update' => '#AskExt_cid',
                            'data'=>array('pid'=>'js:this.value'),
                        )
                    )
                );
            ?>
            <?php
            echo $form->dropDownList($ask , 'cid' ,$childCate ? CHtml::listData($childCate,'id','name') : array('--请添加子分类--'), array('class'=>'form-control input-inline'));
            ?>
        </div>
        <div class="col-md-2"><?php echo $form->error($ask, 'cid') ?></div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">问题</label>
        <div class="col-md-6">
            <?php echo $form->TextArea($ask, 'question', array('class'=>'form-control','rows'=>5)); ?>
        </div>
        <div class="col-md-2"><?php echo $form->error($ask, 'question') ?></div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">楼盘</label>
        <div class="col-md-6">
            <?php echo CHtml::textField('hoses_name',$ask->hid,array('class'=>'form-control','style'=>'width:250px;','data-houses'=>$ask->plot ? CJSON::encode(array(array('id'=>$ask->plot->id, 'text'=>$ask->plot->title))):''))?>
            <?php echo $form->hiddenField($ask, 'hid', array('class'=>'form-control')); ?>
        </div>
        <div class="col-md-2"><?php echo $form->error($ask, 'hid') ?></div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">回答</label>
        <div class="col-md-6">
            <?php echo $form->TextArea($ask, 'answer', array('class'=>'form-control','rows'=>5)); ?>
        </div>
        <div class="col-md-2"><?php echo $form->error($ask, 'answer') ?></div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">状态</label>
        <div class="col-md-6">
            <div class="radio-list">
                <?php echo $form->radioButtonList($ask,'status', AskExt::$status,array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;')) ?>
            </div>
        </div>
        <div class="col-md-2"><?php echo $form->error($ask, 'status') ?></div>
    </div>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn green">保存</button>
                <?php echo CHtml::link('返回',$this->createUrl('list'),array('class'=>'btn default')) ?>
            </div>
        </div>
    </div>
<?php $this->endWidget() ?>
<?php

//Select2
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/select2/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile('/static/global/plugins/select2/select2.css');
// Yii::app()->clientScript->registerCssFile('/static/global/plugins/select2/select2-bootstrap.css');

//boostrap datetimepicker
Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
// Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js', CClientScript::POS_END, array('charset'=> 'utf-8'));

Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootbox/bootbox.min.js', CClientScript::POS_END);


?>


<?php

$js = "
      var get_houses_by_string = '".$this->createUrl('/admin/plot/AjaxGetHouse')."';

		var getHousesAjax =
		{
			url: get_houses_by_string,
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					kw:params
				};
			},
			results:function(data){
				var items = [];

				$.each(data.results,function(){
					var tmp = {
						id : this.id,
						text : this.name
					}
					items.push(tmp);
				});

				return {
					results: items
				};
			},
			processResults: function (data, page) {
				var items = [];

				$.each(data.msg,function(){
					var tmp = {
						id : this.id,
						text : this.title
					}
					items.push(tmp);
				});

				return {
					results: items
				};
			}
		}


	  var houses_edit = $('#hoses_name');
      var defaultData = eval(houses_edit.data('houses'));
      var house_done_init_data = {id:'', text:'请选择'};

      if(defaultData){
         house_done_init_data = eval(defaultData[0]);
      }

      var houses_select = $('#hoses_name');
      houses_select.select2({
         ajax: getHousesAjax,
         language: 'zh-CN',
         initSelection: function(element, callback){
            callback(house_done_init_data);
         }
      });


		houses_select.on('change',function(target){
			$('#AskExt_hid').val(target.added.id);
		});

      ";

Yii::app()->clientScript->registerScript('add',$js,CClientScript::POS_END);

?>
