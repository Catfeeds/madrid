<?php
$areaInfo = ($selectedArea ? $selectedArea->name : '') . ($selectedStreet ? $selectedStreet->name : '') . (isset($priceTag[$this->urlConstructor->price]) ? $priceTag[$this->urlConstructor->price]->title : '');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/home/style/kanfangtuan.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/static/home/js/modernizr.custom.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/static/home/js/main.js', CClientScript::POS_END);
$this->pageTitle = $this->siteConfig['cityName'].$areaInfo.'楼盘_'.$this->siteConfig['cityName'].$areaInfo.'新楼盘_'.$this->siteConfig['cityName'].$areaInfo.'新房价格-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
Yii::app()->clientScript->registerMetaTag($this->siteConfig['cityName'].$areaInfo.'楼盘,'.$this->siteConfig['cityName'].$areaInfo.'新楼盘,'.$this->siteConfig['cityName'].$areaInfo.'新房价格-'.$this->siteConfig['siteName'].'房产','keywords');
Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'房产网为您提供最新最全的'.$areaInfo.'新房信息，方便广大网友快速找到喜爱的新房楼盘，购买'.$this->siteConfig['cityName'].$areaInfo.'新盘就上'.$this->siteConfig['siteName'].'房产网','description');
$this->breadcrumbs = array($this->siteConfig['cityName'].'新房');
?>
<?php $this->widget('AdWidget',['position'=>'lpklbysb']); ?>
<div class="xinpan">
<div class="tabs clearfix">
    <ul>
        <li><a href="javascript:void(0)" class="on">楼盘搜索</a></li>
        <li><a href="<?php echo $this->createUrl('/home/map/index');?>" class="map-search" target="_blank">地图找房</a></li>
    </ul>
