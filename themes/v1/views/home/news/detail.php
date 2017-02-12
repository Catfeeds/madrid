<?php
Yii::app()->clientScript->registerScriptFile('/static/home/js/modernizr.custom.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/home/js/main.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile('/static/home/style/news.css');
$this->pageTitle = $articledetail->title.'_'.$articledetail->cate->name.'_'.$this->siteConfig['cityName'].'房产资讯-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($articledetail->cate->name.'，'.$this->siteConfig['siteName'].'房产，'.$this->siteConfig['cityName'].'房产网，'.$this->siteConfig['cityName'].'房产信息网','keywords');
Yii::app()->clientScript->registerMetaTag($articledetail->description ? $articledetail->description : Tools::u8_title_substr(strip_tags($articledetail->content),200),'description');

$this->breadcrumbs = array($this->siteConfig['cityName'].'房产资讯'=>$this->createUrl('index'),$articledetail->cate->name=>$this->createUrl('index',array('cateid'=>$articledetail->cate->id)),'资讯详情页');

?>

<div class="blank5"></div>
<?php $this->widget('AdWidget',['position'=>'zxsb']); ?>
<div class="wapper">
    <div class="news-l">
        <div class="subject">
            <p class="fs24 tac"><?php echo $articledetail->title ?></p>
            <div class="fs14 c-g6 tac">
                <?php if(in_array('1', $articledetail->cate->config)): ?>
                    <span class="mr10">发布于<?php echo Tools::friendlyDate($articledetail->show_time)?></span>
                <?php endif; ?>
                <?php if(in_array('2', $articledetail->cate->config)): ?>
                    <span class="mr10">分类：<?php echo $articledetail->cate->name ?></span>
                <?php endif; ?>
                <?php if(in_array('4', $articledetail->cate->config) && $articledetail->source): ?>
                    <span class="mr10">来源：<?php echo $articledetail->source;?></span>
                <?php endif; ?>
                <?php if(in_array('8', $articledetail->cate->config)): ?>
                    <span class="mr10">编辑：<?php echo $articledetail->author; ?></span>
                <?php endif; ?>
                <?php if(in_array('16', $articledetail->cate->config)): ?>
                    <span class="mr10">阅读(<?php echo $articledetail->hits ?>) </span>
                <?php endif; ?>
                <div class="sao-box">
                   <p class="send-mobile">扫描到手机</p>
                    <div class="send-mobile-box">
                        <span class="right-arrow"><span></span></span>
                        <div class="send-mobile-l">
                            <p class="word1">扫描到手机&nbsp;&nbsp;新闻随时看</p>
                            <p class="word2"><span>扫一扫，用手机看文本<br/>更加方便分享给朋友</span><i></i></p>
                        </div>
                        <div class="send-mobile-r"><img src="<?php echo $this->createUrl('/api/image/qrcode',['data'=>$this->createAbsoluteUrl('/wap/news/detail',array('id'=>$articledetail->id))]); ?>"></div>
                    </div>
               </div>
            </div>
        </div>
        <div class="news-content">
        <?php if (isset($title)) { ?>
            <div class="mb20 clearfix">
                <?php if(!isset($allarticle) || empty($allarticle)):?>
                <div class="fl selector all page-select" >
                    <span class="fs12"><em class="c-g9">第 <?php echo ($pagedetail ? $pagedetail : 1)?>/<?php echo $count ?> 页：</em><?php if(isset($pagedetail)&&!empty($pagedetail)){ foreach($title as $k=>$v){ if($k == $pagedetail-1){ echo $v;}}}else{echo $articledetail->title;} ?></span>
                    <ul class="fs12 dn">
                        <?php
                        $i = 0;
                        foreach ($title as $v) {
                            $i++;
                            if ($i <= $count) {
                                ?>
                                <li><a href="<?php echo $this->createUrl('detail',array('articleid'=>$articleid,'page'=>$i)) ?>" class="db"><em class="c-g9">第 <?php echo $i ?>/ <?php echo $count ?>页：</em><?php echo $v ?></a></li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
                <a href="<?php echo $this->createUrl('detail',array('articleid'=>$articleid,'allarticle'=>'article'))?>" class="see-all all fr db tac fs12">在本页浏览全文<span class="st">&gt;&gt; </span><span class="text-999">(共计<?php echo $count ?>页)</span></a>
                <div class="blank20"></div>
                <?php endif;?>
                <?php
                if (isset($page) && !empty($page) && isset($pagedetail) && !empty($pagedetail)) {
                    if (isset($allarticle) && !empty($allarticle)) {
                        foreach ($page as $v) {
                            ?>
                            <p>
                                      <?php echo $v;?>
                            </p>
                <?php
                        }
                    }else{
                        if($pregStagesub != "" || $pregStagesub != null){
                            echo $page[$pagedetail-1];
                        }else{
                            echo $page[$pagedetail];
                        }
                    }
                }
                ?>
            </div>
        <?php } else{ ?>
            <p><?php echo $articledetail->content;?></p>
        <?php } ?>
        </div>

        <?php if(isset($title)):?>
        <div class="blank10"></div>
            <?php if(!isset($allarticle) || empty($allarticle)):?>
        <div class="page-box fs14 fr text-algin-right">
            <a href="<?php echo $this->createUrl('detail',array('articleid'=>$articleid,'page'=>($pagedetail - 1 >= 1) ? ($pagedetail -1) : 1))?>"><span class="pre-page">上一页</span></a>
            <?php
            $pagenum = 0;
            foreach ($title as $v) {
                $pagenum++;
                if ($pagenum <= $count) {
                    ?>
                    <a href="<?php echo $this->createUrl('detail',array('articleid'=>$articleid,'page'=>$pagenum))?>">
                        <?php if (isset($pagedetail) && !empty($pagedetail) && ($pagedetail == $pagenum)) { ?>
                            <span class=" currents"><?php echo $pagenum ?></span>
                        <?php } else { ?><span><?php echo $pagenum ?></span><?php } ?>
                    </a>
                    <?php
                }
            }
            ?>
            <a href="<?php echo $this->createUrl('detail',array('articleid'=>$articleid,'page'=>($pagedetail + 1) <= $count ? $pagedetail + 1 : $count))?>"><span class="next-page">下一页</span></a>
        </div>
        <?php endif; endif;?>
        <?php if((isset($plotdetail)&& !empty($plotdetail)) || (isset($plot) && !empty($plot))):?>
        <div class="blank20"></div>
        <div class="fs16 mt10 mb10 pl15">相关楼盘</div>
        <div class="contact-plot clearfix">
        <?php if(isset($title)){ ?>
            <?php if($plotdetail){ ?>
                <div class="pic fl">
                    <a href="<?php echo $this->createUrl('/home/plot/detail',array('py'=>$plotdetail->pinyin))?>" target="_blank"><img src=<?php echo ImageTools::fixImage($plotdetail->image,160,120) ?> alt=""></a>
                </div>
                <div class="content fl">
                    <div class="title"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$plotdetail->pinyin))?>" target="_blank"><?php echo Tools::utf8substr($plotdetail->title,0,45);?></a>
                         <?php
                            foreach ($arrxszt as $key => $v) {
                                if ($v == $plotdetail->xszt->name) {
                                    ?>
                                    <span class="lpstate"><i class="state state-<?php echo $key ?>"></i><?php echo $plotdetail->xszt->name ?></span>
                                <?php }
                            }
                            ?>
                    </div>
                    <div class="price">
                        <p class="r1">
                            <span class="k-em-2"><?php echo PlotPriceExt::getPrice($plotdetail->price,$plotdetail->unit)?></span>
                        </p>
                        <p class="r2 c-red fs16"><?php echo $plotdetail->newDiscount ? $plotdetail->newDiscount->title : ''?></p>
                    </div>
                    <p class="short-tips"><?php echo $plotdetail->areaInfo ? $plotdetail->areaInfo->name : ''?>&#160;&#160;<?php echo $plotdetail->streetInfo ? $plotdetail->streetInfo->name : ''?></p>
                    <p class="address"><?php echo $plotdetail->address?></p>
                    <p class="phone"><?php echo $plotdetail->sale_tel?></p>
                </div>
            <?php } ?>
        <?php }else{  if($plot):?>
            <div class="pic fl">
                <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$plot->pinyin))?>" target="_blank"><img src=<?php echo ImageTools::fixImage($plot->image,160,120) ?> alt=""/></a>
            </div>
            <div class="content fl">
                <div class="title"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$plot->pinyin))?>" target="_blank"><?php echo $plot->title ?></a>
                    <?php
                        foreach ($arrxszt as $key => $v) {
                            if ($plot->xszt && $v == $plot->xszt->name) {
                                ?>
                                <span class="lpstate"><i class="state state-<?php echo $key ?>"></i><?php echo $plot->xszt->name ?></span>
                            <?php }
                        }
                    ?>
                </div>
                <div class="price">
                    <p class="r1">
                        <span class="k-em-2"><?php echo PlotPriceExt::getPrice($plot->price,$plot->unit)?></span>
                    </p>
                    <p class="r2 c-red fs16"><?php echo $plot->newDiscount ? $plot->newDiscount->title : ''?></p>
                </div>
                <p class="short-tips"><?php echo $plot->areaInfo ? $plot->areaInfo->name : ''?>&#160;&#160;<?php echo $plot->streetInfo ? $plot->streetInfo->name : ''?></p>
                <p class="address"><?php echo $plot->address?></p>
                <p class="phone"><?php echo $plot->sale_tel?></p>
            </div>
        <?php endif; } ?>
            <div class="blank20"></div>
            <form class="clearfix ui-question-form" action="<?php echo $this->createUrl('/api/order/ajaxSubmit'); ?>" method="post">
                <div class="form-control">
                    <label class="name"><i class="head-icon"></i></label>
                    <input type="text" value="" name="name" placeholder="姓名" datatype="s2-5" errormsg="称呼至少2个字符,最多5个字符！">
                </div>
                <div class="form-control">
                    <label class="phone"><i class="head-icon"></i></label>
                    <input type="text" value="" name="phone" placeholder="手机号" datatype="m" errormsg="手机号码格式不正确" placeholder="手机号">
                </div>
                <?php echo CHtml::hiddenField('csrf', Yii::app()->request->getCsrfToken()); ?>
                <?php echo CHtml::hiddenField('spm', OrderExt::generateSpm('优惠通知',isset($plotdetail)&&$plotdetail?$plotdetail:(isset($plot)?$plot:null))); ?>
                <input type="submit" value="申请优惠" class="tj-answer-btn">
            </form>
        </div>
        <?php endif;?>
        <div class="blank10"></div>
        <?php $this->widget('AdWidget',['position'=>'zxnryxb']); ?>
        <div class="blank10"></div>
        <p class="pl15 c-g9 mb10 fs14 mt30"><?php if($this->siteConfig['infoCP']) {  echo $this->siteConfig['infoCP']; }else{ ?>以上信息仅供参考，最终以开发商公布为准。本稿件为<?php echo $this->siteConfig['siteName']; ?>独家原创稿件，版权所有，引用或转载请注明出处。</p>
        <?php } ?>
        <div class="line"></div>
        <div class="bdsharebuttonbox"><span class="fl txt">分享到：</span><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
        <script>window._bd_share_config = {"common": {"bdSnsKey": {}, "bdText": "", "bdMini": "2", "bdMiniList": false, "bdPic": "", "bdStyle": "0", "bdSize": "24"}, "share": {}, "image": {"viewList": ["qzone", "tsina", "tqq", "renren", "weixin"], "viewText": "分享到：", "viewSize": "16"}, "selectShare": {"bdContainerClass": null, "bdSelectMiniList": ["qzone", "tsina", "tqq", "renren", "weixin"]}};
            with (document)
                0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];</script>
    </div>
    <div class="news-r">
        <?php $this->widget('AdWidget',['position'=>'zxycbanner']); ?>
        <div class="gray-bg p10">
            <div class="mod-tuangou ui-mouseenter">
                <?php echo $this->renderpartial('/layouts/hotTuan'); ?>
            </div>
        </div>
    </div>
</div>
