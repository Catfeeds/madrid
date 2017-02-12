<?php
$this->pageTitle = '房产百科'.'_'.SM::urmConfig()->cityName().'房产网_'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag('房产百科'.'，'.SM::GlobalConfig()->siteName().'房产，'.SM::urmConfig()->cityName().'房产网','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产百科知识就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/knowledge.css');
 $this->pageTitle = '知识库首页';
 $this->breadcrumbs = array('买房宝典');
?>
<div class="blank20"></div>
<div class="wapper">
    <div class="title-bar clearfix"><h2><a href="" class="fs24 c-g3">买房流程</a></h2></div>
    <!-- <div class="iframea clearfix">
        <div class="itema item-list">
            <div class="item-hd know-icon"></div>
            <div class="item-bd">
                <ul>
                <?php foreach ($cates as $cate): ?>

                    <?php if($cate->getIsBelongTo('买房前')): ?>
                      <li>
                        <a target="_blank" href="<?=$this->createUrl('list',array('cid'=>$cate->id))?>"><span class="iconfont"><?=$cate->getPcIcon(); ?></span><?=$cate->name; ?></a>
                      </li>
                  <?php endif;endforeach ?>
                </ul>
            </div>
        </div>
        <div class="itemb item-list">
            <div class="item-hd know-icon"></div>
            <div class="item-bd">
                <ul>
                <?php foreach ($cates as $cate): ?>
                    <?php if($cate->getIsBelongTo('买房中')): ?>
                      <li>
                        <a target="_blank" href="<?=$this->createUrl('list',array('cid'=>$cate->id))?>"><span class="iconfont"><?=$cate->getPcIcon(); ?></span><?=$cate->name; ?></a>
                      </li>
                  <?php endif;endforeach ?>
                </ul>
            </div>
        </div>
        <div class="itemc item-list">
            <div class="item-hd know-icon"></div>
            <div class="item-bd">
                <ul>
                <?php foreach ($cates as $cate): ?>

                    <?php if($cate->getIsBelongTo('买房后')): ?>
                      <li>
                        <a target="_blank" href="<?=$this->createUrl('list',array('cid'=>$cate->id))?>"><span class="iconfont"><?=$cate->getPcIcon(); ?></span><?=$cate->name; ?></a>
                      </li>
                  <?php endif;endforeach ?>
                </ul>
            </div>
        </div>
    </div> -->
    <div class="iframea clearfix">
        <div class="itema item-list">
           <a href="<?=$this->createUrl('list',['cid'=>230])?>"> <div class="item-hd know-icon"></div></a>
        </div>
        <div class="itemb item-list">
            <a href="<?=$this->createUrl('list',['cid'=>237])?>"><div class="item-hd know-icon"></div></a>
        </div>
        <div class="itemc item-list">
            <a href="<?=$this->createUrl('list',['cid'=>244])?>"><div class="item-hd know-icon"></div></a>
        </div>
    </div>
    <div class="blank30"></div>
    <div class="left-content">
    <?php if(BaikeCateExt::getBaikeByFirstCate('maixinfang')): ?>
        <h3>买新房</h3>
        <ul class="clearfix">
        <?php foreach (BaikeCateExt::getBaikeByFirstCate('maixinfang') as $key => $article): ?>
            <li>
                <div class="pic"><img class="lazy" data-original="<?=ImageTools::fixImage($article->image,200,140)?>"></div>
                <div class="info">
                    <a href="<?=$this->createUrl('detail',['id'=>$article->id])?>" target="_blank"><h3><?=$article->title; ?></h3></a>
                    <p><?=$article->description; ?><a href="<?=$this->createUrl('detail',['id'=>$article->id]); ?>" target="_blank">[详情]</a></p>
                    <div class="other">
                        <?php if($tags = $article->getTags()):?>
                        相关知识：<?php foreach($tags as $tag): ?><a href="<?=$this->createUrl('/home/baike/list',['tag'=>$tag]); ?>" target="_blank"><?=$tag; ?></a>
                        <?php endforeach;endif; ?>
                        <span class="fr"><?=date('Y-m-d', $article->created); ?></span>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
        <div class="more-btn"><a href="<?=$this->createUrl('list',['cid'=>230])?>" target="_blank">点击查看更多</a></div>
    <?php endif; ?>
     <?php if(BaikeCateExt::getBaikeByFirstCate('ershoufang')): ?>
        <h3>二手房</h3>
        <ul class="clearfix">
        <?php foreach (BaikeCateExt::getBaikeByFirstCate('ershoufang') as $key => $article): ?>
            <li>
                <div class="pic"><img class="lazy" data-original="<?=ImageTools::fixImage($article->image,200,140)?>"></div>
                <div class="info">
                    <a href="<?=$this->createUrl('detail',['id'=>$article->id])?>" target="_blank"><h3><?=$article->title; ?></h3></a>
                    <p><?=$article->description; ?><a href="<?=$this->createUrl('detail',['id'=>$article->id]); ?>" target="_blank">[详情]</a></p>
                    <div class="other">
                        <?php if($tags = $article->getTags()):?>
                        相关知识：<?php foreach($tags as $tag): ?><a href="<?=$this->createUrl('/home/baike/list',['tag'=>$tag]); ?>" target="_blank"><?=$tag; ?></a>
                        <?php endforeach;endif; ?>
                        <span class="fr"><?=date('Y-m-d', $article->created); ?></span>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
        <div class="more-btn"><a href="<?=$this->createUrl('list',['cid'=>237])?>" target="_blank">点击查看更多</a></div>
    <?php endif; ?>
     <?php if(BaikeCateExt::getBaikeByFirstCate('zufang')): ?>
        <h3>租房</h3>
        <ul class="clearfix">
        <?php foreach (BaikeCateExt::getBaikeByFirstCate('zufang') as $key => $article): ?>
            <li>
                <div class="pic"><img class="lazy" data-original="<?=ImageTools::fixImage($article->image,200,140)?>"></div>
                <div class="info">
                    <a href="<?=$this->createUrl('detail',['id'=>$article->id])?>" target="_blank"><h3><?=$article->title; ?></h3></a>
                    <p><?=$article->description; ?><a href="<?=$this->createUrl('detail',['id'=>$article->id]); ?>" target="_blank">[详情]</a></p>
                    <div class="other">
                        <?php if($tags = $article->getTags()):?>
                        相关知识：<?php foreach($tags as $tag): ?><a href="<?=$this->createUrl('/home/baike/list',['tag'=>$tag]); ?>" target="_blank"><?=$tag; ?></a>
                        <?php endforeach;endif; ?>
                        <span class="fr"><?=date('Y-m-d', $article->created); ?></span>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
        <div class="more-btn"><a href="<?=$this->createUrl('list',['cid'=>244])?>" target="_blank">点击查看更多</a></div>
    <?php endif; ?>
    </div>
      <div class="right-content">
        <div class="box">
            <div class="title"><span>热搜知识</span></div>
            <div class="lab"><?php foreach ($hotTags as $key => $value) {?>
              <a href="<?=$this->createUrl('list',array('tag'=>$value['name']))?>"><?=$value['name']?></a>
            <?php }?></div>
        </div>
        <div class="blank20"></div>
        <div class="box">
           <div class="title"><span>热门推荐</span><a href="#" class="fr change-btn" data-url="<?=$this->createUrl('/home/baike/ajaxChange')?>" data-template="hot-list-tpl" data-container="hot-list"><i class="iconfont icon-shuaxin" style="float:left;margin-top:1px;"></i>换一换</a></div>
           <script type="text/html" id="hot-list-tpl">
               {{each data as v k}}
                <li>
                    <a href="{{v.url}}">
                        <h3>{{v.title}}</h3>
                        <div class="detail clearfix">
                            <p class="info">{{v.info}}</p>
                            <div class="pic"><img data-original="{{v.pic}}"></div>
                        </div>
                    </a>
                </li>
                {{/each}}
           </script>
           <ul class="hot-list">

           </ul>
        </div>
    </div>
</div>
