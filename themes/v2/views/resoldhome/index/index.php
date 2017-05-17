<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/index.css');
$this->pageTitle = SM::resoldSeoConfig()->resoldHomeIndex()['title'] ? SM::resoldSeoConfig()->resoldHomeIndex()['title'] : (''.SM::urmConfig()->cityName().'二手房出售_'.SM::urmConfig()->cityName().'租房_'.SM::urmConfig()->cityName().'写字楼_'.SM::urmConfig()->cityName().'商铺_'.SM::urmConfig()->cityName().'二手房网-'.SM::globalConfig()->siteName().'二手房-'.SM::globalConfig()->siteName().'');

$this->keyword = SM::resoldSeoConfig()->resoldHomeIndex()['keyword']?SM::resoldSeoConfig()->resoldHomeIndex()['keyword']:(''.SM::urmConfig()->cityName().'二手房,'.SM::urmConfig()->cityName().'租房,'.SM::urmConfig()->cityName().'房产网,'.SM::globalConfig()->siteName().'二手房,'.SM::globalConfig()->siteName().'房产');

$this->description = SM::resoldSeoConfig()->resoldHomeIndex()['desc']?SM::resoldSeoConfig()->resoldHomeIndex()['desc']:(''.SM::globalConfig()->siteName().'二手房是'.SM::urmConfig()->cityName().'热门专业的网络二手房平台,提供全面及时的'.SM::urmConfig()->cityName().'二手房、租房、写字楼、商铺等信息,同时支持查看小区房价走势、查找邻校房、免费发布房源信息等,为广大网友提供全方位的购房租房便利。免费查找和发布二手房买卖信息,就上'.SM::globalConfig()->siteName().'二手房');
?>
<div class="wapperout">
    <div class="wapper">
        <?php $this->widget('HomeBreadcrumbs',array('links'=>[SM::urmConfig()->cityName().'二手房'=>$this->createUrl('/resoldhome/esf/list')]));?>
    </div>
    <div class="line"></div>
</div>
<div class="blank10"></div>
<?php $this->widget('AdWidget',['position'=>'esfsysslsb']); ?>
<div class="blank10"></div>
<div class="wapper" style="overflow: visible;">
    <div class="left-box">
        <div class="search-box">
            <form action="<?=$this->createUrl('/resoldhome/esf/list')?>" method="get" >
                <div class="search-input">
                    <input autocomplete="off" type="text" class="fl bigfs" name="kw" id="searchtxt" placeholder="请输入二手房名称" data-type="1" data-url="<?=$this->createUrl('/api/resoldwapapi/plotsearchajax')?>" />
                </div>
                <input type="submit" class="searchbut head-icon" id="searchbut" value="搜索">
                <div class="search-list-box">
                </div>
            </form>
        </div>
        <dl class="hot-search">
            <dt>热门搜索：</dt>
            <dd>
            <?php if($searchRecoms) foreach ($searchRecoms as $key => $value) { if($value):?>
            	<p class="search-more">
            	<?php foreach ($value as $key => $v) {?>
            		<a target="_blank" href="<?=$v->url?>"><?=$v->title?></a>
            	<?php } ?>
            	</p>
            <?php endif;}?>
            </dd>
        </dl>
    </div>
    <div class="right-box">
        <ul>
            <li><a target="_blank" href="<?=$this->createUrl('/resoldhome/map/index')?>"><i class="iconfont">&#xe607;</i>地图找房</a></li>
            <li><a target="_blank" href="<?=$this->createUrl('/vip')?>"><i class="iconfont">&#xe603;</i>经纪人登录</a></li>
            <li><a target="_blank" href="<?=$this->createUrl('/resoldhome/myesf/sellinput')?>"><i class="iconfont">&#xe602;</i>个人免费发布</a></li>
            <li><a target="_blank" href="<?=$this->createUrl('/resoldhome/plot/list')?>"><i class="iconfont">&#xe604;</i>小区找房</a></li>
        </ul>
    </div>
