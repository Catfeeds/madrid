<?php
$this->pageTitle = '房产百科'.'_'.SM::urmConfig()->cityName().'房产网_'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag('房产百科'.'，'.SM::GlobalConfig()->siteName().'房产，'.SM::urmConfig()->cityName().'房产网','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产百科知识就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');
$this->breadcrumbs = array('买房宝典'=>$this->createUrl('/home/baike/index'),"知识列表");
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/knowledge.css');
?>
<div class="blank20"></div>
<div class="wapper">

    <div class="left-side">
      <div class="selection-list-box">
    <?php if($cates = BaikeCateExt::getChildCates('maixinfang')):?>
      <div class="selection-level1">买新房</div>
    <?php foreach ($cates as $key => $cate) {?>
      <div class="selection-level2 <?=$cid==$cate->id?'selected-level2':''; ?>">
        <div class="selection-arrow know-icon"></div>
                <a class="<?=$cid==$cate->id?'selected':''; ?>" href="<?=$this->createUrl('list',['cid'=>$cate->id]); ?>"><?=$cate['name']?></a>
        </div>
    <?php }?>
    <?php endif;?>
    <?php if($cates = BaikeCateExt::getChildCates('ershoufang')):?>
      <div class="selection-level1">二手房</div>
    <?php foreach ($cates as $key => $cate) {?>
      <div class="selection-level2 <?=$cid==$cate->id?'selected-level2':''; ?>">
        <div class="selection-arrow know-icon"></div>
                <a class="<?=$cid==$cate->id?'selected':''; ?>" href="<?=$this->createUrl('list',['cid'=>$cate->id]); ?>"><?=$cate['name']?></a>
        </div>
    <?php }?>
    <?php endif;?>
    <?php if($cates = BaikeCateExt::getChildCates('zufang')):?>
      <div class="selection-level1">租房</div>
    <?php foreach ($cates as $key => $cate) {?>
      <div class="selection-level2 <?=$cid==$cate->id?'selected-level2':''; ?>">
        <div class="selection-arrow know-icon"></div>
                <a class="<?=$cid==$cate->id?'selected':''; ?>" href="<?=$this->createUrl('list',['cid'=>$cate->id]); ?>"><?=$cate['name']?></a>
        </div>
    <?php }?>
    <?php endif;?>
    </div></div>

    <div class="right-side">
        <div class="title">
            <span><?php $flag = $kw?$kw:$tag; if($flag) echo '关于 <em>'.$flag.'</em> ';?>共<em><?=$count?></em>篇文章</span>
            <div class="fr">
                <a href="<?=$this->createUrl('list',['cid'=>$cid])?>" class="<?=!$sort?'on':''?>">最新<i class="know-icon down"></i></a>
                <a href="<?=$this->createUrl('list',array('sort'=>'scan','cid'=>$cid))?>" class="<?=$sort?'on':''?>">最热<i class="know-icon down"></i></a>
            </div>
        </div>
        <div class="info-list">
         <ul class="clearfix">
         <?php foreach ($data as $key => $baike) {?>
           <li>
               <div class="pic"><img class="lazy" data-original="<?=ImageTools::fixImage($baike->image,200,140)?>"></div>
               <div class="info">
                   <a href="<?=$this->createUrl('detail',array('id'=>$baike['id']))?>" target="_blank"><h3><?=$kw?str_replace($kw,'<em class="c-red">'.$kw.'</em>',$baike['title']):$baike['title']?></h3></a>
                   <p><?=$baike->description; ?><a href="<?=$this->createUrl('detail',array('id'=>$baike->id))?>">[详情]</a></p>
                   <div class="other">
                       <?php if($tags = $baike->getTags()):?>
                       相关知识：<?php foreach($tags as $tag): ?><a href="<?=$this->createUrl('/home/baike/list',['tag'=>$tag]); ?>" target="_blank"><?=$tag; ?></a>
                       <?php endforeach;endif; ?>
                       <span class="fr"><?=date('Y-m-d',$baike['created'])?></span>
                   </div>
               </div>
           </li>
         <?php }?>
       </ul>
        </div>
        <div class="page-box fs14 fr mt30">
          <?php $this->widget('HomeLinkPager', array('pages'=>$pager)) ?>
        </div>
    </div>
</div>
<div class="blank40"></div>
