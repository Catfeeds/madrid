<?php 
$this->pageTitle = '区域价格';
$this->breadcrumbs = array($this->pageTitle);
?>
<table class="table table-bordered table-striped table-condensed flip-content table-hover">
    <thead class="flip-content">
    <tr>
        <th class="text-center">日期</th>  
        <th class="text-center">区域</th> 
        <th class="text-center">二手房挂牌均价</th> 
        <th class="text-center">二手房挂牌总面积</th>    
        <th class="text-center">二手房数量</th>   
        <th class="text-center">租房挂牌均价</th>  
        <th class="text-center">租房挂牌总面积</th> 
        <th class="text-center">租房数量</th>    
    </tr>
    </thead>
    <tbody>
    <?php foreach($list as $k=>$v): ?>
        <tr>
            <td class="text-center"><?=date('Y-m-d',$date)?></td>
            <td class="text-center"><?php if(isset($v['a'])){ $area = AreaExt::model()->findByPk($v['a']);echo $area?$area->name:'';}?></td>
            <td class="text-center"><?=isset($v['ep'])?$v['ep']:0?></td>
            <td class="text-center"><?=isset($v['es'])?$v['es']:0?></td>
            <td class="text-center"><?=isset($v['em'])?$v['em']:0?></td>
            <td class="text-center"><?=isset($v['zp'])?$v['zp']:0?></td>
            <td class="text-center"><?=isset($v['zs'])?$v['zs']:0?></td>
            <td class="text-center"><?=isset($v['zm'])?$v['zm']:0?></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>