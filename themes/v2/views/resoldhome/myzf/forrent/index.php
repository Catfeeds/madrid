<?php
$this->pageTitle = '管理求租';
?>

<div class="gtitle"><?php echo $this->pageTitle;?></div>
<div class="my-manage-sell">
        <div class="common-nav">
            <ul>
                <li class="link">
                    <a href="<?php echo $this->createUrl('rentindex')?>">出售房源</a>
                </li>
                <li class="link on">
                    <a href="<?php echo $this->createUrl('forrentindex');?>">管理求租</a>
                </li>
            </ul>
        </div>
        <div class="order-list order-list-buy">
            <ul>
                <?php foreach($dataProvider->data as $item): ?>
                <li>
                    <div class="order-title">
                        <span class="no">发布时间：<?php echo Tools::friendlyDate($item->created);  ?> &nbsp;审核状态：<?php echo Yii::app()->params['checkStatus'][$item->status]; ?></span>
                        <div class="opts">
                            <?php if($item->status == 1): ?>
                                <a href="<?php echo $this->createUrl('/resoldhome/qz/detail',array('id'=>$item->id,'type'=>$item->category));?>" target="_blank">查看详情</a>
                            <?php endif; ?>
                            <a href="<?php echo $this->createUrl('forrentedit',array('id'=>$item->id))?>">修改房源</a>
                            <a href="javascript:;" class="j-delete" data-url="<?php echo $this->createUrl('/resoldhome/myzf/forrentdelete',array('id'=>$item->id))?>">删除房源</a>
                        </div>
                    </div>
                    <div class="order-content">
                        <table>
                            <tr>
                                <td class="w610">
                                    <div class="info m0">
                                        <div class="title">
                                            <?php if($item->status == 1): ?>
                                                <a target="_blank" href="<?php echo $this->createUrl('/resoldhome/qz/detail',array('id'=>$item->id,'type'=>$item->category));?>"><?php echo $item->title;?></a>
                                            <?php else: ?>
                                                <?php echo $item->title;?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="location">出租方式：<?php if($item->category == 1) {
                                                foreach ($this->allTag['zfmode'] as $mode){
                                                    if($mode['id'] == $item->rent_type){
                                                        echo $mode['name'].' | ';
                                                    }
                                                }
                                            }elseif($item->category == 2){
                                                foreach ($this->allTag['esfzfsptype'] as $type){
                                                    if($type['id'] == $item->data_conf['esfzfsptype']){
                                                        echo $type['name'].' | ';
                                                    }
                                                }
                                            }else{
                                                foreach ($this->allTag['esfzfxzltype'] as $type){
                                                    if($type['id'] == $item->data_conf['esfzfxzltype']){
                                                        echo $type['name'].' | ';
                                                    }
                                                }
                                            }
                                            ?><?php echo $item->areaInfo ? $item->areaInfo->name : ''; ?>   <?php echo $item->streetInfo ? $item->streetInfo->name : '';?></div>
                                    </div>
                                </td>
                                <td class="w165">
                                    <div class="price">
                                        <div class="total-price"><span class="num"><?php echo $item->price ; ?> </span>元/月</div>
                                        <div class="unit-price">
                                            <?php echo $item->size;?>㎡</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="opt">
                                        <?php if($item->status == 1): ?>
                                            <?php if($item->isRefresh): ?>
                                                <input type="button" value="已刷新"  class="button unable"/>
                                            <?php else: ?>
                                                <input type="button" value="刷新" class="button j-refresh" data-url="<?php echo $this->createUrl('/resoldhome/myzf/forrentrefresh'); ?>" data-id="<?php echo $item->id; ?>">
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