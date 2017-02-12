<?php
    $this->pageTitle = $seoArr['t'];
    $this->keyword = $seoArr['k'];
    $this->description = $seoArr['d'];
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/list.css');
?>
<div class="wapper-out search-wrap clearfix">
    <div class="search-box clearfix">
    <form method="get" id="search-form">
        <div class="search-input fl">
            <input autocomplete="off" class="input" name="kw" value="<?=$get['kw']?>" placeholder="请输入<?=$get['type']==1?'二手房':Yii::app()->params['category'][$get['type']]?>名称" data-type="1" data-url="<?=$this->createUrl('/api/resoldwapapi/plotsearchajax')?>" data-category="<?=$get['type']?>">
        </div>
            <input type="hidden" name="type" value="<?=$get['type']?>" />
        <a class="btn fl" onclick="document.getElementById('search-form').submit()" >搜索</a>
        <div class="search-list-box">
        </div>
        </form>
        <?php $this->widget('CommonWidget',['type'=>1])?>
    </div>
</div>
<div class="blank5"></div>

<?php if($get['type']==1):?>
    <?php $this->widget('AdWidget',['position'=>'esflbsb']); ?>
    <?php $this->widget('HomeBreadcrumbs',array('links'=>[SM::urmConfig()->cityName().'二手房']));?>
<?php elseif($get['type']==2):?>
    <?php $this->widget('AdWidget',['position'=>'esfsplb']); ?>
    <?php $this->widget('HomeBreadcrumbs',array('links'=>[SM::urmConfig()->cityName().'商铺']));?>
<?php else:?>
    <?php $this->widget('AdWidget',['position'=>'esfxzllb']); ?>
    <?php $this->widget('HomeBreadcrumbs',array('links'=>[SM::urmConfig()->cityName().'写字楼']));?>
