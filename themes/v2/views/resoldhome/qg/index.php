<?php
    $this->pageTitle = SM::urmConfig()->cityName.$this->title.'求购_发布'.SM::urmConfig()->cityName.'求购信息- '.SM::globalConfig()->siteName;
    $this->keyword = SM::urmConfig()->cityName.$this->title.'求购';
    if($this->category == 1) {
        $this->description = SM::urmConfig()->cityName .'二手房网提供' . SM::urmConfig()->cityName . '海量优质二手房房源。想在' . SM::urmConfig()->cityName . '找到理想的房子，可以到' . SM::globalConfig()->siteName . '' . SM::urmConfig()->cityName . '二手房网发布求购信息。' . SM::urmConfig()->cityName . '买房子、找房子、个人房屋出售，就到' . SM::globalConfig()->siteName . '。';
    }else{
        $this->description = SM::urmConfig()->cityName .$this->title.'求购频道为您提供'. SM::urmConfig()->cityName .$this->title.'求购信息，在这里有大量的'. SM::urmConfig()->cityName .$this->title.'求购信息供您查询。查找'. SM::urmConfig()->cityName .$this->title.'求购信息，请到' . SM::globalConfig()->siteName . SM::urmConfig()->cityName .$this->title.'求购频道。';
    }
    Yii::app()->clientScript->registerCssFile($this->staticPath.'/style/list.css');
    $current = array(); //临时替换$params变量
?>
<div class="wapper-out search-wrap clearfix">
<form method="get">
    <div class="search-box clearfix">
        <div class="search-input fl">
            <input name="kw"  class="input" placeholder="请输入求购关键字">
        </div>
        <input name="type"  type="hidden" value="<?= $this->category;?>">
        <input type="submit" class="btn fl" value="搜索" >
        <?php $this->widget('CommonWidget'); ?>
    </div>
</form>
</div>

<?php $this->widget('HomeBreadcrumbs',array('links'=>array('求购'.$this->title)));?>

