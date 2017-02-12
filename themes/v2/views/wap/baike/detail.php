<?php
$this->pageTitle = $baike->title.'_'.$baike->cate->name.'_'.SM::urmConfig()->cityName().'房产百科-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($baike->cate->name.'，'.SM::GlobalConfig()->siteName().'房产，'.SM::urmConfig()->cityName().'房产网，'.SM::urmConfig()->cityName().'房产信息网','keywords');
Yii::app()->clientScript->registerMetaTag($baike->description ? $baike->description : Tools::u8_title_substr(strip_tags($baike->content),200),'description');
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/news.css" media="all" />
<?php $this->renderPartial('/layouts/header',['title'=>'知识详情','bc'=>true]) ?>

<div class="content-box detail-box">
    <div class="detail-title">
        <h3><?=$baike['title']?></h3>
        <p><?=date('Y-m-d',$baike['created']);?>  |  点击次数：<?=$baike['scan']?></p>
    </div>
    <div class="detail-content">
        <p><?=$baike['content']?></p>
    </div>
    <div class="pinjias clearfix">
        <div class="box">
            <div id="dianzan" class="<?=($praiseStatus!='praise')?'zan-frame frame':'common-frame frame'?>">
                <i class="iconfont">&#x2589;</i>
                <p>有用(<span id="zanshu"><?=$baike->praise?></span>)</p>
            </div>
        </div>
        <div class="box">
            <div id="fandui" class="<?=($praiseStatus!='oppose')?'bad-frame frame':'common-frame frame'?>">
                <i class="iconfont bad">&#x2589;</i>
                <p>没用(<span id="fanduishu"><?=$baike->oppose?></span>)</p>
            </div>
        </div>
    </div>
    <?php if(strpos($_SERVER['HTTP_USER_AGENT'],"MicroMessenger") && SM::globalConfig()->weixinQrCode()): ?>
    <div class="erwei-box">
        <div class="erwei"><img src="<?php echo ImageTools::fixImage(SM::globalConfig()->weixinQrCode()); ?>"></div>
        <p>长按识别上方二维码关注<?=SM::GlobalConfig()->siteName(); ?>房产微信<br>
获取更多优惠信息</p>
    </div>
<?php endif; ?>

<?php if($baike->getTags()): ?>
    <div class="tags-box">
        <!-- 2016-07-11分享修改成标签调取 -->
        <span class="bdsharebuttonbox">
            <?php
                foreach($baike->getTags() as $k=>$tag){
                    echo CHtml::link($tag, ['/wap/baike/list','tag'=>$tag],['class'=>'color'.($k%4)]),'&nbsp;&nbsp;';
                }
             ?>
        </span>
    </div>
<?php endif; ?>

</div>
<div class="blank20"></div>
<?php if(count($rel_baikes)>1): ?>
<div class="about">
    <p>相关推荐</p>
    <ul>
    <?php foreach ($rel_baikes as $key => $value) {
        if($baike['id'] != $value['id']) { ?>
            <li><i></i><a href="<?php echo $this->createUrl('detail',array('id'=>$value['id']));?>"><?=$value['title']?></a></li>
        <?php }
        }?>
    </ul>
</div>
<?php endif; ?>
<?php
if(strpos($_SERVER['HTTP_USER_AGENT'],"MicroMessenger"))
{
    $wx = $this->beginWidget('WeChat');
    $wx->onMenuShareTimeline(ImageTools::fixImage(SM::wechatConfig()->shareImg()?SM::wechatConfig()->shareImg():$shareImgUrl),$baike['title']);
    $wx->onMenuShareAppMessage(ImageTools::fixImage(SM::wechatConfig()->shareImg()?SM::wechatConfig()->shareImg():$shareImgUrl),$baike['title'],$baike['description']);
    $this->endWidget();
}
?>
<script type="text/javascript">
    <?php Tools::startJs(); ?>
    Do.ready(function(){
        $("#dianzan").click(function(){
            $.get("<?php echo $this->createUrl('/wap/baike/AjaxSetPraise'); ?>",{id:<?php echo $baike->id; ?>,type:'praise'},function(d){
                if(d.code>0){
                    $("#zanshu").html(d.msg);
                    $("#dianzan").removeClass('zan-frame');
                    $("#dianzan").addClass('common-frame');
                } else {
                    alertPop(d.msg);
                }
            },'json');
        });
        $("#fandui").click(function(){
            $.get("<?php echo $this->createUrl('/wap/baike/AjaxSetPraise'); ?>",{id:<?php echo $baike->id; ?>,type:'oppose'},function(d){
                if(d.code>0){
                    $("#fanduishu").html(d.msg);
                    $("#fandui").removeClass('bad-frame');
                    $("#fandui").addClass('common-frame');
                } else {
                    alertPop(d.msg);
                }
            },'json');
        });
    });
    <?php Tools::endJs('dianzan'); ?>
</script>
