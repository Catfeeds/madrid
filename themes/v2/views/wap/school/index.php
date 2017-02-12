<?php
if($name){
    $this->pageTitle = ''.SM::urmConfig()->cityName().$name.'邻校房_'.SM::urmConfig()->cityName().$name.'在售邻校房-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
    Yii::app()->clientScript->registerMetaTag(SM::urmConfig()->cityName().$name.'邻校房_'.SM::urmConfig()->cityName().$name.'在售邻校房','keywords');
    Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'为你提供'.SM::urmConfig()->cityName().$name.'邻校房信息，并且根据学校区域的不同划分出不同学校区域所属楼盘，为你购买'.SM::urmConfig()->cityName().$name.'邻校房提供最准确的邻校房楼盘信息。','description');
}else{
    $this->pageTitle = SM::urmConfig()->cityName().date('Y').'邻校房_'.SM::urmConfig()->cityName().'学校区域划分_邻校房购买指南-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
    Yii::app()->clientScript->registerMetaTag(SM::urmConfig()->cityName().'邻校房，'.SM::urmConfig()->cityName().'邻校房划分，'.date('Y').SM::urmConfig()->cityName().'邻校房','keywords');
    $areas = '';
    $i = 0;
    foreach($this->siteArea as $v)
    {
        $i++;
        if($i < count($this->siteArea)){
            $areas .= $v.'、';
        }else{
            $areas .= $v;
        }
    }
    Yii::app()->clientScript->registerMetaTag(SM::GlobalConfig()->siteName().'为你提供'.date('Y').SM::urmConfig()->cityName().'邻校房划分信息，以及最全面的'.SM::urmConfig()->cityName().'邻校房信息，还有'.$areas.'等各城区的学校区域信息。','description');
}
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/school.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/search.css" media="all" />

<?php $this->renderPartial('/layouts/header',['title'=>'邻校房','bc'=>true]) ?>

<div class="content-box">
    <div class="pt20 pb20">
        <div class="knowledge-search">
        <form id="search-school" action="<?=$this->createUrl('index')?>">
            <input type="text" name="kw" placeholder="请输入学校关键字" value="<?=$kw?$kw:''?>">
            <a href="" onclick="document.getElementById('search-school').submit();return false;" class="iconfont search-btn">&#x1014;</a>
        </form>
        </div>
    </div>
</div>
<div class="pr clearfix ui-tab">
    <ul class="ui-menu">
        <li>
            <span><?=$name?$name:'区域'?></span>
            <i class="iconfont">&#x2035;</i>
        </li>
        <li>
            <span><?php echo $schoolType?SchoolExt::$type[$schoolType]:'类型';?></span>
            <i class="iconfont">&#x2035;</i>
        </li>
    </ul>

    <div class="ui-submenu">
        <ul class="ui-long">
            <li <?php echo (!isset($id) || empty($id)) ? 'class="ui-active"' : ''?>>
                <a href="<?php echo $this->createUrl('index',array_merge($_GET,array('id'=>0,'type'=>$schoolType,'kw'=>'')))?>"><em>不限</em></a>
                <i class="iconfont">&#x2571;</i>
            </li>
            <?php foreach($schoolarea as $v):?>
                <li <?php echo $id == $v->area ? 'class="ui-active"' : ''?>>
                <a href="<?php echo $this->createUrl('index',array_merge($_GET,array('id'=>$v->area)))?>">
                    <em><?php echo  $v->areaInfo->name;?></em><i class="iconfont">&#x2571;</i>
                </a></li>
            <?php endforeach;?>
        </ul>
    </div>

    <div class="ui-submenu">
        <ul class="ui-long">
            <a href="<?php echo $this->createUrl('index',array_merge($_GET,array('type'=>'','id'=>$id,'kw'=>'')))?>">
                <li <?php echo (!isset($schoolType) || empty($schoolType)) ? 'class="ui-active"' : ''?>><em>不限</em><i class="iconfont">&#x2571;</i></li>
            </a>
            <a href="<?php echo $this->createUrl('index',array_merge($_GET,array('type'=>'xx')))?>">
                <li <?php echo $schoolType == 'xx' ? 'class="ui-active"' : ''?>><em>小学</em><i class="iconfont">&#x2571;</i></li>
            </a>
            <a href="<?php echo $this->createUrl('index',array_merge($_GET,array('type'=>'zx')))?>">
                <li <?php echo $schoolType == 'zx' ? 'class="ui-active"' : ''?>><em>中学</em><i class="iconfont">&#x2571;</i></li>
            </a>
        </ul>
    </div>

</div>
<div class="mask"></div>
<div class="gw">
    <div class="gcal">共有 <?=$count?> 个学校</div>
    <div class="plot-list school-list dropload" data-url='<?=$this->createUrl('AjaxGetSchools',array('type'=>$schoolType,'aid'=>$id,'kw'=>$kw))?>' data-template='schoolindexList'>
        <ul class="more-list">

        </ul>
    </div>
</div>

<div class="blank20"></div>
<script type="text/javascript">
     <?php Tools::startJs(); ?>
        Do.ready(function(){
            $('body').addClass('bg-fff');
        });
    <?php Tools::endJs('searchbaike'); ?>
</script>
