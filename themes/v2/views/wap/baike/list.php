<?php
$this->pageTitle ='房产百科'.'_'.SM::urmConfig()->cityName().'房产网_'.'第'.(int)Yii::app()->request->getParam('page',1).'页-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag('房产百科'.'，'.SM::GlobalConfig()->siteName().'房产，'.SM::urmConfig()->cityName().'房产网','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产百科知识就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/plot.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/search.css" media="all" />

<?php $this->renderPartial('/layouts/header',['title'=>$kw?'搜索结果':'知识列表','bc'=>true]) ?>

<div class="cate-box">
<?php if($kw):?>
    <div class="content-box">
    <a href="<?php echo $this->createUrl('search');?>">
        <div class=" pt20 pb20">
            <div class="knowledge-search">
                    <input type="text" name="kw" placeholder="请输入您的问题" value="<?=$kw?>"></input>
                    <a class="iconfont search-btn">&#x1014;</a>
            </div>
        </div>
    </a>
    <div class="clearfix cate-title">
        <ul>
            <li><span>与"<?=$kw?>"相关的文章共有<?=$pager->itemCount; ?>篇</span></li>
        </ul>
    </div>
</div>
<?php elseif($tag):?>
    <div class="clearfix cate-title">
        <ul>
            <li><span>与"<?=$tag?>"相关的文章共有<?=$pager->itemCount; ?>篇</span></li>
        </ul>
    </div>
<?php else:?>
<div class="cate-expand">
    <?php foreach ($cates as $key => $cate): //if($cate->pinyin=='maixinfang'): //目前只有新房 ?>
        <dl class="<?php echo $selectedCate->parent==$cate->id ? 'on':'';?>">
            <dt><?=$cate->name; ?><span class="iconfont">&#x1001;</span></dt>
            <dd>
                <ul>
                <?php
                    foreach ($cate->childCate as $key => $childCate): ?>
                    <li class="<?php echo $selectedCate->id==$childCate->id ? 'current' : '';?>"><a href="<?php echo $this->createUrl('list',array('cid'=>$childCate->id));?>" ><?=$childCate->name; ?></a></li>
                <?php endforeach; ?>
                </ul>
            </dd>
        </dl>
    <?php //endif;
     endforeach; ?>
</div>
<div class="clearfix cate-title">
        <ul>
            <li><span>买房宝典</span></li>
            <li>&gt;<span><?=$cates[$selectedCate->parent]->name; ?></span></li>
            <li>&gt;<span><?=$selectedCate->name; ?></span></li>
        </ul>
        <span class="rechoose-btn">重选分类</span>
<?php endif;?>

</div>
<div class="layer-overall"></div>
<div class="content-box news-list dropload" data-url="<?php echo $ajaxUrl;?>" data-template='knowledgeList'>
    <ul class="list more-list">
    </ul>
</div>
<div class="blank20"></div>
<div class="mask"></div>
