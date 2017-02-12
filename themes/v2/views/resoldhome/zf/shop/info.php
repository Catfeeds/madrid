<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/detail.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/iconfont/iconfont.css');
$this->pageTitle = '商铺详情页';
?>

<div class="wapper">
    <div class="detail_l">
        <?php $this->widget('HomeBreadcrumbs',array('links'=>[SM::urmConfig()->cityName().'二手房','租房详情']));?>
        <div class="line"></div>
        <div class="detail-top clearfix">
            <p class="title"><?=$zf->title?></p>
            <div class="clearfix">

                <span class="time">发布时间：<?=date('Y-m-d',$zf->sale_time)?></span>
                <span class="time">浏览量：<?=$zf->hits?></span>
            </div>
            <div class="esf-slider">
                <ul class="bigImg">
                <?php
                if($zf->images):
                    foreach($zf->images as $key=>$value):
                ?>
                <li><a href="" target="_blank"><img src="<?=ImageTools::fixImage($value->url)?>"></a></li>
                <?php
                    endforeach;
                endif;
                ?>
            </ul>
                <div class="smallScroll">
                    <a class="pre-btn" href="javascript:void(0)"><i class="detail-ico"></i></a>
                    <div class="smallImg">
                        <ul>
                            <?php
                            if($zf->images):
                                foreach($zf->images as $key=>$value):
                            ?>
                            <li class=""><a><img src="<?=ImageTools::fixImage($value->url)?>"></a></li>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </div>
                    <a href="javascript:void(0)" class="next-btn "><i class="detail-ico"></i></a>
                </div>
            </div>

            <div class="info rent-info">
                <ul class="info-ul clearfix">
                    <li class="long"><span><em>总</em>价：</span><em><?=$zf->price?></em>万（<?=$zf->wuye_fee?>元/平米·天）</li>
                    <li class="long"><span>建筑面积：</span><?=$zf->size?>m²</li>
                </ul>
                <div class="tel-box">
                    <i class="tel-ico iconfont">&#xe609;</i>
                    <span><?=$zf->phone?><?php if(!$staff):?><em>(业主<?=$esf->username?$esf->username:$esf->account?>)</em><?php endif;?></span>
                </div>
                <p class="promite">联系我时，请说在<?=SM::globalConfig()->siteName()?>二手房看到的</p>
                <ul class="info-ul">
                    <li class="long"><span>楼盘名称：</span><a href="" class="addr"><?=$zf->plot_name?><em>（</em><?=$zf->area?$zf->areaInfo->name:''?> <?=$zf->street?$zf->streetInfo->name:''?><em>）</em><em>[</em>街景地图<em>]</em></a>
                    </li>
                    <li class="long"><span>楼盘地址：</span><?=$plot->address?></li>
                    <li class="left"><span>当前状态：</span><?=isset($conf['esfzfxszt'])?TagExt::getNamebyTag($conf['esfzfxszt']):''?></li>
                    <li><span><em>类</em>型：</span>
                        <?php $conf = CJSON::decode($zf->data_conf);?>
                        <?=isset($conf['esfsplevel'])?TagExt::getNamebyTag($conf['esfsplevel']):''?>
                    </li>

                    <li class="left"><span>物 业 费 ：</span><?=$zf->wuye_fee?>元/平米·月</li>
                    <li><span>所在楼层：</span><?=isset($conf['esffloorcate'])?TagExt::getNamebyTag($conf['esffloorcate']):''?>(共<?=$zf->total_floor?>层)</li>
                    <li class="left"><span><em>装</em>修：</span><?=isset($zf->decoration)?TagExt::getNameByTag($zf->decoration):'未知'?></li>
                    <li class="long"><span>配套设施：</span><?php
                        $tagname = '';
                        if(isset($conf[$ptArr[$zf->category]])){
                            $tagNames = TagExt::getNameByTag($conf[$ptArr[$zf->category]]);
                            foreach($tagNames as $k=>$v){
                                $tagname .= $v .' ';
                            }
                        }
                        echo trim($tagname);
                ?></li>
                    <!--li class="left"><span>建筑年代：</span>暂无资料年</li-->

                    <li class="long"><span>适合经营：</span><?php
                        $jyfw = '';
                        if(isset($conf['zfspkjyxm'])){
                            $tagNames = TagExt::getNameByTag($conf['zfspkjyxm']);
                            foreach($tagNames as $k=>$v){
                                $jyfw .= $v.' ';
                            }
                        }
                        echo $jyfw;
                    ?></li>

                </ul>
                <a href="javascript:void(0)" class="jubao-btn j-report-btn" data-infoid="<?=$zf->id?>" data-infoname="<?=$zf->title?>" data-type="zf"><i class="iconfont">&#xe601;</i>举报虚假</a>
                <a href="javascript:void(0)" class="save-btn j-fav-btn" data-fid="<?=$zf->id?>" data-category="3"><i class="iconfont">&#xe600;</i>收藏房源</a>
            </div>
        </div>
        <div class="blank50"></div>
        <div class="common-nav">
            <ul>
                <li class="link on">
                    <a href="#content1">房源描述</a>
                </li>
                <li class="link">
                    <a href="#content2">房源图片（<?=$zf->image_count?>）</a>
                </li>
                <li class="link">
                    <a href="#content3">位置及配套</a>
                </li>
            </ul>
        </div>
        <a id="content1"></a>
        <div class="desc">
            <?=$zf->content?>
        </div>
        <a id="content2"></a>
        <div class="common-title"><span>房源图片（<?=$zf->image_count?>）</span></div>
        <div class="desc">
            <?php if($zf->images) foreach ($zf->images as $key => $value) {?>
            	<p><img src="<?=ImageTools::fixImage($value->url)?>"></p>
            	<p style="text-align: center;"><?=$value->name?></p>
            <?php }?>
        </div>
        <a id="content3"></a>
        <div class="common-title"><span>位置及配套</span></div>
        <div class="desc">
            <p>地 址：<?=$zf->address?></p>
            <P>交通状况：<?=isset($plot->data_conf['transit'])?$plot->data_conf['transit']:''?></P>
        </div>
        <div class="map">
            <div class="map-box">
                <div id="ui-map-box" data-lat="<?=$plot->map_lat?>" data-lng="<?=$plot->map_lng?>"></div>
                <div class="assort-distance  school">
                    <div class="close-assort ">
                        显<br>示<br>周<br>边<br>配<br>套
                    </div>
                    <div class="extend-box">
                        <h4><span class="detail-ico"></span><i id="bmap-keyword">学校</i><i id="result-count">(20)</i>
                        </h4>
                        <span class="close iconfont">&#xe60e;</span>
                        <ul>
                            <li>
                                <span class="digit">1.</span>
                                <span class="text" title="七里塘小学">七里塘小学</span>
                                <span class="distance">581米</span>
                            </li>
                            <li>
                                <span class="digit">2.</span>
                                <span class="text" title="合肥市第三十中学">合肥市第三十中学</span>
                                <span class="distance">1397米</span>
                            </li>
                            <li>
                                <span class="digit">3.</span>
                                <span class="text" title="合肥市第七十中学">合肥市第七十中学</span>
                                <span class="distance">1924米</span>
                            </li>
                            <li>
                                <span class="digit">4.</span>
                                <span class="text" title="合肥市杏林小学">合肥市杏林小学</span>
                                <span class="distance">1419米</span>
                            </li>
                            <li>
                                <span class="digit">5.</span>
                                <span class="text" title="合肥市临泉路第二小学">合肥市临泉路第二小学</span>
                                <span class="distance">1626米</span>
                            </li>
                            <li>
                                <span class="digit">6.</span>
                                <span class="text" title="安徽神学院">安徽神学院</span>
                                <span class="distance">1152米</span>
                            </li>
                            <li>
                                <span class="digit">7.</span>
                                <span class="text" title="合肥市元一·名城小学">合肥市元一·名城小学</span>
                                <span class="distance">1121米</span>
                            </li>
                            <li>
                                <span class="digit">8.</span>
                                <span class="text" title="兴海苑小学">兴海苑小学</span>
                                <span class="distance"> 506米</span>
                            </li>
                            <li>
                                <span class="digit">9.</span>
                                <span class="text" title="合肥市第七十一中学">合肥市第七十一中学</span>
                                <span class="distance">1115米</span>
                            </li>
                            <li>
                                <span class="digit">10.</span>
                                <span class="text" title="红星路小学北环阳光校区">红星路小学北环阳光校...</span>
                                <span class="distance">1500米</span>
                            </li>
                            <li>
                                <span class="digit">11.</span>
                                <span class="text" title="元一名城小学">元一名城小学</span>
                                <span class="distance"> 1637米</span>
                            </li>
                            <li>
                                <span class="digit">12.</span>
                                <span class="text" title="星火小学">星火小学</span>
                                <span class="distance">1087米</span>
                            </li>
                            <li>
                                <span class="digit">13.</span>
                                <span class="text" title="合肥经济管理学校">合肥经济管理学校</span>
                                <span class="distance"> 2262米</span>
                            </li>
                            <li>
                                <span class="digit">14.</span>
                                <span class="text" title="合肥市兴华苑小学">合肥市兴华苑小学</span>
                                <span class="distance">1846米</span>
                            </li>
                            <li>
                                <span class="digit">15.</span>
                                <span class="text" title="合肥市育才学校">合肥市育才学校</span>
                                <span class="distance">834米</span>
                            </li>
                            <li>
                                <span class="digit">16.</span>
                                <span class="text" title="元一名城幼儿园">元一名城幼儿园</span>
                                <span class="distance"> 1405米</span>
                            </li>
                            <li>
                                <span class="digit">17.</span>
                                <span class="text" title="小森林兴海苑幼儿园">小森林兴海苑幼儿园</span>
                                <span class="distance"> 554米</span>
                            </li>
                            <li>
                                <span class="digit">18.</span>
                                <span class="text" title="东方剑桥幼儿园(龙门岭路)">东方剑桥幼儿园(龙门...</span>
                                <span class="distance"> 1817米</span>
                            </li>
                            <li>
                                <span class="digit">19.</span>
                                <span class="text" title="银河幼儿园">银河幼儿园</span>
                                <span class="distance"> 1053米</span>
                            </li>
                            <li>
                                <span class="digit">20.</span>
                                <span class="text" title="金摇篮幼儿园">金摇篮幼儿园</span>
                                <span class="distance"> 763米</span>
                            </li>
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
            <!--a id="content4"></a>
            <div class="common-title"><span>小区信息</span></div>
            <ul class="plot-info clearfix">
                <li class="long"><span>楼盘名称：</span><a href="" target="_blank">香江华廷（钟楼 永红）查看楼盘详情&gt;&gt;</a></li>
                <li><span>二  手  房：</span>619套</li>
                <li><span>租       房：</span>619套</li>
                <li><span>物业类型：</span>住宅</li>
                <li><span>绿  化  率：</span>35.00%</li>
                <li><span>物  业  费：</span>1.25元/平米/月</li>
                <li><span>物业公司：</span>中房物业公司</li>
                <li class="long"><span>开  发  商：</span>常州市康桥房地产开发有限公司(中房股份)</li>
            </ul>
            <p class="price-box"><span>香江华庭本月均价：</span><em>8900</em>元/平方米<a href="">查看价格走势&gt;&gt;</a></p>
            <p class="compare"><span class="left up">环比上月：<i
                    class="iconfont icon-jiantou1"></i><em>0.88%</em></span><span class="down">同比去年：<i
                    class="iconfont icon-jiantou1"></i><em>0.88%</em></span></p-->
        </div>
        <!--div class="blank20"></div>
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
        </div-->
    </div>
    <div class="detail_r">
        <a class="erweima-btn">
            <i class="detail-ico"></i>
            <div class="erweima-expand">
                <div class="erweima-box">
                    <img src="<?php echo $this->createUrl('/api/image/qrcode',['data'=>$this->createAbsoluteUrl('www.baidu.com')]); ?>">
                    <p>扫描二维码获取房源信息</p>
                </div>
            </div>
        </a>
        <div class="share-btn"><i class="detail-ico"></i>分享</div>
        <div class="blank10"></div>
        <?php if($staff):?>
        <div class="publisher-box">
            <div class="people"><a href="" target="_blank"><img src="<?=ImageTools::fixImage($staff?$staff->image:$user['icon'])?>"><?=$zf->username?$zf->username:$zf->account?></a></div>
            <div class="renzheng">
                <em>认证：</em><?php if($staff->id_card): ?><span><i class="detail-ico sfz-ico"></i>身份证</span><?php endif;?><?php if($staff->licence): ?><span><i class="detail-ico zgz-ico"></i>资格证</span><?php endif;?>
            </div>
            <div class="btns">
                <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?=$staff->qq?>&amp;site=qq&amp;menu=yes" target="_blank"
                   class="qq-btn">QQ联系</a>
                <a href="<?=$this->createUrl('shop/index',['shop'=>$staff->shop?$staff->shop->id:0])?>" target="_blank" class="enter-btn">进入店铺</a>
            </div>
            <div class="clearfix">
                <div class="count-box sell">
                    <a href="<?=$this->createUrl('/resoldhome/staff/esfList',['staff'=>$staff->id])?>" target="_blank">
                        <p class="count"><?=count($staff->onsaleEsfs)?>套</p>
                        <p class="word">出售房源</p>
                    </a>
                </div>
                <div class="count-box">
                    <a href="<?=$this->createUrl('/resoldhome/staff/zfList',['staff'=>$staff->id])?>" target="_blank">
                        <p class="count"><?=count($staff->onsaleZfs)?>套</p>
                        <p class="word">出租房源</p>
                    </a>
                </div>
            </div>
            <div class="info">
                <p>电话：<?=$staff->phone?></p>
                <p>公司：<a href="<?=$this->createUrl('shop/index',['shop'=>$staff->shop?$staff->shop->id:0])?>" target="_blank"><?=$staff->shop?$staff->shop->name:'--'?></a></p>
                <p>地址：<?=$staff->shop?$staff->shop->address:'--'?></p>
            </div>
        </div>
    <?php endif;?>
        <div class="s-common-title"><span>最近浏览过的房源</span></div>
        <?php $this->widget('ViewRecordWidget',['url'=>'/resoldhome/zf/info','cssType'=>1,'type'=>2,'category'=>2])?>
        <div class="s-common-title"><span>其他相似商铺房源</span><a href="<?=$this->createUrl('zf/list',['type'=>2])?>" target="_blank">更多&gt;</a></div>
        <?php $this->widget('SpXzlRightWidget',['url'=>'/resoldhome/zf/info','model'=>$zf])?>

        <div class="s-common-title"><span><?=$plot->area?$plot->areaInfo->name:''?>租金相近出租房源</span><a href="<?=$this->createUrl('zf/list')?>" target="_blank">更多&gt;</a></div>
        <?php $this->widget('SpXzlRightWidget',['type'=>2,'url'=>'/resoldhome/zf/info','model'=>$zf])?>

        <?php if($staff):?>
            <?php $staffZfs = ResoldZfExt::model()->saling()->findAll(['condition'=>'uid=:uid and category=1','params'=>[':uid'=>$staff->uid],'order'=>'refresh_time desc,sale_time desc','limit'=>4]);
             if($staffZfs): ?>
            <div class="s-common-title"><span>该经纪人其他二手房源</span><a href="<?=$this->createUrl('/resoldhome/staff/esfList',['staff'=>$staff->id])?>" target="_blank">更多&gt;</a></div>
            <ul class="right-list">
            <?php foreach ($staffZfs as $key => $value) {?>
                <li><a href="<?=$this->createUrl('list',['hid'=>$value->plot->id])?>" target="_blank"><span class="name"><?=$value->plot->title?> </span><span class="cate tac"><?=$value->bedroom?>室<?=$value->livingroom?>厅 </span><span class="price"><?=$value->price?>万</span></a></li>
            <?php }?>
            </ul>
            <?php endif;?>
        <?php endif;?>

        <div class="gg-type80">
            <ul>
                <li><a href=""><img src="images/gg1.jpg"></a></li>
            </ul>
        </div>
        <div class="gg-type210">
            <ul>
                <li><a href=""><img src="images/gg2.jpg"></a></li>
            </ul>
        </div>
    </div>

</div>
<div class="wapper">
    <?php $plotAlbum = PlotImgExt::model()->findAll(['condition'=>'hid=:hid','params'=>[':hid'=>$plot->id],'order'=>'sort desc,created desc','limit'=>5]);if($plotAlbum):?>
    <div class="common-title"><span><?=$plot->title?>相册</span></div>
    <div class="fang-list long-list">
        <ul>
            <?php
                foreach($plotAlbum as $k=>$v):
            ?>
            <li>
                <a href="">
                    <div class="pic">
                        <img src="<?=ImageTools::fixImage($value->url)?>" alt="">
                    </div>

                </a>
            </li>
            <?php
        endforeach;
            ?>

        </ul>
        <div class="more-info">更多信息：<a href="<?=$this->createUrl('/resoldhome/plot/album',['py'=>$plot->pinyin])?>" target="_blank"><?=$plot->title?></a><a href="<?=$this->createUrl('/home/plot/price',['py'=>$plot->pinyin])?>" target="_blank"><?=$plot->title?>房价走势</a><a href="<?=$this->createUrl('/resoldhome/plot/album',['py'=>$plot->pinyin])?>"
                                                                                                                 target="_blank"><?=$plot->title?>相册</a><a
                href="http://www.hualongxiang.com/yezhu" target="_blank"><?=$plot->title?>业主论坛</a></div>
    </div>
    <?php
endif;
    ?>

    <div class="common-title"><span>您可能感兴趣的租房</span></div>
    <div class="fang-list long-list">
        <?php $this->widget('ViewRecordWidget',['url'=>'/resoldhome/zf/info','cssType'=>4,'type'=>2,'category'=>2,'limit'=>5])?>
    </div>
    <div class="blank10"></div>
    <div class="shengming"><span>免责声明：</span><?=SM::resoldConfig()->resoldPCFreeStatement()?SM::resoldConfig()->resoldPCFreeStatement():'房源信息有网站用户提供、其真实性、合法性由信息提供者负责，最终以政府部门登记备案为准，本网站不声明或保证内容之正确性和可靠行，购买该房屋时，请谨慎核查，如该房源信息有误，您可以投诉此房源信息或拨打举报电话：0519-83022322'?>
    </div>
</div>
