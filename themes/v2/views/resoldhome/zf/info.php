<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/detail.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/iconfont/iconfont.css');
if($zf->category==1){
    $this->pageTitle = $zf->title.'-'.SM::urmConfig()->cityName().SM::GlobalConfig()->siteName();
    $this->keyword = SM::urmConfig()->cityName().'租房,'.($zf->area?$zf->areaInfo->name:'').'租房,'.($zf->street?$zf->streetInfo->name:'').'租房,'.$zf->plot->title.'租房';
    $this->description = SM::urmConfig()->cityName().'租房-'.SM::GlobalConfig()->siteName().'提供'.SM::urmConfig()->cityName().$zf->plot->title.'租房信息，'.$zf->rent_type.$zf->bedroom.'室'.$zf->livingroom.'厅'.$zf->size.'出租信息， 找更多'.SM::urmConfig()->cityName().$zf->plot->title.'租房信息就到'.SM::urmConfig()->cityName().'租房-'.SM::GlobalConfig()->siteName();
}elseif($zf->category==2){
    $this->pageTitle = $zf->title.'- '.($zf->street?$zf->streetInfo->name:'').'商铺出租- '.SM::GlobalConfig()->siteName();
    $this->keyword = SM::urmConfig()->cityName().'商铺出租';
    $this->description = $zf->title.'，'.Tools::u8_title_substr($zf->content,20);
}else{
    $this->pageTitle = $zf->title.'- '.($zf->street?$zf->streetInfo->name:'').'写字楼出租- '.SM::GlobalConfig()->siteName();
    $this->keyword = SM::urmConfig()->cityName().'写字楼出租';
    $this->description = $zf->title.'，'.Tools::u8_title_substr($zf->content,20);
}

