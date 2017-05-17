<?php
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'楼盘信息_'.$this->plot->title.'图片-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($this->plot->title.','.$this->plot->title.'楼盘信息','keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'房产网是最热的'.$this->siteConfig['cityName'].'房产网，是'.$this->siteConfig['cityName'].'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.$this->siteConfig['cityName'].'房地产新闻资讯就上'.$this->siteConfig['siteName'].'房产网。','description');

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/fang.css');
$this->registerHeadJs(['640resize']);
?>
<!--头部 begin-->
<header class="ui-title-bar">
    <a href="<?php echo $this->createUrl('/wap/plot/index',array('py'=>$this->plot->pinyin));?>" class="back"><i class="icon icon-black-arrow"></i></a>
    <h1><?php echo $this->plot->title;?></h1>
    <?php $this->renderPartial('/layouts/nav')?>
</header>
<!--头部 end-->
<!--楼盘库首页-->
<div class="loupanku loupan-detail gw">
    <div class="heading mt50">基本详情</div>
    <div class="baseinfo mb50">
        <p>物业类别：
            <?php foreach($this->plot->wylx as $k=>$v):?>
                <?php echo $v->name;?>
            <?php endforeach;?>
        </p>
        <p>建筑类别：
            <?php foreach($this->plot->jzlb as $k=>$v):?>
                <?php echo $v->name;?>
            <?php endforeach;?>
        </p>
        <p>装修情况：
            <?php foreach($this->plot->zxzt as $k=>$v):?>
                <?php echo $v->name;?>
            <?php endforeach;?>
        </p>
        <p>所属商圈：<?php echo Tools::export($this->plot->streetInfo['name']); ?></p>
        <p>项目地址：<?php echo $this->plot->address; ?></p>
        <p>开盘时间：<?php echo $this->plot->open_time>0?date('Y-m',$this->plot->open_time):'--';?></p>
        <p>交付时间：<?php echo $this->plot->delivery_time>0?date('Y-m',$this->plot->delivery_time):'--';?></p>
        <p>建筑面积：<?php echo Tools::export($this->plot->data_conf['size']);?>平方米</p>
        <p>占地面积：<?php echo Tools::export($this->plot->data_conf['buildsize']);?>平方米</p>
        <p>容积率：<?php echo Tools::export($this->plot->data_conf['capacity']);?></p>
        <p>绿化率：<?php echo Tools::export($this->plot->data_conf['green']);?>%</p>
        <p>物业费：<?php echo Tools::export($this->plot->data_conf['manage_fee']);?>元/平方米/月</p>
        <p>物业公司：<?php echo Tools::export($this->plot->data_conf['manage_company']);?></p>
        <p>开发商：<?php echo Tools::export($this->plot->data_conf['developer']);?></p>
        <p>预售许可证：<?php echo Tools::export($this->plot->data_conf['license']);?></p>
        <p>售楼地址：<?php echo Tools::export($this->plot->sale_addr);?></p>
        <p>交通状况：<?php echo Tools::export($this->plot->data_conf['transit']);?></p>
    </div>
    <div class="heading">项目介绍</div>
    <div class="project-introduce">
        <p><?php echo Tools::export($this->plot->data_conf['content'],'暂无信息');?></p>
    </div>
    <div class="heading mt50">周边配套</div>
    <div class="traffic-state">
        <p><?php echo Tools::export($this->plot->data_conf['peripheral'],'暂无信息');?></p>
    </div>
</div>
