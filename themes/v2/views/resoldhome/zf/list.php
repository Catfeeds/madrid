<?php
if($get['type']==1){
    $this->pageTitle = SM::urmConfig()->cityName().'房屋出租|'.SM::urmConfig()->cityName().'租房子|'.SM::urmConfig()->cityName().'出租房信息- '.SM::urmConfig()->cityName().SM::GlobalConfig()->siteName();
    $this->keyword = SM::urmConfig()->cityName().'出租房,'.SM::urmConfig()->cityName().'租房子';
    $this->description=SM::urmConfig()->cityName().'出租房网为您提供最新、最真实的'.SM::urmConfig()->cityName().'出租房个人信息、'.SM::urmConfig()->cityName().'出租房经纪人信息，欢迎您来到'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'出租房网';
}elseif($get['type']==2){
    $this->pageTitle = SM::urmConfig()->cityName().'商铺出租|'.SM::urmConfig()->cityName().'店铺出租信息-'.SM::GlobalConfig()->siteName();
    $this->keyword = SM::urmConfig()->cityName().'商铺出租';
    $this->description = SM::urmConfig()->cityName().'商铺出租频道为您提供'.SM::urmConfig()->cityName().'商铺出租信息，在这里有大量的'.SM::urmConfig()->cityName().'商铺出租信息供您查询。查找'.SM::urmConfig()->cityName().'商铺出租信息，请到'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'商铺出租频道';
}else{
    $this->pageTitle = SM::urmConfig()->cityName().'写字楼出租|'.SM::urmConfig()->cityName().'店铺出租信息-'.SM::GlobalConfig()->siteName();
    $this->keyword = SM::urmConfig()->cityName().'写字楼出租';
    $this->description = SM::urmConfig()->cityName().'写字楼出租频道为您提供'.SM::urmConfig()->cityName().'写字楼出租信息，在这里有大量的'.SM::urmConfig()->cityName().'写字楼出租信息供您查询。查找'.SM::urmConfig()->cityName().'写字楼出租信息，请到'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'写字楼出租频道';
}
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/list.css');

?>
<div class="wapper-out search-wrap clearfix">
    <div class="search-box clearfix">
        <form method="get" id="search-form">
        <div class="search-input fl">
            <input  autocomplete="off"  data-type="2" data-url="<?=$this->createUrl('/api/resoldwapapi/plotsearchajax')?>" data-category="<?=$get['type']?>" class="input" name="kw" value="<?=$get['kw']?>" placeholder="请输入租房名称">
        </div>
        <input type="hidden" name="type" value="<?=$get['type']?>">
        <a class="btn fl" onclick="document.getElementById('search-form').submit()">搜索</a>
        </form>
        <div class="search-list-box">
            <ul>

            </ul>
        </div>
        <?php $this->widget('CommonWidget',['type'=>1])?>
    </div>
</div>
<div class="blank5"></div>
<?php $this->widget('AdWidget',['position'=>'esfzflb']); ?>

<?php if($get['type']==1):?>
    <?php $this->widget('HomeBreadcrumbs',array('links'=>[SM::urmConfig()->cityName().'租房']));?>
<?php elseif($get['type']==2):?>
    <?php $this->widget('HomeBreadcrumbs',array('links'=>[SM::urmConfig()->cityName().'商铺']));?>
<?php else:?>
    <?php $this->widget('HomeBreadcrumbs',array('links'=>[SM::urmConfig()->cityName().'写字楼']));?>
<?php endif;?>

