<?php
/**
 * User: fanqi
 * Date: 2016/8/29
 * Time: 10:17
 */
$this->pageTitle = "房源举报信息列表";
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
    <div class="pull-left">
        <form class="form-inline">
            <?php Yii::app()->controller->widget("DaterangepickerWidget",['time'=>$time,'params'=>['class'=>'form-control chose_text']]);?>
            <div class="form-group">
                <?= CHtml::dropDownList('deal', $deal, Yii::app()->params['deal'], ['class' => 'form-control chose_select', 'encode' => false, 'prompt' => '--处理状态--']) ?>
            </div>
            <div class="form-group">
                <?= CHtml::dropDownList('type', $type, Yii::app()->params['report_type'], ['class' => 'form-control chose_select', 'encode' => false, 'prompt' => '--房源类型--']) ?>
            </div>
            <button type="submit" class="btn blue">搜索</button>
            <a class="btn yellow" onclick="removeOptions()"><i class="fa fa-trash"></i>&nbsp;清空</a>

        </form>
    </div>
</div>
<div class="protlet-body">
    <table class="table table-bordered table-striped table-condensed flip-content table-hover">
        <thead>
        <tr role="row">
            <th width="35px"><input type="checkbox"></th>
            <th class="text-center">ID</th>
            <th class="text-center">信息标题</th>
            <th class="text-center">举报人账号</th>
            <th class="text-center">电话</th>
            <th class="text-center">原因</th>
            <th class="text-center">举报内容</th>
            <th class="text-center">举报时间</th>
            <th class="text-center">处理状态</th>
            <th class="text-center">房源类型</th>
            <th class="text-center">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($models as $report) { ?>
            <tr>
                <td class="text-center"><input type="checkbox" class="checkboxes" name="item[]"
                                               value="<?= $report['id'] ?>"></td>
                <td style="text-align:center;vertical-align: middle"><?= $report->id; ?></td>
                <td style="text-align:center;vertical-align: middle"><a target="_blank" href="<?=$this->createUrl(Yii::app()->params['report_url'][$report->type],['id'=>$report['infoid']])?>"><acronym title="<?=$report->infoname?>"><?= Tools::u8_title_substr($report->infoname,20).'</acronym></a>'?></td>
                <td style="text-align:center;vertical-align: middle"><?= $report->account; ?></td>
                <td style="text-align:center;vertical-align: middle"><?= $report->phone; ?></td>
                <td style="text-align:center;vertical-align: middle"><?= $report->reason; ?></td>
                <td style="text-align:center;vertical-align: middle"><?= Tools::u8_title_substr($report->content)?></td>
                <td style="text-align:center;vertical-align: middle"><?= date("Y-m-d", $report->created); ?></td>
                <td style="text-align:center;vertical-align: middle"><?php $deal = Yii::app()->params['deal'];
                    echo $deal[$report->deal]; ?></td>
                <td style="text-align:center;vertical-align: middle"><?php $report_type = Yii::app()->params['report_type'];
                    echo $report_type[$report->type]; ?></td>
                <td style="text-align:center;vertical-align: middle">
                    <!-- <?= CHtml::htmlButton('处理', [
                        'class' => 'btn btn-xs blue report_handle',
                        'data_id' => $report->id,
                    ]) ?> -->
                        <?php //if($report->type==1 || $report->type==3):?>
                            <?php $model = $report->getSource();
                            if($model && $model->saling()->count(['condition'=>'id=:id','params'=>[':id'=>$report->infoid]])):?>
                            <a href="javascript:;" class="btn red btn-xs" id="sold_out" data-id="<?=$report->id?>"><i class="fa fa-arrow-down"></i> 房源下架</a>
                            <?php else:?>
                                已下架
                            <?php endif;?>
                        <?php //endif;?>
                        <a href="javascript:;" class="btn red btn-xs" id="delete" data-id="<?=$report->id?>"><i class="fa fa-times"></i> 房源删除</a>
                    <?= CHtml::htmlButton('删除', [
                        'data-toggle' => 'confirmation',
                        'class' => 'btn btn-xs yellow',
                        'data-title' => '确认删除？',
                        'data-btn-ok-label' => '确认',
                        'data-btn-cancel-label' => '取消',
                        'data-popout' => true,
                        'ajax' => [
                            'url' => $this->createUrl('ajaxDel'),
                            'type' => 'post',
                            'success' => 'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}',
                            'data' => array('id' => $report->id),
                        ]
                    ]) ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php $this->widget('AdminLinkPager', array('pages' => $pager)); ?>
<script>
    <?php Tools::startJs(); ?>
    function removeOptions() {
        $('.chose_text').val('');
        $('.chose_select').val('');
    }
    $(function () {
        $('.report_handle').on('click', function () {
            var $_this = $(this);
            // location.href = "<?=$this->createUrl("handle")?>?id="+$_this.attr("data_id");
        });
    });

    $("#sold_out,#delete").on("click",function(){
        var _id = $(this).data("id");
        var way = $(this).attr("id");
       if(_id&&_id!=""){
          $.post("<?=$this->createUrl("ajax");?>",{'id':_id,'way':way},function(data){
            location.reload();
          });
       }
    });
    <?php Tools::endJs('js') ?>
</script>

