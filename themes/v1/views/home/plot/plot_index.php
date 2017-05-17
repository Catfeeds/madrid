<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/home/style/plot.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/static/home/js/modernizr.custom.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/static/home/js/main.js', CClientScript::POS_END);
if($this->plot->data_conf['seo_keywords'])
    Yii::app()->clientScript->registerMetaTag($this->plot->data_conf['seo_keywords'],'keywords');
else
    Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'价格，'.$this->plot->title.'户型，'.$this->plot->title.'电话，'.$this->plot->title.'环境，'.$this->plot->title.'图片，'.$this->siteConfig['siteName'].'房产','keywords');
if($this->plot->data_conf['seo_description'])
    Yii::app()->clientScript->registerMetaTag($this->plot->data_conf['seo_description'],'description');
else
    Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'房产网提供'.$this->plot->title.'售楼电话（'.$this->plot->sale_tel.')、最新房价、地址、交通和周边配套、开盘动态、户型图、实景图等楼盘信息。','description');
?>

<div class="wapperout">
    <div class="wapper">
        <div class="p_current fs14">当前位置：
            <a href="/"><?php echo $this->siteConfig['cityName']?>房产</a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list');?>"><?php echo $this->siteConfig['cityName']?>新房</a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list',array('place'=>$this->plot->area));?>"><?php echo isset($this->siteArea[$this->plot->area])?$this->siteArea[$this->plot->area]:'';?>楼盘</a>&gt;
            <span><?php echo $this->plot->title;?></span>
        </div>
    </div>
</div>
<?php $this->renderPartial('plot_naver')?>

<div class="wapper">
    <div class="plot-slider">
        <ul class="bd" style="height:385px;overflow:hidden;">
            <?php
                if(!empty($faceimg)):
                    foreach($faceimg as $v):
            ?>
                    <?php if($v->type == 21):?>
                        <li>
                            <a href="<?php echo $this->createUrl('/home/plot/huxing',array('py'=>$this->plot->pinyin))?>" target="_blank" class="big-img"><img data-original="<?php echo ImageTools::fixImage($v->url,'520','385'); ?>"></a>
                        </li>
                    <?php else:?>
                    <li>
                        <a href="<?php echo $this->createUrl('/home/plot/album',array('py'=>$this->plot->pinyin,'t'=>$v->type))?>" target="_blank" class="big-img"><img data-original="<?php echo ImageTools::fixImage($v->url,'520','385'); ?>"></a>
                    </li>
                    <?php endif;?>
            <?php
                    endforeach;
                endif;
            ?>
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
            </ul>
            <ul class="autopages"></ul>
            <a href="javascript:void(0)" class="pre-btn plot-ico prev"></a>
            <a href="javascript:void(0)" class="next-btn plot-ico next"></a>
        </div>
    </div>
    <div class="plot-info">
<!--        <h2>经开翡翠湖板块综合社区 交通便捷环境优美</h2>-->
        <dl class="items">
            <dt><?php echo isset(PlotPriceExt::$mark[$this->plot->price_mark]) ? PlotPriceExt::$mark[$this->plot->price_mark] : '楼盘均价' ?></dt>
            <dd class="first-dd"><?php if($this->plot->price>0):?><span class="c-red fs30"><?php echo $this->plot->price?></span><?php echo PlotPriceExt::$unit[$this->plot->unit];?><?php else:?><span class="c-red fs30">暂无报价</span><?php endif;?></dd>
            <dd><a href="<?php echo $this->createUrl('price',array('py'=>$this->plot->pinyin));?>" class="icon-link old-price"><em class="plot-ico"></em>历史价格</a></dd>
        </dl>
        <dl class="items">
            <dt>优惠信息</dt>
            <dd class="first-dd"><span class="c-red"><?php echo $this->plot->newDiscount?$this->plot->newDiscount->title:'暂无优惠信息';?></span></dd>
            <dd><a href="" class="icon-link de-notice k-dialog-type-1" data-title="[优惠通知]<?php echo $this->plot->title; ?>" data-dialog="yhtz" data-spm="<?php echo OrderExt::generateSpm('优惠通知',$this->plot); ?>"><em class="plot-ico"></em>优惠通知我</a></dd>
        </dl>

        <div class="clear"></div>
        <dl class="date-time">
            <dt>开盘时间</dt>
            <dd><?php echo $this->plot->open_time?date('Y年m月',$this->plot->open_time):'--';?></dd>
        </dl>
        <dl class="date-time">
            <dt>交房时间</dt>
            <dd><?php echo $this->plot->delivery_time?date('Y年m月',$this->plot->delivery_time):'--';?></dd>
        </dl>
        <div class="blank5"></div>
