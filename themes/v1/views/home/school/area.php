<?php
 Yii::app()->clientScript->registerScriptFile('/static/home/js/modernizr.custom.js',CClientScript::POS_END);
 Yii::app()->clientScript->registerScriptFile('/static/home/js/main.js',  CClientScript::POS_END);
 Yii::app()->clientScript->registerCssFile('/static/home/style/xuequ.css');
 $this->pageTitle = ''.$this->siteConfig['cityName'].$areaone->name.'邻校房_'.$this->siteConfig['cityName'].$areaone->name.'在售邻校房-'.$this->siteConfig['siteName'].'房产-'.$this->siteConfig['siteName'];
 Yii::app()->clientScript->registerMetaTag($this->siteConfig['cityName'].$areaone->name.'邻校房_'.$this->siteConfig['cityName'].$areaone->name.'在售邻校房','keywords');
 Yii::app()->clientScript->registerMetaTag($this->siteConfig['siteName'].'为你提供'.$this->siteConfig['cityName'].$areaone->name.'邻校房信息，并且根据学校区域的不同划分出不同学校区域所属楼盘，为你购买'.$this->siteConfig['cityName'].$areaone->name.'邻校房提供最准确的邻校房楼盘信息。','description');
 $this->breadcrumbs = array($this->siteConfig['cityName'].'邻校房'=>$this->createUrl('index'),$areaone->name.'邻校房');
?>
<div class="blank15"></div>
<?php $this->renderPartial('_nav'); ?>
<div class="blank15"></div>
<div class="wapper gray-bg">
    <div class="zs-plan clearfix">
        <div class="zs-left school-info">
            <p class="fs22 mb10"><?php echo date('Y')?>年<?php echo $areaone->name?>招生政策方案</p>
            <div class="detail limit">
            	<p class="fs14"><?php echo $areaone->schoolarea ? $areaone->schoolarea->description : ''?></p>
            </div>
            <a href="" class="c-g6 fr mt10 more">更多</a>
        </div>
        <div class="zs-right">
            <div class="box-01 box mb10"><a href="<?php echo $areaone->schoolarea&&$areaone->schoolarea->xx_pic ? ImageTools::fixImage($areaone->schoolarea->xx_pic) : 'javascript:;'; ?>" target="_blank" ><?php echo $areaone->name. date('Y'); ?>年小学学区示意图</a></div>
            <div class="box box-02"><a href="<?php echo $areaone->schoolarea&&$areaone->schoolarea->zx_pic ? ImageTools::fixImage($areaone->schoolarea->zx_pic) : 'javascript:;'; ?>" target="_blank"><?php echo $areaone->name. date('Y'); ?>年中学学区示意图</a></div>
        </div>
    </div>
</div>
<div class="blank20"></div>
<div class="wapper gray-bg">
    <dl class="key-school clearfix">
        <dt class="fs22">重点学区</dt>
        <dd class="fs14">
            <?php foreach($areaone->zdschool as $v){ ?>
                <a href="<?php echo $this->createUrl('/home/school/school',array('pinyin'=>$v->pinyin))?>" target="_blank"><?php echo $v->name?></a>
            <?php } ?>
        </dd>
    </dl>
</div>
<div class="blank20"></div>
<div class="wapper">
    <h1 class="fs20 c-g3 mb20"><?php echo $areaone->name?>小学学区</h1>
    <div class="left-table fs14">
        <table cellspacing="0" cellpadding="0" >
            <tbody>
            <tr>
                <th class="w220">学校名称</th>
                <th>区域范围</th>
            </tr>
            <?php foreach($areaone->allxxschool as $v){ ?>
            <tr>
                <td><a href="<?php echo $this->createUrl('/home/school/school',array('pinyin'=>$v->pinyin))?>" target="_blank" target="_blank"><?php echo $v->name ?></a>  <?php if($v->important == 1){ ?><i>重点</i><?php } ?></td>
                <td><?php echo $v->scope ?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="right-map"><iframe src="<?php echo $this->createUrl('/home/map/map',array('lng'=>$areaone->map_lng,'lat'=>$areaone->map_lat,'ids'=>$xxids))?>" width="305" height="215" frameborder="0"></iframe></div>
</div>
<div class="blank20"></div>
<div class="wapper">
    <h1 class="fs20 c-g3 mb20"><?php echo $areaone->name?>中学学区</h1>
    <div class="left-table">
        <table cellspacing="0" cellpadding="0"  class="fs14">
            <tbody>
            <tr>
                <th class="w220">学校名称</th>
                <th>区域范围</th>
            </tr>
            <?php foreach($areaone->allzxschool as $v){ ?>
            <tr>
                <td><a href="<?php echo $this->createUrl('/home/school/school',array('pinyin'=>$v->pinyin))?>" target="_blank" target="_blank"><?php echo $v->name ?></a>  <?php if($v->important == 1){ ?><i>重点</i><?php } ?></td>
                <td><?php echo $v->scope ?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="right-map"><iframe src="<?php echo $this->createUrl('/home/map/map',array('lng'=>$areaone->map_lng,'lat'=>$areaone->map_lat,'ids'=>$zxids))?>" width="305" height="215" frameborder="0"></iframe></div>
</div>
