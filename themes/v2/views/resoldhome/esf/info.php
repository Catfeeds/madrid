<?php
    $this->pageTitle = $seoArr[$esf->category]['t'];
    $this->keyword = $seoArr[$esf->category]['k'];
    $this->description = $seoArr[$esf->category]['d'];
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/detail.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/static/resoldhome/style/iconfont/iconfont.css');
?>
<div class="blank10"></div>
<div class="wapper">
	<div class="detail_l">
        <?php $allTags = TagExt::tagCache(); $esftags = $esf->getEsfTag(); $alltags = []; if($allTags) foreach ($allTags as $key => $value) {
            $alltags[$value->cate][(string)$value->id] = $value->name;
        } ?>
        <?php $infoname = $esf->category==2?'商铺':($esf->category==3?'写字楼':'二手房');  $breadCrumbs = [SM::urmConfig()->cityName()."$infoname"=>$this->createUrl('list',['type'=>$esf->category])];
        $areaInfo && $breadCrumbs = $breadCrumbs + [$areaInfo->name."$infoname"=>$this->createUrl('list',['type'=>$esf->category,'area'=>$esf->area])];
        $streetInfo && $breadCrumbs = $breadCrumbs + [$streetInfo->name."$infoname"=>$this->createUrl('list',['type'=>$esf->category,'street'=>$esf->street])];
        $breadCrumbs = $breadCrumbs + [$esf->plot->title."$infoname"=>$this->createUrl('list',['type'=>$esf->category,'hid'=>$esf->plot->id])];
    ?>
        <?php $this->widget('HomeBreadcrumbs',array('links'=>$breadCrumbs));?>

        <div class="line"></div>
		<div class="detail-top clearfix">
			<p class="title"><?=$esf->title?></p>
			<div class="clearfix">
                <?php
                    $tsArr = ['1'=>'esfzzts','2'=>'esfspts','3'=>'esfxzlts'];
                    $tss = [];
                    $dataconf = json_decode($esf->data_conf,true);
                    $data_conf['tags'] = [];
                    foreach ($dataconf['tags'] as $key => $value) {
                        $data_conf['tags'][] = (int)$value;
                    }
                    $tss = array_intersect(array_keys($alltags[$tsArr[$esf->category]]), $data_conf['tags']);

                    // var_dump(array_keys($alltags[$tsArr[$esf->category]]),$data_conf['tags']);exit;
                    if($tss):
                ?>
				<div class="tags">
				<?php $colorArr = ['color1','color2','color3','color1','color2'];?>
                <?php $i=0;foreach($tss as $key=>$v1):?>
                            <?php if($i==5) break;?>
                            <span class="<?=$colorArr[$i]?>"><?=$alltags[$tsArr[$esf->category]][$v1]?></span>
                <?php $i++;endforeach;?>
                  </div>
              <?php endif;?>
				<span class="time">发布时间：<?=$esf->sale_time?date('Y-m-d H:i',$esf->sale_time):date('Y-m-d H:i',$esf->created)?></span>
				<span class="time">浏览量：<?=$esf->hits?></span>
			</div>

			<div class="esf-slider">

				<ul class="bigImg">
                <?php if($esf->image): ?>
                    <li><img src="<?=ImageTools::fixImage($esf->image,400,300)?>"/></li>
                <?php else: ?>
                    <li><img src="<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic,400,300)?>"></li>
                <?php endif; ?>
				<?php if($esf->images):?>
                    <?php foreach ($esf->images as $key => $value):?>
                        <?php if($value->url==$esf->image) continue;?>
					<li><img src="<?=ImageTools::fixImage($value->url,400,300)?>"></li>
                <?php endforeach;?>
                <?php endif;?>
				</ul>
				<div class="smallScroll">
				<a class="pre-btn" href="javascript:void(0)"><i class="detail-ico"></i></a>
				<div class="smallImg">
				<ul>
                    <?php if($esf->image): ?>
                        <li><img src="<?=ImageTools::fixImage($esf->image,400,300)?>"/></li>
                    <?php else: ?>
                        <li><img src="<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic,400,300)?>"></li>
                    <?php endif; ?>
                    <?php if($esf->images):?>
                        <?php foreach ($esf->images as $key => $value):?>
                            <?php if($value->url==$esf->image) continue;?>
    					<li><img src="<?=ImageTools::fixImage($value->url,400,300)?>"></li>
                    <?php endforeach;?>
                    <?php endif;?>
				</ul>
				</div>
				<a href="javascript:void(0)" class="next-btn "><i class="detail-ico"></i></a>
				</div>
			</div>
            <!--商铺信息-->
            <?php if($esf->category == 2):?>
                <div class="info">
                    <ul class="info-ul clearfix">
                        <li class="long"><span><em>总</em>价：</span><em><?=Tools::FormatPrice($esf->price,'</em>万')?></em><?php if($esf->ave_price>0):?>(<?=$esf->ave_price?>元/m²)<?php endif;?></li>
                        <li class="left"><span><em>楼</em>层：</span><?=isset($esftags['floorcate'])?$esftags['floorcate']['name']:'暂无'?><?php if($esf->total_floor > 0): ?>/(共<?=$esf->total_floor?>层)<?php endif; ?>
                        </li>
                        <li class=""><span>建筑面积：</span><?=$esf->size?>m²</li>
                    </ul>
                    <div class="tel-box">
                        <i class="tel-ico iconfont">&#xe609;</i>
                        <span><?=$esf->phone?><?php if(!$staff):?><em>(业主<?=$esf->username?$esf->username:$esf->account?>)</em><?php endif;?></span>
                    </div>
                    <p class="promite">联系我时，请说在<?=SM::globalConfig()->siteName()?>二手房看到的</p>
                    <ul class="info-ul">
                        <li class="left"><span>商铺类型：</span><?php $zztype = array_intersect($data_conf['tags'], array_keys($alltags['esfzfsptype']));echo $zztype?$alltags['esfzfsptype'][array_values($zztype)[0]]:'暂无'?></li>
                        <li><span><em>级</em>别：</span><?php $zztype = array_intersect($data_conf['tags'], array_keys($alltags['esfsplevel']));echo $zztype?$alltags['esfsplevel'][array_values($zztype)[0]]:'暂无'?></li>
                        <li class="left"><span>物 业 费 ：</span><?=$esf->wuye_fee?$esf->wuye_fee.'元/平米·月':'暂无'?></li>
                        <li><span><em>装</em>修：</span><?=$esf->decoration?$alltags['resoldzx'][$esf->decoration]:'暂无'?></li>
                        <li class="left"><span>建筑年代：</span><?=$esf->age?$esf->age:'不详'?></li>
                        <li><span><em>朝</em>向：</span><?=$esf->towards?$alltags['resoldface'][$esf->towards]:'暂无'?></li>

                        <li class="long"><span>配套设施：</span><?php $sppt = array_intersect($data_conf['tags'], array_keys($alltags['esfsppt']));?><?php
                        $esfpt = '';
                            if($sppt){
                                foreach($sppt as $key=>$value){
                                    $esfpt .= $alltags['esfsppt'][$value].' ';
                                }
                            }
                            echo !empty($esfpt)?trim($esfpt):'暂无';
                        ?></li>
                        <li class="long"><span>适合经营：</span><?php $sppt = array_intersect(array_unique($data_conf['tags']), array_keys($alltags['esfspkjyxm']));?><?php
                        $spjy = '';
                            if($sppt){
                                foreach($sppt as $key=>$value){
                                    $spjy .= $alltags['esfspkjyxm'][$value].' ';
                                }
                            }
                            echo !empty($spjy)?trim($spjy):'暂无';
                        ?></li>
                        <li class="long"><span>小区名称：</span>
                            <a href="<?=$this->createUrl('/resoldhome/plot/pesflist',['py'=>$esf->plot->pinyin])?>" clas="addr"><?=$esf->plot->title?>
                                <?php if($esf->areaInfo): ?>
                                    (<a href="<?=$this->createUrl('/resoldhome/plot/list',['area'=>$esf->area])?>"><?=$esf->areaInfo->name?></a>
                                    <?php if($esf->streetInfo): ?>
                                        <a href="<?=$this->createUrl('/resoldhome/plot/list',['street'=>$esf->street])?>"><?=$esf->streetInfo->name?></a>
                                    <?php endif; ?>
                                    )
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="long"><span>小区地址：</span>
                            <a href="#content3"><?=$esf->plot->address?></a>
                        </li>

                    </ul>
            <!--写字楼信息-->
            <?php elseif($esf->category == 3):?>
                <div class="info">
					<ul class="info-ul clearfix">
						<li class="long"><span><em>总</em>价：</span><em><?=Tools::FormatPrice($esf->price,'</em>万')?></em><?php if($esf->ave_price>0):?>(<?=$esf->ave_price?>元/m²)<?php endif;?></li>
						<!-- <li><i class="caculate-ico detail-ico"></i><a href="" target="_blank">房贷计算器</a></li> -->
                        <li class="left"><span>所在楼层：</span><?=isset($esftags['floorcate'])?$esftags['floorcate']['name']:'暂无'?><?php if($esf->total_floor > 0): ?>/(共<?=$esf->total_floor?>层)<?php endif; ?>
                        </li>
						<li class=""><span>建筑面积：</span><?=$esf->size?>m²</li>
					</ul>
					<div class="tel-box">
						<i class="tel-ico iconfont">&#xe609;</i>
						<span><?=$esf->phone?><?php if(!$staff):?><em>(业主<?=$esf->username?$esf->username:$esf->account?>)</em><?php endif;?></span>
					</div>
					<p class="promite">联系我时，请说在<?=SM::globalConfig()->siteName()?>二手房看到的</p>
					<ul class="info-ul">
                        <li class="left"><span><em>类</em>型：</span><?php $zztype = array_intersect($data_conf['tags'], array_keys($alltags['esfzfxzltype']));echo $zztype?$alltags['esfzfxzltype'][array_values($zztype)[0]]:'暂无'?></li>
                        <li class=""><span><em>等</em>级：</span><?php $zztype = array_intersect($data_conf['tags'], array_keys($alltags['zfxzllevel']));echo $zztype?$alltags['zfxzllevel'][array_values($zztype)[0]]:'暂无'?></li>
						<li class="left"><span>物 业 费 ：</span><?=$esf->wuye_fee?$esf->wuye_fee.'元/平米·月':'暂无'?></li>
						<li><span><em>装</em>修：</span><?=$esf->decoration?$alltags['resoldzx'][$esf->decoration]:'暂无'?></li>
                        <li class="left"><span>建筑年代：</span><?=$esf->age?$esf->age.'年':'不详'?></li>
                        <li><span><em>朝</em>向：</span><?=$esf->towards?$alltags['resoldface'][$esf->towards]:'暂无'?></li>
						<li class="long"><span>配套设施：</span><?php $sppt = array_intersect($data_conf['tags'], array_keys($alltags['esfxzlpt']));?><?php
                        $esfpt = '';
                            if($sppt){
                                foreach($sppt as $key=>$value){
                                    $esfpt .= $alltags['esfxzlpt'][$value].' ';
                                }
                            }
                            echo !empty($esfpt)?trim($esfpt):'暂无';
                        ?></li>
                        <li class="long"><span>小区名称：</span><a href="<?=$this->createUrl('/resoldhome/plot/pesflist',['py'=>$esf->plot->pinyin])?>" clas="addr"><?=$esf->plot->title?>
                                <?php if($esf->areaInfo): ?>
                                    (<a href="<?=$this->createUrl('/resoldhome/plot/list',['area'=>$esf->area])?>"><?=$esf->areaInfo->name?></a>
                                    <?php if($esf->streetInfo): ?>
                                        <a href="<?=$this->createUrl('/resoldhome/plot/list',['street'=>$esf->street])?>"><?=$esf->streetInfo->name?></a>
                                    <?php endif; ?>
                                    )
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="long"><span>小区地址：</span><a href="#content3"><?=$esf->plot->address?></a>
                        </li>
					</ul>
            <!--二手房信息-->
            <?php else:?>
			<div class="info">
				<ul class="info-ul clearfix">
					<li class="long"><span><em>总</em>价：</span><em><?=Tools::FormatPrice($esf->price,'</em>万')?><?php if($esf->ave_price>0):?>(<?=$esf->ave_price?>元/m²)<?php endif;?></li>
					<!-- <li><i class="caculate-ico detail-ico"></i><a href="" target="_blank">房贷计算器</a></li> -->
					<li class="left"><span><em>户</em>型：</span><?=$esf->bedroom?>室<?=$esf->livingroom?>厅<?=$esf->bathroom?>卫</li>
					<li><span>建筑面积：</span><?=$esf->size?>m²</li>
				</ul>
				<div class="tel-box">
					<i class="tel-ico iconfont">&#xe609;</i>
					<span><?=$esf->phone?><?php if(!$staff):?><em>(业主<?=$esf->username?$esf->username:$esf->account?>)</em><?php endif;?></span>
				</div>
				<p class="promite">联系我时，请说在<?=SM::globalConfig()->siteName()?>二手房看到的</p>
				<ul class="info-ul">
					<li class="left"><span>住宅类别：</span><?php $zztype = array_intersect($data_conf['tags'], array_keys($alltags['esfzfzztype']));echo $zztype?$alltags['esfzfzztype'][array_values($zztype)[0]]:'暂无'?></li>
					<li><span><em>朝</em>向：</span><?=$esf->towards?$alltags['resoldface'][$esf->towards]:'暂无'?></li>
					<li class="left"><span><em>楼</em>层：</span><?=isset($esftags['floorcate'])?$esftags['floorcate']['name']:'暂无'?><?php if($esf->total_floor > 0): ?>/(共<?=$esf->total_floor?>层)<?php endif; ?>
                    </li>
					<li><span><em>装</em>修：</span><?=$esf->decoration?$alltags['resoldzx'][$esf->decoration]:'暂无'?></li>
					<li class="long"><span>建筑年代：</span><?=$esf->age?$esf->age.'年':'不详'?></li>
                    <li class="long"><span>配套设施：</span><?php $sppt = array_intersect($data_conf['tags'], array_keys($alltags['esfzzpt']));?><?php
                        $esfpt = '';
                            if($sppt){
                                foreach($sppt as $key=>$value){
                                    $esfpt .= $alltags['esfzzpt'][$value].' ';
                                }
                            }
                            echo !empty($esfpt)?trim($esfpt):'暂无';
                        ?></li>
					<!-- <li class="long"><span>产权性质：</span>个人产权</li> -->
					<!-- <li class="long"><span>楼盘名称：</span><a href="<?=$this->createUrl('/resoldhome/plot/index',['py'=>$plot->pinyin])?>" class="addr"><?=$plot?$plot->title:''?><em>（</em><?=$plot&&$plot->areaInfo?$plot->areaInfo->name:''?>  <?=$plot&&$plot->streetInfo?$plot->streetInfo->name:'-'?><em>）</em><em>[</em>街景地图<em>]</em></a></li> -->
                    <li class="long"><span>小区名称：</span><a href="<?=$this->createUrl('/resoldhome/plot/pesflist',['py'=>$esf->plot->pinyin])?>" clas="addr"><?=$esf->plot->title?>
                            <?php if($esf->areaInfo): ?>
                                (<a href="<?=$this->createUrl('/resoldhome/plot/list',['area'=>$esf->area])?>"><?=$esf->areaInfo->name?></a>
                                <?php if($esf->streetInfo): ?>
                                    <a href="<?=$this->createUrl('/resoldhome/plot/list',['street'=>$esf->street])?>"><?=$esf->streetInfo->name?></a>
                                <?php endif; ?>
                                )
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="long"><span>小区地址：</span><a href="#content3"><?=$esf->plot->address?></a>
                    </li>
				</ul>

        <?php endif;?>
        <a href="javascript:void(0)" class="jubao-btn j-report-btn" data-infoid="<?=$esf->id?>" data-infoname="<?=$esf->title?>" data-type="esf"><i class="iconfont">&#xe601;</i>举报虚假</a>
        <a href="javascript:void(0)" class="save-btn j-fav-btn on" data-fid="<?=$esf->id?>" data-category="2"><i class="iconfont"></i>收藏房源</a>
    </div>
		</div>
		<div class="blank50"></div>
		<?php $this->renderPartial('esf_info')?>

	</div>
    <!--中介及个人信息-->
	<?php $this->renderPartial('person')?>

