<?php
 Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/kanfangtuan.css');
 $this->pageTitle = SM::urmConfig()->cityName().'房产问答_'.SM::urmConfig()->cityName().'买房问题-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
 Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产，'.SM::urmConfig()->cityName().'房产网，'.SM::urmConfig()->cityName().'房产信息网，'.SM::GlobalConfig()->siteName().'，'.SM::urmConfig()->cityName(),'keywords');
 Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');
$this->breadcrumbs = array(SM::urmConfig()->cityName().'问答');
if(isset($cate) && !empty($cate)){
    foreach($cate as $v){
        if(isset($v['childs']) && !empty($v['childs'])){
            foreach($v['childs'] as $n){
                if($cid == $n['id']){
                    $this->breadcrumbs = array(SM::urmConfig()->cityName().'问答'=>$this->createUrl('index'),$n['name']);
                }
            }
        }
    }
}
?>
<div class="wenda">
    <?php $this->renderPartial('_search',array('kw'=>$kw)); ?>
    <div class="main-block wenda-index">
        <div class="main-left k-fl">
            <h2>问题分类</h2>
            <?php foreach($cate as $v):?>
                <dl>
                    <dt><?php echo $v['name'];?></dt>
                    <?php if(isset($v['childs']) && !empty($v['childs'])): foreach($v['childs'] as $n):?>
                        <dd>
                            <a href="<?php echo $this->createUrl('index',array('cid'=>$n['id']))?>">
                                <p <?php if($cid == $n['id']):?> style="color:red" <?php endif;?> > <?php echo $n['name'];?> </p>
                            </a>
                        </dd>
                    <?php endforeach;endif;?>
                </dl>
            <?php endforeach;?>
        </div>
        <div class="main-right k-fl">
            <div class="wenda-zixun" id="tiwen">
                <h2>我要咨询</h2>
                <form action="<?php echo $this->createUrl('/api/ask/ajaxSubmit')?>" method="post" class="ui-question-form">
                    <div class="textarea-wrap">
                        <textarea id="" name="question" cols="30" rows="10" placeholder="在这里输入问题，房产专家会帮您解答，您还可以输入255个字符" datatype="*1-255" errormsg="请输入问题，最多255个字符！"></textarea>
                    </div>
                    <div class="row clearfix">
                        <div class="name k-form-text ui-check-ele"><i class="kanfangicon icon-17"></i><input type="text" name="name" placeholder="姓名" datatype="s2-5" errormsg="称呼至少2个字符,最多5个字符！" ></div>
                        <div class="phone k-form-text ui-check-ele"><i class="kanfangicon icon-18"></i><input type="text" name="phone" placeholder="手机号" datatype="m" errormsg="手机号码格式不正确"></div>
                        <div class="tips">获取答案及时通知您</div>
                    </div>
                    <?php echo CHtml::hiddenField('csrf', Yii::app()->request->getCsrfToken()); ?>
                    <div class="submit k-form-submit">
                        <input type="submit" value="提交问题"/>
                    </div>
                </form>
            </div>
            <div class="sub-block clearfix">
                <div class="sub-left">
                    <h3 class="wenda-aside-title"><?php if(isset($cid) && !empty($cid)){ $acate = AskCateExt::model()->find(array('condition'=>'id = :id','params'=>array(':id'=>$cid))); echo $acate->name; }else{ ?>近期提问<?php } ?></h3>
                    <ul>
                        <?php if(isset($ask) && !empty($ask)){?>
                        <?php foreach($ask as $v):$length=60; ?>
                        <li class="wenda-question">
                            <span class="wen wen1">问</span>
                            <?php if(isset($v->plot) && !empty($v->plot)): ?>
                                <a class="k-em-2 c-red" href="<?php echo $this->createUrl('/home/plot/index',array('py'=>$v->plot->pinyin)); ?>" target="_blank">[<?php echo $v->plot->title; $length -= 15; ?>]</a>
                            <?php endif; ?>
                            <a href="<?php echo $this->createUrl('detail',array('id'=>$v->id))?>" target="_blank">
                                <?php echo Tools::u8_title_substr($v->question,$length);?><span class="time"><?php echo date('m-d',$v->created); ?>
                                </span>
                            </a>
                        </li>
                        <?php endforeach;}else{?>
                        <li class="wenda-question">未搜索到相关的问题</li>
                        <?php }?>
                    </ul>
                    <div class="blank10"></div>
                    <div class="page-box fs14 fr">
                        <?php $this->widget('HomeLinkPager', array('pages'=>$pager,'maxButtonCount'=>5)) ?>
                    </div>
                    <div class="blank10"></div>
                </div>
                <div class="sub-right">
                    <div class="mod-wenda-hotquestion">
                        <h3 class="wenda-aside-title">热点问题</h3>
                        <ul class="hot-p">
                            <?php foreach($reask as $v):?>
                            <li><a href="<?php echo $this->createUrl('detail',array('id'=>$v->id))?>" target="_blank"><?php echo $v->question;?></a></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                    <?php $this->renderPartial('_tools'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="blank10"></div>