</div>
<div class="blank10"></div>
<?php $this->widget('AdWidget',['position'=>'esfsysb']); ?>
<div class="blank10"></div>
<div class="wapper">
    <div class="left-content">
        <div class="title-box">
            <h4>精品 · 二手房</h4>
        </div>
        <!-- 精品二手房 From the Modules.Admin.ResoldRecomController, configured in backstage-->
        <div class="change-box">
            <ul class="s-tab clearfix">
                <?php if(isset($esfRecoms['pcsyzdjesf'])&&$esfRecoms['pcsyzdjesf']):?><li class="on">低总价<span></span></li><?php endif;?>
                <?php if(isset($esfRecoms['pcsyskzjesf'])&&$esfRecoms['pcsyskzjesf']):?><li>三口之家<span></span></li><?php endif;?>
                <?php if(isset($esfRecoms['pcsylxfesf'])&&$esfRecoms['pcsylxfesf']):?><li>邻校房<span></span></li><?php endif;?>
                <?php if(isset($esfRecoms['pcsyrmsqesf'])&&$esfRecoms['pcsyrmsqesf']):?><li>热门商圈<span></span></li><?php endif;?>
            </ul>
    
            <div class="tab-content">
                
				<?php if(isset($esfRecoms['pcsyzdjesf'])&&$esfRecoms['pcsyzdjesf']):?>
                <ul class="change-sub-box clearfix">
                <?php foreach ($esfRecoms['pcsyzdjesf'] as $key => $value) {
                    if(!isset($value['info'])) $value['info'] = ['id'=>0,'image'=>SM::resoldImageConfig()->resoldNoPic(),'bedroom'=>0,'livingroom'=>0,'price'=>0,'size'=>0]?>
					<li>
                        <a target="_blank" href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$value['info']['id']])?>">
                            <?php if($value['config']['isAd']): ?>
                                <span class="ad-lab"></span>
                            <?php endif; ?>
                            <img src="<?=ImageTools::fixImage($value['image']?$value['image']:$value['info']['image'],200,150)?>">
                            <p class="name"><?=$value['title']?></p>
                            <div class="info">
                                <p class="area"><span><?=$value['info']['bedroom']?>室<?=$value['info']['livingroom']?>厅</span><span><?=(int)$value['info']['size']?>㎡</span></p>
                                <p class="price"><?=Tools::formatPrice($value['info']['price'],'万')?></p>
                            </div>
                            
                        </a>
                    </li>
				<?php } echo '</ul>'; endif;?>

                <?php if(isset($esfRecoms['pcsyskzjesf'])&&$esfRecoms['pcsyskzjesf']):?>
                <ul class="change-sub-box clearfix">
                    <?php foreach ($esfRecoms['pcsyskzjesf'] as $key => $value) {
                        if(!isset($value['info'])) $value['info'] = ['id'=>0,'image'=>SM::resoldImageConfig()->resoldNoPic(),'bedroom'=>0,'livingroom'=>0,'price'=>0,'size'=>0]?>
					<li>
                        <a target="_blank" href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$value['info']['id']])?>">
                            <?php if($value['config']['isAd']): ?>
                            <span class="ad-lab"></span>
                            <?php endif; ?>
                            <img src="<?=ImageTools::fixImage($value['image']?$value['image']:$value['info']['image'],200,150)?>">
                            <p class="name"><?=$value['title']?></p>
                            <div class="info">
                                <p class="area"><span><?=$value['info']['bedroom']?>室<?=$value['info']['livingroom']?>厅</span><span><?=$value['info']['size']?>㎡</span></p>
                                <p class="price"><?=Tools::formatPrice($value['info']['price'],'万')?></p>
                            </div>
                            
                        </a>
                    </li>
				<?php } echo '</ul>'; endif;?>

                <?php if(isset($esfRecoms['pcsylxfesf'])&&$esfRecoms['pcsylxfesf']):?>
                <ul class="change-sub-box clearfix">
                <?php foreach ($esfRecoms['pcsylxfesf'] as $key => $value) {
                    if(!isset($value['info'])) $value['info'] = ['id'=>0,'image'=>SM::resoldImageConfig()->resoldNoPic(),'bedroom'=>0,'livingroom'=>0,'price'=>0,'size'=>0]?>
					<li>
                        <a target="_blank" href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$value['info']['id']])?>">
                            <?php if($value['config']['isAd']): ?>
                                <span class="ad-lab"></span>
                            <?php endif; ?>
                            <img src="<?=ImageTools::fixImage($value['image']?$value['image']:$value['info']['image'],200,150)?>">
                            <p class="name"><?=$value['title']?></p>
                            <div class="info">
                                <p class="area"><span><?=$value['info']['bedroom']?>室<?=$value['info']['livingroom']?>厅</span><span><?=$value['info']['size']?>㎡</span></p>
                                <p class="price"><?=Tools::formatPrice($value['info']['price'],'万')?></p>
                            </div>
                            
                        </a>
                    </li>
				<?php } echo '</ul>'; endif;?>

                <?php if(isset($esfRecoms['pcsyrmsqesf'])&&$esfRecoms['pcsyrmsqesf']): ?>
                <ul class="change-sub-box clearfix">
                <?php foreach ($esfRecoms['pcsyrmsqesf'] as $key => $value) {
                    if(!isset($value['info'])) $value['info'] = ['id'=>0,'image'=>SM::resoldImageConfig()->resoldNoPic(),'bedroom'=>0,'livingroom'=>0,'price'=>0,'size'=>0]?>
					<li>
                        <a target="_blank" href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$value['info']['id']])?>">
                            <?php if($value['config']['isAd']): ?>
                                <span class="ad-lab"></span>
                            <?php endif; ?>
                            <img src="<?=ImageTools::fixImage($value['image']?$value['image']:$value['info']['image'],200,150)?>">
                            <p class="name"><?=$value['title']?></p>
                            <div class="info">
                                <p class="area"><span><?=$value['info']['bedroom']?>室<?=$value['info']['livingroom']?>厅</span><span><?=(int)$value['info']['size']?>㎡</span></p>
                                <p class="price"><?=Tools::formatPrice($value['info']['price'],'万')?></p>
                            </div>
                            
                        </a>
                    </li>
				<?php } echo '</ul>'; endif;?>

            </div>
        </div>
        <!-- End of 精品二手房 -->
        <!-- The newest Esfs. From Modules.Resoldhome.IndexController-->
        <div class="other-esf clearfix">
            <ul>
            <?php if($esfs) foreach ($esfs as $key => $value) {?>
            	<li>
                    <a target="_blank" href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$value->id])?>">
                        <span class="region"><?=$value->areaInfo?$value->areaInfo->name:'暂无区域'?></span>
                        <span class="name"><?=$value->plot_name?$value->plot_name:'暂无小区'?></span>
                        <span class="type"><?php if($value->bedroom):?><?=$value->bedroom?>室<?=$value->livingroom?>厅<?php else:?><?=Yii::app()->params['category'][$value->category]?><?php endif;?></span>
                        <span class="area"><?=(int)$value->size?>平</span>
                        <span class="price"><?=(int)$value->price?((int)$value->price.'万'):'面议'?></span>
                    </a>
                </li>
            <?php }?>
               
            </ul>
        </div>
        <!-- End of the newest Esfs -->
    </div>
    <div class="right-content mt46 hot-areas">
        <ul class="r-s-tab clearfix">
            <li class="on" <?=!SM::resoldConfig()->resoldIsOpenStreet()?'style="width: 100%"':''?>>热门小区</li>
            <?php if(SM::resoldConfig()->resoldIsOpenStreet()):?><li>热门街区</li> <?php endif;?>
        </ul>
        <!-- Begin of hot plots,in regard to esfs -->
        <div class="r-tab-content">
            <ul class="clearfix">
            <?php if($esfPlots) foreach ($esfPlots as $key => $value) {?>
            	<li>
                    <a target="_blank" href="<?=$this->createUrl('/resoldhome/plot/pesflist',['py'=>$value->pinyin])?>">
                        <span class="name"><?=$value->title?></span>
                        <span class="area"><?=Tools::formatPrice((int)PlotResoldDailyExt::getLastInfoByHid($value->id)['esf_price'],'元/㎡','暂无报价')?></span>
                        <span class="nub"><?=$value->esf_num?>套</span>
                    </a>
                </li>
            <?php }?>
            </ul>
            <!-- End of hot plots -->
            <!-- Begin of hot streets,in regard to esfs -->
            <?php if(SM::resoldConfig()->resoldIsOpenStreet()):?><ul class="clearfix">
            <?php if($esfStreets) foreach ($esfStreets as $key => $value) {?>
            	<li>
                    <a target="_blank" href="<?=$this->createUrl('/resoldhome/esf/list',['street'=>$value['id']])?>">
                        <span class="name"><?=$value['name']?></span>
                        <span class="area"><?=$value['area']?></span>
                        <span class="nub"><?=$value['num']?>套</span>
                    </a>
                </li>
            <?php }?>
            </ul><?php endif;?>
            <!-- End of hot streets -->
        </div>
    </div>
