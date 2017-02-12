<?php
if($name){
    $this->pageTitle = ''.$this->siteConfig['cityName'].$name.'邻校房_'.$this->siteConfig['cityName'].$name.'在售邻校房-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
    Yii::app()->clientScript->registerMetaTag($this->siteConfig['cityName'].$name.'邻校房_'.$this->siteConfig['cityName'].$name.'在售邻校房','keywords');
    Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'为你提供'.$this->siteConfig['cityName'].$name.'邻校房信息，并且根据学校区域的不同划分出不同学校区域所属楼盘，为你购买'.$this->siteConfig['cityName'].$name.'邻校房提供最准确的邻校房楼盘信息。','description');
}else{
    $this->pageTitle = $this->siteConfig['cityName'].date('Y').'邻校房_'.$this->siteConfig['cityName'].'学校区域划分_邻校房购买指南-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
    Yii::app()->clientScript->registerMetaTag($this->siteConfig['cityName'].'邻校房，'.$this->siteConfig['cityName'].'邻校房划分，'.date('Y').$this->siteConfig['cityName'].'邻校房','keywords');
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
    Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'为你提供'.date('Y').$this->siteConfig['cityName'].'邻校房划分信息，以及最全面的'.$this->siteConfig['cityName'].'邻校房信息，还有'.$areas.'等各城区的学校区域信息。','description');
}

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/static/wap/style/plot.css');
$this->registerHeadJs(['640resize']);
$this->registerEndJs(['jquery-2.1.4.min','main']);
?>
<header class="ui-title-bar">
    <div class="ui-header-logo fl"><a href="<?php echo $this->createUrl('/wap/index/index')?>"><img src="<?php echo ImageTools::fixImage($this->siteConfig['wapLogo']); ?> "></a></div>
    <span class="ml10 mr10 c-gc fl fs32">|</span>
    <span class="fl fs32 gc3">邻校房 </span>
</header>

<div  class="ui-search-box pr">
    <div class="ui-search">
        <form action="<?php echo $this->createUrl('index')?>"  method="GET">
            <div class="ui-search-r"><input type="submit" class="ui-search-btn" value="搜索"></div>
            <div class="ui-search-l"><i class="icon icon-search"></i><input class="ui-search-text" type="search" name="kw" placeholder="输入您要找的学校名称" value=""></div>
        </form>
    </div>
</div>

<div class="pr clearfix ui-tab gborder-box">
    <ul class="ui-menu ui-li-two border-top">
        <li>
            <span>区域</span>
            <i></i>
        </li>
        <li>
            <span >类型</span>
            <i></i>
        </li>
    </ul>

    <div class="ui-submenu">
        <ul class="ui-long">
            <li <?php echo (!isset($id) || empty($id)) ? 'class="current"' : ''?>>
                <a href="<?php echo $this->createUrl('index',array_merge($_GET,array('id'=>0,'type'=>$type,'kw'=>'')))?>">不限</a>
            </li>
            <?php foreach($schoolarea as $v):?>
                <li <?php echo $id == $v->area ? 'class="current"' : ''?>>
                    <a href="<?php echo $this->createUrl('index',array_merge($_GET,array('id'=>$v->area)))?>"><?php echo  $v->areaInfo->name;?></a>
                </li>
            <?php endforeach;?>
        </ul>
    </div>

    <div class="ui-submenu">
        <ul class="ui-long">
            <li <?php echo (!isset($type) || empty($type)) ? 'class="current"' : ''?>>
                <a href="<?php echo $this->createUrl('index',array_merge($_GET,array('type'=>'','id'=>$id,'kw'=>'')))?>">不限</a>
            </li>
            <li <?php echo $type == 'xx' ? 'class="current"' : ''?>>
                <a href="<?php echo $this->createUrl('index',array_merge($_GET,array('type'=>'xx')))?>">小学</a>
            </li>
            <li <?php echo $type == 'zx' ? 'class="current"' : ''?>>
                <a href="<?php echo $this->createUrl('index',array_merge($_GET,array('type'=>'zx')))?>">中学</a>
            </li>
        </ul>
    </div>

</div>
<div class="layer-overall"></div>
    <div class="gw">
        <div class="gcal">共有 <?php echo $pager->getItemCount();?> 个学校</div>
        <div class="plot-list school-list">
            <ul>
                <?php foreach($school as $v):?>
                    <li>
                        <?php if($v->plotNum != 0):?>
                            <a href="<?php echo $this->createUrl('detail',array('id'=>$v->id))?>">
                        <?php else:?>
                            <a href="javascript:">
                        <?php endif;?>
                                <div class="pic"><img src="<?php echo ImageTools::fixImage($v->image,195,130)?>" alt="" /></div>
                                <div class="info">
                                    <h3 class="fs28"><?php echo $v->name?></h3>
                                    <p class="right-float"><?php echo $name ? $name : ($v->streetInfo ? $v->streetInfo->name : ($v->areaInfo ? $v->areaInfo->name : ''));?></p>
                                    <p class="gc6">共<span class="c-red"><?php echo $v->plotNum?></span>个楼盘</p>
                                </div>
                            </a>
                    </li>
                <?php endforeach;?>

            </ul>
        </div>
    </div>
<?php $this->widget('WapLinkPager', array('pages'=>$pager)); ?>
