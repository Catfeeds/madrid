<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/plot.css');
if($this->plot->data_conf['seo_keywords'])
    Yii::app()->clientScript->registerMetaTag($this->plot->data_conf['seo_keywords'],'keywords');
else
    Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'价格，'.$this->plot->title.'户型，'.$this->plot->title.'电话，'.$this->plot->title.'环境，'.$this->plot->title.'图片，'.SM::GlobalConfig()->siteName().'房产','keywords');
if($this->plot->data_conf['seo_description'])
    Yii::app()->clientScript->registerMetaTag($this->plot->data_conf['seo_description'],'description');
else
    Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网提供'.$this->plot->title.'售楼电话（'.$this->plot->sale_tel.')、最新房价、地址、交通和周边配套、开盘动态、户型图、实景图等楼盘信息。','description');
?>
<!-- 面包屑 -->
<div class="wapperout">
    <div class="wapper">
        <div class="p_current fs14">当前位置：
            <a href="/"><?php echo SM::urmConfig()->cityName()?>房产</a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list');?>"><?php echo SM::urmConfig()->cityName()?>新房</a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list',array('place'=>$this->plot->area));?>"><?php echo isset($this->siteArea[$this->plot->area])?$this->siteArea[$this->plot->area]:'';?>楼盘</a>&gt;
            <a href="<?=$this->createUrl('index',['py'=>$this->plot->pinyin])?>"><?php echo $this->plot->title;?></a>&gt;<span id="plot-nav">主页</span>
        </div>
    </div>
</div>
<!-- 导航 -->
<?php $this->renderPartial('plot_naver')?>
<!-- 特惠团 -->
<?php if($this->plot->tuan):?>
<div class="wapper">
    <div class="help-buy-l"><img src="<?=Yii::app()->theme->baseUrl.'/static/home/images/help_buy.png'?>"></div>
    <div class="help-buy-r">
        <div class="c-left">
            <p class="desc1"><?=$this->plot->tuan->title?></p>
            <p class="desc2"><?=$this->plot->tuan->s_title?></p>
            <p class="desc3"><?=$this->t('房大白')?>专属服务：楼盘推荐、免费咨询，全程陪看</p>
        </div>
        <div class="c-right">
             <P class="count">已有 <?php echo($this->plot->tuan->stat + $this->plot->tuan->tuanNum); ?> 人报名参团</P>
             <input type="button" value="立即申请" class="tj-btn k-dialog-type-1" data-dialog="qyh" data-title="[<?php echo $this->t('特惠团'); ?>]<?php echo $this->plot->tuan->title; ?>" data-spm="<?php echo OrderExt::generateSpm('特惠团',$this->plot->tuan); ?>">
             <p class="time"><i class="plot-ico"></i><?php echo floor(($this->plot->tuan->end_time - time())/86400).'天&nbsp;'.floor(($this->plot->tuan->end_time - (time() + (floor(($this->plot->tuan->end_time - time())/86400))*86400))/3600).'小时&nbsp;'.floor( ($this->plot->tuan->end_time - (time() + floor(($this->plot->tuan->end_time - time())/86400)*86400 + floor(($this->plot->tuan->end_time - (time() + (floor(($this->plot->tuan->end_time - time())/86400))*86400))/3600)*3600 ))/60)?>分钟&nbsp;后结束</p>
        </div>
    </div>
