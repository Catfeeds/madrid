<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/plot.css');
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'楼盘信息_'.$this->plot->title.'图片-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($this->plot->title.','.$this->plot->title.'楼盘信息','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().'房产网。','description');
?>
<div class="wapperout">
    <div class="wapper">
        <div class="p_current fs14">当前位置：
            <a href="/"><?php echo SM::urmConfig()->cityName().'房产'?></a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list');?>"><?php echo SM::urmConfig()->cityName()?>新房</a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list',array('place'=>$this->plot->area));?>"><?php echo isset($this->siteArea[$this->plot->area])?$this->siteArea[$this->plot->area]:'';?>楼盘</a>&gt;
            <a href="<?=$this->createUrl('index',['py'=>$this->plot->pinyin])?>"><?php echo $this->plot->title;?></a>&gt;<span id="plot-nav">详情</span>
        </div>
    </div>
</div>

<?php $this->renderPartial('plot_naver')?>
<div class="wapper">
<div class="plot-detail-l">
    <div class="gray-bg plot-detail-box">
        <dl class="items">
            <dt>楼盘名称</dt>
            <dd><?php echo $this->plot->title;?>
                <?php if($this->plot->data_conf['recordname']):?>
                <span class="c-g9 fs14 ml5">(备案名：<?php echo $this->plot->data_conf['recordname']?>)</span>
                <?php endif;?>
            </dd>
        </dl>
        <dl class="items">
            <dt>参考售价</dt>
            <dd class="first-dd"><?php if($this->plot->price):?><span class="c-red fs30"><?php echo $this->plot->price;?></span><?php echo PlotPriceExt::$unit[$this->plot->unit];?><?php else:?><span class="c-red fs30">暂无报价</span><?php endif;?> </dd>
            <dd><a href="<?php echo $this->createUrl('/home/plot/price',array('py'=>$this->plot->pinyin));?>" class="icon-link old-price"><em class="plot-ico"></em>历史价格</a></dd>
        </dl>
        <dl class="items">
            <dt>优惠信息</dt>
            <dd class="first-dd"><?php echo $this->plot->newDiscount['title']?'<span class="c-red">'.$this->plot->newDiscount['title']:'<span>暂无优惠信息';?></span></dd>
            <dd><a href="" class="icon-link de-notice k-dialog-type-1" data-title="[优惠通知]<?php echo $this->plot->title; ?>" data-spm="<?php echo OrderExt::generateSpm('优惠通知',$this->plot); ?>"><em class="plot-ico"></em>优惠通知我</a></dd>
        </dl>
        <dl class="items">
            <dt>楼盘地址</dt>
            <dd><?php echo $this->plot->address;?></dd>
        </dl>
        <dl class="items">
            <dt>特色标签</dt>
            <dd>
                <ul class="advantage-tag">
                    <?php foreach($this->plot->xmts as $k=>$v):?>
                        <li><?php echo $v->name;?></li>
                    <?php endforeach;?>
                </ul>
            </dd>
        </dl>
    </div>
    <div class="title-box">
        <h2>基本信息</h2>
    </div>
    <div class="gray-bg p25">
        <table class="basic-info">
            <tr>
                <td>
                    <span>物业类别</span>
                    <?php foreach($this->plot->wylx as $k=>$v):?>
                        <?php echo $v->name;?>
                    <?php endforeach;?>
                </td>
                <td>
                    <span>项目特色</span>
                    <?php foreach($this->plot->xmts as $k=>$v):?>
                        <?php echo $v->name;?>
                    <?php endforeach;?>
                </td>
            </tr>
            <tr>
                <td>
                    <span>建筑类别</span>
                    <?php foreach($this->plot->jzlb as $k=>$v):?>
                        <?php echo $v->name;?>
                    <?php endforeach;?>
                </td>
                <td>
                    <span>装修情况</span>
                    <?php foreach($this->plot->zxzt as $k=>$v):?>
                        <?php echo $v->name;?>
                    <?php endforeach;?>
                </td>
            </tr>
            <tr>
                <td><span>所属商圈</span><?php echo Tools::export($this->plot->streetInfo['name']); ?></td>
                <td><span>项目地址</span><?php echo $this->plot->address; ?></td>
            </tr>
            <tr>
                <td><span>开盘时间</span><?php echo $this->plot->open_time>0?date('Y-m',$this->plot->open_time):'--';?></td>
                <td><span>交付时间</span><?php echo $this->plot->delivery_time>0?date('Y-m',$this->plot->delivery_time):'--';?></td>
            </tr>
            <tr>
                <td><span>建筑面积</span><?php echo Tools::export($this->plot->data_conf['buildsize']);?>平方米 	</td>
                <td><span>占地面积</span><?php echo Tools::export($this->plot->data_conf['size']);?>平方米</td>
            </tr>
            <tr>
                <td><span>容积率</span><?php echo Tools::export($this->plot->data_conf['capacity']);?></td>
                <td><span>绿化率</span><?php echo Tools::export($this->plot->data_conf['green']);?> %</td>
            </tr>
            <tr>
                <td><span>物业费</span><?php echo Tools::export($this->plot->data_conf['manage_fee']);?>元/平方米·月</td>
                <td><span>物业公司</span><?php echo Tools::export($this->plot->data_conf['manage_company']);?></td>
            </tr>
            <tr>
                <td><span>开发商</span><?php echo Tools::export($this->plot->data_conf['developer']);?></td>
                <td><span>代理公司</span><?php echo Tools::export($this->plot->data_conf['agent']);?></td>
            </tr>
            <tr>
                <td><span class="mr20">预售许可证 </span><?php echo Tools::export($this->plot->data_conf['license']);?> 	</td>
                <td><span>售楼地址</span><?php echo Tools::export($this->plot->sale_addr);?></td>
            </tr>
        </table>
    </div>
    <div class="title-box">
        <h2>项目介绍</h2>
    </div>
    <div class="gray-bg p25">
        <div class="introduce-box">
            <?php echo Tools::export($this->plot->data_conf['content'],'暂无信息');?>
        </div>
    </div>
    <div class="title-box">
        <h2>项目配套</h2>
    </div>
    <div class="gray-bg p25">
        <div class="introduce-box">
            <?php echo Tools::export($this->plot->data_conf['peripheral'],'暂无信息');?>
        </div>
    </div>
    <div class="title-box">
        <h2>交通状况</h2>
    </div>
    <div class="gray-bg p25">
        <div class="introduce-box">
            <?php echo Tools::export($this->plot->data_conf['transit'],'暂无信息');?>
        </div>
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
