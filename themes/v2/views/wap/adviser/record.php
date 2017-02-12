<?php
$this->pageTitle = SM::GlobalConfig()->siteName().'带看记录-'.SM::GlobalConfig()->siteName().'房产-'.SM::GlobalConfig()->siteName();
Yii::app()->clientScript->registerMetaTag('带看记录，'.SM::GlobalConfig()->siteName().'房产，'.SM::urmConfig()->cityName().'房产网，'.SM::urmConfig()->cityName().'房产信息网','keywords');
Yii::app()->clientScript->registerMetaTag('特色买房顾问整装待发为您提供专业贴心的房产服务','description');
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/static/wap/style/search.css" media="all" />
<?php $this->renderPartial('/layouts/header',['title'=>'带看记录']) ?>
<div class="record-box record-box-detail content-box">
    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <th>客户</th>
            <th>电话</th>
            <th>楼盘</th>
            <th>带看时间</th>
        </tr>
        <?php foreach ($record as $key => $value) {?>
            <tr>
            <td><?=$value['user']['name']?></td>
            <td><?=substr_replace($value->phone,'****',3,4)?></td>
            <td><?=$value['plot']['title']?></td>
            <td><?=date('Y.m.d',$value['created'])?></td>
        </tr>
        <?php }?>
    </table>

</div>


<div class="blank20"></div>
<?php if(strpos(Yii::app()->request->getUserAgent(),'MicroMessenger')===false && !$this->getIsInQianFan()): ?>
    <div class="gototop"></div>
<?php endif?>