</div>
<div class="blank15"></div>
<?php endif;?>
<!-- 基本资料 -->
<div class="wapper ovisible">
    <div class="plot-slider">
        <ul class="bd" style="height:385px;overflow:hidden;">
            <?php
                if(!empty($faceimg)):
                    foreach($faceimg as $v):
            ?>
                    <li>
                        <a href="<?php echo $this->createUrl('/home/plot/album',array('py'=>$this->plot->pinyin,'t'=>$v->type))?>" target="_blank" class="big-img"><img data-original="<?php echo ImageTools::fixImage($v->url,'520','385'); ?>"></a>
                    </li>
            <?php
                    endforeach;
                endif;
            ?>
            <?php if($hxImage): ?>
                <li>
                    <a href="<?=$this->createUrl('/home/plot/hximg',['py'=>$this->plot->pinyin,'pid'=>$hxImage->id]); ?>" class="big-img" target="_blank"><img data-original="<?=ImageTools::fixImage($hxImage->image, 520, 385); ?>" /></a>
                </li>
            <?php endif; ?>
        </ul>
        <div class="slider-list pr hd">
            <ul>
                <?php
                    if(!empty($faceimg)):
                        foreach($faceimg as $k=>$v):?>
                <li<?php if($k == 0):?> class="current"<?php endif;?>><?php echo CHtml::image(ImageTools::fixImage($v->url,'120','90'));?></li>
                <?php
                        endforeach;
                    endif;
                ?>
                <?php if($hxImage): ?>
                    <li><img src="<?=ImageTools::fixImage($hxImage->image, 120, 90); ?>" /></li>
                <?php endif; ?>
            </ul>
            <ul class="autopages"></ul>
            <a href="javascript:void(0)" class="pre-btn plot-ico prev"></a>
            <a href="javascript:void(0)" class="next-btn plot-ico next"></a>
        </div>
    </div>
    <div class="plot-info">
        <dl class="items">
            <dt><?=PlotPriceExt::$mark[$this->plot->price_mark]=='均价'?'在售均价':PlotPriceExt::$mark[$this->plot->price_mark]?></dt>
            <dd class="first-dd"><?php if($this->plot->price>0):?><span class="c-red fs30"><?php echo $this->plot->price; ?></span><?php echo PlotPriceExt::$unit[$this->plot->unit];?><?php else:?><span class="c-red fs30">暂无报价</span><?php endif;?></dd>
            <dd class="second-dd">
                <a href="<?=$this->createUrl('/home/plot/price', ['py'=>$this->plot->pinyin]); ?>" class="icon-link old-price"><em class="plot-ico"></em>查看价格走势</a>
                <a href="javascript:;" class="icon-link de-notice k-dialog-type-1" data-title="[优惠通知]<?php echo $this->plot->title; ?>" data-dialog="yhtz" data-spm="<?php echo OrderExt::generateSpm('优惠通知',$this->plot); ?>"><em class="plot-ico"></em>降价通知我</a>
                <a href="javascript:;" class="icon-link calculate-loan ui-loan-dialog"><em class="plot-ico"></em>房贷计算器</a>
            </dd>
        </dl>
        <div class="tuan-box">
            <div class="tuan-box-content tab-content">
                <?php if($this->plot->newKan && !$this->plot->newKan->getIsExpired()): ?>
                    <div class="fl"> <p class="title fs16 mb15" title="<?php echo $this->plot->newKan->title; ?>"><span class="fw">[看房团]</span><?php echo Tools::u8_title_substr($this->plot->newKan->title,35); ?></p>
                        <div class="time-box">
                            <span class="date"><?php echo $dayS ? $dayS : 0;?></span><span class="date"><?php echo $dayG ? $dayG : 0;?></span><span>天</span><span class="date"><?php echo $hourS ? $hourS : 0;?></span><span class="date"><?php echo $hourG ? $hourG : 0;?></span><span>时</span><span class="date"><?php echo $secondS ? $secondS : 0;?></span><span class="date"><?php echo $secondG ? $secondG : 0;?></span><span>分</span><span>参与人数：<em class="c-red"><?php echo ($this->plot->newKan->stat + $this->plot->newKan->kanNum);?></em></span>
                        </div>
                    </div>
                    <input type="button" value="立即报名" data-title="[看房团]<?php echo $this->plot->newKan->title; ?>" data-dialog="kft" data-spm="<?php echo OrderExt::generateSpm('看房团',$this->plot->newKan); ?>" class="tj-btn dialog-open-btn k-dialog-type-1">
                <?php else: ?>
                    <div class="fl"> <p class="title fs16 mb15"><span class="fw">[我要看房]</span>近期看房活动、优惠信息免费通知我</p>
                        <div class="time-box">
                            <span>参与人数：<em class="c-red"><?php echo OrderExt::model()->count('spm_b=:b and spm_c=:c',[':b'=>'看房团需求',':c'=>$this->plot->id]);//UserPlotRelExt::model()->count('hid='.$this->plot->id) ;?></em></span>
                        </div></div>

                    <input type="button" value="立即申请" data-dialog="wykf" class="tj-btn dialog-open-btn k-dialog-type-1" data-title="[我要看房]<?php echo $this->plot->title; ?>" data-spm="<?php echo OrderExt::generateSpm('看房团需求',$this->plot);?>" >
                <?php endif; ?>

            </div>
        </div>
        <dl class="items">
            <dt>开盘时间</dt>
            <dd><?=(($lbuilding = $this->plot->getLatestBuilding())?date('Y年m月',$lbuilding->open_time).(date('d',$lbuilding->open_time)<=10?'上旬':(date('d',$lbuilding->open_time)>20?'下旬':'中旬')):($this->plot->open_time?date('Y年m月',$this->plot->open_time).(date('d',$this->plot->open_time)<=10?'上旬':(date('d',$this->plot->open_time)>20?'下旬':'中旬')):'-')).' '?></dd>
            <dd>
                <?php if($jfsj): ?>
                <div class="expend-btn fl">
                    <a href="" class="icon-link all-htype ml20"><i class="iconfont notice-ico">&#x1469;</i>交房时间</a>
                    <div class="kaipan-time expend-box ">
                        <p class="title"><?=$this->plot->title; ?>交房时间</p>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th width="30%">交房时间</th>
                                <th width="70%">交房详情</th>
                            </tr>
                            <?php foreach($jfsj as $sj=>$v): ?>
                            <tr>
                                <td><?=date('Y-m-d', $sj); ?></td>
                                <td><?=implode('；', $v); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
                <a href="javascript:;" data-dialog="bmtg" class="icon-link all-htype ml20 k-dialog-type-1" data-title="[开盘通知]<?=$this->plot->title; ?>" data-spm="<?=OrderExt::generateSpm('报名团购',$this->plot); ?>"><i class="iconfont notice-ico">&#x2546;</i>开盘通知我</a>
            </dd>
        </dl>
        <dl class="items">
            <dt>楼盘地址</dt>
            <?php if(isset($this->plot->address)&&mb_strlen($this->plot->address,'UTF8')>26):?>
            <dd style="width: 400px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;-o-text-overflow: ellipsis;-icab-text-overflow: ellipsis; -khtml-text-overflow: ellipsis;-moz-text-overflow: ellipsis;-webkit-text-overflow: ellipsis;"><?=$this->plot->address; ?></dd>
            <?php else:?>
            <dd><?=$this->plot->address; ?></dd>
            <?php endif?>
            <dd><a href="<?=$this->createUrl('/home/plot/map',['py'=>$this->plot->pinyin]); ?>" class="icon-link all-htype ml20"><i class="iconfont map-ico">&#x2569;</i>查看地图</a></dd>
        </dl>
        <dl class="items">
            <dt>在售户型</dt>
            <?php
                if(!empty($houseTypeCate)):
                    $k=0;
                    foreach($houseTypeCate as $v):
                        if($k<4):;
        ?>
            <dd>
                <a href="<?php echo $this->createUrl('/home/plot/huxing',array('py'=>$this->plot->pinyin,'t'=>$v[0]->bedroom))?>" class="<?=$k++==0?'':'ml20'; ?>">
                    <?php echo $v[0]->getChineseBedroom().'居室'; ?>(<?php echo count($v);?>)
                </a>
            </dd>
            <?php
                            endif;
                    endforeach;
                else:
            ?>
                    <dd>暂无户型上传</dd>
            <?php
                 endif;
            ?>
            <dd><a href="<?=$this->createUrl('/home/plot/huxing',array('py'=>$this->plot->pinyin)); ?>" class="icon-link all-htype ml20" target="_blank"><em class="plot-ico"></em>全部户型</a></dd>
        </dl>
        <dl class="items">
            <dt>物业公司</dt>
            <dd><?php echo isset($this->plot->data_conf['manage_company'])&&$this->plot->data_conf['manage_company']?$this->plot->data_conf['manage_company']:'--';?></dd>
        </dl>
        <dl class="date-time">
            <dt>物业费</dt>
            <dd><?php if(isset($this->plot->data_conf['manage_fee'])&&$this->plot->data_conf['manage_fee']):?><?php echo $this->plot->data_conf['manage_fee'];?>元/平方米·月<?php else:?>暂无信息<?php endif;?></dd>
        </dl>
        <div class="clear"></div>
        <p><a href="<?=$this->createUrl('/home/plot/detail', ['py'=>$this->plot->pinyin]); ?>" class="fs14 c-red">查看更多信息&gt;&gt;</a></p>
        <div class="operate-box clearfix">
            <div class="share-box">
                <div class="bdsharebuttonbox"><a href="#" class="bds_more share" data-cmd="more"><i class=" plot-ico"></i>分享</a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>

            </div>
            <div class="sao-box">
                <span class="sao"><i class="plot-ico"></i>扫描到手机</span>
                <div class="send-mobile-box">
                    <span class="right-arrow"><span></span></span>
                    <div class="send-mobile-l">
                        <p class="word1">扫描到手机&nbsp;&nbsp;分享到微信</p>
                        <p class="word2"><span>用微信的扫一扫功能集客<br>将此功能分享到朋友圈</span><i></i></p>
                    </div>
                    <div class="send-mobile-r"><img src="<?php echo $this->createUrl('/api/image/qrcode',['data'=>$this->createAbsoluteUrl('/wap/plot/index',['py'=>$this->plot->pinyin])]); ?>" data-bd-imgshare-binded="1"></div>
                </div>
            </div>
        </div>
        <div class="phone-apply">
            <div class="tel-l"><span class="tel"><?=$this->plot->sale_tel; ?></span><input type="button" data-name="<?php echo $this->plot->title; ?>" data-tel="<?php echo $this->plot->sale_tel; ?>" data-dialog="400dh" data-title="[400电话]<?php echo $this->plot->title; ?>" data-spm="<?php echo OrderExt::generateSpm('400电话',$this->plot); ?>" value="免费通话" class="free dialog-open-btn k-dialog-type-1"></div>

            <?php if($this->plot->evaluate && $this->plot->evaluate->staff && $this->plot->evaluate->staff->qq): ?>
            <div class="tel-r"><img src="<?=ImageTools::fixImage($this->plot->evaluate->staff->avatar,45,45); ?>"><span><?=$this->plot->evaluate->staff->name; ?><br/><?=$this->plot->evaluate->staff->job; ?></span><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?=$this->plot->evaluate->staff->qq; ?>&amp;site=qq&amp;menu=yes" class="zixun-btn">在线<br/>咨询</a></div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- 资讯+问答 -->