<div class="wapper">
        <!--筛选条件-->
        <?php $this->renderPartial('filter')?>
        <!--end 筛选-->
        <div class="blank20"></div>
        <div class="main-left">
            <?php if(isset($school) && $school):?>
            <div class="school-about frame clearfix">
                <div class="info">
                    <p class="n-map"><a href="<?=$this->createUrl('/resoldhome/school/plot',['pinyin'=>$school->pinyin])?>" class="name"><?=$school->name?></a></p>
                    <p class="n-map"><span><em><?=$school->address?></em></span></p>
                </div>
                <div class="duikou">
                    <p><?=$school->plotNumAll?>个对口小区</p>
                </div>
                <div class="other-info">
                    <div class="o-left">
                    <?php
                        // $rel = SchoolPlotRelExt::model()->findAll(['condition'=>'sid=:sid','params'=>[':sid'=>$school->id]]);
                        // $pid = '';
                        // if($rel)
                        //     foreach ($rel as $key => $value) {
                        //         $pid .= 'hid:'.$value->plot->id.' ';
                        //     }
                        // $xs = Yii::app()->search->house_esf;
                        // $xs->setFuzzy()->setQuery($pid);
                        // $xs->addRange('deleted',0,0);
                        // $xs->addRange('sale_status',1,1);
                        // $xs->setMultiSort(['price'=>true]);
                        // $priceUp = $xs->search();
                        // $xs->setMultiSort(['ave_price'=>true]);
                        // $avePriceUp = $xs->search();
                        // $xs->setMultiSort(['ave_price'=>false]);
                        // $avePriceDown = $xs->search();
                        // if($priceUp)
                        //     $lowestPriceEsf = ResoldEsfExt::model()->findByPk($priceUp[0]['id']);
                        // if($avePriceUp)
                        //     $lowestAvePriceEsf = ResoldEsfExt::model()->findByPk($avePriceUp[0]['id']);
                        // if($avePriceDown)
                        //     $highestAvePriceEsf = ResoldEsfExt::model()->findByPk($avePriceDown[0]['id']);
                    ?>
                        <!-- <p><em><?=$priceUp?$lowestPriceEsf->price:'-'?></em>万起</p>
                        <p class="c-g9"><?=$avePriceUp?$lowestAvePriceEsf->ave_price:'-'?>元/㎡- <?=$avePriceDown?$highestAvePriceEsf->ave_price:'-'?>元/㎡</p> -->
                    </div>
                    <div class="o-right">
                        <p><em><?=$zfcount?></em>套</p>
                        <p>在售房源</p>
                    </div>
                </div>
            </div>
            <div class="blank20"></div>
            <?php elseif ($plot):?>
            <div class="school-about frame clearfix">
                <div class="info">
                    <p class="n-map"><a href="<?=$this->createUrl('/resoldhome/plot/pzflist',['py'=>$plot->pinyin])?>" class="name"><?=$plot->title?></a></p>
                    <p class="n-map"><span><em><?=$plot->address?></em></span></p>
                </div>
                <div class="other-info">
                    <div class="o-left">
                        <p><em><?=PlotResoldDailyExt::getLastInfoByHid($plot->id)?PlotResoldDailyExt::getLastInfoByHid($plot->id)->esf_price:'--'?></em>元/㎡</p>
                        <?php $rate = PlotExt::plotRate($plot)['lastMouthP'];?>
                        <p class="c-<?=$rate>=0?'green':'red'?>"><?=$rate>0?'↑':($rate<0?'↓':'')?><?=$rate?></p>
                    </div>
                    <div class="o-right">
                        <p><em><?=PlotResoldDailyExt::getLastInfoByHid($plot->id)?PlotResoldDailyExt::getLastInfoByHid($plot->id)->esf_num:'--'?></em>套</p>
                        <p>二手房源</p>
                    </div>
                    <div class="o-right">
                        <p><em><?=PlotResoldDailyExt::getLastInfoByHid($plot->id)?PlotResoldDailyExt::getLastInfoByHid($plot->id)->zf_num:'--'?></em>套</p>
                        <p>租房房源</p>
                    </div>
                </div>
            </div>
            <div class="blank20"></div>
        <?php endif;?>
            <div class="next-tabs clearfix">
                <!--排序-->
                <?php $this->renderPartial('page_right')?>
                <!--end-->

                <!--列表-->
                <ul class="item-list">
                <?php
                    if($zfs):
                        foreach($zfs as $k=>$v):
                ?>
                    <li class="item clearfix">
                        <div class="pic fl">
                            <a target="_blank" href="<?=$this->createUrl('info',['id'=>$v->id])?>"><img src="<?=ImageTools::fixImage($v->image,200,150)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic(),200,150)?>'" alt="" /></a>
                            <span class="num">
                                <span class="img-count"><?=$v->image_count?></span>
                                <span class="list-icon"></span>
                            </span>
                        </div>
                        <?php $zftags = $v->getZfTag();?>
                        <?php if($get['type']==2):?>

                            <div class="content fl">
                                <p class="title"><a target="_blank" href="<?=$this->createUrl('info',['id'=>$v->id])?>"><?=$v->title?></a></p>

                                <p class="detail"><span>
                                    <?php

                                        echo isset($zftags['esfzfsptype'])?$zftags['esfzfsptype']:'暂无';
                                    ?>
                                </span><em>|</em><span><?=$v->size.'㎡'?></span><em>|</em>
                                    <span>
                                        <?=isset($zftags['esffloorcate'])?$zftags['esffloorcate']:'暂无';?>
                                        <?php if($v->total_floor > 0 ): ?>
                                            /共<?=$v->total_floor?>层
                                        <?php endif; ?>
                                    </span>
                                </p>
                                <p class="area"><a href="<?=$this->createUrl('/resoldhome/plot/pesflist',['py'=>$v->plot->pinyin])?>"><?=$v->plot_name?></a>  <a href="<?=$this->createUrl('list',['area'=>$v->area,'type'=>2])?>"><?=$v->area?$v->areaInfo->name:''?></a>  <span><a href="<?=$this->createUrl('list',['street'=>$v->street,'type'=>2])?>"><?=$v->street?$v->streetInfo->name:''?></a></span><span class="maps"><?=Tools::u8_title_substr($v->address,40)?></span></p>

                                <p class="agents">
                                    <a href="<?=$v->source==2&&ResoldStaffExt::findStaffByUid($v->uid)?$this->createUrl('/resoldhome/staff/zfList',['staff'=>ResoldStaffExt::findStaffByUid($v->uid)->id]):'javascript::void(0);'?>"><?=$v->username?></a><span><?=Tools::friendlyDate($v->refresh_time)?>更新</span>
                                </p>
                                <?php $zfts = [1=>'zfzzts',2=>'zfspts',3=>'zfxzlts']; $colorArr = ['green','pink','blue','green','pink','blue','green','pink','blue'];$ts = [];
                                    if(isset($zftags[$zfts[$get['type']]])){
                                        $ts = $zftags[$zfts[$get['type']]];
                                    }

                                ?>

                                    <?php
                                        if($ts):
                                            echo '<p class="tags">';
                                            $i = 0;
                                            foreach($ts as $key=>$value):
                                    ?>
                                    <?php if($i==5) break;?>
                                    <span class="<?=$colorArr[$i]?>"><?=$value?></span>
                                    <?php
                                            $i++;
                                            endforeach;
                                            echo '</p>';
                                        endif;
                                    ?>


                                <div class="about-price">
                                      <p class=""><em class="prices"><?=Tools::FormatPrice($v->price,'</em>元/月')?></p>
                                 </div>
                            </div>
                        <?php elseif($get['type']==3):?>
                            <div class="content fl">
                                <p class="title"><a target="_blank" href="<?=$this->createUrl('info',['id'=>$v->id])?>"><?=$v->title?></a></p>
                                <p class="detail">
                                    <span>
                                        <?php

                                            echo isset($zftags['esfzfxzltype'])?$zftags['esfzfxzltype']:'暂无';
                                        ?>
                                    </span><em>|</em>
                                     <span>
                                        <?=isset($zftags['esffloorcate'])?$zftags['esffloorcate']:'暂无';?>
                                         <?php if($v->total_floor > 0 ): ?>
                                             /共<?=$v->total_floor?>层
                                         <?php endif; ?>
                                    </span>
                                    <em>|</em><span><?=$v->size.'㎡'?></span></p>
                                <p class="area"><a href="<?=$this->createUrl('/resoldhome/plot/pesflist',['py'=>$v->plot->pinyin])?>"><?=$v->plot_name?></a>  <a href="<?=$this->createUrl('list',['area'=>$v->area,'type'=>2])?>"><?=$v->area?$v->areaInfo->name:''?></a>  <span><a href="<?=$this->createUrl('list',['street'=>$v->street,'type'=>2])?>"><?=$v->street?$v->streetInfo->name:''?></a></span><span class="maps"><?=Tools::u8_title_substr($v->address,40)?></span></p>
                                <p class="agents">
                                    <a href="<?=$v->source==2&&ResoldStaffExt::findStaffByUid($v->uid)?$this->createUrl('/resoldhome/staff/zfList',['staff'=>ResoldStaffExt::findStaffByUid($v->uid)->id]):'javascript::void(0);'?>"><?=$v->username?></a><span><?=Tools::friendlyDate($v->refresh_time)?></span>
                                </p>
                                <?php $zfts = [1=>'zfzzts',2=>'zfspts',3=>'zfxzlts']; $colorArr = ['green','pink','blue','green','pink','blue','green','pink','blue'];$ts = [];
                                    if(isset($zftags[$zfts[$get['type']]])){
                                        $ts = $zftags[$zfts[$get['type']]];
                                    }

                                ?>
                                <?php
                                        if($ts):
                                            echo '<p class="tags">';
                                            $i = 0;
                                            foreach($ts as $key=>$value):
                                    ?>
                                    <?php if($i==5) break;?>
                                    <span class="<?=$colorArr[$i]?>"><?=$value?></span>
                                    <?php
                                            $i++;
                                            endforeach;
                                            echo '</p>';
                                        endif;
                                    ?>
                                <div class="about-price">
                                      <p class=""><em class="prices"><?=Tools::FormatPrice($v->price,'</em>元/月')?></p>
                                 </div>
                            </div>
                        <?php else:?>
                        <div class="content fl">
                            <p class="title"><a target="_blank" href="<?=$this->createUrl('info',['id'=>$v->id])?>"><?=$v->title?></a></p>
                            <p class="detail"><span><?=$v->rent_type?TagExt::getNameByTag($v->rent_type):'暂无'?></span><em>|</em><span><?=$v->bedroom?>室<?=$v->livingroom?>厅</span><em>|</em><span><?=$v->size.'㎡'?></span>
                            <em>|</em>
                                 <span>
                                     <?=isset($zftags['esffloorcate'])?$zftags['esffloorcate']:'暂无';?>
                                     <?php if($v->total_floor > 0 ): ?>
                                         /共<?=$v->total_floor?>层
                                     <?php endif; ?>
                                 </span>
                            </p>
                            <p class="area"><a href="<?=$this->createUrl('/resoldhome/plot/pesflist',['py'=>$v->plot->pinyin])?>"><?=$v->plot_name?></a>  <a href="<?=$this->createUrl('list',['area'=>$v->area,'type'=>2])?>"><?=$v->area?$v->areaInfo->name:''?></a>  <span><a href="<?=$this->createUrl('list',['street'=>$v->street,'type'=>2])?>"><?=$v->street?$v->streetInfo->name:''?></a></span><span class="maps"><?=Tools::u8_title_substr($v->address,40)?></span></p>
                            <p class="agents">
                                <a href="<?=$v->source==2&&ResoldStaffExt::findStaffByUid($v->uid)?$this->createUrl('/resoldhome/staff/zfList',['staff'=>ResoldStaffExt::findStaffByUid($v->uid)->id]):'javascript::void(0);'?>"><?=$v->username?></a><span><?=Tools::friendlyDate($v->refresh_time)?></span>
                            </p>
                            <?php $zfts = [1=>'zfzzts',2=>'zfspts',3=>'zfxzlts']; $colorArr = ['green','pink','blue','green','pink','blue','green','pink','blue'];$ts = [];
                                if(isset($zftags[$zfts[$get['type']]])){
                                    $ts = $zftags[$zfts[$get['type']]];
                                }

                            ?>
                            <?php
                                        if($ts):
                                            echo '<p class="tags">';
                                            $i = 0;
                                            foreach($ts as $key=>$value):
                                    ?>
                                    <?php if($i==5) break;?>
                                    <span class="<?=$colorArr[$i]?>"><?=$value?></span>
                                    <?php
                                            $i++;
                                            endforeach;
                                            echo '</p>';
                                        endif;
                                    ?>

                            <div class="about-price">
                                  <p class=""><em class="prices"><?=Tools::FormatPrice($v->price,'</em>元/月')?></em></p>
                             </div>
                        </div>
                    <?php endif;?>

                    </li>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </ul>
                <!--列表-->

                <div class="blank20"></div>
                <div class="page-box">
                    <?php $this->widget('HomeLinkPager', array('pages'=>$pager)) ?>
                </div>
        </div>
        <!--左边小物件-->
        <?php $this->renderPartial('main_left')?>
        <!--end-->
            </div>

        </div>

<div class="blank20"></div>
<?php $this->widget('CommonWidget',['type'=>3])?>
