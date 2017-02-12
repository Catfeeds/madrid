<?php

//存在seo_title，覆盖$this->pageTitle
if($this->plot->data_conf['seo_title']){
    $this->pageTitle = $this->plot->data_conf['seo_title'];
}
if($this->plot->data_conf['seo_keywords'])
    Yii::app()->clientScript->registerMetaTag($this->plot->data_conf['seo_keywords'],'keywords');
else
    Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'价格，'.$this->plot->title.'户型，'.$this->plot->title.'电话，'.$this->plot->title.'环境，'.$this->plot->title.'图片，'.SM::GlobalConfig()->siteName().'房产','keywords');
Yii::app()->clientScript->registerMetaTag($this->pageDescription,'description');
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/index.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/plot.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/swiper.min.css" media="all" />
<!-- 顶部开始 -->
<?php $this->renderPartial('/layouts/header',['title'=>'','search'=>false]) ?>
<!-- 顶部结束 -->

<!-- 内容开始 -->
<section class="container">
	<div class="house-detail">
		<div class="detail-cover">
			<div class=" top-mark"></div>
	        <ul class="swiper-wrapper">
            <?php
                if(!empty($faceimg)):
                    foreach($faceimg as $k=>$v):
                        ?>
                        <li class="swiper-slide">
                            <a href="<?php echo $this->createUrl('/wap/plot/album',array('py'=>$this->plot->pinyin))?>">
                                <img <?=$k==0?'src':'data-src'?>="<?php echo ImageTools::fixImage($v['url']); ?>" <?php if($k>0): ?>class="swiper-lazy"<?php endif; ?>>
                                <?php if($k>0): ?><div class="swiper-lazy-preloader"></div><?php endif;  ?>
                            </a>
                        </li>
                    <?php
                    endforeach;
                else:
                ?>
                <li class="swiper-slide">
                    <a href="<?php echo $this->createUrl('/wap/plot/album',array('py'=>$this->plot->pinyin))?>">
                    <img data-src="<?php echo ImageTools::fixImage($this->plot->image); ?>" class="swiper-lazy">
                    </a>
                </li>
                <?php endif; ?>
	        </ul>
	        <div class="pages">
	        	<i class="iconfont">&#x1021;</i><em>1</em>/<span>1</span>
	        </div>
			<div class="bottom-mark"></div>
        </div>

        <div class="detail-title">
        	<p><?=$plot['title']?></p>
        	<a style="display: none" href="" class="iconfont collect">&#x1028;</a>
        	<a href="" class="iconfont share">&#x1017;</a>
        </div>

        <div class="detail-info">
        	<h2><?php if(!$plot['price']): ?>
            <span>暂无</span>
            <?php else:?>
            <span><?=PlotPriceExt::$mark[$plot->price_mark]?><?=$plot['price']?><?=PlotPriceExt::$unit[$plot->unit]