<div class="blank20"></div>
<div class="wapper">
    <div class="zx-content">
        <div class="title-box">
            <h2><?php echo $this->plot->title;?>资讯</h2>
            <a href="<?php echo $this->createUrl('/home/plot/news',array('py'=>$this->plot->pinyin))?>" target="_blank" class="fr c-g9 fs14 mt10">更多资讯</a>
        </div>
        <div class="hot-zx">
            <?php if(isset($articlePlotRel[0])&&!empty($articlePlotRel[0])):?>
                <div class="zx-title"><span class="dongtai"><?php echo $articlePlotRel[0]->article->cate->name;?></span><a href="<?php echo $articlePlotRel[0]->article->url ? $articlePlotRel[0]->article->url : $this->createUrl('/home/news/detail',array('articleid'=>$articlePlotRel[0]->article->id))?>" target="_blank"><?php echo Tools::u8_title_substr($articlePlotRel[0]->article->title,40);?></a></div>
                <p><?php echo $articlePlotRel[0]->article->description ? Tools::u8_title_substr(strip_tags($articlePlotRel[0]->article->description),180) : Tools::u8_title_substr(strip_tags($articlePlotRel[0]->article->content),180);?><a href="<?php echo $articlePlotRel[0]->article->url ? $articlePlotRel[0]->article->url : $this->createUrl('/home/news/detail',array('articleid'=>$articlePlotRel[0]->article->id))?>" target="_blank" class="c-sred">阅读全文</a></p>
            <?php endif;?>
        </div>
        <div class="blank10"></div>
        <ul class="zx-list">
            <?php foreach($articlePlotRel as $k=>$v):?>
                <?php if($k>0):?>
                <li><div class="zx-title"><span class="dongtai"><?php echo $v->article->cate->name;?></span><a href="<?php echo $v->article->url ? $v->article->url : $this->createUrl('/home/news/detail',array('articleid'=>$v->article->id))?>" target="_blank"><?php echo Tools::u8_title_substr($v->article->title,50);?></a></div><p class="time"><?php echo Tools::friendlyDate($v->article->show_time)?></p></li>
                <?php endif;?>
            <?php endforeach;?>
        </ul>
    </div>
    <div class="a-q-box">
        <div class="mt10 clearfix">
            <span class="fs20 fl"><?php echo $this->plot->title;?>问答</span>
            <a href="<?php echo $this->createUrl('/home/plot/faq',array('py'=>$this->plot->pinyin))?>" target="_blank" class="fr fs14">更多问答</a>
        </div>
        <ul class="answer-list clearfix">
            <?php if(isset($faqlist)):?>
                <?php foreach($faqlist as $v):?>
                    <li><em class="c-sred">问：</em>
                        <a href="<?php echo $this->createUrl('/home/wenda/detail',array('id'=>$v->id))?>" target="_blank"><?php echo Tools::u8_title_substr($v->question,48);?></a>
                        <span><a href="javascript:;" rel="nofollow" class="c-sred">已回答</a></span>
                    </li>
                <?php endforeach;?>
            <?php endif;?>
        </ul>

        <form class="question-form  ui-question-form" action="<?php echo $this->createUrl('/api/ask/ajaxSubmit')?>" method="post">
            <textarea class="q-title" js="inputext" id="faqTitle" name="question" placeholder="有关于<?php echo $this->plot->title;?>项目问题请在这里输入，买房顾问会帮您解答" datatype="*1-255" errormsg="请输入问题，最多255个字符！"></textarea>
            <div class="name-text">
                <label  class="name"><i class="head-icon"></i></label>
                <input type="text" value="" name="name" placeholder="姓名" datatype="s2-5" errormsg="称呼至少2个字符,最多5个字符！" nullmsg="请填写信息！" class="Validform_error">
            </div>
            <div class="phone-text">
                <label  class="phone"><i class="head-icon"></i></label>
                <input type="text" value="" name="phone" placeholder="手机号" datatype="m" errormsg="手机号码格式不正确">
            </div>
            <?php echo CHtml::hiddenField('hid', $this->plot->id); ?>
            <?php echo CHtml::hiddenField('csrf', Yii::app()->request->getCsrfToken()); ?>
            <input type="submit" value="提交问题" class="tj-answer-btn">
            <div class="clear"></div>
        </form>
    </div>
