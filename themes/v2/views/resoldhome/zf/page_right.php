<div class="page-right">
    <?php if($this->otherParams['pager']->pageCount>0):?><p><a href="<?=$this->createUrl('list',['page'=>$this->get['page']-1>0?$this->get['page']-1:1])?>" title="上一页"><</a><span class="page"><em><?=$this->get['page']?></em>/<?=$this->otherParams['pager']->pageCount?></span><a href="<?=$this->createUrl('list',['page'=>$this->get['page']+1])?>" title="上一页">></a></p><?php endif;?>
</div>
<?php if($this->get['type']==2):?>
    <ul class="clearfix">
      <li><a href="<?=$this->createUrl('list',['type'=>2])?>" <?php if($this->get['type']==2 && !$this->get['source'] && !$this->get['hurry']):?>class="active"<?php endif;?>>在租商铺</a></li>
      <li><a href="<?=$this->createUrl('list',['source'=>1,'type'=>2])?>" <?php if($this->get['source']==1):?>class="active"<?php endif;?> >个人房源</a></li>
          <li><a href="<?=$this->createUrl('list',['source'=>2,'type'=>2])?>" class="<?=$this->get['source']==2?'active':''?>">中介房源</a></li>
      <li><a href="<?=$this->createUrl('list',['hurry'=>1,'type'=>2])?>" <?php if($this->get['hurry']==1):?>class="active"<?php endif;?>>急售房源</a></li>
      <li><a href="<?=$this->createUrl('/resoldhome/qz/index',['type'=>2])?>" target="_blank">求租</a></li>
    </ul>
<?php elseif($this->get['type']==3):?>
    <ul class="clearfix">
      <li><a href="<?=$this->createUrl('list',['type'=>3])?>" <?php if($this->get['type']==3 &&!$this->get['source'] && !$this->get['hurry']):?>class="active"<?php endif;?>>在租写字楼</a></li>
      <li><a href="<?=$this->createUrl('list',['type'=>3,'source'=>1])?>" <?php if($this->get['source']==1):?>class="active"<?php endif;?>>个人房源</a></li>
          <li><a href="<?=$this->createUrl('list',['source'=>2,'type'=>3])?>" class="<?=$this->get['source']==2?'active':''?>">中介房源</a></li>
      <li><a href="<?=$this->createUrl('list',['type'=>3,'hurry'=>1])?>" <?php if($this->get['hurry']==1):?>class="active"<?php endif;?>>急售房源</a></li>
      <li><a href="<?=$this->createUrl('/resoldhome/qz/index',['type'=>3])?>" target="_blank">求租</a></li>
    </ul>
<?php else:?>
<ul class="clearfix">
    <li><a href="<?=$this->createUrl('list')?>" class="<?=!$this->get['source']&&!$this->get['hurry']?'active':''?>">全部房源</a></li>
    <li><a href="<?=$this->createUrl('list',['source'=>1])?>" class="<?=$this->get['source']==1?'active':''?>">个人房源</a></li>
    <li><a href="<?=$this->createUrl('list',['source'=>2])?>" class="<?=$this->get['source']==2?'active':''?>">中介房源</a></li>
    <li><a href="<?=$this->createUrl('list',['hurry'=>1])?>" class="<?=$this->get['hurry']==1?'active':''?>">急售房源</a></li>
    <li><a href="<?=$this->createUrl('/resoldhome/qz/index')?>" target="_blank">求租</a></li>
</ul>
<?php endif;?>
</div>
<div class="sort">
<span>找到<em class="c-main"><?=$this->otherParams['zfcount']?></em>套房源</span>
<div class="filter fr mt8">
    <!--end n天-->

    <!--租房-->
    <?php $saleGet = array_filter($this->get);unset($saleGet['saletime'])?>
    <?php $sortGet = array_filter($this->get);unset($sortGet['sort'])?>
    <!--end-->
    <div class="fl paixu">
        <p>排序：<a href="<?=$this->createUrl('list',['sort'=>'7']+$sortGet)?>" class="<?=$this->get['sort']==7?'on':''?>">按更新时间</a>
            <a href="<?=$this->createUrl('list',['sort'=>'8']+$sortGet)?>" class="<?=$this->get['sort']==8?'on':''?>">按发布时间</a></p>
    </div>

    <div class="pr fl">
        <a href="<?=$this->createUrl('list',['sort'=>$this->get['sort']==2?1:2]+$sortGet)?>" class="sort-btn price-btn sort-<?=$this->get['sort']==2?'down':'up'?> <?=$this->get['sort']==2 || $this->get['sort']==1?'on':'fr'?>">租金<i></i></a>
        <div class="tips-notice">
            <div class="tips-box"><?=$this->get['sort']==2?'点击按租金从低到高排序':'点击按租金从高到低排序'?></div>
            <span class="bottom-arrow"><span></span></span>
        </div>
    </div>
    <div class="pr fl">
        <a href="<?=$this->createUrl('list',['sort'=>$this->get['sort']==6?5:6]+$sortGet)?>" class="sort-btn size-btn sort-<?=$this->get['sort']==6?'down':'up'?> <?=$this->get['sort']==6 || $this->get['sort']==5?'on':'fr'?>">面积<i></i></a>
        <div class="tips-notice">
            <div class="tips-box"><?=$this->get['sort']==6?'点击按面积从小到大排序':'点击按面积从大到小排序'?></div>
            <span class="bottom-arrow"><span></span></span>
        </div>
    </div>


</div>
</div>