<?php endif;?>
<div class="wapper">
    <?php $this->renderPartial('filter')?>
        <div class="blank20"></div>
        <div class="main-left">
            <?php if(isset($school) && $school):?>
            <div class="school-about frame clearfix">
                <div class="info">
                    <p class="n-map"><a href="<?=$this->createUrl('/resoldhome/school/plot',['pinyin'=>$school->pinyin])?>" class="name"><?=$school->name?></a>
                    <span><em><?=$school->address?></em></span>
                    </p>
                    <!-- <p class="lab">
                        <span class="xxue"><i class="list-icon"></i><em><?=$school->type==1?'小学':'中学'?></em></span>
                    </p> -->
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
                       <!--  <p class="c-g9"><?=$avePriceUp?$lowestAvePriceEsf->ave_price:'-'?>元/㎡- <?=$avePriceDown?$highestAvePriceEsf->ave_price:'-'?>元/㎡</p> -->
                    </div>
                    <div class="o-right">
                        <p><em><?=$esfNum?></em>套</p>
                        <p>在售房源</p>
                    </div>
                </div>
            </div>
            <div class="blank20"></div>
            <?php elseif ($plot):?>
            <div class="school-about frame clearfix">
                <div class="info">
                    <p class="n-map"><a href="<?=$this->createUrl('/resoldhome/plot/pesflist',['py'=>$plot->pinyin])?>" class="name"><?=$plot->title?></a></p>
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
            <?php $this->renderPartial('sort')?>
            <?php
                $esfTags = [];
                $allTags = TagExt::tagCache();
                foreach($allTags as $key=>$value){
                    $esfTags[$value->id] = ['cate'=>$value->cate,'name'=>$value->name];
                }

            ?>
            <!--商铺列表-->
            <?php if($get['type']==2):?>
                <?php if($esfs):?>
                <ul class="item-list">

                    <?php foreach ($esfs as $key => $v):?>
                        <?php
                            //获取当前对象的data_conf
                            $esftag = [];
                            $data_conf = CJSON::decode($v->data_conf);
                            if(isset($data_conf['tags']))
                            foreach($data_conf['tags'] as $key=>$value){
                               if(isset($esfTags[$value]) && isset($esfTags[$value]['cate'])) {
                                $cate = $esfTags[$value]['cate'];
                                if(!isset($esftag[$cate])){
                                    $esftag[$cate]=[];
                                }
                                array_push($esftag[$cate],$esfTags[$value]['name']);
                            }
                            }
                            //var_dump($esftag);
                        ?>
                        <li class="item clearfix">
                            <div class="pic fl">
                                <a target="_blank" href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$v->id])?>"><img src="<?=ImageTools::fixImage($v->image,200,150)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())?>'" alt="" /></a>
                                <span class="num">
                                    <span class="img-count"><?=$v->image_count?></span>
                                    <span class="list-icon"></span>
                                </span>
                            </div>
                            <div class="content fl">
                                <p class="title"><a target="_blank" href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$v->id])?>"><?=$v->title?></a></p>
                                <p class="detail"><span><?=isset($esftag['esfzfsptype'])?$esftag['esfzfsptype'][0]:'暂无'?></span><em>|</em><span><?=$v->size?$v->size.'㎡':'暂无'?></span><em>|</em>
                                <?=isset($esftag['esffloorcate'])?$esftag['esffloorcate'][0]:'暂无';?>
                                <?php if($v->total_floor > 0 ): ?>
                                    /共<?=$v->total_floor?>层
                                <?php endif; ?>
                                </p>
                                <p class="area"><a href="<?=$this->createUrl('/resoldhome/plot/pesflist',['py'=>$v->plot->pinyin])?>"><?=$v->plot_name?></a>  <a href="<?=$this->createUrl('list',['area'=>$v->area,'type'=>2])?>"><?=$v->area?$v->areaInfo->name:''?></a>  <span><a href="<?=$this->createUrl('list',['street'=>$v->street,'type'=>2])?>"><?=$v->street?$v->streetInfo->name:''?></a></span><span class="maps"><?=Tools::u8_title_substr($v->address,40)?></span></p>
                                <p class="agents">
                                    <a href="<?=$v->source==2&&ResoldStaffExt::findStaffByUid($v->uid)?$this->createUrl('/resoldhome/staff/esfList',['staff'=>ResoldStaffExt::findStaffByUid($v->uid)->id]):'javascript::void(0);'?>"> <?=$v->username?$v->username:$v->account?></a><span><?php echo Tools::friendlyDate($v->refresh_time);?></span>
                                </p>
                                <?php $colorArr = ['green','pink','blue','green','pink','blue','green','pink','blue','green','pink','blue','green','pink','blue','green','pink','blue'];
                                ?>
                                <?php
                                $tss = isset($esftag['esfspts'])?$esftag['esfspts']:[];
                                ?>
                                <?php if($tss)
                                        {?>
                                <p class="tags">
                                    <?php
                                            $i = 0;
                                            foreach ($tss as $key => $v1) {
                                                if($i==5) break;
                                                ?>
                                                <span class="<?=$colorArr[$i]?>"><?=$v1?></span>
                                            <?php $i++;}?>
                                </p>
                                        <?php }?>

                                <div class="about-price">
                                      <p class=""><em class="prices"><?=Tools::FormatPrice($v->price,'</em>万')?></em></p>
                                      <p class="tag"><?=$v->ave_price?$v->ave_price.'元/㎡':""?></p>
                                 </div>
                            </div>
                        </li>
                        <?php
                    endforeach;
                        ?>

                    </ul>
                <?php endif;?>
                <!--写字楼列表-->
            <?php elseif($get['type']==3):?>
                <?php if($esfs):?>
                <ul class="item-list">
                        <?php foreach ($esfs as $key => $v):?>
                            <?php
                                //获取当前对象的data_conf
                                $esftag = [];
                                $data_conf = CJSON::decode($v->data_conf);
                                if(isset($data_conf['tags']))
                                foreach($data_conf['tags'] as $key=>$value){
                                    if(isset($esfTags[$value]) && isset($esfTags[$value]['cate'])) {
                                        $cate = $esfTags[$value]['cate'];
                                        if(!isset($esftag[$cate])){
                                            $esftag[$cate]=[];
                                        }
                                        array_push($esftag[$cate],$esfTags[$value]['name']);
                                    }
                                }
                                //var_dump($esftag);
                            ?>
                        <li class="item clearfix">
                            <div class="pic fl">
                                <a target="_blank" href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$v->id])?>"><img src="<?=ImageTools::fixImage($v->image,200,150)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())?>'" alt="" /></a>
                                <span class="num">
                                    <span class="img-count"><?=$v->image_count?></span>
                                    <span class="list-icon"></span>
                                </span>
                            </div>
                            <div class="content fl">
                                <p class="title"><a target="_blank" href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$v->id])?>"><?=$v->title?></a></p>
                                <p class="detail"><span><?=isset($esftag['esfzfxzltype'])?$esftag['esfzfxzltype'][0]:'暂无'?></span><em>|</em><span><?=$v->size?$v->size.'㎡':'暂无'?></span><em>|</em>
                                    <?=isset($esftag['esffloorcate'])?$esftag['esffloorcate'][0]:'暂无';?>
                                    <?php if($v->total_floor > 0 ): ?>
                                        /共<?=$v->total_floor?>层
                                    <?php endif; ?>

                                </p>
                                <p class="area"><a href="<?=$this->createUrl('/resoldhome/plot/pesflist',['py'=>$v->plot->pinyin])?>"><?=$v->plot_name?></a>  <a href="<?=$this->createUrl('list',['area'=>$v->area,'type'=>3])?>"><?=$v->area?$v->areaInfo->name:''?></a>  <span><a href="<?=$this->createUrl('list',['street'=>$v->street,'type'=>3])?>"><?=$v->street?$v->streetInfo->name:''?></a></span><span class="maps"><?=Tools::u8_title_substr($v->address,40)?></span></p>

                                <p class="agents">
                                    <a href="<?=$v->source==2&&ResoldStaffExt::findStaffByUid($v->uid)?$this->createUrl('/resoldhome/staff/esfList',['staff'=>ResoldStaffExt::findStaffByUid($v->uid)->id]):'javascript::void(0);'?>"><?=$v->username?$v->username:$v->account?></a><span><?php echo Tools::friendlyDate($v->refresh_time);?></span>
                                </p>
                                <?php $colorArr = ['green','pink','blue','green','pink','blue','green','pink','blue'];;
                                    $tss = isset($esftag['esfxzlts'])?$esftag['esfxzlts']:[];
                                ?>
                                <?php if($tss)
                                        {?>
                                <p class="tags">
                                    <?php
                                            $i = 0;
                                            foreach ($tss as $key => $v1) {
                                                if($i==5) break;
                                                ?>
                                                <span class="<?=$colorArr[$i]?>"><?=$v1?></span>
                                            <?php $i++;}?>
                                </p>
                                        <?php }?>


                                <div class="about-price">
                                      <p class=""><em class="prices"><?=Tools::FormatPrice($v->price,'</em>万')?></em></p>
                                      <p class="tag"><?=$v->ave_price?$v->ave_price.'元/㎡':""?></p>
                                 </div>
                            </div>
                        </li>
                    <?php endforeach;?>

                    </ul>
                <?php endif;?>
            <?php else:?>
                <?php if($esfs):?>
            <ul class="item-list">

                    <?php foreach ($esfs as $key => $v):?>
                    <?php
                        //获取当前对象的data_conf
                        $esftag = [];
                        $data_conf = CJSON::decode($v->data_conf);
                        if(isset($data_conf['tags']))
                        foreach($data_conf['tags'] as $key=>$value){
                            if(isset($esfTags[$value]) && isset($esfTags[$value]['cate'])) {
                                $cate = $esfTags[$value]['cate'];
                                if(!isset($esftag[$cate])){
                                    $esftag[$cate]=[];
                                }
                                array_push($esftag[$cate],$esfTags[$value]['name']);
                            }
                        }
                        //var_dump($esftag);
                    ?>
                    <li class="item clearfix">
                        <div class="pic fl">
                            <a target="_blank" href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$v->id])?>"><img src="<?=ImageTools::fixImage($v->image,200,150)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())?>'" alt="" /></a>
                            <span class="num">
                                <span class="img-count"><?=$v->image_count?></span>
                                <span class="list-icon"></span>
                            </span>
                        </div>
                        <div class="content fl">
                            <p class="title"><a target="_blank" href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$v->id])?>"><?=$v->title?></a></p>
                            <p class="detail"><span><?=$v->bedroom?>室<?=$v->livingroom?>厅<?=$v->bathroom?>卫</span><em>|</em><span><?=$v->size?$v->size.'㎡':'暂无'?></span><em>|</em>
                                <?=isset($esftag['esffloorcate'])?$esftag['esffloorcate'][0]:'暂无';?>
                                <?php if($v->total_floor > 0 ): ?>
                                    /共<?=$v->total_floor?>层
                                <?php endif; ?>
                            </p>
                            <p class="area"><a href="<?=$this->createUrl('/resoldhome/plot/pesflist',['py'=>$v->plot->pinyin])?>"><?=$v->plot_name?></a>  <a href="<?=$this->createUrl('list',['area'=>$v->area])?>"><?=$v->area?$v->areaInfo->name:'';?></a>
                                <span>
                                    <a href="<?=$this->createUrl('list',['street'=>$v->street])?>">
                                        <?=$v->street?$v->streetInfo->name:'';?>
                                    </a>
                                </span><span class="maps"><?=Tools::u8_title_substr($v->address,40)?></span></p>
                            <p class="agents">
                                <a href="<?=$v->source==2&&ResoldStaffExt::findStaffByUid($v->uid)?$this->createUrl('/resoldhome/staff/esfList',['staff'=>ResoldStaffExt::findStaffByUid($v->uid)->id]):'javascript::void(0);'?>"><?=$v->username?$v->username:$v->account?></a><span><?php echo Tools::friendlyDate($v->refresh_time);
                                ?>更新</span>
                            </p>
                            <?php $colorArr = ['green','pink','blue','green','pink','blue','green','pink','blue'];;
                                    $tss = isset($esftag['esfzzts'])?$esftag['esfzzts']:[];
                                ?>
                                <?php if($tss)
                                        {?>
                                <p class="tags">
                                    <?php
                                            $i = 0;
                                            foreach ($tss as $key => $v1) {
                                                if($i==5) break;
                                                ?>
                                                <span class="<?=$colorArr[$i]?>"><?=$v1?></span>
                                            <?php $i++;}?>
                                </p>
                                        <?php }?>
                            <div class="about-price">
                                  <p class=""><em class="prices"><?=Tools::FormatPrice($v->price,'</em>万')?></p>
                                      <p class="tag"><?=$v->ave_price&&$v->ave_price!='0.00'?$v->ave_price.'元/㎡':""?></p>
                             </div>
                        </div>
                    </li>
                <?php endforeach;?>

                </ul>
            <?php endif;?>
        <?php endif;?>
                <div class="blank20"></div>
                <div class="page-box">
                  <?php $this->widget('HomeLinkPager', array('pages'=>$pager)) ?>
                </div>
        </div>
        <?php $this->renderPartial('main_left')?>
        </div>

<div class="blank20"></div>
<?php $this->widget('CommonWidget',['type'=>3])?>

