<?php
$this->pageTitle = SM::urmConfig()->cityName().'房产问答_'.SM::urmConfig()->cityName().'买房问题-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产，'.SM::urmConfig()->cityName().'房产网，'.SM::urmConfig()->cityName().'房产信息网，'.SM::GlobalConfig()->siteName().'，'.SM::urmConfig()->cityName(),'keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/search.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/plot.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/qa.css" media="all" />

<?php $this->renderPartial('/layouts/header',['title'=>!isset($hid)?'问答首页':'网友点评与问答('.$count.')条']) ?>

<?php if(!isset($hid)):?>
<div class="content-box">
    <div class="pt20 pb20">
        <div class="knowledge-search">
        <form id="search-school" action="<?=$this->createUrl('index',['sort'=>isset($sort)&&$sort?$sort:'created','cid'=>$cid])?>">
            <input type="text" name="kw" placeholder="请输入问答关键字" value="<?=$kw?$kw:''?>">
            <a href="" onclick="document.getElementById('search-school').submit();return false;" class="iconfont search-btn">&#x1014;</a>
        </form>
        </div>
    </div>
</div>
<div class="pr clearfix ui-tab">
    <ul class="ui-menu ">
        <li>
            <span><?php $ar = ['created'=>'最新排序','views'=>'热门排序']; echo $sort?$ar[$sort]:'排序';?></span>
            <i class="iconfont">&#x2035;</i>
        </li>
        <li>
            <span><?php if($cid){ $wd = AskCateExt::model()->findByPk($cid);echo $wd->name;}else echo '分类';?></span>
            <i class="iconfont">&#x2035;</i>
        </li>
    </ul>
    <div class="ui-submenu" >
        <ul class="ui-long">
            <li class="<?=$sort=='created'?'ui-active':''?>"><a href="<?=$this->createUrl('index',array('sort'=>'created','cid'=>$cid,'kw'=>$kw))?>"><em>最新排序</em><i class="iconfont">&#x2571;</i></a></li>
            <li class="<?=$sort=='views'?'ui-active':''?>"><a href="<?=$this->createUrl('index',array('sort'=>'views','cid'=>$cid,'kw'=>$kw))?>"><em>热门排序</em><i class="iconfont">&#x2571;</i></a></li>
        </ul>
    </div>
    <div class="ui-submenu">
        <ul class="ui-type-two">
        <li class="<?=isset($cid)&&$cid==0?'ui-active':''?>">
            <a href="">全部问答</a>
            <ul class="ui-long">
               <li><a href="<?=$this->createUrl('index',array('cid'=>0,'sort'=>$sort?$sort:'created','kw'=>$kw))?>"><em>全部问答</em><i class="iconfont">&#x2571;</i></a></li>
            </ul>
        </li>
        <?php if($cate) foreach ($cate as $key => $fcate) {?>
            <li class=""><a href=""><?=$fcate['name']?></a>
            <?php if(isset($fcate['childs']) && $fcate['childs']):?>
                <ul class="ui-long">
                <li class="<?=$cid==$fcate['id']?'ui-active':''?>"><a href="<?=$this->createUrl('index',array('cid'=>$fcate['id'],'sort'=>$sort?$sort:'created','kw'=>$kw))?>"><em>不限</em><i class="iconfont">&#x2571;</i></a></li>
               <?php foreach ($fcate['childs'] as $key => $scate) {?>
                <li class="<?=$cid==$scate['id']?'ui-active':''?>"><a href="<?=$this->createUrl('index',array('cid'=>$scate['id'],'sort'=>$sort?$sort:'created','kw'=>$kw))?>"><em><?=$scate['name']?></em><i class="iconfont">&#x2571;</i></a></li>
                <?php }?>
                </ul>
        <?php endif;?>
         </li>
        <?php }?>
        </ul>
    </div>
</div>
<?php endif;?>
<div class="mask"></div>
<div class="blank20"></div>
<div class="">
    <div class="loupan-wenda-list dropload" data-url='<?=!isset($hid)?$this->createUrl('AjaxGetWendas',array('sort'=>$sort?$sort:'created','cid'=>$cid,'kw'=>$kw)):$this->createUrl('AjaxGetWendas',array('hid'=>$hid))?>' data-template='qaList'>
        <div class="more-list">

        </div>
    </div>
</div>
<a href="<?=$this->createUrl('ask',isset($hid)?['hid'=>$hid]:[])?>"><div class="btn-ask"></div></a>
<!--
<div class="fc-guwen">
    <span>房产顾问团快速帮你解答</span>
    <a href="" class="fr">我要咨询</a>
</div> -->
<script type="text/javascript">
    <?php Tools::startJs(); ?>
        Do.ready(function(){
            $("#btn_sub").click(function(){
                $.post('<?=$this->createUrl('/wap/wenda/deal'); ?>', $('form').serialize(), function(d){
                    $('.error-msg').html(d.msg);
                });
                return false;
            });
        });
    <?php Tools::endJs('js'); ?>
</script>