?></span><?php endif;?> <a href="<?=$this->createUrl('/wap/calculator/index')?>"><i class="iconfont">&#x2546;</i><em><a href="<?=$this->createUrl('/wap/calculator/index')?>">购房计算</a></em></a></h2>
        	<p><span>开盘：</span><?=(($lbuilding = $this->plot->getLatestBuilding())?date('Y-m-d',$lbuilding->open_time):'').' '.($lbuilding&&$lbuilding->period?$lbuilding->period->period.'期':'').' '?><?php
        	if($lbuilding&&$pb = PlotBuildingExt::model()->onSale()->findAllByHid($this->plot->id)) {
                foreach ($pb as $key => $value) {
        		echo $value['name'].' ';
        	} echo '(在售)'; }?><?php if(!$lbuilding) echo $this->plot->open_time?date('Y-m-d',$this->plot->open_time):'-';?></p>
        	<p><span>地址：</span><?=$plot->sale_addr?></p>
        	<div class="tags">
        	<?php $i=0; foreach ($tags as $key => $value) { if($i>3) break; ?>
        		<i class="<?php $cl = ['green','yellow','pink','blue'];echo $cl[$i%4];?>"><?=$value['name']?></i>
        	<?php $i++; }?>
            </div>
            <?php if($this->plot->red):?><a href="" class="hongbao"></a><?php endif;?>

            <a href="<?=$this->createUrl('/wap/plot/detail',array('py'=>$plot->pinyin))?>" class="more">更多详细信息<i class="iconfont">&#x1020;</i></a>
            <a href="<?php echo $this->createUrl('/wap/order/form', array('spm'=>OrderExt::generateSpm('降价通知',$plot), 'title'=>$plot->title)); ?>" class="jiangjia"><i class="iconfont">&#x1031;</i>降价通知</a>
            <a href="<?php echo $this->createUrl('/wap/order/form', ['spm'=>OrderExt::generateSpm('看房团需求', $plot),'title'=>$plot->title]); ?>" class="kaipan"><i class="iconfont">&#x1026;</i>开盘通知</a>
        </div>
    <?php if(SM::adviserConfig()->enable() && $plot->evaluate && $plot->evaluate->getIsEnabled() && SM::PlotEvaluateConfig()->enable()):?>
        <div class="floor">
        	<h1>楼房评测</h1>
    		<div class="slider-pingce">
        		<ul class="swiper-wrapper">
        		<?php
                foreach (PlotEvaluateExt::$contentFields as $name => $pinyin):
                    if(isset($plot->evaluate->{$pinyin}) && !$plot->evaluate->{$pinyin}->getIsEmpty()):
                ?>
        			<li class="swiper-slide">
        				<div class="title"><i class="iconfont">&#x2030;</i><?=$name; ?></div>
                        <a href="<?php echo $this->createUrl('/wap/plot/evaluate', ['py'=>$plot->pinyin, 'type'=>$pinyin]); ?>">
            				<div class="info">
                                <?=$plot->evaluate->{$pinyin}->getDescription(55); ?>
            					<span>查看全部 &gt;</span>
            				</div>
            				<div class="cover"><img class="lazy" data-original="<?php echo ImageTools::fixImage($plot->evaluate->{$pinyin}->image); ?>"></div>
                        </a>
        			</li>
        		<?php endif;endforeach; ?>
        		</ul>
    		</div>
        </div>
    <?php endif;?>
    <?php if($thtuan) {?>
        <div id="tht" class="floor">
        	<h1>特惠团</h1>
        	<div class="baoming">
        		<div class="cover"><img class="lazy" data-original="<?php echo ImageTools::fixImage($thtuan['wap_img']); ?>"></div>
        		<div class="info">
        			<h3><?=$thtuan['title']?></h3>
        			<p><em><?=$thtuan->getTuanNum(); ?></em> 人已报名</p>
        			<p>报名截止时间：<em><?=date('Y-m-d', $thtuan->end_time); ?></em></p>
        		</div>
        		<a href="<?php echo $this->createUrl('/wap/order/form', array('spm'=>OrderExt::generateSpm('特惠团',$thtuan), 'title'=>$thtuan->title,'plotName'=>$plot->title)); ?>" class="bm-btn">我要报名</a>
        	</div>
        </div>
        <?php }?>
    <?php if(SM::kanConfig()->enable() && $newKan) {?>
        <div class="floor">
        	<h1>看房团火热报名中</h1>
        	<div class="baoming">
                <div class="cover"><img class="lazy" data-original="<?php echo ImageTools::fixImage($newKan->image); ?>"></div>
                <div class="info">
                    <h3><?=$newKan['title']?></h3>
                    <p><em><?=$newKan->getKanNum(); ?></em> 人已报名</p>
                    <p>报名截止时间：<em><?php echo date('Y-m-d',$newKan->expire)?></em></p>
                </div>
                <a href="<?php echo $this->createUrl('/wap/order/form', array('spm'=>OrderExt::generateSpm('看房团',$newKan), 'title'=>$newKan->title, 'plotName'=>$plot->title)); ?>" class="bm-btn">我要报名</a>
            </div>
        </div>
        <?php }?>
    <?php if($special):?>
        <div class="floor">
        	<h1>特价房</h1>
        	<div class="tjf-list">
		       <ul class="tjf-container">
               <?php foreach ($special as $key => $value): ?>
                   <li>
                        <a href="<?php echo $this->createUrl('/wap/special/detail', ['id'=>$value->id]); ?>">
                            <div class="fang-village">
                                <div class="pic">
                                    <img class="lazy" data-original="<?php echo ImageTools::fixImage($value['image']); ?>" alt="" />
                                    <div class="cx-news">劲省<?=round($value['price_old']-$value['price_new'],1); ?>万</div>
                                </div>
                                <div class="info">
                                    <div class="name"><h2 class="fs16"><?=$value->plot ? $value->plot->title : '-'; ?></h2><?php if($value->plot&&$value->plot->unit==1): ?><span>均价<?=PlotPriceExt::getPrice($value->plot->price,$value->plot->unit)?></span><?php endif; ?></div>
                                    <p class="fs14"><?=$value['room']?>&#160;&#160;<?=$value['bed_room']?>&#160;&#160;<?=$value['size']?>㎡</p>
                                    <p><strong class="oprice">¥<?=$value['price_new']?>万元/套</strong><del>￥<?=$value['price_old']?>万</del></p>
                                    <!-- <i class="goarrow iconfont">&#x1020;</i> -->
                                </div>
                            </div>
                        </a>
                    </li>
               <?php endforeach; ?>

		        </ul>
                <?php if($totalSpecial>3):?>
		        <div class="change-box"><a href="" class="change-btn" data-url="<?php echo $this->createUrl('AjaxGetSpecial',array('id'=>$this->plot->id))?>" data-template="tjfList" data-container="tjf-container">换一换</a><a href="<?php echo $this->createUrl('/wap/special/index'); ?>">查看更多</a></div>
            <?php endif;?>
		    </div>
        </div>
    <?php endif; ?>
        <div class="floor">
        	<h1>价格趋势</h1>
        	<div class="qushi-title">本月楼盘价格<em>6877</em>元/平 对比上月持平</div>
        	<div class="qushi" data-url="<?=$this->createUrl('AjaxJiage',array('hid'=>$this->plot->id))?>">

        	</div>
        </div>
            <?php if(SM::adviserConfig()->enable() && $comment): ?>
        <div class="floor">
        	<h1 class="mb-0"><?=$this->t('房大白')?>点评</h1>
            <div class="fangdabai">
                <div class="dianping-list">
    		        <dl>
    		            <dt>
    		                <a href="<?=$this->createUrl('/wap/adviser/staff',['id'=>$comment->staff->id]); ?>"><img class="lazy" data-original="<?php echo ImageTools::fixImage($comment->staff->avatar); ?>"></a>
    		                <p><?=$comment->staff->name?></p>
    		                <p><?=$comment->staff->job?></p>
    		            </dt>
    		            <dd><?=$comment->content?></dd>
    		        </dl>
    		    </div>
                <a href="<?php echo $this->createUrl('/wap/plot/comment',['py'=>$plot->pinyin]); ?>" class="more">查看其他分析师的犀利点评<i class="iconfont">&#x1020;</i></a>
            </div>
        </div>
            <?php endif; ?>
            <?php if($totalHuxing):?>
        <div class="floor">
        	<h1>户型(<?=$totalHuxing?>)</h1>
        	<a href="<?=$this->createUrl('/wap/plot/huxingDetail',['py'=>$this->plot->pinyin,'id'=>$huxing->id]); ?>" class="huxing">
        		<div class="cover"><img class="lazy" data-original="<?php echo ImageTools::fixImage($huxing->image); ?>"></div>
        		<div class="info">
        			<p>户型：<?=$huxing['bedroom']?>室<?=$huxing['livingroom']?>厅<?=$huxing['bathroom']?>卫<?=$huxing['cookroom']?>厨</p>
        			<p>面积：<?=$huxing->size?>m²</p>
        			<p>参考价：<em><?=$huxing->price?></em>万</p>
        			<p>开盘：（<?php echo $huxing->getSaleStatus($huxing['sale_status'])?>）</p>
        		</div>
        		<a href="<?=$this->createUrl('/wap/plot/huxingList',['py'=>$plot->pinyin]); ?>" class="more">查看全部户型<i class="iconfont">&#x1020;</i></a>
        	</a>
        </div>
        <?php endif; ?>
        <?php if($periods):?>
        <div class="floor">
        	<h1 class="loudong">楼栋信息</h1>
        	<div class="loudong">
        		<!-- 滑动菜单开始 -->

	            <div class="menu-slide-loudong" id="menu_slide_loudong">
	                <ul class="swiper-wrapper">
                    <?php foreach ($periods as $key => $value) {?>
                       <li class="swiper-slide"><a href="" data-url="<?=$this->createUrl('ajaxGetBuilding',array('id'=>$value['id']))?>" class="on"><?=$value['period']?>期</a></li>
                    <?php }?>
	                </ul>
	            </div>
	            <!-- 滑动菜单结束 -->
                <div class="loudong-wapper">
		            <div id="draggable">
		            	<div class="drag-warp">
			            	<div class="img"><img src=""></div>
			            	<div class="infos"></div>
		            	</div>
		            </div>
	            </div>
        	</div>
        	<a href="<?php echo $this->createUrl('building',array('py'=>$this->plot->pinyin))?>" class="ld-more"><i class="iconfont">&#x1020;</i></a>
        </div>
        <?php endif; ?>

        <div class="floor">
        	<h1>周边配套</h1>
        	<div class="slider-peitao">
        		<ul class="swiper-wrapper">
        			<li class="swiper-slide">
                        <a href="<?=$this->createUrl('/wap/plot/around',array('py'=>$this->plot->pinyin,'index'=>0))?>">
            				<h2>交通</h2>
            				<p>1公里以内的公交设施</p>
            				<div class="cover"><img src="<?=Yii::app()->theme->baseUrl?>/static/wap/images/248x154.jpg"></div>
                        </a>
        			</li>

        			<li class="swiper-slide">
                        <a href="<?=$this->createUrl('/wap/plot/around',array('py'=>$this->plot->pinyin,'index'=>1))?>">
                            <h2>教育</h2>
            				<p>1公里以内的学校</p>
            				<div class="cover"><img src="<?=Yii::app()->theme->baseUrl?>/static/wap/images/248x154_2.jpg"></div>
                        </a>
        			</li>

        			<li class="swiper-slide">
                        <a href="<?=$this->createUrl('/wap/plot/around',array('py'=>$this->plot->pinyin,'index'=>2))?>">
            				<h2>餐饮</h2>
            				<p>1公里以内的餐饮服务</p>
            				<div class="cover"><img src="<?=Yii::app()->theme->baseUrl?>/static/wap/images/248x154_3.jpg"></div>
                        </a>
        			</li>

        			<li class="swiper-slide">
                        <a href="<?=$this->createUrl('/wap/plot/around',array('py'=>$this->plot->pinyin,'index'=>3))?>">
            				<h2>健康</h2>
            				<p>1公里以内的公共设施</p>
            				<div class="cover"><img src="<?=Yii::app()->theme->baseUrl?>/static/wap/images/248x154_4.jpg"></div>
                        </a>
        			</li>
                    <li class="swiper-slide">
                        <a href="<?=$this->createUrl('/wap/plot/around',array('py'=>$this->plot->pinyin,'index'=>4))?>">
                            <h2>生活</h2>
                            <p>1公里以内的生活配套</p>
                            <div class="cover"><img src="<?=Yii::app()->theme->baseUrl?>/static/wap/images/248x154_5.jpg"></div>
                        </a>
                    </li>
        		</ul>
    		</div>
        </div>
    <?php if($news): ?>
        <div class="floor">
        	<h1 class="mb-0">楼盘资讯 (<?=$totalNews?>)</h1>
        	<ul class="list-zixun">
            <?php $i = 0; foreach ($news as $key => $value) {?>
                <li>
                    <a href="<?php echo $this->createUrl('/wap/news/detail',['id'=>$value->id])?>">
                        <h2><span class="tag-<?php $cl = ['green','blue'];echo $cl[$i%2];?>"><?=$value->cate->name?></span><?=Tools::substr($value->title,14,'..');?></h2>
                        <p><?=Tools::u8_title_substr($value->getDescription(),92)?></p>
                        <!-- <i class="iconfont">&#x1020;</i> -->
                    </a>
                </li>
            <?php $i++;}?>
        	</ul>
        	<a href="<?php $ct = ArticleCateExt::model()->find(array('condition'=>'pinyin="xfdg"'));  echo $this->createUrl('/wap/news/index',['hid'=>$this->plot->id])?>" class="more">查看全部楼盘资讯<i class="iconfont">&#x1020;</i></a>
        </div>
    <?php endif;?>
    <?php if($ask): ?>
        <div class="floor" id="ask">
        	<h1>网友问答与点评 (<?=$totalAsk?>)</h1>
        	<div class="wenda">
        		<form method="post" action="" class="wendaForm" onSubmit="return false;">
        		<div class="wenda-form">
        			<a href="<?=$this->createUrl('wenda/ask',['hid'=>$this->plot->id])?>"><input type="text" datatype="*1-50" nullmsg="内容不能为空" errormsg="字数不能超过255个字符" sucmsg=" " class="iconfont" placeholder="&#x1002; 我也来说两句，限255字"></a>
                    <input type="hidden" value="<?=$this->plot->id?>"></input>
        			<!-- <input type="button" id="btn_sub" class="btn-submit" value="提交"></input> -->
        		</div>
        		<div class="error-msg"></div>
        		</form>
    			<ul class="wenda-list">
                <?php foreach ($ask as $key => $value) {?>
                    <li>
                        <a href="<?=$this->createUrl('/wap/wenda/detail', ['id'=>$value->id]); ?>">
                            <p><?=$value['question']?></p>
                            <span class="author"><?=$value->username?$value->username:'游客'; ?></span>
                            <span class="date"><?=date('Y-m-d H:i',$value['reply_time'])?></span>
                        </a>
                    </li>
                <?php }?>
    			</ul>
                <a href="<?php echo $this->createUrl('/wap/wenda/index/',['hid'=>$this->plot->id])?>" class="more">查看全部楼盘问答<i class="iconfont">&#x1020;</i></a>
        	</div>
        </div>
    <?php endif;?>
    <?php if($relPlots): ?>
        <div class="floor">
        	<h1 class="mb-0">对此感兴趣的人还浏览了</h1>
        	<ul class="house-list border-n">
            <?php foreach ($relPlots as $key => $value) {?>
                <li>
                    <a href="<?php echo $this->createUrl('/wap/plot/index',array('py'=>$value->pinyin))?>">
                        <div class="cover">
                            <img class="lazy" data-original="<?php echo ImageTools::fixImage($value->image); ?>">
                            <?php if(isset($value->red)):?><div class="active"></div><?php endif;?>
                        </div>
                        <div class="info" href="<?php echo $this->createUrl('/wap/plot/index',array('py'=>$value->pinyin))?>">
                            <div class="info-left">
                                <h2><?=$value['title']?></h2>
                                <?php
                                $des = '';
                                if(isset($value->red)&&$value->red)
                                {
                                    $des = $value->red->title;
                                }
                                else if(isset($value->discount)&&$value->discount)
                                {
                                    $des = $value->discount->title;
                                }
                                if(!$des):
                                ?>
                                <p class="p3"><?=$value['sale_addr']?></p>
                                <?php else:?>
                                <p class="p1"><?=$value['sale_addr']?></p>
                                <p class="p2"><?=$des?></p>
                                <?php endif;?>
                            </div>
                            <div class="info-right">
                                <em class="price"><?=$value['price']?> 元/㎡</em>
                                <em class="location"><i class="iconfont">&#x1044;</i> 1500米</em>
                            </div>
                            <div class="tags">
                            <?php $i=0; foreach ($value->tags as $key => $tag) { if($i>3) break;?>
                                <i class="<?php $cl = ['green','yellow','pink','blue'];echo $cl[$i%4];?>"><?=$tag['name']?></i>
                            <?php $i++;}?>
                            </div>
                        </div>
                    </a>
                </li>
            <?php }?>
            </ul>
        </div>
    <?php endif;?>
        <div class="disclaimer">
        	免责声明：楼盘信息由开发商提供，最终以政府部门登记备案为准，请谨慎核查。
        </div>
        <?php $this->widget('BottomOperate',['style'=>'ul','plot'=>$plot,'url3'=>$this->createUrl('/wap/adviser/index',['plot'=>$plot->title,'spm'=>OrderExt::generateSpm('预约看房', $plot)])]); ?>
    </div>
    <?php if($this->plot->red):?>
    <div class="hongbao-wapper">
    	<h2>独家现金红包</h2>
    	<p><?=round($this->plot->red->amount); ?>元</p>
    	<i><?php echo($this->plot->red->total_num+$redCount); ?>人已领取</i>

    	<!-- 领取按钮 -->
    	<a href="<?php echo $this->createUrl('/wap/order/form', ['spm'=>OrderExt::generateSpm('楼盘红包',$this->plot->red), 'title'=>$this->plot->red->title]); ?>" class="ok-btn"></a>
    	<!-- 不可领取按钮 -->
    	<!-- <a href="" class="no-btn"></a> -->

    	<!-- 关闭按钮 -->
    	<a href="javascript:;" class="close"></a>
    </div>
    <?php endif;?>
    <div class="share-wapper bdsharebuttonbox" data-tag="share_1">
            <div class="share-btns">
                <div class="share-t">
                    <a class="my_bds_tsina" data-cmd="tsina" href="http://service.weibo.com/share/mobile.php?url=<?=Yii::app()->request->hostInfo.Yii::app()->request->getUrl()?>&type=3&count=&title=<?=Tools::export(Tools::substr(str_replace("\"","'",$this->plot->data_conf['content']),140),'暂无信息')?>&pic=<?=ImageTools::fixImage($this->plot->image)?>&ralateUid=&language=zh_cn&dpc=1&rnd=1465353892908" target="_blank"></a>
                    <p>新浪微博</p>
                </div>
                <div class="share-t">
                    <a class="my_bds_qzone" data-cmd="qzone" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?=Yii::app()->request->hostInfo.Yii::app()->request->getUrl()?>&summary=<?=Tools::export(Tools::substr(str_replace("\"","'",$this->plot->data_conf['content']),140),'暂无信息')?>&title=<?=$this->plot->title?>&pics=<?=ImageTools::fixImage($this->plot->image)?>" target="_blank"></a>
                    <p>QQ空间</p>
                </div>
                <div class="share-t">
                    <a class="my_bds_weixin"></a>
                    <p>微信好友</p>
                </div>
                <a class="close iconfont">&#x2488;</a>
            </div>
            <div class="share-bg"><a class="close-bg iconfont">&#x2488;</a></div>
        </div>
</section>
<!-- 内容结束 -->
<?php $this->renderPartial('/layouts/contact'); ?>
<script type="text/javascript">
    <?php Tools::startJs(); ?>
        Do.ready(function(){
            $("#btn_sub").click(function(){
                $.post('<?=$this->createUrl('/wap/wenda/deal'); ?>', $('.wendaForm').serialize(), function(d){
                    $('.error-msg').html(d.msg);
                });
                return false;
            });
            //首次进入红包显示
            <?php
            /*$cookie = Yii::app()->request->getCookies();
            if(!isset($cookie['plot_red'.$this->plot->pinyin])):
                $cookie = new CHttpCookie('plot_red'.$this->plot->pinyin, 1, ['expire'=>time()+6*3600]);
                Yii::app()->request->cookies['plot_red'.$this->plot->pinyin] = $cookie;*/
            ?>
            //$(".hongbao").click();
            <?php //endif; ?>
        });
    <?php Tools::endJs('js'); ?>
</script>

<script type="text/javascript">
    document.body.className += ' bg-f7';
</script>
