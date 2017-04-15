<?php
	$this->pageTitle='视频列表';
	?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            标题
            <div class="form-group">
                <?php echo CHtml::textField('kw', empty($_GET['kw']) ? '' : $_GET['kw'], array('class' => 'form-control')) ?>
            </div>
            <button type="submit" class="btn btn-warning">搜索 <i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="btn-group pull-right">
        <a href="<?=$this->createUrl('index')?>" class="btn blue">抓取弹幕</a>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
        <tr>
            <!-- <th width="35px"><input type="checkbox"></th> -->
            <th class="text-center">id</th>
            <th class="text-center">电影标题</th>
            <th class="text-center">URL</th>
            <th class="text-center">弹幕数</th>
            <th class="text-center">创建时间</th>
            <!-- <th class="text-center">状态</th> -->
            <th class="text-center">操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($infos as $v): ?>
        <tr>
            <td  class="text-center"><?php echo $v->id ?></td>
            <td  class="text-center"><?php echo $v->name ?></td>
            <td class="text-center"><?php echo $v->url; ?></td>
            <td class="text-center"><?php echo Yii::app()->db->createCommand('select count(id) from danmu where mid='.$v->id)->queryScalar() ?></td>
            <td class="text-center"><?php echo date('Y-m-d',$v->created) ?></td>
            <td  class="text-center">
            <a href="<?=$this->createUrl('toExcel',['id'=>$v->id])?>" target="_blank" class="btn btn-xs default">导出弹幕</a>
                <?php echo CHtml::htmlButton('删除', array('data-toggle'=>'confirmation', 'class'=>'btn btn-xs red', 'data-title'=>'确认删除？', 'data-btn-ok-label'=>'确认', 'data-btn-cancel-label'=>'取消', 'data-popout'=>true,'ajax'=>array('url'=>$this->createUrl('del'),'type'=>'get','success'=>'function(data){location.reload()}','data'=>array('id'=>$v->id))));?>

            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $this->widget('AdminLinkPager', array('pages'=>$pager)) ?>
