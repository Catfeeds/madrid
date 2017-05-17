<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/fang.css');
$this->pageTitle = $this->siteConfig['cityName'].'房产特价房_一房一价_'.$this->siteConfig['cityName'].'特价房-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
$this->registerHeadJs(['640resize']);
$this->registerEndJs(['jquery-2.1.4.min','main','TouchSlide.1.1']);
?>
    <!--头部 begin-->
<header class="ui-title-bar">
    <a href="<?php echo Yii::app()->user->returnUrl;?>" class="back"><i class="icon icon-black-arrow"></i></a>
    <h1>特价房详情</h1>

    <?php $this->renderPartial('/layouts/nav')?>

</header>
    <!--头部 end-->
    <div class="img-slide" id="img-slide-type-1">
        <ul class="bd">
            <?php
            if(!empty($special->housetype_img)):
                foreach($special->housetype_img as $v):?>
                <li>
                    <?php echo CHtml::image(ImageTools::fixImage($v,'640','425'),'',array('width'=>'640px','height'=>'425px'));?>
                </li>
            <?php
                endforeach;
            endif;
            ?>
        </ul>
        <div class="hd">
            <ul class="icons">
                <?php
                if(!empty($special->housetype_img)):
                    foreach($special->housetype_img as $k=> $v):?>
                        <li<?php echo $k==0 ? 'class="on"' : ''?>></li>
                    <?php
                    endforeach;
                endif;
                ?>
            </ul>
        </div>
    </div>
    <div class="gw tjf-detail">
        <div class="info">
            <div class="title">
                <h2><?php echo $special->plot->title?></h2>
                <strong class="areaprice em-1"><?php echo $special->plot->price?>元/m<sup>2</sup></strong>
            </div>
            <p><strong class="oprice em-1">￥<?php echo $special->price_new?>万</strong><del>￥<?php echo $special->price_old?>万</del></p>
        </div>
        <hr class="dash-line"/>
        <!--参数-->
        <div class="param">
            <div class="row row-justify">
                <dl>
                  <dt>户型：</dt>
                  <dd><?php echo $special->bed_room?></dd>
                </dl>
                <dl>
                  <dt>面积：</dt>
                  <dd><?php echo $special->size?>m<sup>2</sup></dd>
                </dl>
            </div>
            <dl>
              <dt>房号：</dt>
              <dd><?php echo $special->room?></dd>
            </dl>
            <dl>
              <dt>地址：</dt>
              <dd><?php echo $special->plot->address?></dd>
            </dl>
        </div>
        <div class="yuding">
            <?php if($special->end_time > time()):?>
                <a href="<?php echo $this->createUrl('/wap/order/form', array('spm'=>OrderExt::generateSpm('特价房', $special),'title'=>($special->plot->title.'--'.$special->title))); ?>" class="button">抢先预定</a>
            <?php else:?>
                <a href="javascript:" class="button">报名结束</a>
            <?php endif;?>
        </div>
        <?php if($otherNum>1):?>
        <div class="tjf-list">
            <div class="tjf-sublist on">
                <h2>
                    <?php echo $special->plot->title?>还有<strong class="em-1"><?php echo $otherNum-1; ?></strong>套特价房
                </h2>
                <ul>
                <?php foreach($other as $v): if($special->id != $v->id):?>
                    <li>
                        <a href="<?php echo $this->createUrl('detail',array('id'=>$v->id))?>">
                            <div class="pic"><img src="<?php if(isset($v->housetype_img[0]) && !empty($v->housetype_img[0])){echo ImageTools::fixImage($v->housetype_img[0]);} ?>" alt="" /></div>
                            <div class="info">
                                <p><?php echo $v->room?></p>
                                <p><?php echo $v->bed_room?>&#160;&#160;<?php echo $v->size; ?>㎡</p>
                                <p><strong class="oprice em-1"><small>￥</small><?php echo $v->price_new?><small>万</small></strong><del>￥<?php echo $v->price_old?>万</del></p>
                                <i class="goarrow icon icon-right-arrow2"></i>
                            </div>
                        </a>
                    </li>
                <?php endif; endforeach;?>
                </ul>
                <div class="addmore">
                    <a href="">加载更多</a>
                </div>
            </div>
        </div>
        <?php endif;?>
    </div>
    <script type="text/javascript">
        <?php Tools::startJs(); ?>
        TouchSlide({slideCell:'img-slide-type-1'});
        <?php Tools::endJs('js'); ?>
    </script>
