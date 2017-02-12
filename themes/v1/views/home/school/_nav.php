<div class="wapper">
    <div class="plot-nav">
        <ul>
            <li class="<?php echo Yii::app()->request->getQuery('id',0)==0 ? 'current' : '' ?>"><a href="<?php echo $this->createUrl('index')?>">全部</a></li>
            <?php foreach($this->area as $v): ?>
            <li class="<?php echo Yii::app()->request->getQuery('id',0)==$v->area ? 'current':''?>"><a href="<?php echo $this->createUrl('/home/school/area',array('id'=>$v->area))?>"><?php echo $v->areaInfo->name?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>