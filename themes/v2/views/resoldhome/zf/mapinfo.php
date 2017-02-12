<div class="common-nav">
    <ul>
        <li class="link on">
            <a href="#content1">房源描述</a>
        </li>
        <li class="link">
            <a href="#content2">房源图片（<?=$this->zf->image_count?>）</a>
        </li>
        <li class="link">
            <a href="#content3">位置及配套</a>
        </li>
        <li class="link">
            <a href="#content4">小区信息</a>
        </li>
    </ul>
</div>
<a id="content1"></a>
<div class="desc">
    <?=$this->zf->content?>
</div>
<a id="content2"></a>
<div class="common-title"><span>房源图片（<?=$this->zf->image_count?>）</span></div>
<div class="desc">
    <?php if($this->zf->images) foreach ($this->zf->images as $key => $value) {?>
        <p><img src="<?=ImageTools::fixImage($value->url,640,400,0)?>"></p>
        <p style="text-align: center;"><?=$value->name?></p>
    <?php }?>
</div>
<a id="content3"></a>
<div class="common-title"><span>位置及配套</span></div>
<div class="desc">
    <p>地 址：<?=$this->zf->address?></p>
    <P>交通状况：<?=$this->zf->plot->data_conf['transit']?></P>
</div>

<div class="map">
    <div class="map-box">
        <div id="ui-map-box" data-lat="<?=$this->zf->plot->map_lat?>" data-lng="<?=$this->zf->plot->map_lng?>"></div>
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
    <a id="content4"></a>
    <div class="common-title"><span>小区信息</span></div>
    <ul class="plot-info clearfix">
        <li class="long"><span>楼盘名称：</span><a href="<?=$this->createUrl('/resoldhome/plot/index',['py'=>$this->zf->plot->pinyin])?>" target="_blank"><?=$this->zf->plot->title?>
                 <?php if($this->zf->areaInfo): ?>
                    （<?=$this->zf->areaInfo->name;?>
                      <?php if($this->zf->streetInfo): ?>
                        <?=$this->zf->streetInfo->name;?>
                      <?php endif; ?>
                     ）
                 <?php endif; ?>
                查看楼盘详情&gt;&gt;</a></li>
        <?php $daily = PlotResoldDailyExt::getLastInfoByHid($this->zf->plot->id);?>
        <li><span>二  手  房：</span><a href="<?=$this->createUrl('/resoldhome/plot/pesflist',['py'=>$this->zf->plot->pinyin])?>" style="color:#d51938;"><?=isset($daily)?$daily->esf_num:'--'?></a>套</li>
        <li><span>租       房：</span><a href="<?=$this->createUrl('/resoldhome/plot/pzflist',['py'=>$this->zf->plot->pinyin])?>" style="color:#d51938;"><?=isset($daily)?$daily->zf_num:'--'?></a>套</li>
        <li><span>物业类型：</span><?=Yii::app()->params->category[$this->zf->category]?></li>
        <li><span>绿  化  率：</span><?=$this->zf->plot->data_conf['green']?>%</li>
        <li><span>物  业  费：</span><?=$this->zf->plot->data_conf['manage_fee']?>元/平米/月</li>
        <li><span>物业公司：</span><?=$this->zf->plot->data_conf['manage_company']?></li>
        <li class="long"><span>开  发  商：</span><?=$this->zf->plot->data_conf['developer']?></li>
    </ul>
</div>
