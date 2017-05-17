<?php
$this->pageTitle = '我的收藏';
$with_css_array = array(
    'plot'=>'xinfang',
    'esf'=>'erfang',
    'zf'=>'zufang',
    'staff'=>'type-person',
    'shop'=>'mengdian'
);
?>
<div class="my-fav-mod">
    <div class="gtitle">我的收藏</div>
    <div class="my-fav-nav">
        <ul>
       <!--     <li class="link <?php /*if($with == 'plot')echo 'on';*/?>">
                <a href="<?php /*echo $this->createUrl('index',array('house_type'=>1));*/?>">新房</a>
            </li>-->
            <li class="link <?php if($with == 'esf')echo 'on';?>">
                <a href="<?php echo $this->createUrl('index',array('house_type'=>2));?>">二手房</a>
            </li>
            <li class="link <?php if($with == 'zf')echo 'on';?>">
                <a href="<?php echo $this->createUrl('index',array('house_type'=>3));?>">租房</a>
            </li>
            <li class="link <?php if($with == 'staff')echo 'on';?>">
                <a href="<?php echo $this->createUrl('index',array('house_type'=>4));?>">经纪人</a>
            </li>
            <li class="link <?php if($with == 'shop')echo 'on';?>">
                <a href="<?php echo $this->createUrl('index',array('house_type'=>5));?>">中介门店</a>
            </li>
        </ul>
    </div>
    <!--新房-->
    <div class="my-fav-list <?php echo $with_css_array[$with]; ?>">
        <ul>
            <?php foreach ($dataProvider->data as $item): ?>
            <?php if($item->$with): ?>
            <li>
              <!--  <?php /*if($with == 'plot'): */?>
                <div class="pic">
                    <a href="<?php /*echo $this->createUrl('/resoldhome/plot/index',array('py'=>$item->$with->pinyin));*/?>">
                        <img src="<?/*=ImageTools::fixImage($item->$with->image)*/?>" onError="javascript:this.src='<?/*=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())*/?>'" alt="" />
                    </a>
                </div>
                <div class="info">
                    <div class="title"><a href="<?php /*echo $this->createUrl('/resoldhome/plot/index',array('py'=>$item->$with->pinyin));*/?>"><?php /*echo $item->$with->title ; */?></a></div>
                    <div class="address"><?php /*echo $item->$with->address; */?></div>
                    <div class="area"><?php /*echo $item->$with->areaInfo ? $item->$with->areaInfo->name : ''; */?><?php /*echo $item->$with->streetInfo ? '/'.$item->$with->streetInfo->name : ''; */?></div>
                    <div class="phone"><?php /*echo $item->$with->sale_tel; */?></div>
                </div>
                <div class="aside">
                    <div class="price">
                        <span class="num">
                        <?php /*if($item->$with->price>0){*/?>
                        <?php /*echo $item->$with->price;*/?></span>
                        <span class="unit"><?php /*echo PlotPriceExt::$unit[$item->$with->unit];*/?></span>
                        <?php /*}else{*/?>
                            暂无报价
                        <?php /*} */?>
                    </div>
                </div>-->
                <?php if ($with == 'zf'  || $with == 'esf'): ?>
                    <div class="pic">
                        <?php if($item->$with->sale_status == 1 && $item->$with->deleted == 0 && $item->$with->status == 1) : ?>
                            <a href=" <?php echo $this->createUrl('/resoldhome/'.$with.'/info',array('id'=>$item->$with->id)); ?>">
                                <img src="<?=ImageTools::fixImage($item->$with->image,160,120)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())?>'" alt="" />
                            </a>
                        <?php else: ?>
                            <img src="<?=ImageTools::fixImage($item->$with->image,160,120)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())?>'" alt="" />
                        <?php endif; ?>
                    </div>
                    <div class="info">
                        <div class="title">
                            <?php if($item->$with->sale_status == 1 && $item->$with->deleted == 0 && $item->$with->status == 1) : ?>
                                <a href="<?php echo $this->createUrl('/resoldhome/'.$with.'/info',array('id'=>$item->$with->id));?>"><?php echo Tools::u8_title_substr($item->$with->title,45); ?></a>
                            <?php else: ?>
                                <p class="c-g9"><?php echo Tools::u8_title_substr($item->$with->title,45); ?>（已下架）</p>
                            <?php endif; ?>
                        </div>
                        <div class="er-tags">
                            <?php if($item->$with->category == 1): ?>
                                <?php echo $item->$with->bedroom;?>室<?php echo $item->$with->livingroom;?>厅   |
                            <?php endif; ?>
                            <?php echo $item->$with->size ;?>㎡<?php if($with == 'esf'): ?>   |  建筑年代：<?php echo $item->$with->age ? $item->$with->age : '不限'; ?> <?php endif; ?>
                        </div>
                        <div class="er-address"><?php echo $item->$with->plot->title; ?><span class="road"><?php echo Tools::u8_title_substr($item->$with->address ,40);?></span></div>
                    </div>
                    <div class="aside">
                        <div class="price">
                            <?php if($item->$with->price > 0): ?>
                                <span class="num"><?php echo $item->$with->price; ?></span>
                                <?php if($with == 'zf'): ?>
                                    <span class="unit">元/月</span>
                                <?php else: ?>
                                    <span class="unit">万</span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="num">面议</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php elseif ($with == 'shop'): ?>
                    <div class="pic">
                        <?php if($item->$with->deleted == 0 && $item->$with->status == 1): ?>
                        <a href="<?php echo $this->createUrl('/resoldhome/shop/info',array('shop'=>$item->$with->id));?>">
                            <img src="<?=ImageTools::fixImage($item->$with->image)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())?>'" alt="" />
                        </a>
                        <?php else: ?>
                            <img src="<?=ImageTools::fixImage($item->$with->image)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())?>'" alt="" />
                        <?php endif; ?>
                    </div>
                    <div class="mengdian-info">
                        <div class="shopname">
                            <?php if($item->$with->deleted == 0 && $item->$with->status == 1): ?>
                                <a href="<?php echo $this->createUrl('/resoldhome/shop/info',array('shop'=>$item->$with->id));?>"><?php echo $item->$with->name; ?></a>
                            <?php else: ?>
                                <p class="c-g9"><?php echo $item->$with->name; ?>（已下架）</p>
                            <?php endif; ?>
                        </div>
                        <div class="address">地址：<?= $item->$with->address ; ?></div>
                        <div class="phone">电话：<?= $item->$with->phone; ?></div>
                        <div class="manage">经纪人：<span class="num"><?= $item->$with->countPerson ; ?></span> 人&nbsp;&nbsp;二手房信息：<span class="num"><?= $item->$with->countEsf ; ?></span> 条&nbsp;&nbsp;租房信息：<span class="num"><?= $item->$with->countZf ; ?></span> 条</div>
                    </div>
                <?php elseif ($with == 'staff'): ?>
                    <div class="pic">
                         <?php if($item->$with->deleted == 0 && $item->$with->status == 1): ?>
                              <a href="<?php echo $this->createUrl('/resoldhome/staff/esfList',['staff'=>$item->$with->id]);?>">
                                <img src="<?=ImageTools::fixImage($item->$with->image)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())?>'" alt="" />
                              </a>
                        <?php else: ?>
                             <img src="<?=ImageTools::fixImage($item->$with->image)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())?>'" alt="" />
                         <?php endif; ?>
                    </div>
                    <div class="info">
                        <div class="name">
                            <?php if($item->$with->deleted == 0 && $item->$with->status == 1): ?>
                                <?php echo $item->$with->name; ?>
                            <?php else: ?>
                                <p class="c-g9"><?php echo $item->$with->name; ?>（已下架）</p>
                            <?php endif;?>
                        </div>
                        <div class="phone"><span class="label">电话：</span><?php echo $item->$with->phone ; ?></div>
                        <div class="company"><span class="label">所属公司：</span><span class="em"><?php echo $item->$with->shop ? $item->$with->shop->name : '';?></span></div>
                        <div class="last-login-time"><span class="label">上次登录：</span><?php echo date('Y-m-d',$item->$with->last_login)?></div>
                        <div class="manage"><span class="label">二手房信息：</span><span class="em"><?php echo count($item->$with->onsaleEsfs); ?></span> 条</div>
                        <div class="manage"><span class="label">租房信息：</span><span class="em"><?php echo count($item->$with->onsaleZfs); ?></span> 条</div>
                        <?php if($item->$with->deleted == 0 && $item->$with->status == 1): ?>
                            <a href="<?=$this->createUrl('/resoldhome/staff/esfList',['staff'=>$item->$with->id])?>" class="go-shop em">进入TA的店铺 &gt;&gt;</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="button">
                    <a href="javascript:;" class="j-delete delete-button" data-url="<?php echo $this->createUrl('/resoldhome/mycollect/delete',array('id'=>$item->id))?>" >删除</a>
                </div>
            </li>
             <?php endif; ?>
            <?php endforeach; ?>
        </ul>
        <div class="blank20"></div>
        <div class="page-box">
            <?php $this->widget('HomeLinkPager', array('pages'=>$dataProvider->pagination)); ?>
        </div>
    </div>