<!--        --><?php //echo $this->plot->newKan->expire.'<br/>';echo time();?>
        <?php if($this->plot->kan_id && isset($this->plot->newKan) && !empty($this->plot->newKan->expire) && ($this->plot->newKan->expire > time())):?>
        <div class="tuan-box">
            <div class="tuan-box-content tab-content">
                <div class="fl"> <p class="title fs16 mb15" title="<?php echo $this->plot->newKan->title; ?>"><span class="fw">[看房团]</span><?php echo Tools::u8_title_substr($this->plot->newKan->title,35); ?></p>
                    <div class="time-box">
                        <span class="date"><?php echo $dayS ? $dayS : 0;?></span><span class="date"><?php echo $dayG ? $dayG : 0;?></span><span>天</span><span class="date"><?php echo $hourS ? $hourS : 0;?></span><span class="date"><?php echo $hourG ? $hourG : 0;?></span><span>时</span><span class="date"><?php echo $secondS ? $secondS : 0;?></span><span class="date"><?php echo $secondG ? $secondG : 0;?></span><span>分</span><span>参与人数：<em class="c-red"><?php echo ($this->plot->newKan->stat + $this->plot->newKan->kanNum);?></em></span>
                    </div>
                </div>
                <input type="button" value="立即报名" data-title="[看房团]<?php echo $this->plot->newKan->title; ?>" data-dialog="kft" data-spm="<?php echo OrderExt::generateSpm('看房团',$this->plot->newKan); ?>" class="tj-btn dialog-open-btn k-dialog-type-1">
            </div>
        </div>
        <?php else: ?>
        <div class="tuan-box">
            <div class="tuan-box-content tab-content">
                <div class="fl"> <p class="title fs16 mb15"><span class="fw">[我要看房]</span>最新看房活动、优惠信息免费通知我</p>
                    <div class="time-box">
                        <span>参与人数：<em class="c-red"><?php echo ($this->plot->newKan && !$this->plot->newKan->getIsExpired() && ($this->plot->newKan->stat+$this->plot->newKan->kanNum)) ? ($this->plot->newKan->stat + $this->plot->newKan->kanNum) : UserPlotRelExt::model()->count('hid='.$this->plot->id) ;?></em></span>
                    </div></div>

                <input type="button" value="立即申请" class="tj-btn dialog-open-btn k-dialog-type-1" data-title="[我要看房]<?php echo $this->plot->title; ?>" data-dialog="wykf" data-spm="<?php echo OrderExt::generateSpm('看房团需求',$this->plot);?>" >
            </div>
        </div>
        <?php endif;?>
        <dl class="items">
            <dt>楼盘地址</dt>
            <dd><?php echo $this->plot->address;?></dd>
        </dl>
        <dl class="items">
            <dt>在售户型</dt>
            <dd>
                <?php
                    if(!empty($hx_cate)):
                        foreach($hx_cate as $v):
                            if(isset(PlotimgExt::$room[$v->room])):
            ?>
                <a href="<?php echo $this->createUrl('/home/plot/huxing',array('py'=>$this->plot->pinyin,'t'=>$v->room))?>">
                    <?php echo PlotimgExt::$room[$v->room]?>(<?php echo $v->count;?>)
                </a>
                <?php
                                endif;
                        endforeach;
                    else:
                ?>
                        暂无户型上传
                <?php
                     endif;
                ?>
            </dd>
            <dd><a href="<?php echo $this->createUrl('/home/plot/huxing',array('py'=>$this->plot->pinyin))?>" class="icon-link all-htype ml20"><em class="plot-ico"></em>全部户型</a></dd>
        </dl>
        <div class="clear"></div>
        <dl class="date-time">
            <dt>物业公司</dt>
            <dd><?php echo isset($this->plot->data_conf['manage_company'])&&$this->plot->data_conf['manage_company']?$this->plot->data_conf['manage_company']:'--';?></dd>
        </dl>
        <dl class="date-time">
            <dt>物业费</dt>
            <dd><?php if(isset($this->plot->data_conf['manage_fee'])&&$this->plot->data_conf['manage_fee']):?><?php echo $this->plot->data_conf['manage_fee'];?>元/平方米·月<?php else:?>暂无信息<?php endif;?></dd>
        </dl>
        <div class="blank15"></div>
        <div class="phone-apply plot-ico">
            <p class="tel"><?php echo $this->plot->sale_tel?$this->plot->sale_tel:'暂无电话';?></p>
            <p class="fs14"><span class="c-g6">免费咨询电话</span><a href="#faq" id="chatonline" class="c-g9 ml30"></a>
            <?php if($this->siteConfig['enablePlotCall']):?>
            <a href="" data-name="<?php echo $this->plot->title; ?>" data-tel="<?php echo $this->plot->sale_tel; ?>" data-title="[免费通话]<?php echo $this->plot->title; ?>" data-dialog="mfth" data-spm="<?php echo OrderExt::generateSpm('400电话',$this->plot); ?>" class="free-tel fs16 free-tel-form k-dialog-phone">免费通话</a>
            <?php endif; ?>
            </p>
    </div>
