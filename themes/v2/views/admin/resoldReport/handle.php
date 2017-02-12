<?php
/**
 * User: fanqi
 * Date: 2016/8/29
 * Time: 15:30
 */
$this->pageTitle = "房源举报处理";
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="portlet box blue-hoki">
                <div class="portlet-title">
                    <div class="caption">
                        <?=$report->infoname;?>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn red btn-sm" id="sold_out"><i class="fa fa-arrow-down"></i> 房源下架</a>
                        <a href="javascript:;" class="btn red btn-sm" id="delete"><i class="fa fa-times"></i> 房源删除</a>
                        <a href="<?=$this->createUrl("list");?>" class="btn blue btn-sm" id="cancel"><i class="fa fa-mail-forward"></i> 返回</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="scroller" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
                        <p>房源类型：<?$report_type = Yii::app()->params['report_type'];echo $report_type[$report->type];?>&nbsp;&nbsp;ID：<?=$source['id'];?>&nbsp;&nbsp;房源标题：<?=$source['title'];?></p>
                        <p><?=$report->content;?></p>
                        <p><strong>原因：<?=$report->reason;?></strong></p>
                        <p>举报人：<?=$report->account;?>&nbsp;&nbsp;ID:<?=$report->uid;?>&nbsp;&nbsp;手机号：<?=$report->phone;?></p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    <?php Tools::startJs(); ?>
    $("#sold_out,#delete").on("click",function(){
        var _id = "<?=$report->id?>";
        var way = $(this).attr("id");
       if(_id&&_id!=""){
          $.post("<?=$this->createUrl("ajax");?>",{'id':_id,'way':way},function(data){
              location.href = "<?=$this->createUrl("list");?>";
          });
       }
    });
    <?php Tools::endJs('js') ?>
</script>


