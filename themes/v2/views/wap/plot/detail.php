<?php
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'楼盘信息-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'楼盘信息','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/wap/style/plot.css'); ?>
    <?php $this->renderPartial('/layouts/header',['title'=>$this->plot->title]) ?>

    <div class="detail-box">
        <p class="s-title">基本详情</p>
        <div class="base-detail">
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

    </div>
    <div class="detail-box">
        <p class="s-title">项目介绍</p>
        <div class="base-detail  plot-info">
            <p><?php echo Tools::export($this->plot->data_conf['content'],'暂无信息');?></p>
        </div>
    </div>
    <div class="detail-box">
        <p class="s-title">周边配套</p>
        <div class="base-detail">
            <p><?php echo Tools::export($this->plot->data_conf['peripheral'],'暂无信息');?></p>
        </div>
    </div>
    <div class="blank20"></div>
<script type="text/javascript">
document.body.className += ' bg-f7';

</script>
