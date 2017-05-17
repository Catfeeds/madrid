<?php
$this->pageTitle = '买房顾问列表';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            <div class="form-group">
                用户名<?php echo CHtml::textField('username', $username, array('class'=>'form-control')); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('status',$status,AdminExt::$status,array('class'=>'form-control','encode'=>false,'submit'=>'','empty'=>'--状态--')); ?>
            </div>
            <button type="submit" class="btn btn-warning">搜索 <i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="btn-group pull-right">
        <a href="<?php echo $this->createUrl('/admin/staff/edit'); ?>" class="btn blue">
            添加顾问<i class="fa fa-plus"></i>
        </a>
    </div>
</div>

<div class="portlet-body flip-scroll">
    <table class="table table-bordered table-striped table-condensed flip-content">
        <thead class="flip-content">
            <tr>
                <th width="5%" class="text-center">id</th>
                <th width="" class="text-center">登录帐号</th>
                <th width="" class="text-center">用户名</th>
                <th width="" class="text-center">QQ</th>
                <th width="" class="text-center">最后登录时间</th>
                <th width="" class="text-center">最后登陆ip</th>
                <th width="20%" class="text-center">状态</th>
                <th width="20%" class="text-center">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data as $v): ?>
                <tr>
                    <td class="text-center"><?php echo $v->id; ?></td>
                    <td class="text-center"><?php echo $v->username; ?></td>
                    <td class="text-center"><?php echo $v->name ? $v->name : '-'; ?></td>
                    <td class="text-center"><?php echo $v->qq ? $v->qq : '-'; ?></td>
                    <td class="text-center"><?php echo $v->login_time ? date('Y-m-d H:i:s', $v->login_time) : '-'; ?></td>
                    <td class="text-center"><?php echo $v->login_ip ? long2ip($v->login_ip) : '-'; ?></td>
                    <td class="text-center"><?php echo CHtml::ajaxLink(StaffExt::$status[$v->status], $this->createUrl('/admin/staff/ajaxStatus'), array('data'=>array('id'=>$v->id), 'type'=>'post', 'success'=>'function(d){if(d.code){location.reload();}else{toastr.error(d.msg)}}'),array('class'=>StaffExt::$statusStyle[$v->status])); ?></td>
                    <td class="text-center">
                        <?php echo CHtml::ajaxLink(StaffExt::$recommend[$v->recommend?1:0],$this->createUrl('ajaxRecommend'),array('type'=>'post','data'=>array('id'=>$v->id),'success'=>'function(d){if(d.code){location.reload();}else{toastr.error(d.msg)}}'), array('class'=>StaffExt::$statusStyle[$v->recommend?0:1]));?>
                        <a href="<?php echo $this->createUrl('/admin/staff/edit',array('id'=>$v->id)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>
