<?php
/**
 * User: fanqi
 * Date: 2016/8/26
 * Time: 10:42
 */
$this->pageTitle = "黑名单";
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
    <div class="pull-left">
        <form class="form-inline">
            <div class="form-group">
                <?= CHtml::textField('phone', $phone, array('class' => 'form-control','placeholder'=>'电话号码')) ?>
            </div>
            <button type="submit" class="btn blue"><i class="fa fa-search"></i> 搜索</button>
        </form>
    </div>
</div>
<div style="border-style: solid;
    border-width: 1px;
    border-color: rgba(128, 128, 128, 0.36);">
    <?php foreach ($models as $black) { ?>
    <div style="display: inline-table;height: 30px;margin-top: 10px;margin-right: 40px"><input type="checkbox" name="item[]" value="<?php echo $black['id'] ?>" class="checkboxes"><?= $black->phone; ?> <?= CHtml::htmlButton('删除 <i class="fa fa-trash"></i>', array('data-toggle' => 'confirmation', 'class' => 'btn green btn-xs ', 'data-title' => '确认删除？', 'data-btn-ok-label' => '确认', 'data-btn-cancel-label' => '取消', 'data-popout' => true, 'ajax' => array('url' => $this->createUrl('ajaxDel'), 'type' => 'post', 'success' => 'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}', 'data' => array('id' => $black->id)))); ?>
    </div>
    <?php } ?>
</div>
<!-- <table class="table table-bordered table-striped table-condensed flip-content">
    <tbody>
    <?php foreach ($models as $black) { ?>
        <tr>
            <td class="text-center"><input type="checkbox" name="item[]" value="<?php echo $black['id'] ?>"
                                           class="checkboxes"></td>
            <td class="text-center"><?= $black->id; ?></td>
            <td class="text-center"><?= $black->phone; ?></td>
            <td class="text-center"><?= date("Y-m-d", $black->created); ?></td>
            <td class="text-center">
                <?= CHtml::htmlButton('<i class="fa fa-trash"></i>', array('data-toggle' => 'confirmation', 'class' => 'btn btn-xs blue', 'data-title' => '确认删除？', 'data-btn-ok-label' => '确认', 'data-btn-cancel-label' => '取消', 'data-popout' => true, 'ajax' => array('url' => $this->createUrl('ajaxDel'), 'type' => 'post', 'success' => 'function(d){if(d.code){location.reload()}else{toastr.error(d.msg)}}', 'data' => array('id' => $black->id)))); ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table> -->
<div class="form-group" style="margin-top: 10px">
    <button type="button" class="btn btn-success btn-sm group-checkable" data-set=".checkboxes">全选/反选</button>
    <?php echo CHtml::ajaxButton('删除所选', $this->createUrl('black/ajaxDel'), array('data' => array('ids' => 'js:getChecked()', 'kw' => 'open'), 'type' => 'post', 'success' => 'function(data){location.reload()}', 'beforeSend' => 'function(){if(!getChecked()){toastr.error("请至少选择一项！");return false;}}'), array('class' => 'btn btn-success btn-sm')); ?>
</div>
<form method="post" action="<?=$this->createUrl('/admin/black/edit')?>">
<div class="form-group" style="margin-top: 10px">
    <label>添加号码：</label>
    <div class="input-icon input-icon-sm right">
        <input type="text" name="phones" class="form-control input" placeholder="多个用逗号隔开">
    </div>
</div>

<div class="form-group" style="margin-top: 10px">
    <button type="submit" class="btn btn-sm blue">新增</button>
</div>
</form>
<?php $this->widget('AdminLinkPager', array('pages' => $pager)); ?>

<script>
    <?php Tools::startJs(); ?>
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
    $(".group-checkable").click(function () {
        var set = $(this).attr("data-set");
        $(set).each(function () {
            $(this).attr("checked", !$(this).attr("checked"));
        });
        $.uniform.update(set);
    });

    <?php Tools::endJs('js') ?>
</script>