</div>
<div class="blank20"></div>
<div class="wapper">
    <div class="left-content">
        <div class="title-box">
            <h4>热门 · 租房</h4>
        </div>
        <div class="change-box">
            <ul class="s-tab clearfix">
                <?php if(isset($zfRecoms['pcsyzzzf'])&&$zfRecoms['pcsyzzzf']):?><li class="on">整租<span></span></li><?php endif;?>
                <?php if(isset($zfRecoms['pcsyhzzf'])&&$zfRecoms['pcsyhzzf']):?><li>合租<span></span></li><?php endif;?>
            </ul>
    
            <div class="tab-content">
            <?php if(isset($zfRecoms['pcsyzzzf'])&&$zfRecoms['pcsyzzzf']):?>
                <ul class="change-sub-box clearfix">
                <?php foreach ($zfRecoms['pcsyzzzf'] as $key => $value) {
                    if(!isset($value['info'])) $value['info'] = ['id'=>0,'image'=>SM::resoldImageConfig()->resoldNoPic(),'bedroom'=>0,'livingroom'=>0,'price'=>0,'size'=>0]?>
                    <li>
                    <a target="_blank" href="<?=$this->createUrl('/resoldhome/zf/info',['id'=>$value['info']['id']])?>">
                        <?php if($value['config']['isAd']): ?>
                            <span class="ad-lab"></span>
                        <?php endif; ?>
                            <img src="<?=ImageTools::fixImage($value['image']?$value['image']:$value['info']['image'],200,150)?>">
                            <p class="name"><?=$value['title']?></p>
                            <div class="info">
                                <p class="area"><span><?=$value['info']['bedroom']?>室<?=$value['info']['livingroom']?>厅</span><span><?=(int)$value['info']['size']?>㎡</span></p>
                            </div>
                            <p class="rent-price"><em><?=Tools::formatPrice($value['info']['price'],'元/月')?></em></p>
                        </a>
                    </li>
                    <?php } echo '</ul>'; endif;?>
                    
                <?php if(isset($zfRecoms['pcsyhzzf'])&&$zfRecoms['pcsyhzzf']):?>
                <ul class="change-sub-box clearfix">
                <?php foreach ($zfRecoms['pcsyhzzf'] as $key => $value) {
                    if(!isset($value['info'])) $value['info'] = ['id'=>0,'image'=>SM::resoldImageConfig()->resoldNoPic(),'bedroom'=>0,'livingroom'=>0,'price'=>0,'size'=>0]?>
                    <li>
                    <a target="_blank" href="<?=$this->createUrl('/resoldhome/zf/info',['id'=>$value['info']['id']])?>">
                        <?php if($value['config']['isAd']): ?>
                            <span class="ad-lab"></span>
                        <?php endif; ?>
                            <img src="<?=ImageTools::fixImage($value['image']?$value['image']:$value['info']['image'],200,150)?>">
                            <p class="name"><?=$value['title']?></p>
                            <div class="info">
                                <p class="area"><span><?=$value['info']['bedroom']?>室<?=$value['info']['livingroom']?>厅</span><span><?=(int)$value['info']['size']?>㎡</span></p>
                            </div>
                            <p class="rent-price"><em><?=Tools::formatPrice($value['info']['price'],'元/月')?></em></p>
                        </a>
                    </li>
                    <?php } echo '</ul>'; endif;?>

                </ul>
            </div>
        </div>
        <div class="other-esf clearfix">
            <ul>
             <?php if($zfs) foreach ($zfs as $key => $value) {?>
            	<li>
                    <a target="_blank" href="<?=$this->createUrl('/resoldhome/zf/info',['id'=>$value->id])?>">
                        <span class="region"><?=$value->areaInfo?$value->areaInfo->name:'暂无区域'?></span>
                        <span class="name"><?=$value->plot_name?$value->plot_name:'暂无小区'?></span>
                        <span class="type"><?php if($value->bedroom):?><?=$value->bedroom?>室<?=$value->livingroom?>厅<?php else:?><?=Yii::app()->params['category'][$value->category]?><?php endif;?></span>
                        <span class="area"><?=(int)$value->size?>平</span>
                        <span class="price"><?=Tools::formatPrice($value->price,'元/月')?></span>
                    </a>
                </li>
            <?php }?>
                
            </ul>
        </div>
    </div>
    <div class="right-content mt46 hot-areas">
        <ul class="r-s-tab clearfix">
            <li class="on" <?=!SM::resoldConfig()->resoldIsOpenStreet()?'style="width: 100%"':''?>>热门小区</li>
            <?php if(SM::resoldConfig()->resoldIsOpenStreet()):?><li>热门街区</li> <?php endif;?>
        </ul>
        <div class="r-tab-content">
            <ul class="clearfix">
            <?php if($zfPlots) foreach ($zfPlots as $key => $value) {?>
            	<li>
                    <a target="_blank" href="<?=$this->createUrl('/resoldhome/plot/pzflist',['py'=>$value->pinyin])?>">
                        <span class="name"><?=$value->title?></span>
                        <span class="area"><?=Tools::formatPrice((int)PlotResoldDailyExt::getLastInfoByHid($value->id)['zf_price'],'元/月','暂无报价')?></span>
                        <span class="nub"><?=$value->zf_num?>套</span>
                    </a>
                </li>
            <?php }?>
                
                
            </ul>
            <?php if(SM::resoldConfig()->resoldIsOpenStreet()):?><ul class="clearfix">
            <?php if($zfStreets) foreach ($zfStreets as $key => $value) {?>
            	<li>
                    <a target="_blank" href="<?=$this->createUrl('/resoldhome/zf/list',['street'=>$value['id']])?>">
                        <span class="name"><?=$value['name']?></span>
                        <span class="area"><?=$value['area']?></span>
                        <span class="nub"><?=$value['num']?>套</span>
                    </a>
                </li>
            <?php }?>
                

            </ul><?php endif;?>
        </div>
    </div>
