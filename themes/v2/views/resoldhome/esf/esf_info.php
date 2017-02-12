<div class="common-nav">
    <ul>
        <li class="link on">
            <a href="#content1" >房源描述</a>
        </li>
        <li class="link">
            <a href="#content2">房源图片（<?=$this->esf->image_count?>）</a>
        </li>
        <li class="link">
            <a href="#content3">位置及配套</a>
        </li>
        <?php $plot = $this->esf->plot?>
        <li class="link">
            <a href="#content4">小区信息</a>
        </li>
    </ul>
</div>
<a id="content1"></a>
<div class="desc">
    <p><?=$this->esf->content?></p>
</div>
<a id="content2"></a>
<div class="common-title"><span>房源图片（<?=$this->esf->image_count?>）</span></div>
<div class="desc">
<?php if($this->esf->images) foreach ($this->esf->images as $key => $value) {?>
    <p><img src="<?=ImageTools::fixImage($value->url,640,400,0)?>"></p>
    <p style="text-align: center;"><?=$value->name?></p>
<?php }?>
</div>
<a id="content3"></a>
<div class="common-title"><span>位置及配套</span></div>
<div class="desc">
    <p>地      址：<?=$this->esf->address?></p>
    <P>交通状况：<?=$plot->data_conf['transit']?></P>
</div>
<div class="map">
    <div class="map-box">
        <div id="ui-map-box" data-lat="<?=$plot&&$plot->map_lat?$plot->map_lat:($streetInfo?$streetInfo->map_lat:$areaInfo->map_lat)?>" data-lng="<?=$plot&&$plot->map_lng?$plot->map_lng:($streetInfo?$streetInfo->map_lng:$areaInfo->map_lng)?>"></div>
        <div class="assort-distance  school">
            <div class="close-assort ">
                显<br>示<br>周<br>边<br>配<br>套
            </div>
            <div class="extend-box">
                <h4><span class="detail-ico"></span><i id="bmap-keyword">学校</i><i id="result-count">(20)</i></h4>
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


    <a id="content4"></a>

    <div class="common-title"><span>小区信息</span></div>
    <ul class="plot-info clearfix">
        <li class="long"><span>楼盘名称：</span><a href="<?=$this->createUrl('/resoldhome/plot/index',['py'=>$plot->pinyin])?>" target="_blank"><?=$plot->title?>（<?=$plot->area?$plot->areaInfo->name:''?>  <?=$plot->street?$plot->streetInfo->name:''?>）查看楼盘详情&gt;&gt;</a></li>
        <?php $plotResold = PlotResoldDailyExt::getLastInfoByHid($plot->id);?>
        <li><span>二  手  房：</span><a href="<?=$this->createUrl('/resoldhome/plot/pesflist',['py'=>$plot->pinyin])?>" style="color:#d51938;"><?=$plotResold?$plotResold->esf_num:'--'?></a>套</li>
        <li><span>租       房：</span><a href="<?=$this->createUrl('/resoldhome/plot/pesflist',['py'=>$plot->pinyin])?>" style="color:#d51938;"><?=$plotResold?$plotResold->zf_num:'--'?></a>套</li>
        <li><span>物业类型：</span><?php foreach($plot->wylx as $k=>$v):?>
                <?php echo $v->name;?>
            <?php endforeach;?></li>
        <li><span>绿  化  率：</span><?php echo Tools::export($plot->data_conf['green']);?> %</li>
        <li><span>物  业  费：</span><?php echo Tools::export($plot->data_conf['manage_fee']);?>元/平米/月</li>
        <li><span>物业公司：</span><?php echo Tools::export($plot->data_conf['manage_company']);?></li>
        <li class="long"><span>开  发  商：</span><?php echo Tools::export($plot->data_conf['developer']);?></li>
    </ul>
</div>

<div class="blank20"></div>
<?php if(SM::resoldConfig()->resoldIsOpenPlotTrend()):?>
<div class="price-box-wrapper" data-id="<?=$plot->id?>">
    <p class="price-box"><span><?=$plot->title?>上月均价：</span><em><?=$plot->avg_esf?$plot->avg_esf->price.'</em>元/平方米':'</em>暂无报价'?></p>
    <?php $rate = PlotExt::PlotRate($plot);?>

    <p class="compare"><span class="left <?php if(intval($rate['lastMouthP'])>0):?>up<?php else: ?>down<?php endif;?>">环比上月：<i
            class="iconfont icon-jiantou1"></i><em><?=$rate['lastMouthP']?>%</em></span><span class="<?php if(intval($rate['lastYearP'])>0):?>up<?php else: ?>down<?php endif;?>">同比去年：<i
            class="iconfont icon-jiantou1"></i><em><?=$rate['lastYearP']?>%</em></span></p>
    <div class="blank20"></div>
    <div class="chat-content">
        <div class="common-nav">
            <ul>
                <li class="link on">
                    <a href="javascript:void(0)">本楼盘价格走势</a>
                </li>
                <li class="link">
                    <a href="javascript:void(0)">本区县价格走势</a>
                </li>
                <li class="link">
                    <a href="javascript:void(0)">本市价格走势</a>
                </li>
            </ul>
        </div>
        <div class="chat-box">
            <div class="chat" id="chat-1"></div>
            <div class="chat" id="chat-2"></div>
            <div class="chat" id="chat-3"></div>
        </div>
    </div>
</div>
<?php endif;?>