</div>
<div class="category-select">
    <dl>
        <dt>区域</dt>
        <dd>
            <ul class="main">
                <li><a href="<?php echo $this->urlConstructor->remove('place')?>" class="bx">不限</a></li>
                <?php
                    foreach($allArea as $k=>$v):
                        if($v->getIsFirstLevel()):
                ?>
                <li>
                    <a href="<?php echo $this->urlConstructor->add('place', $v->id); ?>" <?php if($selectedArea&&$selectedArea->id==$v->id): $this->urlConstructor->addClearItem($v->name, 'place');?>class="on"<?php endif;?>><?php echo $v->name;?></a>
                </li>
                <?php
                        endif;
                    endforeach;
                ?>
            </ul>
            <?php if($selectedArea):?>
            <ul class="sub">
                <li><a href="<?php echo $this->urlConstructor->add('place', $selectedArea->id); ?>" <?php if(!$selectedStreet):?>class="on"<?php endif;?>>不限</a></li>
                <?php
                    foreach($allArea as $v):if($v->parent==$selectedArea->id):
                ?>
                    <li><a href="<?php echo $this->urlConstructor->add('place', $v->id); ?>" <?php if($selectedStreet&&$selectedStreet->id == $v->id): $this->urlConstructor->addClearItem($v->name, 'place', $this->urlConstructor->add('place', $selectedArea->id)); ?>class="on"<?php endif; ?>><?php echo $v->name;?></a></li>
                <?php
                endif;
                    endforeach;
                ?>
            </ul>
            <?php endif;?>
        </dd>
    </dl>
    <dl>
        <dt>类型</dt>
        <dd>
            <ul>
                <li><a href="<?php echo $this->urlConstructor->remove('wylx'); ?>" class="bx">不限</a></li>
                <?php
                    if(!empty($allTagsIndexByCate['wylx'])):
                        foreach($allTagsIndexByCate['wylx'] as $k=>$v):
                ?>
                <li><a <?php if($this->urlConstructor->wylx == $v->id): $this->urlConstructor->addClearItem($v->name, 'wylx'); ?>class="on"<?php endif;?> href="<?php echo $this->urlConstructor->add('wylx',$v->id);?>"><?php echo $v->name;?></a></li>
                <?php
                        endforeach;
                    endif;
                ?>
            </ul>
        </dd>
    </dl>
    <dl>
        <dt>价格</dt>
        <dd>
            <ul>
                <li><a href="<?php echo $this->urlConstructor->remove('price');?>" class="bx">不限</a></li>
                <?php
                    if(!empty($priceTag)):
                        foreach($priceTag as $v):
                ?>
                <li><a <?php if($this->urlConstructor->price == $v->id): $this->urlConstructor->addClearItem($v->title, 'price');?>class="on"<?php endif;?> href="<?php echo $this->urlConstructor->add('price', $v->id);?>"><?php echo $v->title;?></a></li>
                <?php
                        endforeach;
                    endif;
                ?>
            </ul>
        </dd>
    </dl>
    <dl>
        <dt>特色</dt>
        <dd>
            <ul>
                <li><a href="<?php echo $this->urlConstructor->remove('xmts');?>" class="bx">不限</a></li>
                <?php
                if(!empty($allTagsIndexByCate['xmts'])):
                    foreach($allTagsIndexByCate['xmts'] as $k=>$v):
                        ?>
                        <li><a <?php if($this->urlConstructor->xmts == $v->id): $this->urlConstructor->addClearItem($v->name, 'xmts');?>class="on"<?php endif;?> href="<?php echo $this->urlConstructor->add('xmts',$v->id);?>"><?php echo $v->name;?></a></li>
                    <?php
                    endforeach;
                endif;
                ?>
            </ul>
        </dd>
    </dl>
    <dl class="other">
        <dt>其他</dt>
        <dd>
            <div class="filter gc3 fs14">
                <div class="fl filter_sel dropdown open">
                    <a class="dropdown_toggle" data-toggle="dropdown"><?php echo isset($allTagsIndexByCate['xszt'][$this->urlConstructor->xszt]) ? $allTagsIndexByCate['xszt'][$this->urlConstructor->xszt]->name : '销售状态';?><span class="caret list_icon"></span></a>
                    <ul class="filter_sel_box dropdown-menu dn" style="display: none;">
                        <?php if($this->urlConstructor->xszt):?>
                        <li><a href="<?php echo $this->urlConstructor->remove('xszt');?>">全部</a>
                        <?php endif;?>
                        <?php
                            foreach($allTagsIndexByCate['xszt'] as $k=>$v):
                                ?>
                                <li><a <?php if($this->urlConstructor->xszt == $v->id): $this->urlConstructor->addClearItem($v->name, 'xszt');?>class="on"<?php endif;?> href="<?php echo $this->urlConstructor->add('xszt',$v->id);?>"><?php echo $v->name;?></a></li>
                            <?php
                            endforeach;
                        ?>
                    </ul>
                </div>
                <span class="shuxian fl">|</span>
                <div class="fl filter_sel dropdown open filter_types">
                    <a class="dropdown_toggle" data-toggle="dropdown"><?php echo isset($allTagsIndexByCate['zxzt'][$this->urlConstructor->zxzt]) ? $allTagsIndexByCate['zxzt'][$this->urlConstructor->zxzt]->name : '装修状态';?><span class="caret list_icon"></span></a>
                    <ul class="filter_sel_box dropdown-menu dn" style="display:none;">
                        <?php if($this->urlConstructor->zxzt):?>
                        <li><a href="<?php echo $this->urlConstructor->remove('zxzt');?>">全部</a>
                            <?php endif;?>
                        <?php
                        if(!empty($allTagsIndexByCate['zxzt'])):
                            foreach($allTagsIndexByCate['zxzt'] as $k=>$v):
                        ?>
                        <li><a <?php if($this->urlConstructor->zxzt == $v->id): $this->urlConstructor->addClearItem($v->name, 'zxzt'); ?>class="on"<?php endif;?> href="<?php echo $this->urlConstructor->add('zxzt',$v->id);?>"><?php echo $v->name;?></a></li>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                </div>
                <span class="shuxian fl">|</span>
                <div class="fl filter_sel dropdown open filter_times">
                    <a class="dropdown_toggle" data-toggle="dropdown"><?php if($this->urlConstructor->kpsj):?><?php echo $kpsjOptions[$this->urlConstructor->kpsj]['name'];?><?php else:?>开盘时间<?php endif;?><span class="caret list_icon"></span></a>
                    <ul class="filter_sel_box dropdown-menu dn" style="display: none;">
                        <?php if($this->urlConstructor->kpsj):?>
                        <li><a href="<?php echo $this->urlConstructor->remove('kpsj');?>">全部</a>
                            <?php endif;?>
                            <?php
                            foreach($kpsjOptions as $k=>$v):
                            ?>
                        <li><a <?php if($this->urlConstructor->kpsj == $k): $this->urlConstructor->addClearItem($v['name'], 'kpsj');?>class="on"<?php endif;?> href="<?php echo $this->urlConstructor->add('kpsj',$k);?>"><?php echo $v['name'];?></a></li>
                            <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="clear"></div>
        </dd>
    </dl>
    <dl class="hascheck">
        <dt>已选状态</dt>
        <dd>
            <ul>
                <?php foreach($this->urlConstructor->clearItems as $k=>$v): ?>
                    <li><a href="<?php echo $v['url']; ?>" class="k-select-1"><?php echo $v['name']; ?><i class="kanfangicon icon-12"></i></a></li>
                <?php endforeach; ?>
                <li><a href="<?php echo $this->createUrl('/home/plot/list')?>" class="k-select-3"><i class="kanfangicon icon-14"></i>清空所有条件</a></li>
            </ul>
        </dd>
    </dl>
