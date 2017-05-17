<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/plot.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/home/style/kanfangtuan.css');
$this->pageTitle = $this->plot->title.'_'.$this->plot->title.'问答_'.$this->plot->title.'相关问题-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag($this->plot->title.'，'.$this->plot->title.'问答，'.$this->plot->title.'问题','keywords');
Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'房产网是最热的'.SM::urmConfig()->cityName().'房产网，是'.SM::urmConfig()->cityName().'地区的房地产专业网站。小区业主交流、买房、看盘、租房、二手房买卖、了解'.SM::urmConfig()->cityName().'房地产新闻资讯就上'.SM::GlobalConfig()->siteName().SM::urmConfig()->cityName().'房产网。','description');
?>

<div class="wapperout">
    <div class="wapper">
        <div class="p_current fs14">当前位置：
            <a href="/"><?php echo SM::urmConfig()->cityName().'房产'?></a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list');?>"><?php echo SM::urmConfig()->cityName()?>新房</a>&gt;
            <a href="<?php echo $this->createUrl('/home/plot/list',array('place'=>$this->plot->area));?>"><?php echo isset($this->siteArea[$this->plot->area])?$this->siteArea[$this->plot->area]:'';?>楼盘</a>&gt;
            <a href="<?=$this->createUrl('index',['py'=>$this->plot->pinyin])?>"><?php echo $this->plot->title;?></a>&gt;<span id="plot-nav">问答</span>
        </div>
    </div>
</div>

<?php $this->renderPartial('plot_naver')?>

<div class="wenda">
    <div class="main-block loupanwenda">
        <div class="main-left">
            <div class="wenda-zixun">
                <h2>我要咨询</h2>
                <form action="<?php echo $this->createUrl('/api/ask/ajaxSubmit')?>" class="housetool ui-question-form" method="post">
                    <div class="textarea-wrap">
                        <textarea id="" name="question" cols="30" rows="10" placeholder="在这里输入问题，房产专家会帮您解答，您还可以输入255个字符" datatype="*1-255" errormsg="请输入问题，最多255个字符！"></textarea>
                    </div>
                    <div class="row clearfix">
                        <div class="name k-form-text"><i class="kanfangicon icon-17"></i><input id="" type="text" name="name" placeholder="姓名" datatype="s2-5" errormsg="称呼至少2个字符,最多5个字符！"></div>
                        <div class="phone k-form-text"><i class="kanfangicon icon-18"></i><input id="" type="text" name="phone" placeholder="手机号" datatype="m" errormsg="手机号码格式不正确"></div>
                        <div class="tips">获取答案及时通知您</div>
                    </div>
                    <?php echo CHtml::hiddenField('hid', $this->plot->id); ?>
                    <?php echo CHtml::hiddenField('csrf', Yii::app()->request->getCsrfToken()); ?>
                    <div class="submit k-form-submit">
                        <input type="submit" value="提交问题" data-hid="<?php echo $this->plot->id;?>" />
                    </div>
                </form>
            </div>
            <div class="wenda-q-a-list">
                <?php
                    if(!empty($list)):
                        foreach($list as $k=>$v):
                ?>
                <dl class="wenda-q-a">
                    <dt class="wenda-question"><span class="wen wen1">问</span><?php echo $v->question;?><span class="time">（<?php echo date('Y/m/d G:i:s',$v->created);?>）</span></dt>
                    <dd class="wenda-answer"><span class="wen wen2">答</span><?php echo strip_tags($v->answer); ?></dd>
                </dl>
                <?php
                        endforeach;
                    endif;
                ?>
            </div>
            <div class="blank10"></div>
            <div class="page-box fs14 fr">
                <?php $this->widget('HomeLinkPager', array('pages'=>$pager)); ?>
            </div>
            <div class="blank10"></div>
        </div>
        <div class="main-right ui-mouseenter">
            <div class="gray-bg p10">
                <div class="mod-tuangou">
                    <?php echo $this->renderpartial('/layouts/hotTuan'); ?>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="blank10"></div>