?>
<div class="wapper">
    <div class="detail_l">
    <?php $infoname = $zf->category==2?'商铺':($zf->category==3?'写字楼':'租房');  $breadCrumbs = [SM::urmConfig()->cityName()."$infoname"=>$this->createUrl('list',['type'=>$zf->category])];
        isset($zf->areaInfo->name) && $breadCrumbs = $breadCrumbs + [$zf->areaInfo->name."$infoname"=>$this->createUrl('list',['type'=>$zf->category,'area'=>$zf->area])];
        isset($zf->streetInfo->name) && $breadCrumbs = $breadCrumbs + [$zf->streetInfo->name."$infoname"=>$this->createUrl('list',['type'=>$zf->category,'street'=>$zf->street])];
        $breadCrumbs = $breadCrumbs + [$zf->plot->title."$infoname"=>$this->createUrl('list',['type'=>2,'hid'=>$zf->plot->id])];
    ?>
        <?php $this->widget('HomeBreadcrumbs',array('links'=>$breadCrumbs));?>
        <div class="line"></div>
        <div class="detail-top clearfix">
            <p class="title"><?=$zf->title?></p>
            <div class="clearfix">
                <?php $colorArr = ['color1','color2','color3','color1','color2'];?>
                <?php

                    if($zf->category == 1)
                        $ts = isset($tagArray['zfzzts'])?$tagArray['zfzzts']:[];
                    elseif($zf->category == 2)
                        $ts = isset($tagArray['zfspts'])?$tagArray['zfspts']:[];
                    elseif($zf->category == 3)
                        $ts = isset($tagArray['zfxzlts'])?$tagArray['zfxzlts']:[];
                ?>
                <?php if(!empty($ts)): ?>
                <div class="tags">

                        <?php foreach($ts as $i => $ts) : ?>
                        <span class="<?=$colorArr[$i]?>"><?= $ts ?></span>
                        <?php endforeach; ?>

                </div>
                <?php endif;?>
                <span class="time">发布时间：<?=$zf->sale_time?date('Y-m-d H:i',$zf->sale_time):date('Y-m-d H:i',$zf->created)?></span>
                <span class="time">浏览量：<?=$zf->hits?></span>
            </div>
            <div class="esf-slider">
                <ul class="bigImg">
                    <?php if($zf->image): ?>
                        <li><img src="<?=ImageTools::fixImage($zf->image,400,300)?>"/></li>
                    <?php else: ?>
                        <li><img src="<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic,400,300)?>"></li>
                    <?php endif; ?>
                    <?php if($zf->images):?>
                        <?php foreach ($zf->images as $key => $value):?>
                            <?php if($value->url==$zf->image) continue;?>
    					<li><img src="<?=ImageTools::fixImage($value->url,400,300)?>"></li>
                         <?php endforeach;?>
                    <?php endif;?>
                </ul>
                <div class="smallScroll">
                    <a class="pre-btn" href="javascript:void(0)"><i class="detail-ico"></i></a>
                    <div class="smallImg">
                        <ul>
                            <?php if($zf->image): ?>
                                <li><img src="<?=ImageTools::fixImage($zf->image,400,300)?>"/></li>
                            <?php else: ?>
                                <li><img src="<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic,400,300)?>"></li>
                            <?php endif; ?>
            				<?php if($zf->images):?>
                                <?php foreach ($zf->images as $key => $value):?>
                                    <?php if($value->url==$zf->image) continue;?>
            					<li><img src="<?=ImageTools::fixImage($value->url,80,60)?>"></li>
                            <?php endforeach;?>
                            <?php endif;?>
                        </ul>
                    </div>
                    <a href="javascript:void(0)" class="next-btn "><i class="detail-ico"></i></a>
                </div>
            </div>
            <!--商铺详情-->
            <?php if($zf->category==2):?>
                <div class="info rent-info">
                    <ul class="info-ul clearfix">
                        <li class="left"><span><em>租</em>金：</span><em><?=Tools::FormatPrice($zf->price,'</em>元/月')?></em>【押<?=CJSON::decode($zf['pay_type'])['ya']?>付<?=CJSON::decode($zf['pay_type'])['jiao']?>】</li>
                        <li class="left"><span><em>楼</em>层：</span><?=isset($tagArray['esffloorcate'])? $tagArray['esffloorcate'] : '暂无'?> <?php if($zf->total_floor > 0): ?>(共<?=$zf->total_floor?>层)<?php endif; ?></li>
                        <li class=""><span>建筑面积：</span><?=$zf->size?>m²</li>
                    </ul>
                    <div class="tel-box">
                        <i class="tel-ico iconfont">&#xe609;</i>
                        <span><?=$zf->phone?><?php if(!$staff):?><em>(业主<?=$zf->username?$zf->username:$zf->account?>)</em><?php endif;?></span>
                    </div>
                    <p class="promite">联系我时，请说在<?=SM::globalConfig()->siteName()?>二手房看到的</p>
                    <ul class="info-ul">

                        <li class="left"><span>商铺类型：</span>
                            <?=isset($tagArray['esfzfsptype']) ? $tagArray['esfzfsptype']:'暂无'?>
                        </li>
                        <li><span><em>级</em>别：</span><?=isset($tagArray['esfsplevel'])? $tagArray['esfsplevel']:'暂无'?></li>
                        <li class="left"><span>物 业 费 ：</span><?=$zf->wuye_fee?$zf->wuye_fee.'元/平米·月':'暂无'?></li>
                        <li class=""><span><em>装</em>修：</span><?=$zf->decoration?TagExt::getNameByTag($zf->decoration):'暂无'?></li>
                        <li class="left"><span><em>朝</em>向：</span><?=$zf->towards?TagExt::getNameByTag($zf->towards):'暂无'?></li>
                        <li class="long"><span>配套设施：</span><?php
                                echo isset($tagArray[$ptArr[$zf->category]]) ? implode(' ',$tagArray[$ptArr[$zf->category]]) : '暂无' ;
                            ?></li>

                        <li class="long"><span>适合经营：</span><?php
                                 echo isset($tagArray['zfspkjyxm']) ? implode(' ',$tagArray['zfspkjyxm']) : '暂无' ;
                            ?></li>
                            <li class="long"><span>小区名称：</span>
                                <a href="<?=$this->createUrl('/resoldhome/plot/pzflist',['py'=>$zf->plot->pinyin])?>" clas="addr"><?=$zf->plot->title?>
                                    <?php if($zf->areaInfo): ?>
                                        (<a href="<?=$this->createUrl('/resoldhome/plot/list',['area'=>$zf->area])?>"><?=$zf->areaInfo->name?></a>
                                        <?php if($zf->streetInfo): ?>
                                            <a href="<?=$this->createUrl('/resoldhome/plot/list',['street'=>$zf->street])?>"><?=$zf->streetInfo->name?></a>
                                        <?php endif; ?>
                                        )
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li class="long"><span>小区地址：</span>
                                <a href="#content3"><?=$zf->plot->address?></a>
                            </li>
                    </ul>

            <!--写字楼详情-->
            <?php elseif($zf->category==3):?>
                <div class="info rent-info">
					<ul class="info-ul clearfix">
						<li class="long"><span><em>租</em>金：</span><em><?=Tools::FormatPrice($zf->price,'</em>元/月')?></em>【押<?=CJSON::decode($zf['pay_type'])['ya']?>付<?=CJSON::decode($zf['pay_type'])['jiao']?>】</li>
                        <li class="left"><span>所在楼层：</span><?=isset($tagArray['esffloorcate'])? $tagArray['esffloorcate'] : $zf->floor?>(共<?=$zf->total_floor?>层)</li>
                        <li class=""><span>建筑面积：</span><?=$zf->size?$zf->size.'m²':'暂无'?></li>
					</ul>
					<div class="tel-box">
						<i class="tel-ico iconfont">&#xe609;</i>
						<span><?=$zf->phone?><?php if(!$staff):?><em>(业主<?=$zf->username?$zf->username:$zf->account?>)</em><?php endif;?></span>
					</div>
					<p class="promite">联系我时，请说在<?=SM::globalConfig()->siteName()?>二手房看到的</p>
					<ul class="info-ul">
						<li class="left"><span><em>类</em>型：</span><?=isset($tagArray['esfzfxzltype'])? $tagArray['esfzfxzltype']:'暂无'?></li>
						<li class=""><span><em>等</em>级：</span><?=isset($tagArray['zfxzllevel'])? $tagArray['zfxzllevel']:'暂无'?></li>
                        <li class="left"><span>物 业 费：</span><?=$zf->wuye_fee?$zf->wuye_fee.'元/平米·月':'暂无'?></li>
                        <li><span><em>装</em>修：</span><?=isset($zf->decoration)?TagExt::getNamebyTag($zf->decoration):''?></li>
                        <li class="left"><span>建筑年代：</span><?=$zf->age?$zf->age:'不详'?></li>
                        <li class=""><span><em>朝</em>向：</span><?=$zf->towards?TagExt::getNameByTag($zf->towards):'暂无'?></li>
                        <li class="long"><span>配套设施：</span><?php
                            echo isset($tagArray[$ptArr[$zf->category]]) ? implode(' ',$tagArray[$ptArr[$zf->category]]) : '暂无' ;
                    ?></li>
                    <li class="long"><span>小区名称：</span>
                        <a href="<?=$this->createUrl('/resoldhome/plot/pzflist',['py'=>$zf->plot->pinyin])?>" clas="addr"><?=$zf->plot->title?>
                            <?php if($zf->areaInfo): ?>
                                (<a href="<?=$this->createUrl('/resoldhome/plot/list',['area'=>$zf->area])?>"><?=$zf->areaInfo->name?></a>
                                <?php if($zf->streetInfo): ?>
                                    <a href="<?=$this->createUrl('/resoldhome/plot/list',['street'=>$zf->street])?>"><?=$zf->streetInfo->name?></a>
                                <?php endif; ?>
                                )
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="long"><span>小区地址：</span>
                        <a href="#content3"><?=$zf->plot->address?></a>
                    </li>

					</ul>
            <!--租房详情-->
            <?php else:?>
            <div class="info">
                <ul class="info-ul clearfix">
                    <li class="long"><span><em>租</em>金：</span><em><?=Tools::FormatPrice($zf->price,'</em>元/月')?></em>【押<?=CJSON::decode($zf['pay_type'])['ya']?>付<?=CJSON::decode($zf['pay_type'])['jiao']?>】</li>
                    <li class="left"><span><em>户</em>型：</span><?=$zf->bedroom?>室<?=$zf->livingroom?>厅<?=$zf->bathroom?>卫</li>
                    <li><span>建筑面积：</span><?=$zf->size?$zf->size.'m²':'暂无'?></li>
                </ul>
                    <div class="tel-box">
                        <i class="tel-ico iconfont">&#xe609;</i>
                        <span><?=$zf->phone?><?php if(!$staff):?><em>(业主<?=$zf->username?$zf->username:$zf->account?>)</em><?php endif;?></span>
                    </div>
                    <p class="promite">联系我时，请说在<?=SM::globalConfig()->siteName()?>二手房看到的</p>
                    <ul class="info-ul">
                    <li class="left"><span>出租方式：</span><?=$zf->rent_type;?></li>
                    <li><span><em>朝</em>向：</span><?=$zf->towards?TagExt::getNameByTag($zf->towards):'暂无'?></li>
                    <li class="left"><span><em>楼</em>层：</span><?=isset($tagArray['esffloorcate'])? $tagArray['esffloorcate'] :$zf->floor?>(共<?=$zf->total_floor?>层)</li>
                    <li><span><em>装</em>修：</span><?=isset($tagArray['resoldzx'])?$tagArray['resoldzx']:'暂无' ?></li>
                    <li class="long"><span>配套设施：</span>
                        <?php
                            echo isset($tagArray[$ptArr[$zf->category]]) ? implode(' ',$tagArray[$ptArr[$zf->category]]) : '暂无' ;
                        ?></li>
                        <li class="long"><span>小区名称：</span>
                            <a href="<?=$this->createUrl('/resoldhome/plot/pzflist',['py'=>$zf->plot->pinyin])?>" clas="addr"><?=$zf->plot->title?>
                                <?php if($zf->areaInfo): ?>
                                    (<a href="<?=$this->createUrl('/resoldhome/plot/list',['area'=>$zf->area])?>"><?=$zf->areaInfo->name?></a>
                                    <?php if($zf->streetInfo): ?>
                                        <a href="<?=$this->createUrl('/resoldhome/plot/list',['street'=>$zf->street])?>"><?=$zf->streetInfo->name?></a>
                                    <?php endif; ?>
                                    )
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="long"><span>小区地址：</span>
                            <a href="#content3"><?=$zf->plot->address?></a>
                        </li>
                </ul>



        <?php endif;?>
            <a href="javascript:void(0)" class="jubao-btn j-report-btn" data-infoid="<?=$zf->id?>" data-infoname="<?=$zf->title?>" data-type="zf"><i class="iconfont">&#xe601;</i>举报虚假</a>
            <a href="javascript:void(0)" class="save-btn j-fav-btn" data-fid="<?=$zf->id?>" data-category="3"><i class="iconfont"></i>收藏房源</a>
        </div>
        </div>
        <div class="blank50"></div>
        <!--地图 及 配套-->
        <?php $this->renderPartial('mapinfo')?>
        <!--end-->
        <div class="blank20"></div>
    </div>
    <!--中介-->
    <?php $this->renderPartial('person');?>

</div>
<div class="wapper">
    <?php $this->renderPartial('more_zf')?>
    <div class="blank10"></div>
    <div class="shengming"><span>免责声明：</span><?=SM::resoldConfig()->resoldPCFreeStatement()?SM::resoldConfig()->resoldPCFreeStatement():'房源信息有网站用户提供、其真实性、合法性由信息提供者负责，最终以政府部门登记备案为准，本网站不声明或保证内容之正确性和可靠行，购买该房屋时，请谨慎核查，如该房源信息有误，您可以投诉此房源信息或拨打举报电话：0519-83022322'?>
    </div>
</div>
