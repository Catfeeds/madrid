<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/list.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/xiaoqu-public.css');
$this->pageTitle = '小区租房列表';
?>
<?php $this->renderPartial('plot_search')?>
<div class="wapper xiaoqu-head ovisible">
<?php $this->widget('HomeBreadcrumbs',array('links'=>[$this->plot->title=>$this->createUrl('index',array('py'=>$this->plot->pinyin)),'租房']));?>
<div class="line"></div>
<?php $this->renderPartial('plot_naver')?>
</div>
<div class="wapper">
     <div class="big-filter">
        <div class="category-select">
            <dl class="clearfix">
              <dt>租金：</dt>
              <dd>
                  <?php
                  if($get['type']==3){
                      $this->widget('TagInfoWidget',['cate'=>'zfxzlprice','id'=>$get['price'],'get'=>$_GET,'url'=>'/resoldhome/plot/pzflist']);
                  }elseif($get['type']==2){
                      $this->widget('TagInfoWidget',['cate'=>'zfspprice','id'=>$get['price'],'get'=>$_GET,'url'=>'/resoldhome/plot/pzflist']);
                  }else{
                      $this->widget('TagInfoWidget',['cate'=>'zfzzprice','id'=>$get['price'],'get'=>$_GET,'url'=>'/resoldhome/plot/pzflist']);
                  }
                  ?>
              </dd>
            </dl>
            <dl class="clearfix">
              <dt>户型：</dt>
              <dd>
                  <?php
                  if($get['type']==3){
                      $this->widget('TagInfoWidget',['cate'=>'esfzfxzltype','id'=>$get['cate'],'get'=>$_GET,'url'=>'/resoldhome/plot/pzflist']);
                  }elseif($get['type']==2){
                      $this->widget('TagInfoWidget',['cate'=>'esfzfsptype','id'=>$get['cate'],'get'=>$_GET,'url'=>'/resoldhome/plot/pzflist']);
                  }else{
                      $this->widget('TagInfoWidget',['cate'=>'resoldhuxing','id'=>$get['bedroom'],'get'=>$_GET,'url'=>'/resoldhome/plot/pzflist']);
                  }

                  ?>
              </dd>
            </dl>
            <dl class="clearfix">
              <dt>方式：</dt>
              <dd>
                  <?php $this->widget('TagInfoWidget',['cate'=>'zfmode','id'=>$get['way'],'get'=>$_GET,'url'=>$this->createUrl('pzflist')])?>
              </dd>
            </dl>

        </div>
    </div>
        <div class="blank20"></div>
        <div class="main-left">

            <div class="next-tabs clearfix">
                <div class="page-right">
                    <?php if($pager->pageCount):?><p><a href="<?=$this->createUrl('pzflist',['py'=>$this->plot->pinyin,'page'=>$page-1>0?$page-1:1])?>" title="上一页"><</a><span class="page"><em><?=$page?></em>/<?=$pager->pageCount?></span><a href="<?=$this->createUrl('pzflist',['py'=>$this->plot->pinyin,'page'=>$get['page']+1])?>" title="上一页">></a></p><?php endif;?>
                </div>
                <ul class="clearfix">
                    <?php $saleGet = array_filter($get);unset($saleGet['saletime'])?>
                  <li><a href="<?php echo $this->createUrl('pzflist',['py'=>$this->plot->pinyin])?>" <?php if(!$get['source'] && !$get['hurry']):?>class="active"<?php endif;?>>全部房源</a></li>
                  <li><a href="<?php echo $this->createUrl('pzflist',['py'=>$this->plot->pinyin,'source'=>1])?>" <?php if($get['source']==1):?> class="active" <?php endif;?>>个人房源</a></li>
                  <li><a href="<?php echo $this->createUrl('pzflist',['py'=>$this->plot->pinyin,'source'=>2])?>" <?php if($get['source']==2):?> class="active" <?php endif;?>>中介房源</a></li>
                  <li><a href="<?php echo $this->createUrl('pzflist',['py'=>$this->plot->pinyin,'hurry'=>1])?>" <?php if($get['hurry']==1):?> class="active" <?php endif;?>>急售房源</a></li>
                </ul>
            </div>
            <div class="sort">
                <span>找到<em class="c-main"><?=$zfcount?></em>套房源</span>

                <div class="filter fr mt8">
                    <?php $sortGet = array_filter($get);unset($sortGet['sort']);?>
                    <div class="fl paixu">
                        <p>排序：<a href="<?=$this->createUrl('pesflist',['py'=>$this->plot->pinyin,'sort'=>'7']+$sortGet)?>" class="<?=$get['sort']==7?'on':''?>">按更新时间</a>
                            <a href="<?=$this->createUrl('pesflist',['py'=>$this->plot->pinyin,'sort'=>'8']+$sortGet)?>" class="<?=$get['sort']==8?'on':''?>">按发布时间</a></p>
                    </div>

                    <div class="pr fl">
                        <a href="<?=$this->createUrl('pzflist',['py'=>$this->plot->pinyin,'sort'=>$get['sort']==2?1:2]+$sortGet)?>" class="sort-btn sort-<?=$get['sort']==2?'down':'up'?> <?=$get['sort']==2||$get['sort']==1?'on':'fr'?>">租金<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box"><?=$get['sort']==2?'点击按总价从低到高排序':'点击按总价从高到低排序'?></div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    </div>
                    <div class="pr fl">
                        <a href="<?=$this->createUrl('pzflist',['py'=>$this->plot->pinyin,'sort'=>$get['sort']==6?5:6]+$sortGet)?>" class="sort-btn size-btn sort-<?=$get['sort']==6?'down':'up'?> <?=$get['sort']==6||$get['sort']==5?'on':'fr'?>">面积<i></i></a>
                        <div class="tips-notice">
                            <div class="tips-box"><?=$get['sort']==6?'点击按面积从小到大排序':'点击按面积从大到小排序'?></div>
                            <span class="bottom-arrow"><span></span></span>
                        </div>
                    </div>


                </div>
            </div>
            <ul class="item-list">
                    <?php
                    if($zfs):
                        foreach($zfs as $k=>$v):
                    ?>
                    <?php $zftags = $v->getZfTag();?>
                    <li class="item clearfix">
                        <div class="pic fl">
                            <a href="<?=$this->createUrl('/resoldhome/zf/info',['id'=>$v->id])?>" target="_blank"><img src="<?=ImageTools::fixImage($v->image,200,150)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic(),200,150)?>'" alt="" /></a>
                            <span class="num">
                                <span class="img-count"><?=$v->image_count?></span>
                                <span class="list-icon"></span>
                            </span>
                        </div>
                        <div class="content fl">
                            <p class="title"><a href="<?=$this->createUrl('/resoldhome/zf/info',['id'=>$v->id])?>" target="_blank"><?=$v->title?></a></p>
                            <p class="detail"><span><?=$v->rent_type?TagExt::getNameByTag($v->rent_type):'暂无'?></span><em>|</em><span><?=$v->bedroom?>室<?=$v->livingroom?>厅</span><em>|</em><span><?=$v->size.'㎡'?></span>
                            <em>|</em><span>
                                <?=isset($zftags['esffloorcate'])?$zftags['esffloorcate']:'暂无'?>
                            </span></p>
                            <p class="area"><a href="<?=$this->createUrl('/resoldhome/plot/pesflist',['py'=>$v->plot->pinyin])?>"><?=$v->plot_name?></a>  <a href="<?=$this->createUrl('list',['area'=>$v->area,'type'=>2])?>"><?=$v->area?$v->areaInfo->name:''?></a>  <span><a href="<?=$this->createUrl('list',['street'=>$v->street,'type'=>2])?>"><?=$v->street?$v->streetInfo->name:''?></a></span><span class="maps"><?=Tools::u8_title_substr($v->address,40)?></span></p>
                            <p class="agents">
                                <a href=""><?=$v->username?></a><span><?=Tools::friendlyDate($v->refresh_time)?></span>
                            </p>
                            <?php $zfts = [1=>'zfzzts',2=>'zfspts',3=>'zfxzlts']; $colorArr = ['green','pink','blue','green','pink','blue','green','pink','blue'];$ts = [];
                                if(isset($zftags[$zfts[$get['type']]])){
                                    $ts = $zftags[$zfts[$get['type']]];
                                }

                            ?>
                            <p class="tags">
                                <?php
                                    if($ts):
                                        $i = 0;
                                        foreach($ts as $key=>$value):
                                ?>
                                <?php if($i==5) break;?>
                                <span class="<?=$colorArr[$i]?>"><?=$value?></span>
                                <?php
                                        $i++;
                                        endforeach;

                                    endif;
                                ?>
                            </p>

                            <div class="about-price">
                                  <p class=""><em class="prices"><?=Tools::FormatPrice($v->price,'</em>元/月')?></em></p>

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
                <?php $this->widget('ViewRecordWidget',['url'=>'/resoldhome/zf/info','cssType'=>3,'type'=>2,'category'=>1])?>

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