</div>
<!-- 楼栋 -->
<?php if($periods)://楼栋信息开始 ?>
<script type="text/javascript">
// 沙盘图数据
var sand_data = <?=CJSON::encode($periodJsData); ?>;
</script>
<?php if($periodJsData): ?>
<div class="blank10"></div>
<div class="wapper loudong-info">
    <div class="title-box">
        <h2><?=$this->plot->title; ?>楼栋信息</h2>
    </div>
    <div class="luodong-info-detail">
    <?php $i = 0; if($periodHx):
     foreach ($periodHx as $key => $hx):?>
        <div class="<?='b'.$i++;?>">
            <h3><?=$this->plot->title.$key.'期'; ?>楼栋户型列表</h3>
            <div class="scroll loudong-table">
                <ul class="lists-head">
                    <li>
                        <div class="hx">户型</div>
                        <div class="room">厅室</div>
                        <div class="area">建筑面积</div>
                    </li>
                </ul>
                <ul class="lists">
                <?php if($hx):
                     foreach ($hx as $key => $v):
                    ?>
                    <li>
                        <div class="hx"><a target="_blank" href="<?=$this->createUrl('/home/plot/hximg',['py'=>$this->plot->pinyin,'pid'=>$v->id])?>"><?=$v->title; ?></a></div>
                        <div class="room"><?=$v->bedroom.'室'.$v->livingroom.'厅'.$v->bathroom.'卫'; ?></div>
                        <div class="area"><?=$v->size; ?>m²</div>
                    </li>
                    <?php endforeach;
                endif; ?>
                </ul>
            </div>
        </div>
    <?php endforeach;
    endif; ?>
    </div>
    <div class="loudong-maps">
        <div class="tabs">
            <ul class="period-block-tabs">
                <?php foreach($periods as $k=>$period): ?>
                <li><a href="#tabs-<?=$period->id; ?>" class="<?=$k==0?'on':''; ?>"><?=$period->period; ?>期</a></li>
                <?php endforeach; ?>
            </ul>
            <?php foreach($periods as $k=>$period): ?>
                <div id="tabs-<?=$period->id; ?>" class="loudong-map-container">
                    <div class="loudong-map">
                        <div class="img-wrap" data-width="<?=$period->getImageWidth(); ?>" data-height="<?=$period->getImageHeight(); ?>">
                            <img src="<?=ImageTools::fixImage($period->image); ?>" alt="<?=$period->period.'期'; ?>"/>
                        </div>
                    </div>
                    <div class="state">
                        <ul>
                          <li class="s1">在售</li>
                          <li class="s2">待售</li>
                          <li class="s3">售罄</li>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
    <div class="arrow-detail">
        <div class="inner">
            <div class="title"><?=$this->plot->title; ?></div>
            <div class="arrow-detail-content"></div>
            <a class="close" href="javascript:;"><i class="plot-ico plot-ico-close3"></i></a>
        </div>
    </div>
    <script type="text/html" id="arrow-detail-content-tpl">
            <ul class="params">
                <li>
                    <div class="icon"><i class="iconfont icon-icon"></i></div>
                    <div>最新开盘：{{kaipan}}</div>
                </li>
                <li>
                    <div class="icon"><i class="iconfont icon-shoufangyanfang"></i></div>
                    <div>最新交房：{{jiaofang}}</div>
                </li>
                <li>
                    <div class="icon"><i class="iconfont icon-loufang"></i></div>
                    <div><span class="mr2em">单</span>元：含{{danyuan}}个单元</div>
                </li>
                <li>
                    <div class="icon"><i class="iconfont icon-floor"></i></div>
                    <div><span class="mr2em">层</span>数：{{cengshu}}层</div>
                </li>
                <li>
                    <div class="icon"><i class="iconfont icon-person"></i></div>
                    <div><span class="mr2em">户</span>数：{{hushu}}户</div>
                </li>
                <li>
                    <div class="icon"><i class="iconfont icon-hotel"></i></div>
                    <div>在售房源：{{zaishou}}套</div>
                </li>
            </ul>
            <dl class="fang-source">
              <dt><div class="icon"><i class="iconfont icon-fangyuan"></i></div>房源</dt>
              <dd>
                <div class="scroll loudong-table">
                    <ul class="lists-head">
                        <li>
                            <div class="hx">户型</div>
                            <div class="room">厅室</div>
                            <div class="area">面积</div>
                        </li>
                    </ul>
                    <ul class="lists">
                        {{each fangyuan as v k}}
                        <li>
                            <div class="hx"><a target="_blank" href="{{v.url}}">{{v.huxing}}</a></div>
                            <div class="room">{{v.tingshi}}</div>
                            <div class="area">{{v.mianji}}</div>
                        </li>
                        {{/each}}
                    </ul>
                </div>
              </dd>
            </dl>
    </script>
