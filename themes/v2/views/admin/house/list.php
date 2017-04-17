<?php
	$this->pageTitle='楼盘列表';
	?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            标题
            <div class="form-group">
                <?php echo CHtml::textField('title', empty($_GET['title']) ? '' : $_GET['title'], array('class' => 'form-control')) ?>
            </div>
            <button type="submit" class="btn btn-warning">搜索 <i class="fa fa-search"></i></button>
        </form>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
        <tr>
            <!-- <th width="35px"><input type="checkbox"></th> -->
            <th class="text-center">id</th>
            <th class="text-center">标题</th>
            <th class="text-center">区域</th>
            <th class="text-center">创建时间</th>
            <!-- <th class="text-center">状态</th> -->
            <th class="text-center">操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($infos as $v): ?>
        <tr>
            <td  class="text-center"><?php echo $v->id ?></td>
            <td  class="text-center"><?php echo $v->title ?></td>
            <td class="text-center"><?php echo $v->area.'-'.$v->street; ?></td>
            <td class="text-center"><?php echo date('Y-m-d',$v->created); ?></td>
            <td  class="text-center">
                <a href="<?=$this->createUrl('dealimage',['hid'=>$v->id])?>" class="btn btn-xs default">处理图片</a>
                <?php echo CHtml::ajaxLink('导入到新系统',$this->createUrl('tohj'), array('type'=>'get', 'data'=>array('hid'=>$v->id),'success'=>'function(data){location.reload()}'), array('class'=>'btn btn-xs default')); ?>
                <a href="<?=$this->createUrl('imagelist',['hid'=>$v->id])?>" class="btn btn-xs red">相册</a>
            	<a href="<?=$this->createUrl('hxlist',['hid'=>$v->id])?>" class="btn btn-xs yellow">户型</a>
                <a href="<?=$this->createUrl('newslist',['hid'=>$v->id])?>" class="btn btn-xs blue">动态</a>
                <a href="<?=$this->createUrl('pricelist',['hid'=>$v->id])?>" class="btn btn-xs blue">价格走势</a>
                <a href="<?=$this->createUrl('wdslist',['hid'=>$v->id])?>" class="btn btn-xs blue">问答</a>
                <a href="<?php echo $this->createUrl('edit',array('id'=>$v->id,'referrer'=>Yii::app()->request->url)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 编辑 </a>
                <?php echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('ajaxDel'),'type'=>'get','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>
