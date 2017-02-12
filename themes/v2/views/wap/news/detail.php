<?php
$this->pageTitle = $news->title.'_'.$news->cate->name.'_'.SM::urmConfig()->cityName().'房产资讯-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($news->cate->name.'，'.SM::GlobalConfig()->siteName().'房产，'.SM::urmConfig()->cityName().'房产网，'.SM::urmConfig()->cityName().'房产信息网','keywords');
Yii::app()->clientScript->registerMetaTag($news->getDescription(),'description');
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/news.css" media="all" />

<?php $this->renderPartial('/layouts/header',['title'=>'资讯详情','bc'=>true]) ?>
<?php $this->widget('WapAdWidget', ['position' => 'wapzxsq'])?>
<div class="content-box detail-box">
    <div class="detail-title">
        <h3><?=$news['title']?></h3>
        <p>
            <?php if(in_array('1', $news->cate->config)): ?>
            <?=date('Y-m-d',$news->show_time)?>
            <?php endif; ?>
            <?php if(in_array('16', $news->cate->config)): ?>
                &nbsp;|&nbsp;点击次数：<?=$news->hits?>
            <?php endif; ?>
            <?php if(in_array('8', $news->cate->config)): ?>
                &nbsp;|&nbsp;作者：<?php echo $news->author; ?>
            <?php endif; ?>
            <?php if(in_array('4', $news->cate->config) && $news->source): ?>
                &nbsp;|&nbsp;来源：<?php echo $news->source;?>
            <?php endif; ?>
        </p>
    </div>
    <div class="detail-content">
        <p><?=$news['content']?></p>
    </div>
    <div class="kanfang-box">
        <div class="kanfang-title"><span><i class="icon-kanfang"></i>立即报名 <?=$this->t('房大白')?> 1对1全程带你看房</span></div>
        <form id="validform" onSubmit="return false;">
            <div class="">
                <p class="eye">姓名：<input type="text" placeholder="请输入姓名" datatype="*" nullmsg="*请正确填写姓名" name="name" /></p>
                <p class="error-txt"></p>
            </div>
            <div class="">
                <p class=eye>手机号：<input type="tel" placeholder="请输入您的手机号码" class="text" datatype="m" nullmsg="*请输入您的手机号码" errormsg="*手机号码格式错误" name="phone"></p>
                <p class="error-txt"></p>
            </div>
            <?php echo CHtml::hiddenField('spm', OrderExt::generateSpm('购房资讯', $news)); ?>
            <input type="submit" value="立即报名"  class="btn" />

        </form>
    </div>
    <?php if(strpos($_SERVER['HTTP_USER_AGENT'],"MicroMessenger") && SM::globalConfig()->weixinQrCode()): ?>
    <div class="erwei-box">
        <div class="erwei"><img src="<?php echo ImageTools::fixImage(SM::globalConfig()->weixinQrCode()); ?>"></div>
        <p>长按识别上方二维码关注<?php echo SM::GlobalConfig()->siteName(); ?>房产微信<br>
    获取更多优惠信息</p>
    </div>
    <?php endif; ?>
   <!--  <div class="share-box">
        <span class="fl">分享到：</span>
        <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
    </div> -->

</div>
<div class="blank20"></div>
<div class="about">
    <p>相关推荐</p>
    <ul>
    <?php foreach ($recom_news as $key => $value) {
        if($value['id']!=$news['id']){?>
       <li><i></i><a href="<?php echo $this->createUrl('detail',array('id'=>$value['id']));?>"><?=$value['title']?></a></li>
    <?php }
     }?>
    </ul>
</div>


<div class="blank20"></div>
<script type="text/javascript">
    <?php Tools::startJs(); ?>
    Do.ready(function(){
        $('.btn').click(function(){
            $.post('<?php echo $this->createUrl('/api/order/ajaxSubmit'); ?>', $('#validform').serialize(),function(d){
                $("#form-result").html(d.msg);
            });
        });
    });
    <?php Tools::endJs('js'); ?>
</script>