</div>
<?php if($this->plot->tuan):?>
<div class="blank30"></div>
<div class="wapper overvisible">
    <div class="group-list">
        <dl class="clearfix">
            <dt><a href="<?php echo $this->plot->tuan->url?$this->plot->tuan->url:'javascript:;'; ?>" target="_blank"><img data-original="<?php echo ImageTools::fixImage($this->plot->tuan->pc_img,'580','346'); ?>" /></a></dt>
            <dd>
                <span class="fs22 c-g3 ml20 mt20 mb20 db"><?php echo $this->plot->tuan->title?></span>
                <div class="txt-box1 clearfix"><span class="group-icon left">&nbsp;</span><span class="mid"><em class="ml20"><?php echo $this->plot->tuan->s_title?></em><a href="" class="group-icon btn k-dialog-type-1" data-title="[<?php echo $this->t('特惠团'); ?>]<?php echo $this->plot->tuan->title; ?>" data-dialog="qyh" data-spm="<?php echo OrderExt::generateSpm('特惠团',$this->plot->tuan); ?>">抢优惠</a></span><span class="group-icon right">&nbsp;</span></div>
                <div class="txt-box2 clearfix">
                    <span class="fr fs16 c-g6">原价：
                        <em class="c-g3">
                            <i><?php echo $this->plot->price; ?></i>
                            <?php echo PlotPriceExt::$unit[$this->plot->unit];?>
                        </em>
                    </span>
                    <a href="" class="fs20 c-g3"><?php echo $this->plot->title?></a>
                </div>
                <ul class="fs16 mt10">
                    <li class="clearfix"><span class="fr c-g6"><em><?php echo($this->plot->tuan->stat + $this->plot->tuan->tuanNum); ?></em>人已抢到优惠</span><span class="c-g6"><i class="head-icon icon-time" expire-date="<?php echo ($this->plot->tuan->end_time-time())?>"></i><?php echo floor(($this->plot->tuan->end_time - time())/86400).'天'.floor(($this->plot->tuan->end_time - (time() + (floor(($this->plot->tuan->end_time - time())/86400))*86400))/3600).'小时'.floor( ($this->plot->tuan->end_time - (time() + floor(($this->plot->tuan->end_time - time())/86400)*86400 + floor(($this->plot->tuan->end_time - (time() + (floor(($this->plot->tuan->end_time - time())/86400))*86400))/3600)*3600 ))/60)?>分钟 后结束</span></li>
                    <li><span class="c-g6 mr10">楼盘地址</span><span class="c-g3"><?php echo $this->plot->address;?></span></li>
                    <li class="fs22 c-pinkred"><i class="head-icon icon-tel"></i><?php echo $this->plot->sale_tel;?></li>
                </ul>
            </dd>
        </dl>
    </div>
</div>
<?php endif;?>

<div class="blank10"></div>
<?php if($specialplots && $this->siteConfig['enableSpecialPlot']):?>
<div class="wapper">
    <div class="title-box">
        <h2><?php echo $this->plot->title;?>特价房</h2>
        <a href="<?php echo $this->createUrl('/home/special/trade')?>" target="_blank" class="fr c-g9 fs14 mt10">全部特价房&gt;&gt;</a>
    </div>
    <table cellpadding="0" cellspacing="0" class="tj-house-list" width="100%">
        <tr>
            <th width="23%">标题</th>
            <th width="18%">房号</th>
            <th width="11%">户型</th>
            <th width="11%">面积</th>
            <th width="11%">原价</th>
            <th width="11%">现价</th>
            <th width="15%">操作/状态</th>
        </tr>
        <?php foreach($specialplots as $v):?>
            <tr>
                <td class="tal"><?php echo $v->title;?></td>
                <td><?php echo $v->room;?></td>
                <td><?php echo $v->bed_room;?></td>
                <td><?php echo $v->size;?>㎡</td>
                <td class="old-price">￥<?php echo $v->price_old;?>万</td>
                <td class="now-price">￥<?php echo $v->price_new;?>万</td>
                <td><a class="free-yy-btn k-dialog-type-1" data-title="[特价房]<?php echo $v->title; ?>" data-spm="<?php echo OrderExt::generateSpm('特价房',$v); ?>">免费预约</a></td>
            </tr>
        <?php endforeach;?>
    </table>