<div class="wapper">
    <div class="big-filter">
        <div class="tabs clearfix">
            <div class="btn-right">
                <a href="<?php echo $this->createUrl('/resoldhome/myesf/buyinput');?>">免费发布求购</a>
            </div>
            <ul class="clearfix">
                <?php if($this->category == 2 || $this->category == 3): ?>
                    <li><a href="<?php echo $this->createUrl('/resoldhome/esf/list',array('type'=>$this->category)); ?>">出售</a></li>
                    <li><a href="<?php echo $this->createUrl('/resoldhome/zf/list',array('type'=>$this->category)); ?>">出租</a></li>
                    <li><a class="on">求购</a></li>
                    <li><a href="<?php echo $this->createUrl('/resoldhome/qz/index',array('type'=>$this->category));?>">求租</a></li>
                <?php endif; ?>
                <?php if($this->category == 1): ?>
                <li><a class="on">按区域查询</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="category-select xuqiu">
            <dl class="clearfix">
                <dt>期望区域：</dt>
                <dd>
                    <?php $this->widget('TagInfoWidget',['url'=>'/resoldhome/qg/index','cate'=>'area','id'=>$params['street'] ? $params['street'] : $params['area'],'get'=>$_GET])?>
                </dd>
            </dl>

            <dl class="clearfix">
                <dt>期望总价：</dt>
                <dd>
                    <?php $this->widget('TagInfoWidget',['url'=>'/resoldhome/qg/index','cate'=>ResoldQgExt::$price_cate[$this->category],'id'=>$params['price'],'get'=>$_GET])?>
                </dd>
            </dl>
            <?php if ($this->category == 1): ?>
            <dl class="clearfix">
                <dt>期望户型：</dt>
                <dd>
                    <?php $this->widget('TagInfoWidget',['cate'=>'resoldhuxing','id'=>$params['bedroom'],'get'=>$_GET,'url'=>'/resoldhome/qg/index'])?>
                </dd>
            </dl>
            <?php endif; ?>
            <dl class="clearfix">
                <dt>期望面积：</dt>
                <dd>
                    <?php $this->widget('TagInfoWidget',['cate'=>ResoldQgExt::$size_cate[$this->category],'id'=>$params['size'],'get'=>$_GET,'url'=>'/resoldhome/qg/index'])?>
                </dd>
            </dl>
            <?php if($this->category == 2 || $this->category == 3): ?>
                <dl class="clearfix">
                    <dt>期望类型：</dt>
                    <dd>
                        <?php $this->widget('TagInfoWidget',['cate'=>ResoldQgExt::$type_cate[$this->category],'id'=>$params['cate'],'get'=>$_GET,'url'=>'/resoldhome/qg/index']); ?>
                    </dd>
                </dl>
            <?php endif; ?>
            <?php if(!empty($condition)): ?>
            <dl class="hascheck">
                <dt>当前选择条件：</dt>
                <dd>
                    <ul class="clearfix">
                        <?php foreach ($condition as $k => $v): ?>
                            <li><a href="<?php
                                $current = $params ;
                                if($k == 'size')
                                    unset($current['minsize'],$current['maxsize']);
                                if($k == 'price')
                                    unset($current['minprice'],$current['maxprice']);
                                unset($current[$k]);
                                echo $this->createUrl('index',array_filter($current)); ?>" class="k-select-1"><?php echo $v;?><i class="list-icon icon-12"></i></a></li>
                        <?php endforeach; ?>
                        <li><a href="<?php echo $this->createUrl('index',array('type'=>$this->category))?>" class="k-select-2"><i class="list-icon icon-clear"></i>清空所有条件</a></li>
                    </ul>
                </dd>
            </dl>
            <?php endif; ?>
        </div>
    </div>
    <div class="blank20"></div>
    <div class="main-left">
        <div class="sort xiaoqu-sort">
            <span>找到<em class="c-main"><?php echo $pager->itemCount;?></em>套房源</span>

            <div class="filter fr mt8">
                <div class="fl paixu">
                    <p>
                        排序：
                        <a href="<?php $current = $params;unset($current['sort']);echo $this->createUrl('index',array_filter($current))?>" class="<?php if($params['sort'] == '') {echo 'on';} ?>">按更新时间</a>
                        <a href="<?php $current = $params;unset($current['sort']);echo $this->createUrl('index',array_merge(array_filter($current),array('sort'=>'1')))?>" class="<?php if($params['sort'] == '1'){ echo 'on'; } ?>">按发布时间</a>
                    </p>
                </div>

                <div class="pr fl">
                    <?php if($params['sort'] == '2'): ?>
                         <a href="<?php echo $this->createUrl('index',array_merge(array_filter($params),array('sort'=>'3')))?>" class="sort-btn sort-down on">价格<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box">点击按价格从低到高排序</div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo $this->createUrl('index',array_merge(array_filter($params),array('sort'=>'2')))?>" class="sort-btn sort-up <?php if($params['sort'] == '3'){echo  'on'; }?>">价格<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box">点击按价格从高到低排序</div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="page-right fl">
                    <p><a href="<?php echo $this->createUrl('/resoldhome/qg/index',array_merge($_GET, array($pager->pageVar=>$pager->currentPage))); ?>" title="下一页"><</a><span class="page"><em><?php echo $pager->currentPage+1; ?></em>/<?php echo $pager->pageCount ? $pager->pageCount : 1; ?></span>
                        <a href="<?php echo $this->createUrl('/resoldhome/qg/index',array_merge($_GET, array($pager->pageVar=>$pager->currentPage+2))); ?>" title="上一页">></a>
                    </p>
                </div>


            </div>
        </div>

        <ul class="item-list">
            <?php foreach ($list as $item): ?>
            <li class="item clearfix">
                <div class="content q-xilie fl">
                    <p class="title"><a href="<?php echo $this->createUrl('/resoldhome/qg/detail',array('id'=>$item->id,'type'=>$item->category));?>"><?php echo Tools::u8_title_substr($item->title,45);?></a></p>
                    <?php if($this->category == 1): ?>
                        <p class="detail"><span><?php echo $item->bedroom; ?>室<?php echo $item->livingroom; ?>厅<?php echo $item->bathroom;?>卫</span><em>|</em><span><?php echo $item->size;?>㎡</span><em>|</em>
                            <span><?php
                                $lc = '暂无';
                                if(isset($item->data_conf['tags']) && $item->data_conf['tags'])
                                foreach ($item->data_conf['tags'] as $value){
                                    if(isset($all_tag['qgzzqwlc'][$value])){
                                        $lc = $all_tag['qgzzqwlc'][$value]['name'];
                                    }
                                }
                                echo $lc;
                                ?></span>
                        </p>
                    <?php elseif ($this->category == 2): ?>
                        <p class="detail"><span>
                                <?php
                                    $type = '暂无';
                                    if(isset($item->data_conf['tags']) && $item->data_conf['tags'])
                                    foreach ($item->data_conf['tags'] as $value){
                                        if(isset($all_tag['esfzfsptype'][$value])){
                                            $type = $all_tag['esfzfsptype'][$value]['name'];
                                        }
                                    }
                                    echo $type;
                                ?>
                            </span><em>|</em><span><?php echo $item->size;?>㎡</span></p>
                    <?php elseif ($this->category == 3): ?>
                        <p class="detail"><span>
                                <?php
                                $type = '暂无';
                                if(isset($item->data_conf['tags']) && $item->data_conf['tags'])
                                foreach ($item->data_conf['tags'] as $value){
                                    if(isset($all_tag['esfzfxzltype'][$value])){
                                        $type = $all_tag['esfzfxzltype'][$value]['name'];
                                    }
                                }
                                echo $type;
                                ?>
                            </span><em>|</em><span><?php echo $item->size;?>㎡</span></p>
                    <?php endif; ?>
                    <?php if(isset($item->areaInfo->name)){ ?>
                        <p class="area"><?php echo $item->areaInfo->name;?>
                            <?php if(isset($item->streetInfo->name)){ ?>
                                <?php echo $item->streetInfo->name; ?>
                            <?php } ?>
                        </p>
                    <?php } ?>
                    <p class="agents">
                        <a href="javascript:;"><?php echo $item->username ; ?></a><span><?php echo Tools::friendlyDate($item->updated,'normal','Y-m-d H:i');?>更新</span>
                    </p>
                    <div class="about-price">
                        <p><em class="prices"><?php echo $item->price > 0 ? $item->price.'</em>万' : '面议</em>';?></p>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <div class="blank20"></div>
        <div class="page-box">
            <?php $this->widget('HomeLinkPager', array('pages'=>$pager)); ?>
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
        <div class="frame side-box">
            <div class="stitle">
                <span><?=SM::urmConfig()->cityName()?>二手房价格趋势</span>
            </div>
            <?php $this->widget('RightWidget',['type'=>'pricetrend','limit'=>5])?>
        </div>
        <div class="blank20"></div>
        <div class="frame side-box">
            <div class="stitle">
                <span>最近浏览的房源</span>
            </div>
            <?php $this->widget('ViewRecordWidget',['url'=>'/resoldhome/esf/info','cssType'=>3,'type'=>1,'category'=>1])?>
        </div>
        <div class="blank20"></div>
        <div class="frame side-box">
            <div class="stitle">
                <span>热门小区</span>
            </div>
            <?php $this->widget('RightWidget',['type'=>'hotplot','limit'=>10])?>
        </div>
        <div class="blank20"></div>
        <?php $this->widget('AdWidget',['position'=>'esfycbanner']); ?>
    </div>

</div>
<div class="blank20"></div>
<?php $this->widget('CommonWidget',['type'=>3])?>