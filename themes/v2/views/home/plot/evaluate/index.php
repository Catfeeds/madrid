<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/plot.css');
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'评测-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'相册','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');
?>
<div class="wapperout">
    <div class="wapper">
        <div class="p_current fs14">当前位置：
            <a href="/"><?php echo SM::urmConfig()->cityName().'房产'?></a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list');?>"><?php echo SM::urmConfig()->cityName()?>新房</a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list',array('place'=>$this->plot->area));?>"><?php echo isset($this->siteArea[$this->plot->area])?$this->siteArea[$this->plot->area]:'';?>楼盘</a>&gt;
            <a href="<?=$this->createUrl('index',['py'=>$this->plot->pinyin])?>"><?php echo $this->plot->title;?></a>&gt;<span id="plot-nav">评测</span>
        </div>
    </div>
</div>
<?php $this->renderPartial('plot_naver'); ?>
<div class="wapper">
  	<div class="pingce-l">
  		<div class="teacher-box people-info clearfix">
            <div class="pic"><img src="<?php echo $evaluate&&$evaluate->staff?ImageTools::fixImage($evaluate->staff->avatar,120,150):Yii::app()->theme->baseUrl.'/static/wap/images/erweima.jpg'; ?>"></div>
            <div class="detail-r">
                <p class="fl"><span class="name"><?php echo $evaluate?$evaluate->staff->name:'未添加'; ?></span><span class="items"><i class="iconfont v-ico">&#x5364;</i><?php echo $evaluate?$evaluate->staff->job:''; ?></span></p>
                <div class="fr">
                    <?php if($evaluate->staff && $evaluate->staff->qq):?><a href="http://wpa.qq.com/msgrd?v=3&uin=<?=$evaluate->staff->qq?>&site=qq&menu=yes" class="items fl" target="_blank"><i class="iconfont qq-ico">&#x1568;</i>在线咨询</a><?php endif;?>
                    <?php if($evaluate->staff->wx_image):?><a href="javascript:void(0);" class="items weixinex fr"><i class="iconfont weixin-ico">&#x1444;</i>微信联系
                        <div class="weixin-box">
                            <div class="pr">
                                <span class="top-arrow"><span></span></span>
                                <div class="weixin-pop-box">
                                    <p>微信联系，更便捷哦</p>
                                    <img src="<?=ImageTools::fixImage($evaluate->staff->wx_image,100,100)?>">

                                </div>
                            </div>
                        </div>
                    </a><?php endif;?>
                </div>
                <div class="clear"></div>
                <P class="info"><?=$staff['idea']?></P>
				<p class="experience"><span class="zan-click"><i class="iconfont zan-ico">&#x1888;</i><label id="zanshu"><?php echo $evaluate?$evaluate->staff->praise:'-'; ?></label> 个赞</span><span>最近带看：<em><?php echo $evaluate?$evaluate->staff->checkNum:'-'; ?></em></span><span>从业经验：<em><?php echo $evaluate?$evaluate->staff->work_time:'-'; ?></em>年</span></p>
            </div>
        </div>
        <?php $icons = ['huxing'=>'&#x3425;', 'wuye'=>'&#x4898;','peitao'=>'&#x8696;','shequpinzhi'=>'&#x4777;']; ?>
        <div class="pingce-content">
	        <div class="big-title">
	        	<p><?=$this->plot->title?>-评测报告</p>
	        	<ul class="clearfix">
                    <?php $k=1;foreach(PlotEvaluateExt::$contentFields as $name=>$field):if(!$evaluate->{$field}->getIsEmpty()): ?>
                        <li><a href="#pingce<?=$k++;?>"><i class="iconfont huxing-ico1"><?=$icons[$field]; ?></i><?=$name; ?></a></li>
                    <?php endif;endforeach; ?>
	        	</ul>
	        </div>


            <?php $className = ['huxing'=>'huxing-ico2','wuye'=>'wuye-ico2','peitao'=>'peitao-ico2','shequpinzhi'=>'yang-ico2']; ?>

            <?php $k=1;foreach(PlotEvaluateExt::$contentFields as $name=>$field): ?>
                <?php if(isset($evaluate->{$field}) && !$evaluate->{$field}->getIsEmpty()): ?>
                <a id="pingce<?=$k++; ?>"></a>
                <div class="sm-title"><i class="iconfont <?=$className[$field]; ?>"><?=$icons[$field]; ?></i><?=$name?></div>
                <?php foreach($evaluate->{$field}->getContent() as $item): ?>
                    <?php if($item->isTitle): ?>
                    <p class="ss-title"><span><?=$item->text; ?></span></p>
                    <?php else: ?>
                    <div class="detail">
                        <?=$item->text; ?>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>

        </div>
  	</div>
  	<div class="plot-detail-r">

        <div class="gray-bg p10">
            <div class="mod-tuangou ui-mouseenter">
            <?php echo $this->renderpartial('/layouts/hotTuan'); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->footer(); ?>
<script type="text/javascript">
    <?php Tools::startJs(); ?>
    Do.ready(function(){
        $(".zan-click").click(function(){
            $.get("<?php echo $this->createUrl('/home/adviser/praise'); ?>",{sid:<?php echo $staff['id']; ?>},function(d){
                if(d.code>0){
                    $("#zanshu").html(d.msg);
                } else {
//                    alertPop(d.msg);
                }
            },'json');
        });
    });
    <?php Tools::endJs('dianzan'); ?>
</script>
