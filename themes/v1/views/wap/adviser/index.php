<?php
$this->pageTitle = $this->siteConfig['siteName'].'买房顾问-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag('买房顾问，'.$this->siteConfig['siteName'].'房产，'.$this->siteConfig['cityName'].'房产网，'.$this->siteConfig['cityName'].'房产信息网','keywords');
Yii::app()->clientScript->registerMetaTag('特色买房顾问整装待发为您提供专业贴心的房产服务','description');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/common.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/fang_dabai.css');
$this->registerHeadJs(['640resize','TouchSlide.1.1']);
$this->registerEndJs(['jquery.min','validform.min','main']);
?>
<div class="dabai-top">
    <header class="dabai-title-bar">
        <div class="ui-header-logo"><a href="<?php echo $this->createUrl('/wap/index/index')?>" class=" "><img src="<?php echo ImageTools::fixImage($this->siteConfig['wapLogoRed']); ?>"></a></div>
        <div class="level"><em>|</em><?php echo $this->t('房大白'); ?></div>
        <div class="fr ui-operate layer-sub-btn down"><p class="dabai-icon dabai-icon-guide"></p></div>
        <div class="column subnav-layer menuout" >
            <ul class="clearfix">
                <li><a href="<?php echo $this->createUrl('/wap/index/index')?>"><i class="icon icon-nav icon-home">&nbsp;</i>首页</a></li>
                <li><a href="<?php echo $this->createUrl('/wap/plot/list')?>"><i class="icon icon-nav icon-plot">&nbsp;</i>找楼盘</a></li>
                <li><a href="<?php echo $this->createUrl('/wap/purchase/index')?>"><i class="icon icon-nav icon-thfang">&nbsp;</i><?php echo $this->t('特惠团'); ?></a></li>
                <?php if($this->siteConfig['enableSpecialPlot']): ?>
                <li><a href="<?php echo $this->createUrl('/wap/special/index')?>"><i class="icon icon-nav icon-tjfang">&nbsp;</i>特价房</a></li>
                <?php endif; ?>
                <li><a href="<?php echo $this->createUrl('/wap/school/index')?>"><i class="icon icon-nav icon-xqfang">&nbsp;</i>临校房</a></li>
                <li><a href="<?php echo $this->createUrl('/wap/tuan/index')?>"><i class="icon icon-nav icon-kft">&nbsp;</i>看房团</a></li>
                <li><a href="<?php echo $this->createUrl('/wap/wenda/index')?>"><i class="icon icon-nav icon-answer">&nbsp;</i>问答</a></li>
                <li><a href="<?php echo $this->createUrl('/wap/calculator/index')?>"><i class="icon icon-nav icon-calculator">&nbsp;</i>计算器</a></li>
                <li><a href="<?php echo $this->createUrl('/wap/news/index')?>"><i class="icon icon-nav icon-news">&nbsp;</i>资讯</a></li>
            </ul>
        </div>
        <div class="layer-subnav-bg"></div>
    </header>
    <div class="desc">
        <p>免费提供一对一私人服务 /</p>
        <p>房源推荐 / 陪看选房 /</p>
        <p>议价签约 / 专车接送</p>
    </div>
    <div class="dabai"><?php echo $this->siteConfig['wapAdviserPageMascot'] ? CHtml::Image(ImageTools::fixImage($this->siteConfig['wapAdviserPageMascot']),''):'' ?></div>
