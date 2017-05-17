<?php
$artcate = '';
foreach($firstCates as $v){
    if($v->id == $cate){
        $artcate = $v->name;
    }
}
$this->pageTitle =($artcate ? $artcate : '房产百科').'_'.SM::urmConfig()->cityName().'房产网_'.'第'.(int)Yii::app()->request->getParam('page',1).'页-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag(($artcate ? $artcate : '房产百科').'，'.SM::GlobalConfig()->siteName().'房产，'.SM::urmConfig()->cityName().'房产网','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产百科知识就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/search.css" media="all" />

<?php $this->renderPartial('/layouts/header',['title'=>'买房宝典','bc'=>true]) ?>

<div class="content-box">
    <div class="pt20 pb20">
        <a href="<?php echo $this->createUrl('search');?>">
            <div class="knowledge-search">
                <input type="text" placeholder="请输入您的问题"><a href="<?php echo $this->createUrl('search');?>" class="iconfont search-btn">&#x1014;</a>
            </div>
        </a>
    </div>
    <div id="leftTabBox" class="tabBox">
        
        <div class="tempWrap">
            <div class="bd">
                <ul class="mxf-container">
                    <li>
                    <?php foreach ($tags as $key => $tag) { ?>
                        <a href="<?php echo $this->createUrl('list',array('tag'=>$tag['name']));?>"><?=$tag['name']?></a>
                    <?php }?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="long-btn operate-btns">
        <a href="" class="change-btn" data-url="<?php echo $this->createUrl('AjaxChangeTags');?>" data-template="tagsList" data-container="mxf-container">换一换</a>
    </div>
</div>
<div class="blank20 bg-gray"></div>
<div id="leftTabBox" class="tabBox">
    <div class="hd clearfix">
        <ul>
            <?php foreach ($firstCates as $key => $value) { //目前只有新房 ?>
                <a href="<?php echo $this->createUrl('index',array('cate'=>$value['id']));?>"><li class="<?php echo $cate==$value['id']?'on':''; ?>"><?=$value['name']?></li></a>
           <?php }?>
        </ul>
    </div>
</div>
<div class="blank20"></div>
<?php foreach ($baikeLists as $key => $baikeList):
    if($baikeList['baike']): ?>
    <div class="content-box news-list">
        <p class="s-title"><?=$baikeList['name']?></p>
        <ul class=<?php echo $baikeList['pinyin']."-container"; ?>>
        <?php foreach ($baikeList['baike'] as $key => $baike): ?>
        <li>
            <a href="<?php echo $this->createUrl('detail',array('id'=>$baike['id']));?>">
                <div class="pic"><img src="<?php echo ImageTools::fixImage($baike['image'],200,140); ?>"></div>
                <div class="info">
                    <p><?=$baike['title']?></p>
                    <div class="tags"><?php foreach($baike->getTags() as $tag): ?><?=CHtml::link($tag, ['/wap/baike/list','tag'=>$tag]); ?><?php endforeach; ?></div>
                </div>
            </a>
        </li>
        <?php endforeach;?>
        </ul>
        <?php if($baikeHyh[$baikeList['name']]):?>
        <div class="operate-btns">
            <a href="" class="change-btn" data-url="<?php echo $this->createUrl('ajaxChangeBaike',array('cate'=>$baikeList['id']));?>" data-template="newsList" data-container=<?php echo $baikeList['pinyin']."-container"; ?>>换一换</a><a href="<?php echo $this->createUrl('list',array('cid'=>$baikeList['id']));?>">查看更多</a>
        </div>
    <?php endif;?>
    </div>
    <div class="blank20 bg-gray"></div>
<?php endif;endforeach; ?>
<?php $this->renderPartial('/layouts/contact'); ?>
