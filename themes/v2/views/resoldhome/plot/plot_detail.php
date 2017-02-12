<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/list.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/xiaoqu-public.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/xiaoqu-detail.css');
?>

<div class="wrap">
    <?php $this->renderPartial('plot_search')?>
    <div class="wapper xiaoqu-head ovisible">
    <?php $this->widget('HomeBreadcrumbs',array('links'=>[$this->plot->title=>$this->createUrl('index',array('py'=>$this->plot->pinyin)),'详情']));?>
    <!--  小区名字  -->
    <div class="line"></div>
    <?php $this->renderPartial('plot_naver')?>
</div>
    <div class="wapper">

        <div class="common-title"><span>小区概况</span></div>
        <div class="detail">
            <div class="dea_1i">
                <ul>
                    <li class="title"> 楼盘地址</li>
                    <li class="content"> <?=$this->plot->address?$this->plot->address:'暂无'?></li>
                    <li class="title-2">所属商圈</li>
                    <li class="content"><?=$this->plot->street?$this->plot->streetInfo->name:'暂无'?></li>
                </ul>
            </div>
            <div class="dea_1i">
                <ul>
                    <li class="title"> 物业公司</li>
                    <li class="content"> <?=isset($this->plot->data_conf['manage_company'])?$this->plot->data_conf['manage_company']:'暂无'?></li>
                    <li class="title-2"> 占地面积</li>
                    <li class="content"><?=isset($this->plot->data_conf['size'])?$this->plot->data_conf['size'].'平方米':'暂无'?></li>
                </ul>
            </div>
            <div class="dea_1i">
                <ul>
                    <li class="title"> 物业费</li>
                    <li class="content"> <?=isset($this->plot->data_conf['manage_fee']) && $this->plot->data_conf['manage_fee']?$this->plot->data_conf['manage_fee']:'暂无'?></li>
                    <li class="title-2"> 容积率</li>
                    <li class="content"><?=isset($this->plot->data_conf['capacity'])?$this->plot->data_conf['capacity']:'暂无'?></li>
                </ul>
            </div>

            <div class="dea_1i">
                <ul>
                    <li class="title"> 区域</li>
                    <li class="content"> <?=$this->plot->areaInfo?$this->plot->areaInfo->name:'暂无'?></li>
                    <li class="title-2"> 建筑面积</li>
                    <li class="content"><?=isset($this->plot->data_conf['buildsize'])?$this->plot->data_conf['buildsize']:'暂无'?></li>
                </ul>
            </div>
            <div class="dea_1i">
                <ul>
                    <li class="title"> 建筑形态</li>
                    <li class="content">
                        <?php
                            $jzlb = [];
                            foreach($this->plot->jzlb as $v){
                                $jzlb[] = $v->name;
                            }
                            if($jzlb){
                                echo implode(',',$jzlb);
                            }else{
                                echo '暂无';
                            }
                        ?>
                    </li>
                    <li class="title-2"> 绿化率</li>
                    <li class="content"><?=isset($this->plot->data_conf['green'])?$this->plot->data_conf['green'].'%':'暂无'?></li>
                </ul>
            </div>
        </div>
        <div class="common-title"><span>小区介绍</span></div>
        <div class="container">
            <p><?=isset($this->plot->data_conf['content'])?$this->plot->data_conf['content']:'暂无'?></p>
        </div>
        <div class="common-title"><span>周边配套</span></div>
        <div class="container">
            <p><?=isset($this->plot->data_conf['peripheral'])?$this->plot->data_conf['peripheral']:'暂无'?></p>
        </div>
        <div class="common-title">
            <span>周边交通</span>
        </div>
        <div class="container">
            <p><?=isset($this->plot->data_conf['transit'])?$this->plot->data_conf['transit']:'暂无'?></p>
        </div>
</div>