</div>
<?php endif;//判断$periodJsData ?>
<?php endif;//楼栋信息结束 ?>
<!-- 户型 -->
<?php if(!empty($huxing)):?>
<div class="blank10"></div>
<div class="wapper">
    <div class="title-box">
        <h2><?php echo $this->plot->title;?>户型图</h2>
        <ul class="htype-select">
            <?php
                    foreach($houseTypeCate as $v):
            ?>
                <li><a href="<?php echo $this->createUrl('/home/plot/huxing',array('py'=>$this->plot->pinyin,'t'=>$v[0]->bedroom))?>" target="_blank">
                    <?php echo $v[0]->getChineseBedroom().'居室';?>(<?php echo count($v);?>)
                </a><span>|</span></li>
            <?php
                    endforeach;
            ?>
            <li><a href="<?php echo $this->createUrl('/home/plot/huxing',array('py'=>$this->plot->pinyin))?>" target="_blank">更多户型</a></li>
        </ul>
    </div>
    <ul class="pic-list htype-exhibition">
        <?php
                foreach($huxing as $k=>$v):
                    if($k<4):
        ?>
        <li>
            <a href="<?php echo $this->createUrl('/home/plot/hximg',array('py'=>$this->plot->pinyin,'pid'=>$v->id))?>" target="_blank">
                <i class="<?=$v->getPcSaleStatusIcon(); ?>"></i>
                <img data-original="<?php echo ImageTools::fixImage($v->image,'266','225'); ?>">
                <p><?php echo $v->title;?></p>
                <?php if($v->size>0):?>
                <p>建筑面积<?php echo $v->size;?>㎡</p>
                <?php endif;?>
            </a>
        </li>
        <?php
            endif;
        endforeach;
        ?>
    </ul>
</div>
<?php endif;?>

<!-- 特价房 -->
<?php if($specialplots && SM::specialConfig()->enable()):?>
<div class="blank10"></div>
<div class="wapper tj-house-wrap">
    <div class="title-box">
        <h2><?=$this->plot->title; ?>特价房</h2>
        <a href="javascript:void(0)" class="fr c-g9 fs14 mt10"><span>全部展开</span> <i class="plot-ico plot-ico-darrow"></i></a>
    </div>
    <table cellpadding="0" cellspacing="0" class="tj-house-list" width="100%">
        <tr>
            <th width="15%">房号</th>
            <th width="11%">户型</th>
            <th width="11%">面积</th>
            <th width="11%">原价</th>
            <th width="11%">现价</th>
            <th width="11%">净省</th>
            <th width="15%">操作/状态</th>
        </tr>
        <?php foreach($specialplots as $specialPlot): ?>
        <tr>
            <?php if($specialPlot->htid==0):?>
            <td><?=$specialPlot->room; ?></td>
            <td></td>
            <td></td>
            <?php else: ?>
            <td><a target="_blank" href="<?=$this->createUrl('/home/plot/hximg',['py'=>$this->plot->pinyin,'pid'=>$specialPlot->htid])?>"><?=$specialPlot->room; ?></a></td>
            <td><?=$specialPlot->houseType->bedroom;?>室<?=$specialPlot->houseType->livingroom;?>厅<?=$specialPlot->houseType->bathroom;?>卫</td>
            <td><?=$specialPlot->houseType->size;?></td>
            <?php endif;?>
            <td class="old-price">￥<?=$specialPlot->price_old; ?>万</td>
            <td class="now-price">￥<?=$specialPlot->price_new; ?>万</td>
            <td class="sheng-price">￥<?=$specialPlot->price_old-$specialPlot->price_new; ?>万</td>
            <td><a class="free-yy-btn k-dialog-type-1" data-title="<?=$specialPlot->title; ?>" data-spm="<?=OrderExt::generateSpm('特价房', $specialPlot); ?>">免费预约</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php endif;//特价房结束 ?>
