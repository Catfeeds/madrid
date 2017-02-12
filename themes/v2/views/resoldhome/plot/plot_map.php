<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/list.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/xiaoqu-public.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/xiaoqu-map.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/detail.css');
$this->pageTitle = '小区地图';
?>
<?php $this->renderPartial('plot_search')?>
<div class="wapper xiaoqu-head ovisible">

        <?php $this->widget('HomeBreadcrumbs',array('links'=>[$this->plot->title=>$this->createUrl('index',['py'=>$this->plot->pinyin]),'地图配套']));?>
        <!--  小区名字  -->
        <div class="line"></div>
        <?php $this->renderPartial('plot_naver')?>
    </div>
    <div class="wapper">
        <div class="main">
        <!--  地图  -->
        <div class="map">
            <div class="map-box">
                <div id="ui-map-box" data-lat="<?=$this->plot->map_lat?>" data-lng="<?=$this->plot->map_lng?>"></div>
                <div class="assort-distance  school">
                    <div class="close-assort ">
                        显<br>示<br>周<br>边<br>配<br>套
                    </div>
                    <div class="extend-box">
                        <h4><span class="detail-ico"></span><i id="bmap-keyword">学校</i><i id="result-count"></i>
                        </h4>
                        <span class="close iconfont">&#xe60e;</span>
                        <ul>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="map-label">
                <ul js="clearSonAttr">
                    <li class="label-one">
                        <a href="javascript:;" class="icon-text">
                            <span class="detail-ico"></span><i search-flag="school">学校</i>
                        </a>
                    </li>
                    <li class="label-two">
                        <a href="javascript:;" class="icon-text">
                            <span class="detail-ico"></span><i search-flag="hospital">医院</i>
                        </a>
                    </li>
                    <li class="label-three">
                        <a href="javascript:;" class="icon-text">
                            <span class="detail-ico"></span><i search-flag="bank">银行</i>
                        </a>
                    </li>
                    <li class="label-four">
                        <a href="javascript:;" class="icon-text">
                            <span class="detail-ico"></span><i search-flag="repast">餐饮</i>
                        </a>
                    </li>
                    <li class="label-five">
                        <a href="javascript:;" class="icon-text">
                            <span class="detail-ico"></span><i search-flag="shopping">购物</i>
                        </a>
                    </li>
                    <li class="label-six">
                        <a href="javascript:;" class="icon-text">
                            <span class="detail-ico"></span><i search-flag="bus">公交</i>
                        </a>
                    </li>
                    <li class="label-seven">
                        <a href="javascript:;" class="icon-text">
                            <span class="detail-ico"></span><i search-flag="park">公园</i>
                        </a>
                    </li>
                    <li class="label-eight">
                        <a href="javascript:;" class="icon-text">
                            <span class="detail-ico"></span><i search-flag="airport">机场</i>
                        </a>
                    </li>
                    <li class="label-nine" style="border-bottom-width: 0px;">
                        <a href="javascript:;" class="icon-text">
                            <span class="detail-ico"></span><i search-flag="refuel">加油站</i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!--  小区图册  -->
        <!-- <div class="common-title">
            <span>小区图册</span>
            <em class="more-link"><a href="<?=$this->createUrl('/resoldhome/esf/list',['hid'=>$this->plot->id])?>"> 查看更多房源&nbsp;&nbsp;></a></em>
            <div>
                <div class="house-list house-img">
                    <?php
                    if($list):
                        foreach($list as $k=>$v):
                    ?>
                    <div class="list-box <?php if(($k+1)%3==0):?>last-list-box<?php endif;?>">
                        <a href="<?=$this->createUrl('image',['py'=>$this->plot->pinyin,'pid'=>$v->id])?>"><img src="<?=ImageTools::fixImage($v->url)?>" alt="图片"></a>
                        <p><?=$v->title?></p>
                    </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div> -->
</div>
</div>
</div>
<div class="blank40"></div>
