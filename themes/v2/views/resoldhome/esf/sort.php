<div class="next-tabs clearfix">
    <div class="page-right">
        <p><a href="<?=$this->createUrl('list',['page'=>$this->get['page']-1>0?$this->get['page']-1:1]+array_filter($_GET))?>" title="上一页"><</a><span class="page"><em><?=$this->get['page']?></em>/<?=$this->pager->pageCount?></span><a href="<?=$this->createUrl('list',['page'=>$this->get['page']+1]+array_filter($_GET))?>" title="下一页">></a></p>
    </div>
    <?php if($this->get['type']==2):?>
        <ul class="clearfix">
            <li><a href="<?=$this->createUrl('list',['type'=>2])?>" class="<?=!$this->get['source']&&!$this->get['hurry']?'active':''?>">在售商铺</a></li>
            <li><a href="<?=$this->createUrl('list',['source'=>1,'type'=>2])?>" class="<?=$this->get['source']==1?'active':''?>">个人房源</a></li>
            <li><a href="<?=$this->createUrl('list',['source'=>2,'type'=>2])?>" class="<?=$this->get['source']==2?'active':''?>">中介房源</a></li>
            <li><a href="<?=$this->createUrl('list',['hurry'=>1,'type'=>2])?>" class="<?=$this->get['hurry']==1?'active':''?>">急售房源</a></li>
            <li><a href="<?=$this->createUrl('/resoldhome/qg/index',['type'=>2])?>" target="_blank">求购</a></li>
        </ul>
    <?php elseif($this->get['type']==3):?>
        <ul class="clearfix">
            <li><a href="<?=$this->createUrl('list',['type'=>3])?>" class="<?=!$this->get['source']&&!$this->get['hurry']?'active':''?>">在售写字楼</a></li>
            <li><a href="<?=$this->createUrl('list',['source'=>1,'type'=>3])?>" class="<?=$this->get['source']==1?'active':''?>">个人房源</a></li>
            <li><a href="<?=$this->createUrl('list',['source'=>2,'type'=>3])?>" class="<?=$this->get['source']==2?'active':''?>">中介房源</a></li>
            <li><a href="<?=$this->createUrl('list',['hurry'=>1,'type'=>3])?>" class="<?=$this->get['hurry']==1?'active':''?>">急售房源</a></li>
            <li><a href="<?=$this->createUrl('/resoldhome/qg/index',['type'=>3])?>" target="_blank">求购</a></li>
        </ul>
    <?php else:?>
        <?php $sourceArr = $this->get;
                unset($sourceArr['source']);unset($sourceArr['hurry']);?>
    <ul class="clearfix">
      <li><a href="<?=$this->createUrl('list')?>" class="<?=!$this->get['source']&&!$this->get['hurry']?'active':''?>">全部房源</a></li>
      <li><a href="<?=$this->createUrl('list',['source'=>1]+array_filter($sourceArr))?>" class="<?=$this->get['source']==1?'active':''?>">个人房源</a></li>
      <li><a href="<?=$this->createUrl('list',['source'=>2]+array_filter($sourceArr))?>" class="<?=$this->get['source']==2?'active':''?>">中介房源</a></li>
      <li><a href="<?=$this->createUrl('list',['hurry'=>1]+array_filter($sourceArr))?>" class="<?=$this->get['hurry']==1?'active':''?>">急售房源</a></li>
      <li><a href="<?=$this->createUrl('/resoldhome/qg/index')?>" target="_blank">求购</a></li>
    </ul>
    <?php endif;?>
</div>
<div class="sort">
    <span>找到<em class="c-main"><?=$this->moreGet['esfNum']?></em>套房源</span>
    <?php if($school = $this->moreGet['school']):?><span>*以下仅供参考，最终以教育局发布的数据为准</span><?php endif;?>
    <div class="filter fr mt8">
        <?php $saleGet = array_filter($this->get);unset($saleGet['saletime'])?>
        <?php $sortGet = array_filter($this->get);unset($sortGet['sort'])?>


        <div class="fl paixu">
            <p>排序：<a href="<?=$this->createUrl('list',['sort'=>'7']+$sortGet)?>" class="<?=$this->get['sort']==7?'on':''?>">按更新时间</a>
                <a href="<?=$this->createUrl('list',['sort'=>'8']+$sortGet)?>" class="<?=$this->get['sort']==8?'on':''?>">按发布时间</a></p>
        </div>
        <div class="pr fl">
            <a href="<?=$this->createUrl('list',['sort'=>$this->get['sort']==2?1:2]+$sortGet)?>" class="sort-btn price-btn sort-<?=$this->get['sort']==1?'up':'down'?> <?=$this->get['sort']==2 || $this->get['sort']==1?'on':'fr'?>">总价<i></i></a>
            <div class="tips-notice">
                <div class="tips-box"><?=$this->get['sort']==2?'点击按总价从低到高排序':'点击按总价从高到低排序'?></div>
                <span class="bottom-arrow"><span></span></span>
            </div>
        </div>
        <div class="pr fl">
            <a href="<?=$this->createUrl('list',['sort'=>$this->get['sort']==3?4:3]+$sortGet)?>" class="sort-btn price-btn sort-<?=$this->get['sort']==3?'up':'down'?> <?=$this->get['sort']==3 || $this->get['sort']==4?'on':'fr'?>">单价<i></i></a>
            <div class="tips-notice">
                <div class="tips-box"><?=$this->get['sort']==3?'点击按单价从低到高排序':'点击按单价从高到低排序'?></div>
                <span class="bottom-arrow"><span></span></span>
            </div>
        </div>
        <div class="pr fl">
            <a href="<?=$this->createUrl('list',['sort'=>$this->get['sort']==6?5:6]+$sortGet)?>" class="sort-btn size-btn sort-<?=$this->get['sort']==5?'up':'down'?> <?=$this->get['sort']==6 || $this->get['sort']==5?'on':'fr'?>">面积<i></i></a>
            <div class="tips-notice">
                <div class="tips-box"><?=$this->get['sort']==6?'点击按面积从小到大排序':'点击按面积从大到小排序'?></div>
                <span class="bottom-arrow"><span></span></span>
            </div>
        </div>


    </div>
</div>