<!-- 动态和点评 -->
<div class="blank10"></div>
<div class="wapper">
    <ul class="dianping-list">
        <?php if(SM::adviserConfig()->enable() && $dianping && $dianping->staff): ?>
        <li>
            <p class="title"><span>楼盘点评</span><a href="<?=$this->createUrl('/home/plot/comment', ['py'=>$this->plot->pinyin]); ?>" target="_blank">更多&gt;</a></p>
            <div class="teacher-box clearfix">
                <div href="javascript:;" class="pic"><img src="<?=ImageTools::fixImage($dianping->staff->avatar,100,100); ?>"></div>
                <div class="detail-r">
                    <p class="fl"><span class="name"><?=$dianping->staff->name; ?></span><span class="items"><i class="iconfont v-ico">卤</i><?=$dianping->staff->job;?></span></p>
                    <div class="fr">
                        <?php if($dianping->staff->qq): ?>
                        <a href="http://wpa.qq.com/msgrd?v=3&uin=<?=$dianping->staff->qq; ?>&site=qq&menu=yes" class="items fl" target="_blank"><i class="iconfont qq-ico">&#x1568;</i>在线咨询</a>
                        <?php endif; ?>
                        <?php if($dianping->staff->wx_image): ?>
                        <a href="javascript:void(0);" class="items weixinex fr"><i class="iconfont weixin-ico">&#x1444;</i>微信联系
                            <div class="weixin-box">
                                <div class="pr">
                                    <span class="top-arrow"><span></span></span>
                                    <div class="weixin-pop-box">
                                        <p>微信联系，更便捷哦</p>
                                        <img src="<?=ImageTools::fixImage($dianping->staff->wx_image); ?>">
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php endif; ?>
                    </div>
                    <div class="clear"></div>
                    <P class="info"><a href="<?=$this->createUrl('/home/plot/comment', ['py'=>$this->plot->pinyin]); ?>" target="_blank"><?=Tools::substr($dianping->content,80,3); ?></a></P>
                </div>
            </div>
        </li>
        <?php endif; ?>
        <?php if(SM::adviserConfig()->enable() && $dianping && $dongtai): ?>
        <li>
            <p class="title"><span><?=$this->plot->title; ?>动态</span><a href="<?=$this->createUrl('/home/plot/price',['py'=>$this->plot->pinyin]); ?>" target="_blank">更多&gt;</a></p>
            <div class="dongtai">
                <P><a href="<?=$this->createUrl('/home/plot/price', ['py'=>$this->plot->pinyin]); ?>" target="_blank"><?=Tools::substr($dongtai->description,120,3); ?></a></P>
                <P class="tar c-g9"><?=date('Y-m-d', $dongtai->created);?></P>
            </div>
        </li>
        <?php endif; ?>
    </ul>
</div>
<!-- 楼盘评测 -->
<?php if(SM::adviserConfig()->enable() && $this->plot->evaluate && $this->plot->evaluate->getIsEnabled() && SM::plotEvaluateConfig()->enable()):?>
<div class="blank10"></div>
<div class="wapper">
    <div class="title-box">
        <h2>楼盘评测</h2>
        <a href="<?=$this->createUrl('/home/plot/evaluate',['py'=>$this->plot->pinyin]); ?>" target="_blank" class="fr c-g9 fs14 mt10">更多&gt;&gt;</a>
    </div>
    <ul class="pingce-list">
        <?php
        foreach (PlotEvaluateExt::$contentFields as $name => $pinyin):
            if(isset($this->plot->evaluate->{$pinyin})&&!$this->plot->evaluate->{$pinyin}->getIsEmpty()):
        ?>
        <li>
            <p class="title"><span><?=PlotEvaluateExt::$pcIconStyle[$pinyin].$name; ?></span><a href="<?=$this->createUrl('/home/plot/evaluate',['py'=>$this->plot->pinyin]); ?>" target="_blank">查看更多&gt;</a></p>
            <div class="detail clearfix">
                <p><?=$this->plot->evaluate->{$pinyin}->getDescription(170); ?></p>
                <a href="<?=$this->createUrl('/home/plot/evaluate',['py'=>$this->plot->pinyin]); ?>" target="_blank" class="pic"><img src="<?=ImageTools::fixImage($this->plot->evaluate->{$pinyin}->image,98,98);?>"></a>
            </div>
        </li>
    <?php endif;endforeach; ?>
    </ul>
</div>
<?php endif;?>
<!-- 楼盘地图 -->
<div class="blank10"></div>
<div class="wapper">
    <div class="title-box">
        <h2><?php echo $this->plot->title;?>配套地图</h2>
    </div>
    <div class="map">
        <div class="map-box"
             data-lng="<?php echo $this->plot->map_lng?>"
             data-lat="<?php echo $this->plot->map_lat;?>"
             data-zoom="<?php echo $this->plot->map_zoom?>"
             data-plot-name="<?php echo $this->plot->title;?>"
             data-plot-addr="<?php echo $this->plot->address;?>"
            >
            <div id="ui-map-box"></div>
            <div class="assort-distance fixed-side school">
                <div class="close-assort ">
                    显<br>示<br>周<br>边<br>配<br>套
                </div>
                <div class="extend-box">
                    <h4><span class="plot-ico"></span><i id="bmap-keyword">学校</i><i id="result-count">()</i></h4>
                    <span class="close plot-ico"></span>
                    <ul>
                    </ul>
                </div>
            </div>
        </div>
        <div class="map-label">
            <ul js="clearSonAttr">
                <li class="label-one">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="school" data-name="<?=SM::urmConfig()->cityName(); ?>学校">学校</i>
                    </a>
                </li>
                <li class="label-two">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="hospital" data-name="<?=SM::urmConfig()->cityName(); ?>医院">医院</i>
                    </a>
                </li>
                <li class="label-three">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="bank" data-name="<?=SM::urmConfig()->cityName(); ?>银行">银行</i>
                    </a>
                </li>
                <li class="label-four">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="repast" data-name="<?=SM::urmConfig()->cityName(); ?>餐饮">餐饮</i>
                    </a>
                </li>
                <li class="label-five">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="shopping" data-name="<?=SM::urmConfig()->cityName(); ?>购物">购物</i>
                    </a>
                </li>
                <li class="label-six">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="bus" data-name="<?=SM::urmConfig()->cityName(); ?>公交">公交</i>
                    </a>
                </li>
                <li class="label-seven">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="park" data-name="<?=SM::urmConfig()->cityName(); ?>公园">公园</i>
                    </a>
                </li>
                <li class="label-eight">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="airport" data-name="<?=SM::urmConfig()->cityName(); ?>机场">机场</i>
                    </a>
                </li>
                <li class="label-nine" style="border-bottom-width: 0px;">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="refuel" data-name="<?=SM::urmConfig()->cityName(); ?>加油站">加油站</i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="blank20"></div>
