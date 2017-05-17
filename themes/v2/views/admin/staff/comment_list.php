<?php
$this->pageTitle = '买房顾问点评列表';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            <div class="form-group">查看
                <?php echo CHtml::dropDownList('sid',$sid,$staffs,array('class'=>'form-control','encode'=>false,'submit'=>'','empty'=>'--被点评对象--')); ?>
            </div>
            <!-- <button type="submit" class="btn btn-warning">搜索 <i class="fa fa-search"></i></button> -->
        </form>
    </div>
    <div class="btn-group pull-right">
        <a href="<?php echo $this->createUrl('/admin/staff/commentEdit'); ?>" class="btn blue">
            添加点评<i class="fa fa-plus"></i>
        </a>
    </div>
</div>

<div class="portlet-body flip-scroll">
    <table class="table table-bordered table-striped table-condensed flip-content">
        <thead class="flip-content">
            <tr>
                <th width="5%" class="text-center">id</th>
                <th width="20%" class="text-center">点评对象</th>
                <th width="" class="text-center">点评内容</th>
                <th width="20%" class="text-center">状态</th>
                <th width="20%" class="text-center">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list as $v): ?>
                <tr>
                    <td class="text-center"><?php echo $v->id; ?></td>
                    <td class="text-center"><?php echo $v->staff->username,$v->staff->name?'('.$v->staff->name.')':''; ?></td>
                    <td class="text-center"><?php echo $v->content; ?></td>
                    <td class="text-center"><?php echo CHtml::ajaxLink(StaffCommentExt::getStatus($v->status), $this->createUrl('/admin/staff/commentAjax'), array('data'=>array('id'=>$v->id), 'type'=>'post', 'success'=>'function(d){if(d.code){location.reload();}else{toastr.error(d.msg)}}'),array('class'=>StaffCommentExt::$statusStyle[$v->status])); ?></td>
                    <td class="text-center">
                        <a href="<?php echo $this->createUrl('/admin/staff/commentEdit',array('id'=>$v->id)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>
