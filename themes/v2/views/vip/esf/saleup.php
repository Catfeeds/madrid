<?php
$this->pageTitle = '二手房上架列表';
$this->breadcrumbs = array($this->pageTitle);
//引入排序+筛选头部
include('filterbase/base.php');
?>

<table class="table table-bordered table-striped table-condensed flip-content table-hover">
    <thead class="flip-content">
    <tr>
        <th width="35px"><input type="checkbox"></th>
        <th class="text-center">ID</th>

        <th class="text-center">房源详情</th>
        <th class="text-center">发布时间</th>
        <th class="text-center">上架时间</th>
        <th class="text-center">刷新时间</th>
        <th class="text-center">刷新</th>
        <th class="text-center">预约</th>
        <th class="text-center">加急</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($list as $k=>$v): ?>
        <tr>
            <td style="text-align:center;vertical-align: middle"><input type="checkbox" name="item[]" value="<?php echo $v['id'] ?>" class="checkboxes"></td>
            <td class="id" style="text-align:center;vertical-align: middle"><?php echo $v->id; ?></td>
            <td class="">
                <span class="title" style="display: none"><?=$v->title?></span>
                <div style="height: 95px;display: inline-flex;">
                    <div style="height: 90px;float: left;">
                        <?php $image = $v->image?$v->image:SM::resoldImageConfig()->resoldNoPic();?>
                        <img src="<?=ImageTools::fixImage($image,120,90)?>">
                    </div>
                    <div style="height: 90px;margin-left: 5px;font-size: 14px">
                        <div style="height: 33%"><a target="_blank" href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$v->id])?>"><?=$v->title?></a></div>
                        <div style="height: 33%"><?=$v->plot_name?></div>
                        <div style="height: 33%"><?=$v->size.'m<sup>2</sup> | '.($v->bedroom?($v->bedroom.'室'.$v->livingroom.'厅'):Yii::app()->params['category'][$v->category]).' | '.$v->price.'万元'?></div>
                    </div>
                </div>
            </td>
            <td style="text-align:center;vertical-align: middle"><?=date('Y-m-d',$v->created)?></td>
            <td style="text-align:center;vertical-align: middle"><?=date('Y-m-d',$v->sale_time)?></td>
            <td style="text-align:center;vertical-align: middle"><?=date('Y-m-d H:i:s',$v->refresh_time).'<br>'.((time()-$v->expire_time)>SM::resoldConfig()->resoldExpireTime()*86400?'<span style="color:red">已到期</span>':'')?></td>
            <td style="text-align:center;vertical-align: middle"><?=($v->refresh_time&&(time()-$v->refresh_time) < SM::resoldConfig()->resoldRefreshInterval->value*60)?'<span style="color:grey">已刷新</span>':CHtml::ajaxLink('刷新',$this->createUrl('refresh'),array('type'=>'get','data'=>['fid'=>$v->id],'success'=>'function(){location.reload()}'),['class'=>'btn green btn-xs'])?>
            </td>
            <td style="text-align:center;vertical-align: middle"><?=ResoldAppointExt::model()->count(['condition'=>'fid=:fid and type=1 and status=0','params'=>[':fid'=>$v->id]])>0?'<a href="'.$this->createUrl('appointList',['fid'=>$v->id]).'">您已预约</a> '.CHtml::ajaxLink('取消预约',$this->createUrl('delAppoint'),array('type'=>'get','data'=>['fid'=>$v->id],'success'=>'function(){location.reload()}')):'<a class="btn btn-xs blue" href="'.$this->createUrl('setAppoint',['fid'=>$v->id]).'">点击预约</a>'?></td>
            <td style="text-align:center;vertical-align: middle"><?=$v->hurry>0 && (time()-$v->hurry<SM::resoldConfig()->resoldHurryTime->value*3600)?'<span style="color:grey">您已加急</span>':CHtml::ajaxLink('点击加急',$this->createUrl('hurry'),array('type'=>'get','data'=>['fid'=>$v->id],'success'=>'function(){location.reload()}'))?></td>

            <td style="text-align:center;vertical-align: middle">
                    <a href="<?php echo $this->createUrl('publish',array('id'=>$v->id)); ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 修改 </a>
                    <?php
                        echo CHtml::htmlButton('下架', array('data-toggle' => 'confirmation', 'class' => 'btn btn-xs yellow','style'=>'margin-right:0', 'data-title' => '确认下架？', 'data-btn-ok-label' => '确认', 'data-btn-cancel-label' => '取消', 'data-popout' => true, 'ajax' => array('url' => $this->createUrl('downSale'), 'type' => 'post', 'success' => 'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}', 'data' => array('fids' => $v->id))));
                ?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

<div class="form-group">
<form action="<?=$this->createUrl('setAppoint')?>" method="get" onsubmit=" return checkAppointIds();">
    <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
    <?php echo CHtml::ajaxButton('下架所选', $this->createAbsoluteUrl('downSale'), array('data'=>array('fids'=>'js:getChecked()'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm', 'data-toggle'=>'confirmation', 'data-title'=>'确认下架？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true)); ?>

    <?php echo CHtml::ajaxButton('刷新所选', $this->createUrl('refresh'), array('data'=>array('fid'=>'js:getChecked()'),'type'=>'get', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')); ?>
    
        <input type="submit" id="set-appoint" class="btn btn-success btn-sm" value="点击预约"></input>
    </form>
    
</div>

<?php $this->widget('VipLinkPager', array('pages'=>$pager));
Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js', CClientScript::POS_END, array('charset'=> 'utf-8'));
?>

<?php
    $this->widget('VipModalWidget',[
        'staff'=>$staff
    ]);
?>

<script>
<?php Tools::startJs(); ?>
    var getChecked  = function(){
        var ids = "";
        $(".checkboxes").each(function(){
            if($(this).parents('span').hasClass("checked")){
                if(ids == ''){
                    ids = $(this).val();
                } else {
                    ids = ids + ',' + $(this).val();
                }
            }
        });
       
        return ids;
    }

    $(".group-checkable").click(function () {
        var set = $(this).attr("data-set");
        $(set).each(function () {
            $(this).attr("checked", !$(this).attr("checked"));
        });
        $.uniform.update(set);
    });
    //清空选项
    function removeOptions()
    {
        // alert($('.chose_select').val());
        $('.chose_text').val('');
        $('.chose_select').val('');
    }
    function checkAppointIds() {
        var ids = getChecked();
        if(ids.length <= 0) {
            alert('请至少选择一项！');
            return false;
        }else {
             $('#set-appoint').after('<input type="hidden" name="fid" value="'+ids+'"></input>');
            return true;
        }
    }
<?php Tools::endJs('js') ?>
</script>
