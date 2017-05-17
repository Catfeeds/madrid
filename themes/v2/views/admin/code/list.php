<?php
/**
 * User: fanqi
 * Date: 2016/8/29
 * Time: 8:40
 */
$this->pageTitle = "短信验证码列表";
?>
<div class="table-toolbar">
    <div class="pull-left">
        <form class="form-inline">
            <div class="form-group">
                <?=CHtml::textField('phone',$phone,array('class'=>'form-control','placeholder'=>'电话号码'))?>
            </div>
            <button type="submit" class="btn blue"><i class="fa fa-search"></i> 搜索</button>
        </form>
    </div>
</div>
    <table class="table table-bordered table-striped table-condensed flip-content table-hover">
        <thead class="flip-content">
        <tr>
            <th class="text-center">电话</th>
            <th class="text-center">发送时间</th>
            <th class="text-center">验证码</th>
            <th class="text-center">状态</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($models as $code) { ?>
            <tr>
                <td class="text-center"><?= $code->phone; ?></td>
                <td class="text-center"><?= date("Y年m月d日 H:i:s", $code->created); ?></td>
                <td class="text-center"><?= $code->code; ?></td>
                <td class="text-center"><?php echo ResoldSmsExt::$status_array[$code->status];?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php $this->widget('AdminLinkPager', array('pages' => $pager)); ?>
<script>
    <?php Tools::startJs(); ?>


    <?php Tools::endJs('js') ?>
</script>