</div>
<div class="dabai-content">
    <div class="title title1"><span>预约免费看房</span></div>
    <form class="baom-form gborder-box" method="post" action="<?php echo $this->createUrl('/wap/order/kandeal'); ?>">
        <p>
            <label class="name"><i class="dabai-icon dabai-icon-name"></i><input type="text" name="name" placeholder="输入您的姓名" datatype="*" nullmsg="请填写您的姓名" ></label><label class="tel"><i class="dabai-icon dabai-icon-tel"></i><input type="text" name="phone" placeholder="输入您的电话" datatype="m" nullmsg="请填写您的电话" errormsg="手机号码格式不正确" ></label>
        </p>
        <p>
            <label class="plot"><i class="dabai-icon dabai-icon-plot"></i><input type="text" name="loupan" placeholder="输入购房区域或楼盘名称，可填多个" datatype="*" nullmsg="请填写楼盘名称" ></label>
        </p>
        <p>
            <label class="price"><i class="dabai-icon dabai-icon-price"></i><input type="text" name="jiage" placeholder="请输入预算价格" datatype="n" nullmsg="请填写预算价格"><span class="fr">万</span></label>
        </p>
        <p><label class="desc"><i class="dabai-icon dabai-icon-desc"></i><input type="text" name="note" placeholder="请输入备注"></label></p>
        <p class="huxing">
            <label><input type="checkbox" name="huxing[]" value="一居" id="CheckboxGroup1_0"  datatype="*" nullmsg="请选择意向户型"/>一居</label>
            <label><input type="checkbox" name="huxing[]" value="二居" id="CheckboxGroup1_1"  datatype="*" nullmsg="请选择意向户型"/>二居</label>
            <label><input type="checkbox" name="huxing[]" value="三居" id="CheckboxGroup1_2"  datatype="*" nullmsg="请选择意向户型"/>三居</label>
            <label><input type="checkbox" name="huxing[]" value="四居" id="CheckboxGroup1_3"  datatype="*" nullmsg="请选择意向户型"/>四居</label>
            <label><input type="checkbox" name="huxing[]" value="五居及以上" id="CheckboxGroup1_4"  datatype="*" nullmsg="请选择意向户型"/>五居及以上</label>
        </p>
        <?php echo CHtml::hiddenField('spm', OrderExt::generateSpm('自由组团')); ?>
        <input type="submit" value="立即预约<?php echo $this->t('房大白'); ?>" class="baom-btn bigfs">
        <p class="promite"><span class="c-red">*</span>提交预约表单后，<?php echo $this->t('房大白'); ?>会尽快与您联系！</p>
    </form>
</div>
<div class="blank20"></div>
<div class="yd-dabai">
    <img src="<?php echo Yii::app()->baseUrl.'/static/wap/images/dabai1.jpg'?>">
    <p><?php echo $this->t('房大白')?>六大优势&nbsp;<?php echo $this->siteConfig['cityName'];?>独一无二</p>
</div>
<div class="blank20"></div>
<div class="dabai-content">
    <div class="title title2"><span><?php echo $this->t('房大白'); ?>精英队</span></div>
    <div class="blank20"></div>
    <img src="<?php echo Yii::app()->baseUrl.'/static/wap/images/dabai2.jpg'?>">
    <ul class="team-list clearfix">
        <?php foreach($staffs as $k=>$v):?>
            <li>
                <a href="javascript:">
                    <dl>
                        <dt><img src="<?php echo ImageTools::fixImage($v->avatar,100,100)?>"></dt>
                        <dd>
                            <p class="name"><?php echo $v->name ? $v->name : $v->username;?></p>
                            <p class="stars">
                                <span class="dabai-icon"></span>
                                <span class="dabai-icon"></span>
                                <span class="dabai-icon"></span>
                                <span class="dabai-icon"></span>
                                <span class="dabai-icon"></span>
                            </p>
                            <p class="desc"><?php echo Tools::u8_title_substr($v->idea,25);?></p>
                            <div class="years dabai-icon">
                                <p><?php echo $v->work_time;?></p>
                                <p><?php echo $v->work_time;?>年经验</p>
                            </div>
                        </dd>
                    </dl>
                </a>
            </li>
        <?php endforeach;?>
    </ul>
    <div class="blank30"></div>
</div>
<?php if(RecomCateExt::model()->normal()->getByPinyin('mfgwmfbx')->exists()): ?>
<div class="blank20"></div>
<div class="dabai-content">
    <div class="title title3"><span><?php echo $this->t('房大白'); ?>买房喜报</span></div>
    <div class="blank20"></div>
    <div id="slideBox" class="slideBox">
        <div class="bd">
            <ul>
                <?php foreach($mfxb as $v):?>
                    <li>
                        <a class="pic" <?php if($v->url): ?>target="_blank"<?php endif; ?> href="<?php echo $v->url ? $v->url : 'javascript:;'; ?>"><img src="<?php echo ImageTools::fixImage($v->image, 360, 220); ?>" alt="<?php echo $v->title; ?>"/></a>
                        <a class="tit" <?php if($v->url): ?>target="_blank"<?php endif; ?> href="<?php echo $v->url ? $v->url : 'javascript:;'; ?>"><?php echo $v->title; ?></a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="hd">
            <span class="prev"><img src="<?php echo Yii::app()->baseUrl.'/static/wap/images/left.png'?>"/></span>
            <span class="next"><img src="<?php echo Yii::app()->baseUrl.'/static/wap/images/right.png'?>"/></span>
        </div>
    </div>
    <script type="text/javascript">
        TouchSlide({ slideCell:"#slideBox", mainCell:".bd ul", effect:"leftLoop" });
    </script>
    <div class="blank30"></div>
</div>
<?php endif; ?>
