<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/news.css');
$this->pageTitle = $baike->title.'_'.$baike->cate->name.'_'.SM::urmConfig()->cityName().'房产百科-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($baike->cate->name.'，'.SM::GlobalConfig()->siteName().'房产，'.SM::urmConfig()->cityName().'房产网，'.SM::urmConfig()->cityName().'房产信息网','keywords');
Yii::app()->clientScript->registerMetaTag($baike->description ? $baike->description : Tools::u8_title_substr(strip_tags($baike->content),200),'description');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/knowledge.css');
 $this->breadcrumbs = array('买房宝典'=>['/home/baike/index'],$baike->title);
?>
<div class="blank20"></div>
<div class="wapper">
    <div class="left-content">
        <div class="baodian-detail">
            <div class="subject">
                <h3><?=$baike['title']?></h3>
                <div class="fs14 c-g9 pr"><span class="mr10"><?=date('Y-m-d',$baike['created'])?></span><span class="mr10">阅读:<?=$baike['scan']?><span>
                   <div class="sao-box">
                       <p class="send-mobile ml10">扫描到手机</p>

                        <div class="send-mobile-box">
                            <span class="right-arrow"><span></span></span>
                            <div class="send-mobile-l">
                                <p class="word1">扫描到手机&nbsp;&nbsp;新闻随时看</p>
                                <p class="word2"><span>扫一扫，用手机看文本<br/>更加方便分享给朋友</span><i></i></p>
                            </div>
                            <div class="send-mobile-r"><img src="<?php echo $this->createUrl('/api/image/qrcode',['data'=>$this->createAbsoluteUrl('/wap/baike/detail',array('id'=>$baike->id))]); ?>"></div>
                        </div>
                   </div>
                </div>
            </div>
            <div class="news-content">
                    <p style="text-indent: 2em; text-align: center; "><?=$baike['content']?></p>
                </div>
        </div>
        <div class="bdsharebuttonbox"><span class="fl txt">分享到：</span><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
        <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
    </div>

    <div class="right-content">
        <div class="box">
           <div class="title"><span>热门推荐</span><a href="" class="fr change-btn" data-url="<?=$this->createUrl('/home/baike/ajaxChange')?>" data-template="hot-list-tpl" data-container="hot-list"><i class="iconfont icon-shuaxin" style="float:left;margin-top:1px;"></i>换一换</a></div>
           <script type="text/html" id="hot-list-tpl">
               {{each data as v k}}
                <li>
                    <a href="{{v.url}}">
                        <h3>{{v.title}}</h3>
                        <div class="detail clearfix">
                            <p class="info">{{v.info}}</p>
                            <div class="pic"><img src="{{v.pic}}"></div>
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