</div>
<div class="main-block clearfix">
<div class="main-left fl">
    <div class="sort">
        <span class="t1"><?php echo $this->siteConfig['cityName']; ?>新盘</span>
        <span class="t2">找到<span class="k-em-2"><?php echo $pager->itemCount;?></span>个符合条件的楼盘</span>
        <span class="split">|</span>

        <label class="tuangou-check"><input type="checkbox" data-url="<?php if($this->urlConstructor->tuan){echo $this->urlConstructor->remove('tuan');}else{echo $this->urlConstructor->add('tuan','1');} ?>"  id="tuan" class="k-inline-block-middle" <?php echo $this->urlConstructor->tuan?'checked':'';?> />团购</label>
        <span class="split">|</span>
        <label for="">选择排序：</label>
        <a href="<?php echo $this->urlConstructor->remove('order');?>" class="sort-btn<?php if(!$this->urlConstructor->order):?> on<?php endif;?>">默认排序</a>
        <a href="<?php echo $sortItems->createUrl('售价'); ?>" class="sort-btn <?php if($sortItems->item=='price'): ?>on <?php endif; echo $sortItems->desc ? 'sort-down' : 'sort-up'; ?>">售价<i></i></a>
        <a href="<?php echo $sortItems->createUrl('开盘时间'); ?>" class="sort-btn <?php if($sortItems->item=='open_time'): ?>on <?php endif; echo $sortItems->desc ? 'sort-down' : 'sort-up'; ?>">开盘时间<i></i></a><span class="split">|</span>
        <ul class="page-short-select">
            <a href="<?php echo $this->createUrl('/home/plot/list',array_merge($_GET, array($pager->pageVar=>$pager->currentPage+2))); ?>" title="下一页"><li class="prev kanfangicon icon-16"></li></a>
            <li class="page"><?php echo $pager->currentPage+1; ?>/<?php echo $pager->pageCount ? $pager->pageCount
            : 1; ?></li>
            <a href="<?php echo $this->createUrl('/home/plot/list',array_merge($_GET, array($pager->pageVar=>$pager->currentPage))); ?>" title="上一页"><li class="next kanfangicon icon-15"></li></a>

        </ul>
    </div>
    <ul class="item-list">
        <?php
            foreach($plots as $key=>$val):
        ?>
        <li class="item clearfix">
            <div class="pic fl">
                <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$val->pinyin));?>" target="_blank" title="<?php echo $val->title;?>">
                <img src="<?php echo ImageTools::fixImage($val->image,'240','178'); ?>" >
                </a>
                            <span class="num">
                                <span class="kanfangicon icon-27"></span>
                                <span class="img_count"><?php echo $val->imgcount;?></span>
                            </span>
            </div>
            <div class="content fl">
                <div class="title">
                    <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$val->pinyin));?>" target="_blank" title="<?php echo $val->title;?>" class="c-g3">
                        <?php echo $val->title;?>
                    </a>
                    <?php if($val->xszt): ?>
                    <span class="lpstate"><i class="state state-1"></i><?php echo $val->xszt->name;?></span>
                    <?php endif; ?>
                    <?php if($val->kan_id):?>
                    <span class="lpstate"><i class="state state-2"></i>看房团</span>
                    <?php endif;?>
                    <?php if($val->tuan):?>
                    <span class="lpstate"><i class="state state-3"></i>团购进行中</span>
                    <?php endif;?>
                    <span class="lpstate"><i class="state state-4"></i>新盘</span>
                </div>
                <div class="price">
                    <p class="r1">
                        <span class="k-em-2"><?php if($val->price>0):?><?php echo $val->price;?></span><span class="unit"><?php echo PlotPriceExt::$unit[$val->unit];?><?php else:?>暂无报价<?php endif;?></span>
                    </p>
                    <p class="r3 k-em-2"><?php echo $val->newDiscount ? $val->newDiscount->title : '';?></p>
                </div>
                <p class="address"><?php echo $val->address;?></p>
                <p class="area"><?php echo isset($allArea[$val->area])?$allArea[$val->area]->name:'';?><?php echo isset($allArea[$val->street])?'/'.$allArea[$val->street]->name:''?>
