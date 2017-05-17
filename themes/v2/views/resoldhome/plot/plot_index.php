<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/list.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/detail.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/xiaoqu-home.css');
$this->pageTitle = '小区首页';
?>
<?php $this->renderPartial('plot_search')?>
<div class="wapper xiaoqu-head ovisible">

    <?php $this->widget('HomeBreadcrumbs',array('links'=>[$this->plot->title]));?>
    <div class="line"></div>

    <!--  tab切换栏  -->
    <?php $this->renderPartial('plot_naver')?>
</div>
<div class="wrap">
    <div class="index-main">
        <!--  小区详情-->
        <div class="house-box ">
            <img src="<?=ImageTools::fixImage($plot->image,480,320)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic(),480,320)?>'" alt="图片">
            <div class="index-info fl">
                <div>
                    <?php if($plot->avg_esf && $plot->avg_esf->price!==0):?>
                    <p><label>均价：</label><span><b><?=$plot->avg_esf->price?></b>元/㎡</span>
                    </p>
                <?php else:?>
                    <p><label>均价: </label><span><b>暂无</b></span></p>
                <?php endif;?>
                    <p><label>物&nbsp;&nbsp;业&nbsp;&nbsp;费：</label><span><?=isset($plot->data_conf['manage_fee']) && $plot->data_conf['manage_fee']?$plot->data_conf['manage_fee'].'元/平方米·月':'暂无'?></span></p>
                    <p><label>绿&nbsp;&nbsp;化&nbsp;&nbsp;率：</label><span><?=isset($plot->data_conf['green'])?$plot->data_conf['green'].'%':'暂无'?></span></p>
                </div>
                <div>
                    <p><a href="<?=$this->createUrl('/home/plot/price',['py'=>$plot->pinyin])?>">查看房价走势>></a></p>
                    <p><label>建筑年代：</label><span><?=date('Y-m-d',$plot->open_time)?></span></p>
                    <p><label>容 积 率：</label><span><?=isset($plot->data_conf['capacity']) && $plot->data_conf['capacity']?$plot->data_conf['capacity'].'%':'暂无'?></span></p>
                </div>
            </div>
            <div class="index-info fl">
                <p><label>房屋类型：</label><span><?=$jzlb?implode('，',$jzlb):'暂无'?></span></p>
                <p><label>物业公司：</label><span><?=isset($plot->data_conf['manage_company'])?$plot->data_conf['manage_company']:'暂无'?></span></p>
                <p><label>开&nbsp;&nbsp;发&nbsp;&nbsp;商：</label><span><?=isset($plot->data_conf['developer'])?$plot->data_conf['developer']:'暂无'?></span></p>
                <p><label>交通状况：</label><span><?=isset($plot->data_conf['transit'])?$plot->data_conf['transit']:'暂无'?></span></p>
            </div>
            <div class="index-btn fl">
                <a href="<?=$this->createUrl('pesflist',['py'=>$plot->pinyin])?>">出售房源：<b><?=$esfcount?></b>套</a>
                <a href="<?=$this->createUrl('pzflist',['py'=>$plot->pinyin])?>">出租房源：<b><?=$zfcount?></b>套</a>
            </div>
        </div>
        <!--  小区列表  -->
        <?php if($esfs):?>
        <div class="common-title"><span><?=$plot->title?>二手房（<?=$esfcount?>套房源）</span> <em class="more-link"><a href="<?php echo $this->createUrl('pesflist',array('py'=>$this->plot->pinyin))?>">
            查看更多房源&nbsp;&nbsp;></a></em></div>
        <div class="fang-list long-list">
            <ul>
                <?php
                    foreach($esfs as $key=>$value):

                ?>

                <li>
                    <a href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$value->id])?>" target="_blank">
                        <div class="pic">
                            <img src="<?=ImageTools::fixImage($value->image,200,150)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic(),200,150)?>'" alt="">
                        </div>
                        <div class="info">
                            <div class="h-title"><span><?=$value->title?></span></div>
                            <div class="aside">
                                <div class="cate"><?=$value->bedroom?>室<?=$value->livingroom?>厅</div>
                                <div class="area"><?=$value->size?>m²</div>
                                <div class="price"><?=Tools::FormatPrice($value->price,'</em>万')?></div>
                            </div>
                        </div>
                    </a>
                </li>
            <?php endforeach;?>
            </ul>
        </div>
    <?php endif;?>
    <?php if($zfs):?>
        <div class="common-title"><span><?=$plot->title?>租房（<?=$zfcount?>套房源）</span><em class="more-link"><a href="<?php echo $this->createUrl('pzflist',array('py'=>$this->plot->pinyin))?>"> 查看更多房源&nbsp;&nbsp;></a></em>
        </div>
        <div class="fang-list long-list">
            <ul>
                <?php foreach($zfs as $key=>$value):?>
                <li>
                    <a href="<?=$this->createUrl('/resoldhome/zf/info',['id'=>$value->id])?>" target="_blank">
                        <div class="pic">
                            <img src="<?=ImageTools::fixImage($value->image,200,150)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic(),200,150)?>'" alt="">
                        </div>
                        <div class="info">
                            <div class="h-title"><span><?=$value->title?></span></div>
                            <div class="price"><?=Tools::FormatPrice($value->price,'</em>元/月')?></div>
                        </div>
                    </a>
                </li>
            <?php endforeach;?>
            </ul>
        </div>
    <?php endif;?>
        <div class="common-title">
            <span>小区图册</span>
            <ul class="pic-more-link">
                <li><a href="<?php echo $this->createUrl('album',array('py'=>$this->plot->pinyin))?>">全部</a></li>
                <?php
                if($imgcate):
                    foreach($imgcate as $key=>$value):
                        if(isset($cate[$value->type])):
                ?>
                <li><a href="<?php echo $this->createUrl('/resoldhome/plot/album',array('py'=>$this->plot->pinyin,'t'=>$value->type))?>" target="_blank"><?php echo $cate[$value->type]?>(<?=$value->count?>)</a></li>
                <?php
                        endif;
                    endforeach;
                endif;
                ?>
                <li class="more-album"><a href="<?php echo $this->createUrl('album',array('py'=>$this->plot->pinyin))?>">更多相册&nbsp;&nbsp;></a></li>
            </ul>
        </div>
        <!--  小区图册  -->
        <div class="house-list house-img">
            <?php
            if($ablum):
                foreach($ablum as $k=>$v):
            ?>
            <div class="list-box <?php if($k==2):?>last-list-box<?php endif;?>">
                <a href="<?=$this->createUrl('image',['py'=>$this->plot->pinyin,'pid'=>$v->id])?>"><img src="<?=ImageTools::fixImage($v->url,360,270)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic(),360,270)?>'" alt="图片"></a>
                <p><?php echo $v->title!=''?$v->title:$this->plot->title.$cate[$v->type];?></p>
            </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>
        <div class="blank20"></div>
        <!--  地图  -->
        <div class="map">
            <div class="common-title"><span>位置及配套</span>
            </div>
            <div class="blank20"></div>
            <div class="map-box">
                <div id="ui-map-box" data-lat="<?=$this->plot->map_lat?>" data-lng="<?=$this->plot->map_lng?>"></div>
                <div class="assort-distance  school">
                    <div class="close-assort ">
                        显<br>示<br>周<br>边<br>配<br>套
                    </div>
                    <div class="extend-box">
                        <h4><span class="detail-ico"></span><i id="bmap-keyword">学校</i><i id="result-count">(20)</i>
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
        <div class="common-title"><span>周边小区</span><em class="more-link"><a href="<?=$this->createUrl('list',['street'=>$this->plot->street])?>"> 查看更多房源&nbsp;&nbsp;></a></em></div>

        <div class="fang-list long-list">
            <ul>
                <?php if($zbplots){
                    foreach($zbplots as $key=>$value){
                    ?>
                <li>
                    <a href="<?=$this->createUrl('index',['py'=>$value->pinyin])?>" target="_blank">
                        <div class="pic">
                            <img src="<?=ImageTools::fixImage($value->image,200,150)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic(),200,150)?>'" alt="">
                        </div>
                        <div class="info">
                            <div class="h-title"><span><?=$value->title?></span></div>
                            <div class="price"><?=$value->avg_esf?$value->avg_esf->price.'元/㎡':'暂无'?></div>
                        </div>
                    </a>
                </li>
                <?php }} ?>
            </ul>
        </div>
        <!--你可能感兴趣的房源-->
        <!-- <div class="common-title"><span>您可能感兴趣的房源</span></div>
        <div class="fang-list long-list">
            <?php $this->widget('ViewRecordWidget',['url'=>'/resoldhome/esf/info','cssType'=>4,'type'=>1,'category'=>1,'limit'=>5])?>
        </div> -->
        <div class="shengming">
            <p><strong>免责声明：</strong><?=SM::resoldConfig()->resoldPCFreeStatement()?SM::resoldConfig()->resoldPCFreeStatement():'房源信息有网站用户提供、其真实性、合法性由信息提供者负责，最终以政府部门登记备案为准，本网站不声明或保证内容之正确性和可靠行，购买该房屋时，请谨慎核查，如该房源信息有误，您可以投诉此房源信息或拨打举报电话：0519-83022322'?>
            </p>
        </div>
    </div>
</div>
