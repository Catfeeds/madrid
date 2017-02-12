<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/list.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/xiaoqu-public.css');
$this->pageTitle = '小区二手房列表';
?>
<?php $this->renderPartial('plot_search')?>
<div class="wapper xiaoqu-head ovisible">
<?php $this->widget('HomeBreadcrumbs',array('links'=>[$this->plot->title=>$this->createUrl('index',array('py'=>$this->plot->pinyin)),'二手房']));?>
<div class="line"></div>
<?php $this->renderPartial('plot_naver')?>
</div>
<div class="wapper">
    <div class="big-filter">
           <div class="category-select">

               <dl class="clearfix">
                 <dt>总价：</dt>
                 <dd>
                   <?php $this->widget('TagInfoWidget',['cate'=>'esfzzprice','id'=>$get['price'],'get'=>$_GET,'url'=>$this->createUrl('pesflist')])?>

                 </dd>
               </dl>
               <dl class="clearfix">
                 <dt>户型：</dt>
                 <dd>
                   <?php $this->widget('TagInfoWidget',['cate'=>'resoldhuxing','id'=>$get['bedroom'],'get'=>$_GET,'url'=>$this->createUrl('pesflist')])?>
                 </dd>
               </dl>
               <dl class="clearfix">
                 <dt>面积：</dt>
                 <dd>
                   <?php $this->widget('TagInfoWidget',['cate'=>'esfzzsize','id'=>$get['size'],'get'=>$_GET,'url'=>$this->createUrl('pesflist')])?>
                 </dd>
               </dl>
           </div>
       </div>
        <div class="blank20"></div>
        <div class="main-left">

            <div class="next-tabs clearfix">
                <div class="page-right">
                    <?php if($pager->pageCount):?><p><a href="<?=$this->createUrl('pesflist',['py'=>$this->plot->pinyin,'page'=>$page-1>0?$page-1:1])?>" title="上一页"><</a><span class="page"><em><?=$page?></em>/<?=$pager->pageCount?></span><a href="<?=$this->createUrl('pesflist',['py'=>$this->plot->pinyin,'page'=>$page+1])?>" title="上一页">></a></p><?php endif;?>
                </div>
                <ul class="clearfix">
                    <li><a href="<?=$this->createUrl('pesflist',['py'=>$this->plot->pinyin])?>" class="<?=!$get['source']&&!$get['hurry']?'active':''?>">全部房源</a></li>
                    <li><a href="<?=$this->createUrl('pesflist',['source'=>1,'py'=>$this->plot->pinyin])?>" class="<?=$get['source']==1?'active':''?>">个人房源</a></li>
                    <li><a href="<?=$this->createUrl('pesflist',['source'=>2,'py'=>$this->plot->pinyin])?>" class="<?=$get['source']==2?'active':''?>">中介房源</a></li>
                    <li><a href="<?=$this->createUrl('pesflist',['hurry'=>1,'py'=>$this->plot->pinyin])?>" class="<?=$get['hurry']==1?'active':''?>">急售房源</a></li>
                </ul>
            </div>
            <div class="sort">
                <span>找到<em class="c-main"><?=$esfNum?></em>套房源</span>
                <div class="filter fr mt8">

                    <?php $sortGet = array_filter($get);unset($sortGet['sort'])?>

                    <div class="fl paixu">
                        <p>排序：<a href="<?=$this->createUrl('pesflist',['py'=>$this->plot->pinyin,'sort'=>'7']+$sortGet)?>" class="<?=$get['sort']==7?'on':''?>">按更新时间</a>
                            <a href="<?=$this->createUrl('pesflist',['py'=>$this->plot->pinyin,'sort'=>'8']+$sortGet)?>" class="<?=$get['sort']==8?'on':''?>">按发布时间</a></p>
                    </div>
                    <div class="pr fl">
                        <a href="<?=$this->createUrl('pesflist',['py'=>$this->plot->pinyin,'sort'=>$get['sort']==2?1:2]+$sortGet)?>" class="sort-btn price-btn sort-<?=$get['sort']==2?'down':'up'?> <?=$get['sort']==2||$get['sort']==1?'on':'fr'?>">总价<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box"><?=$get['sort']==2?'点击按总价从低到高排序':'点击按总价从高到低排序'?></div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    </div>
                    <div class="pr fl">
                        <a href="<?=$this->createUrl('pesflist',['py'=>$this->plot->pinyin,'sort'=>$get['sort']==6?5:6]+$sortGet)?>" class="sort-btn size-btn sort-<?=$get['sort']==6?'down':'up'?> <?=$get['sort']==6||$get['sort']==5?'on':'fr'?>">面积<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box"><?=$get['sort']==6?'点击按面积从小到大排序':'点击按面积从大到小排序'?></div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    </div>


                </div>
            </div>
            <ul class="item-list">
                    <?php
                    if($esfs):
                        foreach($esfs as $k=>$v):
                    ?>
                    <?php $esftags = $v->getEsfTag();?>
                    <li class="item clearfix">
                        <div class="pic fl">
                            <a href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$v->id])?>" target="_blank"><img src="<?=ImageTools::fixImage($v->image,200,150)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic(),200,150)?>'" alt="" /></a>
                            <span class="num">
                                <span class="img-count"><?=$v->image_count?></span>
                                <span class="list-icon"></span>
                            </span>
                        </div>
                        <div class="content fl">
                            <p class="title"><a href="<?=$this->createUrl('/resoldhome/esf/info',['id'=>$v->id])?>" target="_blank"><?=$v->title?></a></p>
                            <p class="detail"><span><?=$v->bedroom?>室<?=$v->livingroom?>厅<?=$v->bathroom?>卫</span><em>|</em><span>面积：<?=$v->size?$v->size.'㎡':'暂无'?></span><em>|</em><span><?=isset($esftags['floorcate'])?$esftags['floorcate']['name']:$v->floor?>/共<?=$v->total_floor?>层</span><em>|</em><span>建筑年代:<?=$v->age?$v->age.'年':'不详'?></span></p>
                            <p class="area"><a href="<?=$this->createUrl('/resoldhome/plot/pesflist',['py'=>$v->plot->pinyin])?>"><?=$v->plot_name?></a>  <a href="<?=$this->createUrl('list',['area'=>$v->area])?>"><?=$v->area?$v->areaInfo->name:''?></a>  <span><a href="<?=$this->createUrl('list',['street'=>$v->street])?>"><?=$v->street?$v->streetInfo->name:''?></a></span><span class="maps"><?=Tools::u8_title_substr($v->address,40)?></span></p>
                            <p class="agents">
                                <a href=""><?=$v->username?$v->username:$v->account?></a><span><?php echo Tools::friendlyDate($v->refresh_time);
                                ?>更新</span>
                            </p>

                            <?php $colorArr = ['green','pink','blue','green','pink'];
                                $tss = isset($esftags['ts'])?$esftags['ts']:[];
                            ?>

                            <p class="tags">
                                <?php if($tss)
                                    {
                                        $i = 0;
                                        foreach ($tss as $key => $v1) {
                                            if($i==5) break;
                                            ?>
                                            <span class="<?=$colorArr[$i]?>"><?=$v1['name']?></span>
                                        <?php $i++;}
                                    }?>
                            </p>

                            <div class="about-price">
                                  <p class=""><em class="prices"><?=$v->price!=0?Tools::FormatPrice($v->price,'</em>万'):'面议</em>'?></p>
                                  <p class="tag"><?=$v->ave_price?Tools::FormatPrice($v->ave_price,'元/㎡'):''?></p>
                             </div>
                        </div>
                    </li>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </ul>
                <div class="blank20"></div>
                <div class="page-box">
                    <?php $this->widget('HomeLinkPager', array('pages'=>$pager)) ?>
                </div>
        </div>
        <div class="main-right">
            <div class="frame side-box">
                <div class="stitle">
                    <span>二手房资讯</span>
                </div>
                <?php $this->widget('RightWidget',['type'=>'news','limit'=>8])?>
            </div>
            <div class="blank20"></div>
            <?php if(SM::resoldConfig()->resoldIsOpenPlotTrend()):?>
            <div class="frame side-box">
                <div class="stitle">
                    <span><?=SM::urmConfig()->cityName()?>二手房价格趋势</span>
                </div>
                <?php $this->widget('RightWidget',['type'=>'pricetrend','limit'=>5])?>
            </div>
            <div class="blank20"></div>
        <?php endif;?>
            <div class="frame side-box">
                <div class="stitle">
                    <span>最近浏览的房源</span>
                </div>
                <?php $this->widget('ViewRecordWidget',['url'=>'/resoldhome/esf/info','cssType'=>3,'type'=>1,'category'=>1])?>
            </div>
            <div class="blank20"></div>
            <div class="frame side-box">
                <div class="stitle">
                    <span>小区二手房推荐</span>
                </div>
                <?php $this->widget('RightWidget',['type'=>'plotesf','relatedid'=>$this->plot->id,'limit'=>4])?>
            </div>
            <div class="blank20"></div>
            <div class="frame side-box">
                <div class="stitle">
                    <span>热门小区</span>
                </div>
                <?php $this->widget('RightWidget',['type'=>'hotplot','limit'=>10])?>
            </div>
            <div class="blank20"></div>
            <?php $this->renderPartial('left_ad')?>
        </div>

        </div>
<div class="blank20"></div>

<div class="wapper">
    <div class="frame">
        <div class="h-list">
            <p>
                <span>免责声明：</span><?=SM::resoldConfig()->resoldPCFreeStatement()?SM::resoldConfig()->resoldPCFreeStatement():'房源信息有网站用户提供、其真实性、合法性由信息提供者负责，最终以政府部门登记备案为准，本网站不声明或保证内容之正确性和可靠行，购买该房屋时，请谨慎核查，如该房源信息有误，您可以投诉此房源信息或拨打举报电话：0519-83022322'?>
            </p>
        </div>
    </div>

</div>
