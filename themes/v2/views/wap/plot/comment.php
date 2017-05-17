<?php
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.$this->t('房大白').'点评-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.$this->t('房大白').'点评','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/plot.css'); ?>

<?php $this->renderPartial('/layouts/header',['title'=>$this->t('房大白').'点评']) ?>

<div class="dianping-list content-box">
    <?php foreach($comments as $comment): ?>
    <dl>
        <dt>
            <a href="<?=$this->createUrl('/wap/adviser/staff',['id'=>$comment->staff->id]); ?>"><img src="<?php echo ImageTools::fixImage($comment->staff->avatar); ?>"></a>
            <p><?php echo $comment->staff->name; ?></p>
            <p><?php echo $comment->staff->job; ?></p>
        </dt>
        <dd><?php echo $comment->content; ?></dd>
    </dl>
    <?php endforeach; ?>
</div>

<div class="blank20"></div>
