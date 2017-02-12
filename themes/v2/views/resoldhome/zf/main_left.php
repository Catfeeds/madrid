<div class="main-right">
    <div class="frame side-box">
        <div class="stitle">
            <span>二手房资讯</span>
        </div>
        <?php $this->widget('RightWidget',['type'=>'news','limit'=>8])?>
    </div>
    <div class="blank20"></div>
    <?php if($this->get['type']==1 && SM::resoldConfig()->resoldIsOpenPlotTrend()):?>
    <div class="frame side-box">
        <div class="stitle">
            <span><?=SM::urmConfig()->cityName()?>二手房价格趋势</span>
        </div>
        <?php $this->widget('RightWidget',['type'=>'pricetrend','limit'=>5])?>
    </div>
    <div class="blank20"></div>

    <div class="frame side-box">
        <div class="stitle">
            <span>最近浏览的房源</span>
        </div>
        <?php $this->widget('ViewRecordWidget',['url'=>'/resoldhome/zf/info','cssType'=>3,'type'=>2,'category'=>1])?>
    </div>
    <div class="blank20"></div>
    <?php endif;?>
    <div class="frame side-box">
        <div class="stitle">
            <span>热门小区</span>
        </div>
        <?php $this->widget('RightWidget',['type'=>'hotplot','limit'=>10])?>
    </div>
    <div class="blank20"></div>

<?php $this->widget('AdWidget',['position'=>'esfycbanner']); ?>
</div>
