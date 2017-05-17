<?php
Yii::app()->clientScript->registerScriptFile('/static/home/js/modernizr.custom.js',  CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/home/js/main.js',  CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile('/static/home/style/kanfangtuan.css');
$this->pageTitle = $this->siteConfig['cityName'].'看房团_'.$this->siteConfig['cityName'].'看房团报名_'.$this->siteConfig['cityName'].'看房团班车-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($this->siteConfig['cityName'].'看房团，'.$this->siteConfig['cityName'].'看房团报名，'.$this->siteConfig['cityName'].'看房团班车，'.$this->siteConfig['cityName'].'房产网，'.$this->siteConfig['siteName'].'房产','keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'房产网定期召集网友组织'.$this->siteConfig['cityName'].'看房团、'.$this->siteConfig['cityName'].'看房团报名等活动，为广大网友精心规划优质看房路线，方便大家省时省力选出最合适自己的房子。','description');
$this->breadcrumbs = array($this->siteConfig['cityName'].'看房团');
?>
<div class="kanfangtuan">
    <div class="house-sale-notice">
        <div class="text-box">
            <div class="text-left">
                <p>看房专车&nbsp;免费直达</p>
                <p>购房优惠&nbsp;会员独享</p>
            </div>
            <div class="text-right">
                <strong class="c-ored">一站式购房专业指导</strong>
                <p>看房团热线：<span class="c-ored"><?php echo $this->siteConfig['sitePhone']?></span></p>
            </div>
            <div class="blank10"></div>
            <div class="fs14 c-g9">已有<span class="c-ored"><?php echo $plotNum;?></span>个楼盘参与组团 , 已有<span class="c-ored"><?php echo $kanNum;?></span>名网友报名参与</div>
        </div>
    </div>
        <?php foreach($kan as $v):?>
            <div class="section">
                <div class="tuan clearfix">
                    <div class="fl">
                        <h1><?php echo $v->title;?></h1>
                        <p class="sub"><span class="label time">时间：</span><?php echo date('m-d H:i',$v->gather_time)?><span class="label address">地点：</span><?php echo $v->location?></p>
                    </div>
                    <div class="fr baomingbtn">
                        <a href="<?php echo $v->url ? $v->url : 'javascript:';?>" <?php echo (($v->expire) - time()) < 0 ? 'class="k-btn-2 k-inline-block" target="_blank"' : 'class="k-btn-1 k-inline-block k-dialog-type-1"' ?> data-title="<?php echo '[看房团]'.$v->title; ?>" data-spm="<?php echo OrderExt::generateSpm('看房团',$v); ?>"><?php echo (($v->expire) - time()) < 0 ? '报名结束' : '立即报名';?></a>
                        <p class="baominginfo">
                            <?php echo ($v->expire > time()) ? '报名截止：<span class="k-em-2">'.floor((($v->expire) - time())/86400).'</span>天' : '报名已截止'?>&#160;&#160;已有<span class="k-em-2"><?php echo ($v->stat)+($v->kanNum)?></span>人报名
                        </p>
                    </div>
                </div>
                <div class="liucheng clearfix">
                    <ul>
                        <li class="start"><i class="icon-4 kanfangicon"></i></li>
                       <?php foreach($v->plots as $n):$plotNum=count($v->plots); ?>
                            <li class="m" style="width:<?php echo $plotNum>0?(1100/$plotNum):1100;?>px">
                                <i class="f-line-1"></i>
                                <i class="icon-5 kanfangicon"></i>
                                <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$n->pinyin)); ?>" target="_blank" title="<?php echo $n->title; ?>"><span class="name"><?php echo $n->title; ?></span></a>
                              <div class="popinfo clearfix">
                                  <i class="down-arrow"></i>
                                  <div class="fl pic"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$n->pinyin)); ?>" target="_black"><img class="lazy" data-original="<?php echo ImageTools::fixImage($n->image,150,110)?>" alt="<?php echo $n->title; ?>"/></a></div>
                                  <div class="fl info">
                                      <div class="title"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$n->pinyin)); ?>" target="_blank"><?php echo $n->title?></a></div>
                                      <p><span class="label">编辑推荐：</span><?php echo $n->newDiscount ? $n->newDiscount->title : ''?></p>
                                      <p><span class="label">开盘时间：</span><?php echo isset($n->open_time)&&!empty($n->open_time) ? date('Y',$n->open_time).'年'.date('m',$n->open_time).'月' : '暂无';?></p>
                                      <p><span class="label">楼盘价格：</span><?php echo PlotPriceExt::getPrice($n->price,$n->unit)  ?></p>
                                      <p><span class="label">楼盘地址：</span><?php echo $n->address?></p>
                                  </div>
                              </div>
                            </li>
                       <?php endforeach;?>
                      <li class="m end"><i class="f-line-1"></i><i class="f-line-arrow kanfangicon icon-6 "></i><i class="f-line-arrow"></i></li>
                    </ul>
                </div>
                <div class="loupan hj-picScroll-left">
                    <div class="prev dir"></div>
                    <div class="next dir"></div>
                    <div class="bd">
                        <ul>
                            <?php foreach($v->plots as $n):?>
                                <li class="item">
                                    <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$n->pinyin)); ?>" target="_blank">
                                        <div class="pic">
                                            <img class="lazy" data-original="<?php echo ImageTools::fixImage($n->image,270,200)?>"  />
                                        </div>
                                        <div class="name clearfix"><span class="title"><?php echo $n->title?></span><span class="area"><?php echo $n->areaInfo ? $n->areaInfo->name : ''?></span></div>
                                    </a>
                                    <?php if($n->newDiscount): ?>
                                    <div class="youhui"><?php echo $n->newDiscount ? Tools::u8_title_substr($n->newDiscount->title, 32) : ''?></div>
                                    <?php else: ?>
                                    <div class="junjia">楼盘<?php echo PlotPriceExt::$mark[$n->price_mark]; ?>：<span class="em"><?php echo $n->price?$n->price:'暂无'; ?></span><?php echo $n->price ? PlotPriceExt::$unit[$n->unit]:''; ?></div>
                                    <?php endif;?>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endforeach;?>

        <div class="blank15"></div>
        <div class="page-box fs14">
            <?php $this->widget('HomeLinkPager', array('pages'=>$pager,'maxButtonCount'=>5)) ?>
        </div>
        <div class="blank15"></div>
        <div class="baomingform clearfix">
            <div class="fl left">
                <div class="t1">自由组团</div>
                <div class="t2">贴心服务&#160;&#160;&#160;品质保证</div>
                <div class="t3">免费报名电话&#160;<?php echo $this->siteConfig['sitePhone']?></div>
                <ul class="fuwu">
                    <li><i class="kanfangicon icon-8"></i>购房优惠会员独享</li>
                    <li class="line"></li>
                    <li><i class="kanfangicon icon-9"></i>看房专车免费直达</li>
                    <li class="line"></li>
                    <li><i class="kanfangicon icon-10"></i>一站式购房专业指导</li>
                </ul>
            </div>
            <div class="fl right">
                <form action="<?php echo $this->createUrl('/api/order/ajaxKanOrderSubmit'); ?>" method="post" class="kanfangform">
                    <div class="r1">没有适合看房团？快来参与网友自发组团，人满即有机会成团</div>
                    <dl class="r2 ele">
                        <dt>意向楼盘：</dt><dd><input type="text" name="loupan" placeholder="购房区域或楼盘名称，可填写多个" class="yixiang" datatype="*" nullmsg="请填写楼盘" /></dd>
                    </dl>
                    <dl class="r3 ele">
                        <dt>预算价格：</dt><dd><input type="text" value="" name="jiage" class="price"  datatype="n" nullmsg="请输入预算价格" errormsg="价格格式错误"/><span class="flh">万</span></dd>
                    </dl>
                    <dl class="r4 ele huxing">
                        <dt>意向户型：</dt>
                        <dd>
                        <label>
                            <input type="checkbox" name="huxing[]" class="k-inline-block-middle" value="一居" datatype="*" nullmsg="请选择意向户型"/>一居
                        </label>
                        <label>
                            <input type="checkbox" name="huxing[]" class="k-inline-block-middle" value="二居" datatype="*" nullmsg="请选择意向户型"/>二居
                        </label>
                        <label>
                            <input type="checkbox" name="huxing[]" class="k-inline-block-middle" value="三居" datatype="*" nullmsg="请选择意向户型"/>三居
                        </label>
                        <label>
                            <input type="checkbox" name="huxing[]" class="k-inline-block-middle" value="四居" datatype="*" nullmsg="请选择意向户型"/>四居
                        </label>
                        <label>
                            <input type="checkbox" name="huxing[]" class="k-inline-block-middle" value="五居及以上"/>五居及以上
                        </label>
                        </dd>
                    </dl>
                    <?php echo CHtml::hiddenField('spm', OrderExt::generateSpm('自由组团')); ?>
                    <?php echo CHtml::hiddenField('csrf', Yii::app()->request->getCsrfToken()); ?>
                    <div class="r5 ele">
                        <input type="text" name="name" placeholder="姓名" class="form-name" datatype="*" nullmsg="请输入姓名" />
                        <input type="text" name="phone" placeholder="手机号" class="form-phone" datatype="m" nullmsg="请输入电话号码" errormsg="电话号码格式错误" />
                        <input id="sub" type="submit" name="sub" value="马上报名" class="form-submit" data-spm="<?php echo OrderExt::generateSpm('自由组团'); ?>" />
                    </div>
                </form>
            </div>
        </div>
        <div class="beback">
            <div class="mtitle" >近期战果<a href="<?php echo $this->createUrl('/home/tuan/back')?>" target="_blank" class="fr c-g9 fs14 mt10" >更多精彩回顾</a></div>
            <ul class="clearfix">
                <?php foreach($recom as $v):?>
                    <li class="item">
                        <a href="<?php echo $v->url;?>" target="_blank">
                            <img class="lazy" data-original="<?php echo ImageTools::fixImage($v->image,360,270)?>" alt="" />
                            <div class="title"><?php echo $v->title?></div>
                            <div class="title-bg"></div>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
