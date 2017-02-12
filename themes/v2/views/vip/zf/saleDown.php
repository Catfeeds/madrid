<?php
/**
 * User: fanqi
 * Date: 2016/8/30
 * Time: 14:27
 */
$this->pageTitle = '下架租房';
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
<table class="table table-bordered table-striped table-condensed flip-content table-hover">
    <thead class="flip-content">
    <tr>
        <th width="35px"><input type="checkbox"></th>
        <th class="text-center">ID</th>

        <th class="text-center">房源详情</th>
        <th class="text-center">发布时间</th>
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
                        <?php $image = $v->image?$v->image:SM::globalConfig()->siteNoPic();?>
                        <img src="<?=ImageTools::fixImage($image,120,90)?>" onerror="javascript:this.src='<?=ImageTools::fixImage(SM::globalConfig()->siteNoPic(),120,90)?>'">
                    </div>
                    <div style="height: 90px;margin-left: 5px;font-size: 14px">
                        <div style="height: 33%"><?=$v->title?></div>
                        <div style="height: 33%"><?=$v->plot_name?></div>
                        <div style="height: 33%"><?=$v->size.'m<sup>2</sup> | '.($v->bedroom?($v->bedroom.'室'.$v->livingroom.'厅'):Yii::app()->params['category'][$v->category]).' | '.$v->price.'元/月'?></div>
                    </div>
                </div>
                </td>
            
            <td style="text-align:center;vertical-align: middle"><?=date('Y-m-d',$v->created)?></td>
            <td style="text-align:center;vertical-align: middle">
                <a href="<?php echo $this->createUrl('zfEdit',array('id'=>$v->id)); ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 修改 </a>
                <?php
                echo CHtml::ajaxLink('上架',$this->createUrl('upSale'),array('type'=>'get','data'=>['fids'=>$v->id],'success'=>'function(){location.reload()}'),['class'=>"btn btn-xs blue"])
                ?>
                <?php
                    echo CHtml::htmlButton('删除', array('data-toggle' => 'confirmation', 'class' => 'btn btn-xs yellow','style'=>'margin-right:0', 'data-title' => '确认删除？', 'data-btn-ok-label' => '确认', 'data-btn-cancel-label' => '取消', 'data-popout' => true, 'ajax' => array('url' => $this->createUrl('delete'), 'type' => 'post', 'success' => 'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}', 'data' => array('fids' => $v->id))));
                    ?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

<div class="form-group">
    <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
    <?php echo CHtml::ajaxButton('上架所选', $this->createUrl('upSale'), array('data'=>array('fids'=>'js:getChecked()'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm')); ?>
    <?php echo CHtml::ajaxButton('删除所选', $this->createAbsoluteUrl('delete'), array('data'=>array('fids'=>'js:getChecked()'),'type'=>'post', 'success'=>'function(data){location.reload()}', 'beforeSend'=>'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class'=>'btn btn-success btn-sm', 'data-toggle'=>'confirmation', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true)); ?>
</div>

<?php $this->widget('VipLinkPager', array('pages'=>$pager)); ?>


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
    $(document).ready(function(){
        $('.sort-arr').css('display','none');
    });
    <?php Tools::endJs('js') ?>
</script>

