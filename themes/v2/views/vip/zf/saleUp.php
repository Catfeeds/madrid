<?php
/**
 * User: fanqi
 * Date: 2016/8/30
 * Time: 14:26
 */
$this->pageTitle = '上架租房';
$this->breadcrumbs = array($this->pageTitle);
$this->widget('VipSearchWidget', [
    'type' => $type,
    'value' => $value,
    'time' => $time,
    'time_type' => $time_type,
    'hid' => $hid,
    'plots' => $plots,
    'sort' => $sort,
    'staff' => $this->staff,
    'category' => $category

]);
?>
<div class="portlet-body">
    <table class="table table-bordered table-striped table-condensed flip-content table-hover">
        <thead>
        <tr role="row">
            <th width="35px"><input type="checkbox"></th>
            <th class="text-center">ID</th>
            <th class="text-center">房源详情</th>
            <th class="text-center">发布时间</th>
            <th class="text-center">上架时间</th>
            <th class="text-center">刷新时间</th>
            <th class="text-center">刷新</th>
            <th class="text-center">预约刷新</th>
            <th class="text-center">加急</th>
            <th class="text-center">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($zfs as $zf): ?>
            <tr>
                <td style="text-align:center;vertical-align: middle"><input type="checkbox" name="item[]" value="<?php echo $zf['id'] ?>"
                                               class="checkboxes"></td>
                <td class="id" style="text-align:center;vertical-align: middle"><?= $zf->id; ?></td>
                <td class="">
                <span class="title" style="display: none"><?=$zf->title?></span>
                <div style="height: 95px;display: inline-flex;">
                    <div style="height: 90px;float: left;">
                        <?php $image = $zf->image?$zf->image:SM::globalConfig()->siteNoPic(); ?>
                        <img src="<?=ImageTools::fixImage($image,120,90)?>" onerror="javascript:this.src='<?=ImageTools::fixImage(SM::globalConfig()->siteNoPic(),120,90)?>'">
                    </div>  
                    <div style="height: 90px;margin-left: 5px;font-size: 14px">
                        <div style="height: 33%"><a target="_blank" href="<?=$this->createUrl('/resoldhome/zf/info',['id'=>$zf->id])?>"><?=$zf->title?></a></div>
                        <div style="height: 33%"><?=$zf->plot_name?></div>
                        <div style="height: 33%"><?=$zf->size.'m<sup>2</sup> | '.($zf->bedroom?($zf->bedroom.'室'.$zf->livingroom.'厅'):Yii::app()->params['category'][$zf->category]).' | '.$zf->price.'元/月'?></div>
                    </div>
                </div>
                </td>
                
                <td style="text-align:center;vertical-align: middle"><?= date("Y-m-d", $zf->created); ?></td>
                <td style="text-align:center;vertical-align: middle"><?= date('Y-m-d', $zf->sale_time) ?></td>
                <td style="text-align:center;vertical-align: middle"><?=date('Y-m-d H:i:s',$zf->refresh_time).'<br>'.((time()-$zf->expire_time)>SM::resoldConfig()->resoldExpireTime()*86400?'<span style="color:red">已到期</span>':'')?></td>    
                <td style="text-align:center;vertical-align: middle">
                    <?= ($zf->refresh_time && (time() - $zf->refresh_time) < SM::resoldConfig()->resoldRefreshInterval->value*60) ? '<span style="color:grey">已刷新</span>' : CHtml::ajaxLink('刷新',$this->createUrl('refresh'),array('type'=>'post','data'=>['fid'=>$zf->id],'success'=>'function(){location.reload()}'),['class'=>'btn green btn-xs']) ?>
                </td>
                <td style="text-align:center;vertical-align: middle"><?=ResoldAppointExt::model()->count(['condition'=>'fid=:fid and type=2 and status=0','params'=>[':fid'=>$zf->id]])>0?'<a href="'.$this->createUrl('appointList',['fid'=>$zf->id]).'">您已预约</a> '.CHtml::ajaxLink('取消预约',$this->createUrl('delAppoint'),array('type'=>'get','data'=>['fid'=>$zf->id],'success'=>'function(){location.reload()}')):'<a class="btn btn-xs blue" href="'.$this->createUrl('setAppoint',['fid'=>$zf->id]).'">点击预约</a>'?></td>
                </td>
                <td style="text-align:center;vertical-align: middle"><?= $zf->hurry > 0 && (time() - $zf->hurry < SM::resoldConfig()->resoldHurryTime->value * 3600) ? '<span style="color:grey">您已加急</span>' : CHtml::ajaxLink('点击加急', $this->createUrl('hurry'), array('type' => 'get', 'data' => ['fid' => $zf->id], 'success' => 'function(){location.reload()}')) ?></td>
                <td style="text-align:center;vertical-align: middle">
                    <a href="<?= $this->createUrl("zfEdit", ['id' => $zf->id]); ?>" type="button"
                       class="btn default btn-xs green"><i class="fa fa-edit"></i>修改</a>
                       <?php
                        echo CHtml::htmlButton('下架', array('data-toggle' => 'confirmation', 'class' => 'btn btn-xs yellow','style'=>'margin-right:0', 'data-title' => '确认下架？', 'data-btn-ok-label' => '确认', 'data-btn-cancel-label' => '取消', 'data-popout' => true, 'ajax' => array('url' => $this->createUrl('downSale'), 'type' => 'post', 'success' => 'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}', 'data' => array('fids' => $zf->id))));
                        ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="form-group">
<form action="<?=$this->createUrl('setAppoint')?>" method="get" onsubmit="return checkAppointIds();">
    <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
    <?php echo CHtml::ajaxButton('下架所选', $this->createAbsoluteUrl('downSale'), array('data'=>array('fids'=>'js:getChecked()'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm', 'data-toggle'=>'confirmation', 'data-title'=>'确认下架？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true)); ?>
    <?php echo CHtml::ajaxButton('刷新所选', $this->createUrl('refresh'), array('data'=>array('fid'=>'js:getChecked()'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')); ?>
    <input type="submit" id="set-appoint" class="btn btn-success btn-sm" value="点击预约"></input>
    </form>
</div>
<?php $this->widget('VipLinkPager', array('pages' => $pager)); ?>
<!-- 弹窗 begin-->
<?php
    $this->widget('VipModalWidget',[
        'staff'=>$staff,
    ]);
?>
<!--弹窗 end-->
<script type="text/javascript">
    <?php Tools::startJs();?>
    $(".group-checkable").click(function () {
        var set = $(this).attr("data-set");
        $(set).each(function () {
            $(this).attr("checked", !$(this).attr("checked"));
        });
        $.uniform.update(set);
    });
    var getChecked = function () {
        var ids = "";
        $(".checkboxes").each(function () {
            if ($(this).parents('span').hasClass("checked")) {
                if (ids == '') {
                    ids = $(this).val();
                } else {
                    ids = ids + ',' + $(this).val();
                }
            }
        });
        return ids;
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
    //清空选项
    function removeOptions()
    {
        // alert($('.chose_select').val());
        $('.chose_text').val('');
        $('.chose_select').val('');
    }
    
    <?php
    Tools::endJs('js');
    ?>
</script>