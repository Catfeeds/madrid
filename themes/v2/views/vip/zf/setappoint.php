<?php
$this->pageTitle = '房源预约';
$this->breadcrumbs = array($this->pageTitle);
Yii::app()->clientScript->registerCssFile('/static/vip/appoint/reset.css');
Yii::app()->clientScript->registerCssFile('/static/vip/appoint/appoint-base.css');
$timeInterval = SM::resoldConfig()->resoldRefreshInterval();
?>
<form onsubmit="return formData();" method="get" action="<?=$this->createUrl('appoint')?>">
<div class="col-md-8">
<h3>房源预约</h3>
	<div class="table-scrollable">
		<table class="table table-hover">
		<thead>
		<tr>
			<th>
				房源编号
			</th>
			<th style="width: 60%">
				 房源名称
			</th>
			<th>
				 操作
			</th>
		</tr>
		</thead>
		<tbody>
		<?php if($esf) foreach ($esf as $key => $value) {?>
		<?php foreach ($esf as $key => $value1) {
				$ids[] = $value1->id;
			}?>
			<tr>
			<td>
				 <?=$value->id?>
			</td>
			<td>
				 <?=$value->title?>
			</td>
			<td>
				<?php foreach ($ids as $key => $v) {
					if($v == $value->id)
					 	unset($ids[$key]);
					$ids && $transIds = implode(',', $ids);
				}?>
				<a href="<?=$ids?$this->createUrl('setAppoint',['fid'=>$transIds]):$this->createUrl('saleUp')?>" class="btn btn-xs yellow">取消</a>
			</td>
		</tr>
		<?php }?>
		
		</tbody>
		</table>
	</div>
</div>
<div class="col-md-12">
<h3>选择时间</h3>
	
  <div class="ui-yuyue ui-yuyue-container">
      <div class="ui-yuyue-timehour">
          <ul>
              <li class="time-hour" data-hour="8">8点</li>
              <li class="time-hour" data-hour="9">9点</li>
              <li class="time-hour" data-hour="10">10点</li>
              <li class="time-hour" data-hour="11">11点</li>
              <li class="time-hour" data-hour="12">12点</li>
              <li class="time-hour" data-hour="13">13点</li>
              <li class="time-hour" data-hour="14">14点</li>
              <li class="time-hour" data-hour="15">15点</li>
              <li class="time-hour" data-hour="16">16点</li>
              <li class="time-hour" data-hour="17">17点</li>
              <li class="time-hour" data-hour="18">18点</li>
              <li class="time-hour" data-hour="19">19点</li>
              <li class="time-hour" data-hour="20">20点</li>
              <li class="time-hour" data-hour="21">21点</li>
              <li class="time-hour" data-hour="22">22点</li>
              <li class="time-hour" data-hour="23">23点</li>
          </ul>
      </div>
      <div class="ui-yuyue-timehourminutes">
      </div>
  </div>
  <script type="text/template" id="timehourminutes-tpl">
      {{each hours as v k}}<ul>
            <li class="time-hour on" data-hour="{{k}}">{{k}}点</li>
            <li class="time-minutes" data-hour="{{k}}" data-minutes="5">05分</li>
            <li class="time-minutes" data-hour="{{k}}" data-minutes="10">10分</li>
            <li class="time-minutes" data-hour="{{k}}" data-minutes="15">15分</li>
            <li class="time-minutes" data-hour="{{k}}" data-minutes="20">20分</li>
            <li class="time-minutes" data-hour="{{k}}" data-minutes="25">25分</li>
            <li class="time-minutes" data-hour="{{k}}" data-minutes="30">30分</li>
            <li class="time-minutes" data-hour="{{k}}" data-minutes="35">35分</li>
            <li class="time-minutes" data-hour="{{k}}" data-minutes="40">40分</li>
            <li class="time-minutes" data-hour="{{k}}" data-minutes="45">45分</li>
            <li class="time-minutes" data-hour="{{k}}" data-minutes="50">50分</li>
            <li class="time-minutes" data-hour="{{k}}" data-minutes="55">55分</li>
            <li class="time-minutes" data-hour="{{k}}" data-minutes="60">60分</li>
          </ul>{{/each}}
  </script>
  <br>
  <div id="prefix_225494560051" class="Metronic-alerts alert alert-danger fade in col-md-8"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><i class="fa-lg fa fa-warning"></i> 友情提醒：相邻两次手动刷新或预约刷新请控制在<?=$timeInterval?>分钟以上，<?=$timeInterval?>分钟以内多次预约刷新无效，并正常扣去预约条数。</div>