<div class="blank30"></div>
<?php if(!empty($wantKan)): ?>
<div class="wapper">
    <div class="title-box">
        <h2>您可能想看</h2>
    </div>
    <ul class="pic-list want-to-see">
        <?php foreach($wantKan as $val): if($val->id != $this->plot->id):?>
            <li>
                <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$val->pinyin))?>" target="_blank">
                    <img data-original="<?php echo ImageTools::fixImage($val->image,'270','200')?>">
                    <p><?php echo $val->title?><span class="fr fs14 c-g6"><?php echo PlotPriceExt::getPrice($val->price,$val->unit);?></span></p>
                    <?php if($val->newDiscount):?>
                        <p class="c-red fs16"><?php echo Tools::u8_title_substr($val->newDiscount['title'],25,'..');?></p>
                    <?php else: ?>
                    <p class="fs16 c-g6">
                        <?php echo (isset($this->siteArea[$val->area])&&!empty($this->siteArea[$val->area])) ? ($this->siteArea[$val->area].((isset($this->siteStreet[$val->area])&&!empty($this->siteStreet[$val->area])) ? ((isset($this->siteStreet[$val->area][$val->street])&&!empty($this->siteStreet[$val->area][$val->street])) ? '/'.$this->siteStreet[$val->area][$val->street] : '') :'' )) : '';?>
                    </p>
                    <?php endif;?>
                </a>
            </li>
        <?php endif; endforeach; ?>
    </ul>