<!--                    <a class="jjmap">街景</a>-->
                </p>
                <p class="phone"><?php echo $val->sale_tel;?></p>
                <p class="tags">
                    <?php
                        foreach($val->xmts as $v):
                    ?>
                    <a href="<?php echo $this->urlConstructor->add('xmts',$v->id);?>"><?php echo $v->name; ?></a>
                    <?php
                        endforeach;
                    ?>
                </p>
            </div>
        </li>
        <?php
            endforeach;
        ?>
    </ul>
    <div class="blank20"></div>
    <div class="page-box fs14 fr" style="text-align:right">
        <?php $this->widget('HomeLinkPager', array('pages'=>$pager)); ?>
    </div>
    <div class="blank20"></div>
</div>
<div class="main-right fr">
    <?php $this->widget('AdWidget',['position'=>'lpklbyycbanner']); ?>
    <div class="mod-tuangou small-tuangou ui-mouseenter">
        <?php $this->renderPartial('/layouts/hotTuan');?>
    </div>
    <div class="newloupan">
        <div class="title"><?php echo $this->siteConfig['cityName']; ?>最新楼盘</div>
        <ul>
            <?php
                if(!empty($newPlot)):
                    foreach($newPlot as $k=>$v):
            ?>
            <li>
                <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->pinyin))?>" target="_blank" title="<?php echo $v->title;?>">
                    <span class="fl name"><?php echo $v->title?></span>
                    <span class="fr unit"><?php echo PlotPriceExt::getPrice($v->price,$v->unit);?></span>
                </a>
            </li>
            <?php
                    endforeach;
                endif;
            ?>
        </ul>
    </div>
    <div class="queryloupan">
        <div class="title">您浏览过的楼盘</div>
        <ul>
            <?php
                foreach($this->viewRecordor->getViewedPlots() as $plot):
            ?>
            <li>
                <a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$plot->pinyin))?>" target="_blank" title="<?php echo $plot->title;?>">
                    <span class="fl name"><?php echo $plot->title;?></span>
                    <span class="fr unit"><?php echo PlotPriceExt::getPrice($plot->price,$plot->unit);?></span>
                </a>
            </li>
            <?php
                endforeach;
            ?>
        </ul>
    </div>
</div>
</div>

</div>
