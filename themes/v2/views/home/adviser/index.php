<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/kanfangtuan.css');
$this->pageTitle = SM::GlobalConfig()->siteName().'买房顾问-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag('买房顾问，'.SM::GlobalConfig()->siteName().'房产，'.SM::urmConfig()->cityName().'房产网，'.SM::urmConfig()->cityName().'房产信息网','keywords');
Yii::app()->clientScript->registerMetaTag('特色买房顾问整装待发为您提供专业贴心的房产服务','description');
?>

    <div class="wapperout">
        <div class="dabai-content">
            <div class="wapper">
                <div class="dabai-l">
                    <?php echo SM::adviserConfig()->mascot() ? CHtml::Image(ImageTools::fixImage(SM::adviserConfig()->mascot()),'',['class'=>'dabai-img']):'' ?>
                    <div class="title dabai-ico">
                        <p class="big-title"><?php echo SM::GlobalConfig()->siteName(); ?>买房顾问</p>
                        <p class="sm-title"><?php echo $this->t('房大白'); ?></p>
                    </div>
                    <p class="promite">免费提供一对一私人服务、房源推荐、陪看选 房、议价签约 、专车接送</p>
                    <div class="qq-box clearfix">
                        <?php
                            $k=0;
                            foreach($staffs as $v):
                                if($v->qq&&$k<2):
                                    $k++;
                        ?>
                       <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $v->qq; ?>&amp;site=qq&amp;menu=yes" target="_blank" class="qq-<?php echo $k+1;?> dabai-ico"><i class="dabai-ico"></i><?php echo $v->name ? $v->name : $v->username; ?></a>
                       <?php
                               endif;
                            endforeach;
                       ?>
                   </div>
                    <p class="fs24 c-white">近期申请看房</p>
                    <ul class="new-tb-title">
                        <li><span class="name">网友</span><span class="tel">电话</span><span class="plot">楼盘</span><span class="time">申请时间</span></li>
                    </ul>
                    <div class="txtMarquee-top">
                        <div class="hd">
                            <a class="next"></a>
                            <a class="prev"></a>
                        </div>
                        <div class="bd">
                            <ul class="infoList">
                                <?php foreach($orders as $v): ?>
                                <li><span><?php echo $this->hideName($v->name); ?></span><span><?php echo substr_replace($v->phone,'********',3); ?></span><span><?php echo $v->getPlot() ? $v->getPlot()->title : '-'; ?></span><span><?php echo Tools::friendlyDate($v->created); ?></span></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>


                </div>
                <div class="dabai-r bg-ff">
                    <form action="<?php echo $this->createUrl('/api/order/ajaxKanOrderSubmit'); ?>" method="post" class="baomingform kanfangform">
                        <div class="r1">填写表单，立即预约免费看房</div>
                        <dl class="r2 ele">
                            <dt>意向楼盘：</dt><dd><input type="text" name="loupan" placeholder="购房区域或楼盘名称，可填写多个" class="text330" datatype="*" nullmsg="请填写楼盘"/></dd>
                        </dl>
                        <dl class="r3 ele">
                            <dt>预算价格：</dt><dd class="pr"><input name="jiage" type="text" placeholder="填写您的预算" class="text330" datatype="n" nullmsg="请输入预算价格" errormsg="价格格式错误"/><span class="flh">万</span></dd>
                        </dl>
                        <dl class="r4 ele huxing">
                            <dt>意向户型：</dt>
                            <dd>
                                <label>
                                    <input id="" type="checkbox" name="huxing[]"  value="一居" class="k-inline-block-middle" datatype="*" nullmsg="请选择意向户型"/>一居
                                </label>
                                <label>
                                    <input id="" type="checkbox" name="huxing[]"  value="二居" class="k-inline-block-middle" datatype="*" nullmsg="请选择意向户型" />二居
                                </label>
                                <label>
                                    <input id="" type="checkbox" name="huxing[]"  value="三居" class="k-inline-block-middle" datatype="*" nullmsg="请选择意向户型" />三居
                                </label>
                                <label>
                                    <input id="" type="checkbox" name="huxing[]"  value="四居" class="k-inline-block-middle" datatype="*" nullmsg="请选择意向户型"/>四居
                                </label>
                                <label>
                                    <input id="" type="checkbox" name="huxing[]"  value="五居及以上" class="k-inline-block-middle" datatype="*" nullmsg="请选择意向户型"/>五居及以上
                                </label>
                            </dd>
                        </dl>
                        <div class="form-txt name mr10"><i class="dabai-ico"></i><input id="" type="text" name="name" placeholder="请输入您的姓名" class="form-name" datatype="*" nullmsg="请输入姓名"  /></div>
                        <div class="form-txt tel"><i class="dabai-ico"></i><input id="" type="text" name="phone" placeholder="请输入您的手机号" class="form-phone" datatype="m" nullmsg="请输入电话号码" errormsg="电话号码格式错误" /></div>
                        <div class="blank10"></div>
                        <div class="form-area">
                            <i class="dabai-ico"></i>
                            <textarea placeholder="备注" name="note"></textarea>
                        </div>
                        <?php echo CHtml::hiddenField('spm', OrderExt::generateSpm('自由组团')); ?>
                        <?php echo CHtml::hiddenField('csrf', Yii::app()->request->getCsrfToken()); ?>
                        <input type="submit" value="立即领取一枚<?php echo $this->t('房大白'); ?>" class="form-submit"/>
                        <p class="tac mt10"><span class="c-sred">* </span>提交预约表单后，<?php echo $this->t('房大白'); ?>会尽快与您联系！</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="wapper">
        <div class="advantage-content">
            <div class="sm-title"><?php echo $this->t('房大白'); ?>六大优势</div>
            <div class="advantage-list">
                <ul>
                    <li class="li1">
                        <p class="title dabai-ico">专业</p>
                        <p class="desc">凭借多年从业经验</p>
                        <p class="desc">专业解答您所有购房困惑</p>
                    </li>
                    <li class="li2">
                        <p class="title dabai-ico">便捷</p>
                        <p class="desc">7*12免费专车接送</p>
                        <p class="desc"><?php echo $this->t('房大白'); ?>全程讲解 带你看遍<?php echo SM::urmConfig()->cityName(); ?></p>
                    </li>
                    <li class="li3">
                        <p class="title dabai-ico">优惠</p>
                        <p class="desc">与<?php echo SM::urmConfig()->cityName().PlotExt::model()->isNew()->normal()->count(); ?>余项目亲密合作</p>
                        <p class="desc">给你实实在在的实惠</p>
                    </li>
                    <li class="li4">
                        <p class="title dabai-ico">公信</p>
                        <p class="desc">深耕<?=SM::GlobalConfig()->siteName()?> 打造正规平台</p>
                        <p class="desc">只推对的 不推贵的</p>
                    </li>
                    <li class="li5">
                        <p class="title dabai-ico">贴心</p>
                        <p class="desc">购房过程中您会忽略的小细节</p>
                        <p class="desc">我们都会附上贴心提示</p>
                    </li>
                    <li class="li6">
                        <p class="title dabai-ico">有爱</p>
                        <p class="desc">拒绝无合作不服务</p>
                        <p class="desc">拒绝已成交不服务 抛开利仍有爱</p>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <div class="wapperout team-content-bg">
        <div class="wapper">
            <div class="sm-title"><?php echo $this->t('房大白'); ?>精英队</div>
            <div class="team-content">
                <ul class="team-list">
                    <?php foreach($staffs as $v): ?>
                    <li>
                        <img data-original="<?php echo ImageTools::fixImage($v->avatar,200,210); ?>">
                        <div class="info">
                            <p class="name">
                                <span><?php echo $v->name?$v->name:$v->username; ?></span>
                                <?php if($v->qq): ?>
                                    <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $v->qq; ?>&amp;site=qq&amp;menu=yes" target="_blank" class="qq-contact dabai-ico"></a>
                                <?php endif;?>
                            </p>
                            <p class="time">从事<?php echo SM::urmConfig()->cityName(); ?>房产行业<span> <?php echo $v->work_time; ?> </span>年</p>
                            <p class="stars dabai-ico"></p>
                            <p class="desc"><?php echo $v->idea; ?></p>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <div class="team-right">
                    <p class="title"><?php echo $this->t('房大白'); ?></p>
                    <p class="sm-title">一对一服务</p>
                    <ul>
                        <li>房源推荐</li>
                        <li>全程陪看</li>
                        <li>议价签约</li>
                        <li>专车接送</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php if(RecomCateExt::model()->normal()->getByPinyin('mfgwkfjxs')->exists()): ?>
    <div class="wapper pt20 pb20">
        <div class="sm-title"><?php echo $this->t('房大白'); ?>看房进行时</div>
        <div class="loupan-list hj-picScroll-left" data-num="3" >
            <div class="prev dir"></div>
            <div class="next dir"></div>
            <div class="bd">
                <ul>
                    <?php foreach(RecomExt::model()->getRecom('mfgwkfjxs', 15)->findAll() as $v): ?>
                    <li class="item">
                        <a class="pic" href="<?php echo $v->url ? $v->url : 'javascript:;'; ?>" target="_blank">
                            <img class="lazy" data-original="<?php echo ImageTools::fixImage($v->image, 360, 220); ?>" alt="<?php echo $v->title; ?>">
                            <div class="layerbg"></div>
                            <div class="layertxt"><?php echo $v->title; ?></div>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php
        endif;
        if(RecomCateExt::model()->normal()->getByPinyin('mfgwmfbx')->exists()):
    ?>
    <div class="wapper pt20 pb20">
        <div class="sm-title"><?php echo $this->t('房大白'); ?>买房喜报</div>
        <div class="loupan-list hj-picScroll-left" data-num="3">
            <div class="prev dir"></div>
            <div class="next dir"></div>
            <div class="bd">
                <ul>
                    <?php foreach(RecomExt::model()->getRecom('mfgwmfbx', 15)->findAll() as $v): ?>
                    <li class="item">
                        <a class="pic" href="<?php echo $v->url ? $v->url : 'javascript:;'; ?>" target="_blank">
                            <img class="lazy" data-original="<?php echo ImageTools::fixImage($v->image, 360, 220); ?>" alt="<?php echo $v->title; ?>">
                            <div class="layerbg"></div>
                            <div class="layertxt"><?php echo $v->title; ?></div>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php
        endif;
        if(RecomCateExt::model()->normal()->getByPinyin('mfgwmfrj')->exists()):
    ?>
    <div class="wapper pt20 pb20">
        <div class="sm-title"><?php echo $this->t('房大白'); ?>买房日记</div>
        <div class="loupan-list hj-picScroll-left" data-num="3">
            <div class="prev dir"></div>
            <div class="next dir"></div>
            <div class="bd">
                <ul>
                    <?php foreach(RecomExt::model()->getRecom('mfgwmfrj', 6)->findAll() as $v): ?>
                    <li class="item">
                        <a class="pic" href="<?php echo $v->url ? $v->url : 'javascript:;'; ?>" target="_blank">
                            <img class="lazy" data-original="<?php echo ImageTools::fixImage($v->image, 360, 220); ?>" alt="<?php echo $v->title; ?>">
                            <div class="layerbg"></div>
                            <div class="layertxt"><?php echo $v->title; ?></div>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php endif; ?>