</div>
<?php endif; ?>
<div class="blank30"></div>
<div class="wapper">
    <?php if(count($nearByPlots)>0):?>
    <div class="three-box">
        <div class="ss-title">
            <span>周边楼盘</span>
        </div>
        <dl class="clearfix">
            <dt><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$nearByPlots[0]->pinyin));?>" target="_blank"><img src="<?=ImageTools::fixImage($nearByPlots[0]->image,140,105);?>"></a></dt>
            <dd>
                <div class="info">
                    <h4 class="name"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$nearByPlots[0]->pinyin));?>" target="_blank"><?php echo $nearByPlots[0]->title;?></a></h4>
                    <p class="price"><?php echo $nearByPlots[0]->price>0? $nearByPlots[0]->price.PlotPriceExt::$unit[$nearByPlots[0]->unit]:'待定';?></p>
                    <p class="area"><?php echo $nearByPlots[0]->areaInfo?$nearByPlots[0]->areaInfo->name:'';?></p>
                    <p class="detail"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$nearByPlots[0]->pinyin));?>" target="_blank">查看详情</a></p>
                </div>
            </dd>
        </dl>
        <ul>
            <?php for($i=1;$i<count($nearByPlots);$i++):?>
                <li>
                    <span class="name"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$nearByPlots[$i]->pinyin));?>" target="_blank"><?php echo $nearByPlots[$i]->title;?></a></span>
                    <span class="price"><?php echo $nearByPlots[$i]->price>0? $nearByPlots[$i]->price.PlotPriceExt::$unit[$nearByPlots[$i]->unit]:'待定';?></span>
                    <span class="area"><?php echo $nearByPlots[$i]->areaInfo?$nearByPlots[$i]->areaInfo->name:'';?></span>
                </li>
            <?php endfor;?>
        </ul>
    </div>
    <?php endif;?>
    <?php if(count($nearPricePlots)>0):?>
    <div class="three-box ml25">
        <div class="ss-title">
            <span>同价位楼盘</span>
        </div>
        <dl class="clearfix">
            <dt><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$nearPricePlots[0]->pinyin));?>" target="_blank"><img src="<?=ImageTools::fixImage($nearPricePlots[0]->image,140,105);?>"></a></dt>
            <dd>
                <div class="info">
                    <h4 class="name"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$nearPricePlots[0]->pinyin));?>" target="_blank"><?php echo $nearPricePlots[0]->title;?></a></h4>
                    <p class="price"><?php echo $nearPricePlots[0]->price>0?$nearPricePlots[0]->price.PlotPriceExt::$unit[$nearPricePlots[0]->unit]:'待定';?></p>
                    <p class="area"><?php echo $nearPricePlots[0]->areaInfo?$nearPricePlots[0]->areaInfo->name:'';?></p>
                    <p class="detail"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$nearPricePlots[0]->pinyin));?>" target="_blank">查看详情</a></p>
                </div>
            </dd>
        </dl>
        <ul>
            <?php for($i=1;$i<count($nearPricePlots);$i++):?>
            <li>
                <span class="name"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$nearPricePlots[$i]->pinyin));?>" target="_blank"><?php echo $nearPricePlots[$i]->title;?></a></span>
                <span class="price"><?php echo $nearPricePlots[$i]->price>0?$nearPricePlots[$i]->price.PlotPriceExt::$unit[$nearPricePlots[$i]->unit]:'待定';?></span>
                <span class="area"><?php echo $nearPricePlots[$i]->areaInfo?$nearPricePlots[$i]->areaInfo->name:'';?></span>
            </li>
            <?php endfor;?>
        </ul>
    </div>
    <?php endif;?>
    <?php if(count($discountPlots)>0):?>
    <div class="three-box ml25">
        <div class="ss-title">
            <span>打折楼盘</span>
        </div>
        <dl class="clearfix">
            <dt><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$discountPlots[0]->plot->pinyin));?>" target="_blank"><img src="<?=ImageTools::fixImage($discountPlots[0]->plot->image,140,105);?>"></a></dt>
            <dd>
                <div class="info">
                    <h4 class="name"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$discountPlots[0]->plot->pinyin));?>" target="_blank"><?php echo $discountPlots[0]->plot->title;?></a></h4>
                    <p class="price"><?php echo $discountPlots[0]->plot->price>0?$discountPlots[0]->plot->price.PlotPriceExt::$unit[$discountPlots[0]->plot->unit]:'待定';?></p>
                    <p class="area"><?php echo $discountPlots[0]->plot->areaInfo ? $discountPlots[0]->plot->areaInfo->name : '';?></p>
                    <p class="detail"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$discountPlots[0]->plot->pinyin));?>" target="_blank">查看详情</a></p>
                </div>
            </dd>
        </dl>
        <ul>
            <?php for($i=1;$i<count($discountPlots);$i++):?>
                <li>
                    <span class="name"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$discountPlots[$i]->plot->pinyin));?>" target="_blank"><?php echo $discountPlots[$i]->plot->title;?></a></span>
                    <span class="price"><?php echo $discountPlots[$i]->plot->price>0?$discountPlots[$i]->plot->price.PlotPriceExt::$unit[$discountPlots[$i]->plot->unit]:'待定';?></span>
                    <span class="area"><?php echo $discountPlots[$i]->plot->areaInfo? $discountPlots[$i]->plot->areaInfo->name:'';?></span>
                </li>
            <?php endfor;?>
        </ul>
    </div>
    <?php endif?>
    <?php if(count($nearPricePlots)==0||count($discountPlots)==0||count($nearByPlots)==0):?>
    <div class="three-box ml25">
            <div class="ss-title">
                <span>热门楼盘</span>
            </div>
            <dl class="clearfix">
                <dt><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$hotPlots[0]->pinyin));?>" target="_blank"><img src="<?=ImageTools::fixImage($hotPlots[0]->image,140,105);?>"></a></dt>
                <dd>
                    <div class="info">
                        <h4 class="name"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$hotPlots[0]->pinyin));?>" target="_blank"><?php echo $hotPlots[0]->title;?></a></h4>
                        <p class="price"><?php echo $hotPlots[0]->price>0?$hotPlots[0]->price.PlotPriceExt::$unit[$hotPlots[0]->unit]:'待定';?></p>
                        <p class="area"><?php echo $hotPlots[0]->areaInfo? $hotPlots[0]->areaInfo->name:'';?></p>
                        <p class="detail"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$hotPlots[0]->pinyin));?>" target="_blank">查看详情</a></p>
                    </div>
                </dd>
            </dl>
            <ul>
                <?php for($i=1;$i<count($hotPlots);$i++):?>
                    <li>
                        <span class="name"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$hotPlots[$i]->pinyin));?>" target="_blank"><?php echo $hotPlots[$i]->title;?></a></span>
                        <span class="price"><?php echo $hotPlots[$i]->price>0?$hotPlots[$i]->price.PlotPriceExt::$unit[$hotPlots[$i]->unit]:'待定';?></span>
                        <span class="area"><?php echo $hotPlots[$i]->areaInfo? $hotPlots[$i]->areaInfo->name:'';?></span>
                    </li>
                <?php endfor;?>
            </ul>
        </div>
    <?php endif;?>
</div>

<?php if($this->plot->red)://红包 ?>
    <?php //if($this->action->popRed($this->plot->red->id)): ?>
    <div class="dialog-hongbao">
        <div class="person-num"><?=$this->plot->red->total_num+$redCount; ?>人<br/>已领取</div>
        <div class="info">
            <h3><?=$this->plot->red->title; ?></h3>
            <p class="time"><?=date('Y年m月d日', $this->plot->red->start_time)?>-<?=date('m月d日', $this->plot->red->end_time); ?>可领</p>
            <a href="javascript:;" class="get-btn k-dialog-type-1" data-title="[领取红包]<?=$this->plot->red->title; ?>" data-dialog="lqhb" data-spm="<?=OrderExt::generateSpm('楼盘红包', $this->plot->red); ?>">点击领取</a>
        </div>
        <a class="close" href="javascript:;"><i class="plot-ico plot-ico-close"></i></a>
    </div>
    <?php //endif; ?>
    <div class="fixed-hongbao">
        <p class="num">红包<span class="em"><?=round($this->plot->red->amount); ?></span>元</p>
        <p class="tip">买新房 领红包 人人有份</p>
        <a href="javascript:;" class="get-btn k-dialog-type-1" data-title="<?=$this->plot->red->title; ?>" data-spm="<?=OrderExt::generateSpm('楼盘红包', $this->plot->red); ?>">立即领取</a>
        <a href="javascript:;" class="close"><i class="plot-ico plot-ico-circlose"></i></a>
    </div>
<?php endif; ?>

<?php $this->renderPartial('/plot/_calculator'); ?>
<?php $this->footer(); ?>
<?php $this->widget('AdWidget',['position'=>'lpzydl']); ?>
<script type="text/javascript">
    window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
</script>
<script>
    <?php Tools::startJs(); ?>
     Do.ready(function(){
        $('.fixed-hongbao').click(function(){
            global.loupan_dialog_hongbao();
        });
    });
    <?php Tools::endJs('js'); ?>
</script>
