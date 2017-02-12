<?php foreach($plots as $plot): ?>
    <li class="area-block-item"><a href="javascript:;"  data-id="<?php echo $plot->id; ?>"><?php echo $plot->title; ?> <span class="stars">
        <?php for($i=0;$i<count(PlotExt::$star)-1;$i++): ?>
            <i class="<?php echo ($plot->star--)<=0?'empty':''?>"></i>
        <?php endfor; ?>
    </span></a></li>
<?php endforeach; ?>
