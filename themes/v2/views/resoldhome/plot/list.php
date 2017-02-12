<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/list.css');
    $this->pageTitle = SM::urmConfig()->cityName().'小区信息，'.SM::urmConfig()->cityName().'房价，'.SM::urmConfig()->cityName().'楼盘信息-'.SM::GlobalConfig()->siteName();
    $this->keyword = SM::urmConfig()->cityName().'小区信息，'.SM::urmConfig()->cityName().'房价，'.SM::urmConfig()->cityName().'楼盘信息';
    $this->description = SM::GlobalConfig()->siteName().'为您提供海量的'.SM::urmConfig()->cityName().'小区信息，小区房价，小区详情，周边配套，实景图，户型图，专业客观反映'.SM::urmConfig()->cityName().'房价走势，为您选购'.SM::urmConfig()->cityName().'二手房提供全方位参考';
?>
<?php $this->renderPartial('plot_search')?>
<?php $this->widget('HomeBreadcrumbs',array('links'=>['小区列表']));?>
<div class="wapper">
 <div class="big-filter">
        <div class="tabs clearfix">
            <div class="btn-right">
                <a href="<?=$this->createUrl('/resoldhome/myesf/sellinput')?>">免费发布房源</a>
            </div>
            <ul class="clearfix">
              <li><a href="<?=$this->createUrl('list')?>" class="on">按区域查询</a></li>
              <li><a href="<?=$this->createUrl('/resoldhome/map/index')?>" >切换到地图搜索</a></li>
            </ul>
        </div>
        <div class="category-select">
            <dl class="clearfix">
              <dt>区域：</dt>
              <dd>
                  <?php $this->widget('TagInfoWidget',['cate'=>'area','id'=>$get['area']?$get['area']:$get['street'],'get'=>$_GET,'url'=>'/resoldhome/plot/list'])?>
              </dd>
            </dl>
            <dl class="clearfix">
              <dt>均价：</dt>
              <dd>
                <?php $this->widget('TagInfoWidget',['cate'=>'plotprice','id'=>$get['price'],'get'=>$_GET,'url'=>'/resoldhome/plot/list']);?>
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
                  <?php elseif($key != 'saletime' && $key != 'sort' && $key != 'minprice' && $key != 'maxprice'):
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


            <div class="sort xiaoqu-sort">
                <span>找到<em class="c-main"><?=$count?></em>个楼盘</span>

                <div class="filter fr mt8">


                    <div class="pr fl">
                        <a href="<?=$this->createUrl('list',['sort'=>$get['sort']==7?8:7])?>" class="sort-btn sort-<?=$get['sort']==7?'down':'up'?> <?=$get['sort']==7 || $get['sort']==8?'on':'fr'?>">均价<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box"><?=$get['sort']==7?'点击按均价从低到高排序':'点击按均价从高到低排序'?></div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    </div>
                    <div class="pr fl">
                        <a href="<?=$this->createUrl('list',['sort'=>$get['sort']==9?10:9])?>" class="sort-btn sort-<?=$get['sort']==9?'down':'up'?> <?=$get['sort']==9 || $get['sort']==10?'on':'fr'?>">房源数量<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box"><?=$get['sort']==9?'点击按涨幅从小到大排序':'点击按涨幅从大到小排序'?></div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    </div>
                    <div class="page-right fl">
                        <?php if($pager->pageCount):?><p><a href="<?=$this->createUrl('list',['page'=>$page-1?$page-1:1])?>" title="下一页"><</a><span class="page"><em><?=$page?></em>/<?=$pager->pageCount?></span><a href="<?=$this->createUrl('list',['page'=>$page+1])?>" title="上一页">></a></p><?php endif;?>
                    </div>


                </div>
            </div>
            <ul class="item-list">
                    <?php if($plots){
                    foreach($plots as $key=>$v){
                    ?>
                    <li class="item clearfix">
                        <div class="pic fl">
                            <a target="_blank" href="<?php echo $this->createUrl('index',['py'=>$v->pinyin])?>"><img src="<?=ImageTools::fixImage($v->image)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())?>'" alt="" /></a>
                        </div>
                        <div class="content fl">
                            <p class="title"><a target="_blank" href="<?=$this->createUrl('index',['py'=>$v->pinyin])?>"><?=$v->title?></a></p>
                            <p class="detail"><span><?=$v->area?$v->areaInfo->name:''?>/<?=$v->street?$v->streetInfo->name:''?></span></p>
                            <p class="detail"><?=$v->address?></</p>
                            <p class="fangyuan"><span>二手房源：<a target="_blank" href="<?php echo $this->createUrl('pesflist',['py'=>$v->pinyin])?>">
                            <?=!empty($v->lastResoldData)?$v->lastResoldData->esf_num:0?>
                        </a>套</span><span>租房房源：<a target="_blank" href="<?php echo $this->createUrl('pzflist',['py'=>$v->pinyin])?>">
                            <?=!empty($v->lastResoldData)?$v->lastResoldData->zf_num:0?>
                        </a>套</span></p>
                            <p class="other-detail"><a target="_blank" href="<?=$this->createUrl('index',['py'=>$v->pinyin])?>"><i class="iconfont">&#xe616;</i>查看详情</a><a href="<?=$this->createUrl('album',['py'=>$v->pinyin])?>"><i class="iconfont">&#xe615;</i>小区图片</a></p>
                            <div class="about-price">

                                      <p class=""><em class="prices">
                                          <?=$v->avg_esf?$v->avg_esf->price.'</em>元/㎡':'暂无</em>'?>
                                      </p>
                                      <p class="tag">小区均价</p>

                             </div>
                        </div>
                    </li>
                    <?php }} ?>

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
                    <!-- <div class="blank20"></div> -->
                    <!-- <div class="frame side-box">
                        <div class="stitle">
                            <span>小区二手房推荐</span>
                        </div>
                        <?php //$this->widget('RightWidget',['type'=>'plotesf','relatedid'=>$this->plot->id,'limit'=>4])?>
                    </div> -->
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
      </div>
</div>

<div class="blank20"></div>
