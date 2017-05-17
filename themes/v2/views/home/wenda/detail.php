<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/kanfangtuan.css');
$this->pageTitle = $ask->question.'_'.SM::urmConfig()->cityName().'房产问答-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag(($ask->cate ? $ask->cate->name : '').'，'.SM::urmConfig()->cityName().'房产问答，'.SM::urmConfig()->cityName().'买房问题','keywords');
Yii::app()->clientScript->registerMetaTag(Tools::u8_title_substr($ask->answer,200),'description');
if($ask->cate){
    $this->breadcrumbs = array(SM::urmConfig()->cityName().'问答'=>$this->createUrl('index'),$ask->cate->name=>$this->createUrl('index',array('cid'=>$ask->cate->id)),'问答详情页');
}else{
    $this->breadcrumbs = array(SM::urmConfig()->cityName().'问答'=>$this->createUrl('index'),'问答详情页');
}

?>
    <div class="wenda">
        <?php $this->renderPartial('_search'); ?>
        <div class="main-block wenda-detail clearfix">
            <div class="main-left k-fl">
                <dl class="wenda-q-a-2">
                    <dt class="wenda-question"><span class="wen wen1">问</span>
                    <p><?php echo $ask->question;?></p>
                    <p class="info">
                        <?php echo date('Y-m-d',$ask->created);?>&#160;<?php if($ask->name): ?>丨&#160;提问者：<?php echo $ask->name; ?>&#160;<?php endif; ?>丨&#160;浏览量：<?php echo $ask->views?>&#160;丨&#160;分类：<?php echo $ask->cate ? $ask->cate->name : ''?>
                    </p>
                    </dt>
                      <dd class="wenda-answer"><span class="wen wen2">答</span><?php echo Tools::export($ask->answer); ?></dd>
                </dl>
                <!--相关问题-->
                <div class="relative-question">
                    <h3 class="wenda-aside-title">相关问题</h3>
                    <ul>
                        <?php if(isset($asks) && !empty($asks)):?>
                            <?php foreach($asks as $v):?>
                                <li class="wenda-question"><span class="wen wen1">问</span><?php if(isset($v->plot) && !empty($v->plot)):?><a class="k-em-2" href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->plot->pinyin)); ?>" target="_blank">[<?php echo $v->plot->title?>]</a><?php endif;?><a href="<?php echo $this->createUrl('detail',array('id'=>$v->id))?>" target="_blank"><?php echo $v->question?></a><span class="time"><?php echo date('m-d',$v->created)?></span></li>
                            <?php endforeach;?>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
            <div class="main-right k-fl">
                <div class="mod-wenda-hotquestion">
                    <h3 class="wenda-aside-title">热点问题</h3>
                    <ul class="hot-p">
                        <?php foreach($reask as $v):?>
                            <li><a href="<?php echo $this->createUrl('detail',array('id'=>$v->id))?>" target="_blank"><?php echo $v->question;?></a></li>
                        <?php endforeach;?>
                    </ul>
                </div>
                <?php $this->renderPartial('_tools');  ?>
            </div>
        </div>
    </div>
    <div class="blank10"></div>