</div>
<?php endif;?>




<?php if(!empty($huxing)):?>
<div class="blank10"></div>
<div class="wapper">
    <div class="title-box">
        <h2><?php echo $this->plot->title;?>户型图</h2>
        <ul class="htype-select">
            <?php
                if(!empty($hx_cate)):
                    foreach($hx_cate as $k=>$v):
                        if(isset(PlotimgExt::$room[$v->room])):
            ?>
                <li><a href="<?php echo $this->createUrl('/home/plot/huxing',array('py'=>$this->plot->pinyin,'t'=>$v->room))?>">
                    <?php echo PlotimgExt::$room[$v->room];?>(<?php echo $v->count;?>)
                </a><span>|</span></li>
            <?php
                        endif;
                    endforeach;
                endif;
            ?>
            <li><a href="<?php echo $this->createUrl('/home/plot/huxing',array('py'=>$this->plot->pinyin))?>">更多户型</a></li>
        </ul>
    </div>
    <ul class="pic-list htype-exhibition">
        <?php
                foreach($huxing as $v):
        ?>
        <li>
            <a href="<?php echo $this->createUrl('/home/plot/hximg',array('py'=>$this->plot->pinyin,'pid'=>$v->id))?>" target="_blank">
                <img data-original="<?php echo ImageTools::fixImage($v->url,'266','225'); ?>">
                <p><?php echo $v->title;?></p>
                <?php if($v->size>0):?>
                <p>约<?php echo $v->size;?>㎡</p>
                <?php endif;?>
            </a>
        </li>
        <?php
                endforeach;
        ?>
    </ul>
</div>
<?php endif;?>
<?php if(!empty($newsprice)):?>
<div class="blank20"></div>
<div class="wapper">
    <div class="title-box">
        <h2><?php echo $this->plot->title;?>动态</h2>
    </div>
    <div class="news-box-bg mt10">
        <div class="news-box">
            <ul>
                <?php
                        foreach($newsprice as $k=>$v):
                ?>
                <li>
                    <p class="fs14 c-g6 tac"><?php echo date('Y-m-d',$v->created);?></p>
                    <a href="<?php echo $this->createUrl('/home/plot/price',array('py'=>$this->plot->pinyin));?>" class="fs14 c-g6" title="<?php echo $v->description; ?>"><?php echo Tools::u8_title_substr($v->description, 225); ?></a>
                </li>
                <?php
                        endforeach;
                ?>
            </ul>
        </div>
    </div>
</div>
<?php
endif;
?>
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
                        <span class="plot-ico"></span><i search-flag="school">学校</i>
                    </a>
                </li>
                <li class="label-two">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="hospital">医院</i>
                    </a>
                </li>
                <li class="label-three">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="bank">银行</i>
                    </a>
                </li>
                <li class="label-four">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="repast">餐饮</i>
                    </a>
                </li>
                <li class="label-five">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="shopping">购物</i>
                    </a>
                </li>
                <li class="label-six">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="bus">公交</i>
                    </a>
                </li>
                <li class="label-seven">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="park">公园</i>
                    </a>
                </li>
                <li class="label-eight">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="airport">机场</i>
                    </a>
                </li>
                <li class="label-nine" style="border-bottom-width: 0px;">
                    <a href="javascript:;" class="icon-text">
                        <span class="plot-ico"></span><i search-flag="refuel">加油站</i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>


<div class="blank40"></div>
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
            <textarea rows="3" class="q-title" js="inputext" id="faqTitle" name="question" placeholder="有关于<?php echo $this->plot->title;?>项目问题请在这里输入，买房顾问会帮您解答" datatype="*1-255" errormsg="请输入问题，最多255个字符！"></textarea>
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
        <div class="blank20"></div>
        <div class="zx-box">
            <div class="title clearfix">
                <span class="fs20 fl"><?php echo $this->plot->title;?>讨论</span>
                <a href="<?php echo str_replace('{tagid}',$this->plot->tag_id,$this->siteConfig['bbsTagPageUrl']); ?>" target="_blank" class="fr fs14">更多帖子</a>
            </div>
            <ul>
                <?php foreach($this->getPostByTagId() as $v): ?>
                    <li><a href="<?php echo str_replace('{id}', $v['tid'], $this->siteConfig['threadUrl']); ?>" target="_blank" title="<?php echo $v['subject']; ?>"><?php echo $v['subject']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<div class="blank20"></div>
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
<?php $this->footer(); ?>
<?php $this->widget('AdWidget',['position'=>'lpzydl']); ?>
