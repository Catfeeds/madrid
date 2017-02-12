<?php

        var_dump(Yii::app()->request->getPathInfo());
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/list.css');
$this->pageTitle = '商铺出售详情';
?>

<div class="wapper-out search-wrap clearfix">
    <div class="search-box clearfix">
        <form method="get" id="search-form">
        <div class="search-input fl">
            <input class="input" name="kw" value="<?=$get['kw']?>" placeholder="输入区域、小区名称、学校名称找二手房">
        </div>
        <a class="btn fl" onclick="document.getElementById('search-form').submit()">搜索</a>
        </form>
        <div class="search-list-box">
            <ul>
                <li>
                    <span>大名城<em>新北三井</em></span>
                    <span class="right">约469条房源</span>
                </li>
                <li>
                    <span>大名城别墅<em>新北三井</em></span>
                    <span class="right">约469条房源</span>
                </li>
            </ul>
        </div>
        <?php $this->widget('CommonWidget',['type'=>1])?>
    </div>
</div>
<?php $this->widget('HomeBreadcrumbs',array('links'=>[SM::urmConfig()->cityName().'二手房','二手房商铺列表']));?>
<div class="wapper">
     <div class="big-filter">
        <div class="tabs clearfix">
            <div class="btn-right">
                <a href="<?=$this->createUrl('/resoldhome/myesf/sellinput')?>">免费发布房源</a>
            </div>
            <ul class="clearfix">
              <li><a href="<?=$this->createUrl('list')?>" >按区域查询</a></li>
              <li><a href="" >按学校查询</a></li>
              <li><a href="" >切换到地图搜索</a></li>
              <li><a href="<?=$this->createUrl('list',['type'=>2])?>" class="on">商铺</a></li>
              <li><a href="<?=$this->createUrl('list',['type'=>3])?>" >写字楼</a></li>
            </ul>
        </div>
        <div class="category-select">
            <dl class="clearfix">
              <dt>区域：</dt>
              <dd>
                <?php $this->widget('TagInfoWidget',['cate'=>'area','id'=>$get['area']?$get['area']:$get['street'],'get'=>$_GET,'url'=>'/resoldhome/esf/list'])?>
              </dd>
            </dl>
            <dl class="clearfix">
              <dt>面积：</dt>
              <dd>
                <?php $this->widget('TagInfoWidget',['cate'=>'esfzzsize','id'=>$get['size'],'get'=>$_GET,'url'=>'/resoldhome/esf/list'])?>
              </dd>
            </dl>
            <dl class="clearfix">
              <dt>总价：</dt>
              <dd>
                <?php $this->widget('TagInfoWidget',['cate'=>'esfzzprice','id'=>$get['price'],'get'=>$_GET,'url'=>'/resoldhome/esf/list'])?>
              </dd>
            </dl>
            <dl class="clearfix">
              <dt>类型：</dt>
              <dd>
                <?php $this->widget('TagInfoWidget',['cate'=>'esfzfsptype','id'=>$get['cate'],'get'=>$_GET,'url'=>'/resoldhome/esf/list'])?>
              </dd>
            </dl>
            <dl class="clearfix">
              <dt>特色：</dt>
              <dd>
                <?php $this->widget('TagInfoWidget',['cate'=>'esfspts','id'=>$get['ts'],'get'=>$_GET,'url'=>'/resoldhome/esf/list'])?>
              </dd>
            </dl>
            <dl class="hascheck">
              <dt>当前选择条件：</dt>
              <dd>
                    <ul class="clearfix">
                        <?php if(array_filter($get))
                        foreach (array_filter($get) as $key => $value) {?>
                            <?php if($key=='area'||$key=='street'):
                                $tag = AreaExt::model()->findByPk($value);
                                $tmpGets = array_filter($get);
                                unset($tmpGets['area']);
                                unset($tmpGets['street']);
                            ?>
                            <li><a href="<?=$this->createUrl('list',array_filter($tmpGets))?>" class="k-select-1"><?=$tag->name?><i class="list-icon icon-12"></i></a></li>
                            <?php elseif($key=='source'):
                                $tag = Yii::app()->params['source'];
                                $tmpGets = array_filter($get);
                                unset($tmpGets['source']);
                            ?>
                            <li><a href="<?=$this->createUrl('list',array_filter($tmpGets))?>" class="k-select-1"><?=$tag[$value]?><i class="list-icon icon-12"></i></a></li>
                            <?php elseif($key=='kw'):
                                $tmpGets = array_filter($get);
                                unset($tmpGets['kw']);
                            ?>
                            <li><a href="<?=$this->createUrl('list',array_filter($tmpGets))?>" class="k-select-1"><?=$get[$key]?><i class="list-icon icon-12"></i></a></li>
                            <?php elseif($key=='hid'):
                                $tmpGets = array_filter($get);
                                unset($tmpGets['hid']);
                            ?>
                            <li><a href="<?=$this->createUrl('list',array_filter($tmpGets))?>" class="k-select-1"><?=$plot?$plot->title:'未知楼盘'?><i class="list-icon icon-12"></i></a></li>
                        <?php elseif($key != 'saletime' && $key != 'sort' && $key != 'type'):
                                $tag = TagExt::getNameByTag($value);
                                $tmpGets = array_filter($get);
                                unset($tmpGets[$key]);
                            ?>
                            <li><a href="<?=$this->createUrl('list',array_filter($tmpGets))?>" class="k-select-1"><?=$tag?><i class="list-icon icon-12"></i></a></li>
                            <?php endif;?>
                        <?php }?>
                            <li><a href="<?=$this->createUrl('list')?>" class="k-select-2"><i class="list-icon icon-clear"></i>清空所有条件</a></li>
                    </ul>
              </dd>
            </dl>

        </div>
    </div>
        <div class="blank20"></div>
        <div class="main-left">
            <div class="next-tabs clearfix">
                <div class="page-right">
                    <p><a href="<?=$this->createUrl('list',['page'=>$page-1>0?$page-1:1]+array_filter($_GET))?>" title="上一页"><</a><span class="page"><em><?=$page?></em>/<?=$pager->pageCount?></span><a href="<?=$this->createUrl('list',['page'=>$page+1]+array_filter($_GET))?>" title="下一页">></a></p>
                </div>
                <ul class="clearfix">
                    <li><a href="<?=$this->createUrl('list')?>" class="<?=!$get['source']&&!$get['hurry']?'active':''?>">在售商铺</a></li>
                    <li><a href="<?=$this->createUrl('/resoldhome/zf/list',['type'=>2])?>" class="<?=$get['source']==1?'active':''?>">在租商铺</a></li>
                    <li><a href="<?=$this->createUrl('list',['source'=>1,'type'=>2])?>" class="<?=$get['source']==1?'active':''?>">个人房源</a></li>
                    <li><a href="<?=$this->createUrl('list',['hurry'=>1,'type'=>2])?>" class="<?=$get['hurry']==1?'active':''?>">急售房源</a></li>
                </ul>
            </div>
            <div class="sort">
                <span>找到<em class="c-main"><?=$esfNum?></em>套商铺</span>
                <div class="filter fr mt8">
                    <div class="fl filter_sel dropdown open">
                        <a class="dropdown_toggle" data-toggle="dropdown"><?=$get['saletime']?$get['saletime'].'天内':'发布时间'?><span class="caret list-icon"></span></a>
                        <ul class="filter_sel_box dropdown-menu dn">
                        <?php $saleGet = array_filter($get);unset($saleGet['saletime'])?>
                            <li><a href="<?=$this->createUrl('list',$saleGet)?>">不限</a></li>
                            <li><a href="<?=$this->createUrl('list',['saletime'=>1]+$saleGet)?>" >1天内</a></li>
                            <li><a href="<?=$this->createUrl('list',['saletime'=>3]+$saleGet)?>" >3天内</a></li>
                            <li><a href="<?=$this->createUrl('list',['saletime'=>7]+$saleGet)?>">7天内</a></li>
                        </ul>
                    </div>
                    <div class="fl filter_sel dropdown open">
                        <?php $sortArr = [
                            '7'=>'按更新时间排序',
                            // '1'=>'按总价从低到高',
                            // '2'=>'按总价从高到低',
                            // '5'=>'按面积从小到大',
                            // '6'=>'按面积从大到小',
                            '3'=>'按单价从低到高',
                            '4'=>'按单价从高到低',
                            '8'=>'按发布时间排序',
                        ];?>
                        <a class="dropdown_toggle" data-toggle="dropdown"><?=isset($sortArr[$get['sort']])?$sortArr[$get['sort']]:'默认排序'?><span class="caret list-icon"></span></a>
                        <ul class="filter_sel_box dropdown-menu dn">
                        <?php $sortGet = array_filter($get);unset($sortGet['sort'])?>
                            <li><a href="<?=$this->createUrl('list',['sort'=>'7']+$sortGet)?>">按更新时间排序</a></li>
                            <!-- <li><a href="<?=$this->createUrl('list',['sort'=>'1']+$sortGet)?>" >按总价从低到高</a></li>
                            <li><a href="<?=$this->createUrl('list',['sort'=>'2']+$sortGet)?>" >按总价从高到低</a></li>
                            <li><a href="<?=$this->createUrl('list',['sort'=>'5']+$sortGet)?>">按面积从小到大</a></li>
                            <li><a href="<?=$this->createUrl('list',['sort'=>'6']+$sortGet)?>">按面积从大到小</a></li> -->
                            <li><a href="<?=$this->createUrl('list',['sort'=>'3']+$sortGet)?>" >按单价从低到高</a></li>
                            <li><a href="<?=$this->createUrl('list',['sort'=>'4']+$sortGet)?>" >按单价从高到低</a></li>
                            <li><a href="<?=$this->createUrl('list',['sort'=>'8']+$sortGet)?>">按发布时间排序</a></li>
                            <li><a href="<?=$this->createUrl('list',$sortGet)?>">默认排序</a></li>
                        </ul>
                    </div>
                    <div class="pr fl">
                        <a href="<?=$this->createUrl('list',['sort'=>'2']+$sortGet)?>" class="sort-btn sort-<?=$get['sort']==2?'up':'down'?> on">总价<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box"><?=$get['sort']==2?'点击按总价从低到高排序':'点击按总价从高到低排序'?></div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    </div>
                    <div class="pr fl">
                        <a href="<?=$this->createUrl('list',['sort'=>'6']+$sortGet)?>" class="sort-btn sort-<?=$get['sort']==6?'up':'down'?> fr">面积<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box"><?=$get['sort']==6?'点击按面积从小到大排序':'点击按面积从大到小排序'?></div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    </div>


                </div>
            </div>
            <?php if($esfs):?>
            <ul class="item-list">

                <?php foreach ($esfs as $key => $v):?>
                    <li class="item clearfix">
                        <div class="pic fl">
                            <a href=""><img src="<?=ImageTools::fixImage($v->image)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())?>'" alt="" /></a>
                            <span class="num">
                                <span class="img-count"><?=$v->image_count?></span>
                                <span class="list-icon"></span>
                            </span>
                        </div>
                        <div class="content fl">
                            <p class="title"><a href="<?=$this->createUrl('info',['id'=>$v->id])?>"><?=$v->title?></a></p>
                            <p class="area"><a href="<?=$this->createUrl('list',['type'=>2,'area'=>$v->area])?>"><?=$v->areaInfo->name?></a><span class="maps"><?=$v->streetInfo->name?></span></p>
                            <p class="detail"><span>类型：<?=isset($v->getEsfTag()['esfzfsptype'])?$v->getEsfTag()['esfzfsptype']['name']:''?></span><em>|</em><span><?=isset($v->getEsfTag()['floorcate'])?$v->getEsfTag()['floorcate']['name']:$v->floor?>/<?=$v->total_floor?>层</span></p>
                            <p class="agents">
                                <a href=""><?=$v->username?$v->username:$v->account?></a><span><?php echo Tools::friendlyDate($v->refresh_time);?></span>
                            </p>
                            <?php $colorArr = ['green','pink','blue','green','pink','blue','green','pink','blue'];$data_conf = json_decode($v->data_conf,true);$tss = [];
                                if(isset($data_conf['tags']) && $data_conf['tags'])
                                    foreach ($data_conf['tags'] as $key => $value) {
                                        if(TagExt::getCateByTag($value)=='esfzzts')
                                            $tss[] = TagExt::getNameByTag($value);
                                    }
                            ?>
                            <p class="tags">
                                <?php if($tss)
                                    {
                                        $i = 0;
                                        foreach ($tss as $key => $v1) {?>
                                            <span class="<?=$colorArr[$i]?>"><?=$v1?></span>
                                        <?php $i++;}
                                    }?>
                            </p>

                            <div class="area-detail"><p><?=isset($v->size)?$v->size:"-"?>㎡</p><p class="tag">建筑面积</p></div>
                            <div class="about-price">
                                  <p class=""><em class="prices"><?=isset($v->price)?$v->price:"-"?></em>万</p>
                                  <p class="tag"><?=isset($v->ave_price)?$v->ave_price:"-"?>元/㎡</p>
                             </div>
                        </div>
                    </li>
                    <?php
                endforeach;
                    ?>

                </ul>
            <?php endif;?>
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

            <div class="gg-type80">
                <ul>
                    <li><a href=""><img src="images/gg1.jpg" data-bd-imgshare-binded="1"></a></li>
                </ul>
            </div>
            <div class="gg-type210">
                <ul>
                    <li><a href=""><img src="images/gg2.jpg" data-bd-imgshare-binded="1"></a></li>
                    <li><a href=""><img src="images/gg2.jpg" data-bd-imgshare-binded="1"></a></li>
                    <li><a href=""><img src="images/gg2.jpg" data-bd-imgshare-binded="1"></a></li>
                </ul>
            </div>
        </div>

            </div>

        </div>
      </div>
</div>
