<?php
$this->pageTitle = $help->title ;
Yii::app()->clientScript->registerCssFile($this->staticPath.'/style/my.css');
?>
<?php $this->widget('HomeBreadcrumbs',array('links'=>array($this->pageTitle)));?>
<div class="my">
    <div class="my-nav">
        <div class="m-title">帮助中心导航</div>
        <div class="my-sub-nav">

            <ul class="sub-items">
                <?php foreach ($helps as $item): ?>
                <li>
                    <a href="<?php echo $this->createUrl('index',array('keyword'=>$item->keyword))?>" class="<?php if($item->keyword == $help->keyword){echo 'on';} ?>"><?php echo $item->title; ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>
    <div class="my-content">
        <div class="my-account-mod">
            <div class="gtitle"><?php echo $help->title; ?></div>
            <div class="help-content">
               <?php echo $help->content; ?>
            </div>
        </div>
    </div>
</div>