<div class="col-md-12">
  <h3>选择天数</h3>
  <div class="btn-group" data-toggle="buttons">
	<label class="btn green" style="width: 69px;height: 38px" data-day='1' onclick="setDay(this)">
	<input type="radio" class="toggle"> 今天 </label>
	<label class="btn green" style="width: 69px;height: 38px" data-day='2' onclick="setDay(this)">
	<input type="radio" class="toggle"> 2天 </label>
	<label class="btn green" style="width: 69px;height: 38px" data-day='3' onclick="setDay(this)">
	<input type="radio" class="toggle"> 3天 </label>
	<label class="btn green" style="width: 69px;height: 38px" data-day='4' onclick="setDay(this)">
	<input type="radio" class="toggle"> 4天 </label>
	<label class="btn green" style="width: 69px;height: 38px" data-day='5' onclick="setDay(this)">
	<input type="radio" class="toggle"> 5天 </label>
	<label class="btn green" style="width: 69px;height: 38px" data-day='6' onclick="setDay(this)">
	<input type="radio" class="toggle"> 6天 </label>
	<label class="btn green" style="width: 69px;height: 38px" data-day='7' onclick="setDay(this)">
	<input type="radio" class="toggle"> 7天 </label>
	<label class="btn green" style="width: 69px;height: 38px" data-day='8' onclick="setDay(this)">
	<input type="radio" class="toggle"> 8天 </label>
	</div>
	<br><br>
	<div id="prefix_225494560051" class="Metronic-alerts alert alert-danger fade in col-md-8"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><i class="fa-lg fa fa-warning"></i> 您今天还可以预约<?=$this->staff->getCanAppointNum()?>条，共<?php if(isset($this->staff->staffPackage)&&isset($this->staff->staffPackage->package)) {$data_conf = json_decode($this->staff->staffPackage->package->content,true);echo $data_conf['appoint_num'];}else{echo 10;}?>条/天</div>
  
</div>
<div class="col-md-4">
	<input type="submit" value="保存更改" class="btn green"></input>
</div>
<?php if($esf) foreach ($esf as $key => $value) {?>
	<input type="hidden" value="<?=$value->id?>" name="fid[]" class="fid"></input>
<?php }?>
<input type="hidden" id="flag">
</form>
<?php
//时间脚本
Yii::app()->clientScript->registerScriptFile('/static/vip/appoint/appoint-base.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/vip/appoint/js/countdown.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/vip/appoint/js/jquery.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/vip/appoint/js/template.js', CClientScript::POS_END);
?>
<script type="text/javascript">
	var time_interval = '<?=$timeInterval?>';
	<?php Tools::startJs();?>
	function formData() {
		var times = api.get_data();
		if(!$.isEmptyObject(times))
		{
			for(var hour in times)
			{
				var minute = 0;
				if(times[hour].length != 0)
					for(minute in times[hour] )
					{
				    	$('#flag').after('<input type="hidden" value="' + hour + ':' + minute +'" name="time[]" ></input>');
					}
				// else
				// 	$('#flag').after('<input type="hidden" value="' + hour + ':' + minute +'" name="time[]" ></input>');
			}
		}
		return true;
	}
	function setDay(obj) {
		$('#flag').after('<input type="hidden" value="' + $(obj).data('day') + '" name="day" ></input>');
	}
	<?php Tools::endJs('js');?>
</script>