</div>
<div class="blank20"></div>
<?php if($staffRecoms && isset($staffRecoms['pcsyjpjjr']) && $staffRecoms['pcsyjpjjr']): ?>
<div class="wapper">
    <div class="left-content">
        <div class="title-box"><h4>金牌经纪人</h4></div>
        <ul class="agent-list">
        <?php foreach ($staffRecoms['pcsyjpjjr'] as $key => $value) {?>
            <li>
                <a target="_blank" href="<?=$value->url?>"><img src="<?=ImageTools::fixImage($value->image,150,185)?>"><?=$value->title?></a>
            </li>
        <?php }?>
        </ul>
    </div>
<?php endif;?>
<?php if($newsRecoms && isset($newsRecoms['pcsyzx']) && $newsRecoms['pcsyzx']): ?>
    <div class="right-content">
        <div class="title-box"><h4>二手房资讯</h4></div>
        <ul class="esf-news-list">
        <?php foreach ($newsRecoms['pcsyzx'] as $key => $value) {?>
            <li>
                <a target="_blank" href="<?=$value->url?>"><?=$value->title?></a>
            </li>
        <?php }?>
        </ul>
    </div>
</div>
<?php endif;?>
<div class="blank20"></div>
<?php if(isset($shopRecoms['pcsyppzj'])&&$shopRecoms['pcsyppzj']):?>
<div class="wapper">
        <div class="title-box">
            <h4>品牌中介</h4>
        </div>
        <ul class="agent-shop-list clearfix">
        <?php foreach ($shopRecoms['pcsyppzj'] as $key => $value) {?>
        	<li>
                <a target="_blank" href="<?=$value['url']?>">
                    <img src="<?=ImageTools::fixImage($value->image,120,120)?>">
                    <p><?=$value->title?></p>
                    <p class="name"><?=$value->s_title?></p>
                </a>
            </li>
        <?php }?>
           
        </ul>
</div>
<div class="blank20"></div>
<?php endif;?>
<?php $this->widget('CommonWidget',['type'=>3])?>