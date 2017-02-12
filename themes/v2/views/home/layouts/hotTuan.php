<?php if($tht = PlotTuanExt::model()->normal()->noExpire()->findAll(array('limit' => 10, 'order' => 'sort desc,updated DESC'))): ?>
    <div class="title">热门团购</div>
    <?php foreach ($tht as $v): ?>
        <dl class="item">
            <dt><?php if($v->plot&&$v->plot->areaInfo&&Tools::strlen($v->plot->areaInfo->name.$v->plot->title)<11): ?><a href="<?php echo $this->createUrl('/home/plot/list',array('place'=>$v->plot->areaInfo->id)); ?>" target="_blank" class="fl c-g6 mr5" >[<?php echo $v->plot->areaInfo->name ?>]</a><?php endif; ?><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->plot->pinyin)); ?>" target="_blank" class="name"><?php echo $v->plot->title ?></a><span class="price"><?php echo PlotPriceExt::getPrice($v->plot->price,$v->plot->unit)?></span></dt>
            <dd class="t1"><p class="privilege"><span>楼盘特惠</span><?php echo Tools::u8_title_substr($v->s_title,40)?></p></dd>
            <dd class="t2 clearfix">
                <div class="pic fl"><a href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->plot->pinyin)); ?>" target="_blank"><img src=<?php echo ImageTools::fixImage($v->pc_img,100,74) ?> alt=""></a></div>
                <div class="content fl">
                    <p><?php echo Tools::u8_title_substr($v->s_title,40) ?></p>
                    <a href="javascript:;" class="join k-dialog-type-1" data-title="[<?php echo $this->t('特惠团'); ?>]<?php echo $v->plot->title; ?>" data-spm="<?php echo OrderExt::generateSpm('特惠团',$v); ?>">参团</a>
                </div>
            </dd>
        </dl>
    <?php endforeach; ?>
<?php endif; ?>
