<?php
$this->pageTitle = $ask->question.'_'.SM::urmConfig()->cityName().'房产问答-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag(($ask->cate ? $ask->cate->name : '').'，'.SM::urmConfig()->cityName().'房产问答，'.SM::urmConfig()->cityName().'买房问题','keywords');
Yii::app()->clientScript->registerMetaTag(Tools::u8_title_substr($ask->answer,200),'description');?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/search.css" media="all" />

<?php $this->renderPartial('/layouts/header',['title'=>'网友点评与问答']) ?>

<!-- 顶部结束 -->

<div class="plot-reviews reviews-detail">
    <div class="reviews-content">
        <ul class="reviews-list">
            <li class="bg-hui">
                <div class="gw">
                    <p><?=$ask['question']?></p>
                    <p><span>游客</span><span>发表于<?=date('Y-m-d',$ask['created'])?></span><span><?=date('h:i:s',$ask['created'])?></span></p>
                </div>
                <div class="detail">
                	<?=$ask['answer']?>
                	<div class="d-foot">
                		<p>编辑于<?=date('Y.m.d',$ask['reply_time'])?></p>
						</p>著作版权归作者所有</p>
                	</div>
                </div>
            </li>
        </ul>
    </div>
</div>