</div>
<div class="wapper">
<?php $plotAlbum = PlotImgExt::model()->with('tag')->findAll(['condition'=>'t.hid=:hid and tag.name=:name','params'=>[':hid'=>$plot->id,':name'=>'配套图'],'order'=>'t.sort desc,t.created desc','limit'=>5]);if($plotAlbum):?>
	<div class="common-title"><span><?=$plot->title?>小区相册</span><a class="more" href="<?=$this->createUrl('/resoldhome/plot/album',['py'=>$plot->pinyin,'t'=>$plotAlbum[0]->type])?>">查看更多图片&nbsp;&nbsp;&gt;</a></div>

	<div class="fang-list long-list">
        <ul>
        <?php foreach ($plotAlbum as $key => $value) {?>
        	<li>
                <a href="<?=$this->createUrl('/resoldhome/plot/image',['py'=>$plot->pinyin,'pid'=>$value->id])?>" target="_blank">
                    <div class="pic">
                        <img src="<?=ImageTools::fixImage($value->url,200,150)?>" onError="javascript:this.src='<?=ImageTools::fixImage(SM::GlobalConfig()->siteNoPic())?>'" alt="">
                    </div>

                </a>
            </li>
        <?php }?>

        </ul>
        <?php if($plot->is_new):?>
        <div class="more-info">更多信息：<a href="<?=$this->createUrl('/resoldhome/plot/album',['py'=>$plot->pinyin])?>" target="_blank"><?=$plot->title?></a><a href="<?=$this->createUrl('/home/plot/price',['py'=>$plot->pinyin])?>" target="_blank"><?=$plot->title?>房价走势</a><a href="<?=$this->createUrl('/resoldhome/plot/album',['py'=>$plot->pinyin])?>" target="_blank"><?=$plot->title?>相册</a><a href="http://www.hualongxiang.com/yezhu" target="_blank"><?=$plot->title?>业主论坛</a></div>
    <?php endif;?>
    </div>
<?php endif;?>
<div class="common-title"><span>您可能感兴趣的房源</span></div>
<div class="fang-list long-list">
    <?php $this->widget('ViewRecordWidget',['url'=>'/resoldhome/esf/info','cssType'=>4,'type'=>1,'category'=>$esf->category,'limit'=>5,'infoId'=>$esf->id])?>
</div>
<?php if($esf->category == 1): ?>
<?php $this->widget('PlotWidget',['areaid'=>$esf->area,'streetid'=>$esf->street ]); ?>
<?php endif; ?>
    <div class="blank10"></div>
	<div class="shengming"><span>免责声明：</span><?=SM::resoldConfig()->resoldPCFreeStatement()?SM::resoldConfig()->resoldPCFreeStatement():'房源信息有网站用户提供、其真实性、合法性由信息提供者负责，最终以政府部门登记备案为准，本网站不声明或保证内容之正确性和可靠行，购买该房屋时，请谨慎核查，如该房源信息有误，您可以投诉此房源信息或拨打举报电话：0519-83022322'?></div>
</div>
