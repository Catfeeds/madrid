<?php
$this->pageTitle = '管理出售房源';
?>

    <div class="gtitle">管理出售房源</div>
    <div class="my-manage-sell">
        <div class="common-nav">
            <ul>
                <li class="link on">
                    <a href="<?php echo $this->createUrl('sellindex')?>">出售房源</a>
                </li>
                <li class="link">
                    <a href="<?php echo $this->createUrl('buyindex')?>">管理求购</a>
                </li>
            </ul>
        </div>
        <div class="order-list order-list-sell">
            <ul>
                <?php foreach ($dataProvider->data as $item): ?>
                <li>
                    <div class="order-title">
                        <span class="no">发布时间：<?php echo Tools::friendlyDate($item->created);  ?></span>
                        <span class="no" style="color: #D51938"><?php if(YII_BEGIN_TIME  > $item->expire_time && $item->sale_status == 1 && $item->status == 1){ echo '已过期';}?></span>
                        <div class="opts">
                            <?php if($item->status == 1 && $item->sale_status == 1): ?>
                            <a href="<?php echo $this->createUrl('/resoldhome/esf/info',array('id'=>$item->id,'type'=>$item->category));?>" target="_blank">查看详情</a>
                            <?php endif; ?>
                            <a href="<?php echo $this->createUrl('/resoldhome/myesf/selledit',array('id'=>$item->id));?>">修改房源</a>
                            <a href="javascript:;" class="j-delete" data-url="<?php echo $this->createUrl('/resoldhome/myesf/selldelete',array('id'=>$item->id))?>">删除房源</a>
                        </div>
                    </div>
                    <div class="order-content">
                        <table>
                            <tr>
                                <td>
                                    <div class="pic">
                                        <?php if($item->sale_status == 1 && $item->status == 1): ?>
                                        <a href="<?php echo $this->createUrl('/resoldhome/esf/info',array('id'=>$item->id,'type'=>$item->category));?>" target="_blank">
                                            <img src="<?php echo ImageTools::fixImage($item->image,160,120) ?>" alt="<?php echo $item->title; ?>" />
                                        </a>
                                        <?php else: ?>
                                            <img src="<?php echo ImageTools::fixImage($item->image,160,120) ?>" alt="<?php echo $item->title; ?>"/>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="info">
                                        <div class="title">
                                        <?php if($item->sale_status == 1 && $item->status == 1): ?>
                                            <a href="<?php echo $this->createUrl('/resoldhome/esf/info',array('id'=>$item->id,'type'=>$item->category));?>" target="_blank">
                                                <?php echo $item->title ; ?>
                                            </a>
                                            <?php else: ?>
                                            <?php echo $item->title; ?>
                                        <?php endif; ?>
                                        </div>
                                        <?php if($item->category == 1):  ?>
                                        <div class="er-tags"><?php echo $item->bedroom;?>室<?php echo $item->livingroom;?>厅   |  <?php echo $item->size ;?>㎡   |  <?php echo $item->floor;?>层/共<?php echo $item->total_floor;?>层   |   建筑年代：<?php echo $item->age ? $item->age : '不限'; ?> </div>
                                        <?php elseif($item->category == 2): ?>
                                        <div class="er-tags"><?php
                                            $type='暂无';
                                            foreach ($this->allTag['esfzfsptype'] as $tag){
                                                if(isset($item->data_conf['esfzfsptype'][$tag['id']])){
                                                    $type = $item->data_conf['esfzfsptype'][$tag['id']];
                                                }
                                            }
                                            echo $type;
                                            ?>   <?php
                                                if(isset($item->data_conf['esfsplevel'])) {
                                                    $level = '';
                                                    foreach ($this->allTag['esfsplevel'] as $tag) {
                                                        if (isset($item->data_conf['esfsplevel'][$tag['id']])) {
                                                            $level = $item->data_conf['esfsplevel'][$tag['id']];
                                                        }
                                                    }
                                                    echo '   |   '.$level;
                                                }
                                            ?>   |  <?php echo $item->size;?>㎡   |  <?php echo $item->floor .'层/共'.$item->total_floor.'层'; ?></div>
                                        <?php elseif($item->category == 3): ?>
                                            <div class="er-tags"><?php
                                                $type='暂无';
                                                foreach ($this->allTag['esfzfxzltype'] as $tag){
                                                    if(isset($item->data_conf['esfzfxzltype'][$tag['id']])){
                                                        $type = $item->data_conf['esfzfxzltype'][$tag['id']];
                                                    }
                                                }
                                                echo $type;
                                                ?>   <?php
                                                if(isset($item->data_conf['zfxzllevel'])) {
                                                    $level = '';
                                                    foreach ($this->allTag['zfxzllevel'] as $tag) {
                                                        if (isset($item->data_conf['zfxzllevel'][$tag['id']])) {
                                                            $level = $item->data_conf['zfxzllevel'][$tag['id']];
                                                        }
                                                    }
                                                    echo '   |   '.$level;
                                                }
                                                ?>   |  <?php echo $item->size;?>㎡   |  <?php echo $item->floor .'层/共'.$item->total_floor.'层'; ?></div>
                                        <?php endif; ?>
                                        <div class="er-address"><?php echo $item->plot->title; ?><span class="road"><?php echo Tools::u8_title_substr($item->address ,27); ?></span></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="aside">
                                        <div class="price"><span class="num"><?php echo Tools::FormatPrice($item->price,'万'); ?></span></div>
                                        <div class="unit-price"><?php echo $item->price <= 0 ? '' : $item->ave_price.'元/m²'; ?></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="opt">
                                        <?php if($item->sale_status == 1 && $item->status == 1): ?>
                                            <?php if($item->isRefresh): ?>
                                                <input type="button" value="已刷新"  class="button unable"/>
                                            <?php else: ?>
                                                <input type="button" value="刷新" class="button j-refresh" data-url="<?php echo $this->createUrl('/resoldhome/myesf/refresh'); ?>" data-id="<?php echo $item->id; ?>">
                                            <?php endif; ?>
                                            <?php else: ?>
                                            <input type="button" value="刷新"  class="button unable"/>
                                        <?php endif; ?>
                                        <div class="state"><?php echo Yii::app()->params['checkStatus'][$item->status]; ?></div>
                                    </div>
                                </td>

                                <td>
                                    <div class="refresh-time">
                                        <div>上次刷新时间</div>
                                        <div><?php if($item->refresh_time){echo date('Y-m-d H:i:s',$item->refresh_time);}else{echo '未刷新';} ?></div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <div class="blank20"></div>
            <div class="page-box">
                <?php $this->widget('HomeLinkPager', array('pages'=>$dataProvider->pagination)); ?>
            </div>
        </div>
    </div>