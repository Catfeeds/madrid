<?php
/**
 * Created by PhpStorm.
 * User: sc
 * Date: 2015/12/2
 * Time: 17:19
 */
?>
<?php
    if(!empty($list)):
        foreach($list as $v):
?>
<li>
    <div class="box">
        <h3><?php echo date('Y-m-d',$v->created);?><span class="unit"> <?php echo PlotPriceExt::getPrice($v->price,$v->unit)?></span></h3>
        <p><?php echo $v->description; ?></p>
    </div>
</li>
<?php
        endforeach;
    endif;
?>
