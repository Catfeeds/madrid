<?php
$this->pageTitle = '全站设置';
$this->breadcrumbs = array('站点设置',$this->pageTitle);
?>

<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#jiben" aria-controls="home" role="tab" data-toggle="tab">基本设置</a></li>
	<li role="presentation"><a href="#gexing" aria-controls="profile" role="tab" data-toggle="tab">个性设置</a></li>
	<li role="presentation"><a href="#jiekou" aria-controls="settings" role="tab" data-toggle="tab">常规接口设置</a></li>
	<li role="presentation"><a href="#kaiguan" aria-controls="settings" role="tab" data-toggle="tab">开关设置</a></li>
	<li role="presentation"><a href="#tupian" aria-controls="settings" role="tab" data-toggle="tab">图片设置</a></li>
	<li role="presentation"><a href="#loupanhuibo" aria-controls="settings" role="tab" data-toggle="tab">楼盘回拨设置</a></li>
    <li role="presentation"><a href="#newlogin" aria-controls="settings" role="tab" data-toggle="tab">论坛应用整合</a></li>
</ul>

<?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))); ?>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="jiben">
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'siteName') ?></label>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'siteName', array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'siteName') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'sitePhone') ?></label>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'sitePhone', array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'sitePhone') ?></div>
        </div>
        <?php
        foreach($model->maiFangQQ as $qqk=>$v):
        ?>
        <div class="form-group qq">
            <label class="col-md-2 control-label"><?php if($qqk==0) echo $form->label($model,'maiFangQQ') ?></label>
            <div class="col-md-10">
                <span>
                    <?php
                        echo $form->dropDownList($model,'maiFangQQ['.$qqk.'][type]',QqModel::$typeEnum,['class'=>'form-control input-inline qq_type','onchange'=>'showQQ()']);
                        echo $form->textField($model,'maiFangQQ['.$qqk.'][name]',['class'=>'form-control input-inline','placeholder'=>'QQ昵称或群组名称']);
                        echo $form->textField($model,'maiFangQQ['.$qqk.'][number]',['class'=>'form-control input-inline','placeholder'=>'QQ号或QQ群号']);
                        echo $form->textField($model,'maiFangQQ['.$qqk.'][url]',['class'=>'form-control input-inline qq_url','placeholder'=>'QQ群链接']);
                     ?>
                </span>
                <?php if($qqk==0): ?>
                    <a href="javascript:;" class="btn btn-circle btn-default" id="add_qq"><i class="fa fa-plus"></i>添加</a>（最多添加4个）
                <?php endif; ?>
            </div>
        </div>
        <?php
        endforeach;
        ?>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'esfUrl') ?></label>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'esfUrl', array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'esfUrl') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'zfUrl') ?></label>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'zfUrl', array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'zfUrl') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'plotEsfUrl') ?></label>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'plotEsfUrl', array('class'=>'form-control')); ?>
                <span class="help-inline">使用{id}占位符代表小区旧的id，系统会使用旧的id替换之，如http://yourfangurl.com/esf/{id}</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'plotEsfUrl') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'plotZfUrl') ?></label>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'plotZfUrl', array('class'=>'form-control')); ?>
                <span class="help-inline">使用{id}占位符代表小区旧的id，系统会使用旧的id替换之，如http://yourfangurl.com/zf/{id}</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'plotZfUrl') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'bbsPlotPageUrl') ?></label>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'bbsPlotPageUrl', array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'bbsPlotPageUrl') ?></div>
        </div>
    </div>

    <!-- 个性设置 -->
    <div role="tabpanel" class="tab-pane fade" id="gexing">
        <?php 
        foreach($model->siteSqNav as $sqk=>$v): 
        ?>
        <div class="form-group sqnav">
            <label class="col-md-2 control-label"><?php if($sqk==0) echo $form->label($model,'siteSqNav') ?></label>
            <span>
                <div class="col-md-2">
                    <?php echo $form->textField($model, 'siteSqNav['.$sqk.'][name]', array('class'=>'form-control','placeholder'=>'菜单标题','value'=>$v['name'])); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->textField($model, 'siteSqNav['.$sqk.'][url]', array('class'=>'form-control','placeholder'=>'菜单链接','value'=>$v['url'])); ?>
                </div>
            </span>
            <?php if($sqk==0): ?>
            <div class="col-md-3">
                <a href="javascript:;" class="btn btn-circle btn-default" id="add_sqdh"><i class="fa fa-plus"></i>添加</a>（最多添加4个）
            </div>
            <?php endif; ?>
        </div>
        <?php
        endforeach;
        ?>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'tradeTermsUrl') ?></label>
            <div class="col-md-6">
                <?php
                echo $form->textField($model, 'tradeTermsUrl', array('class'=>'form-control')); ?><span class="help-inline">PC表单框处显示的交易条款链接地址</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'tradeTermsUrl') ?></div>
        </div>
		<div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'staffLogLength') ?></label>
            <div class="col-md-6">
                <?php
                echo $form->textField($model, 'staffLogLength', array('class'=>'form-control')); ?><span class="help-inline">为了能够在后台复查时，了解买房顾问对网友流水记录的表达意思，可以设定买房顾问填写流水的最少字数，以便能够详细描述网友的需求。</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'staffLogLength') ?></div>
        </div>
		<div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'diyWordsMap[特惠团]') ?></label>
            <div class="col-md-6">
                <?php
                echo $form->textField($model, 'diyWordsMap[特惠团]', array('class'=>'form-control')); ?><span class="help-inline">有团购品牌的站点可修改该团购名称文案</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'diyWordsMap[特惠团]') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'diyWordsMap[房大白]') ?></label>
            <div class="col-md-6">
                <?php
                echo $form->textField($model, 'diyWordsMap[房大白]', array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'diyWordsMap[房大白]') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'siteFooter') ?></label>
            <div class="col-md-10">
                <?php
                    echo $form->textArea($model, 'siteFooter', array('cols'=>100,'rows'=>10));

                ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'siteFooter') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'siteStatistic') ?></label>
            <div class="col-md-10">
                <?php
                    echo $form->textArea($model, 'siteStatistic', array('cols'=>100,'rows'=>8));
                ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'siteStatistic') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'wapStatistic') ?></label>
            <div class="col-md-10">
                <?php
                    echo $form->textArea($model, 'wapStatistic', array('cols'=>100,'rows'=>8));
                ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'wapStatistic') ?></div>
        </div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'sySEO') ?></label>
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">标题</span>
					<?php echo $form->textField($model, 'sySEO[title]', array('class'=>'form-control')); ?>
				</div>
				<div class="input-group">
					<span class="input-group-addon">关键词</span>
					<?php echo $form->textField($model, 'sySEO[keyword]', array('class'=>'form-control')); ?>
				</div>
				<div class="input-group">
					<span class="input-group-addon">描述</span>
					<?php echo $form->textField($model, 'sySEO[description]', array('class'=>'form-control')); ?>
				</div>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'sySEO') ?></div>
		</div>
		<div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'wxAppId') ?></label>
            <div class="col-md-6">
                <?php
                echo $form->textField($model, 'wxAppId', array('class'=>'form-control')); ?><span class="help-inline">用于在分享部分页面到微信时可指定标题或预览图</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'wxAppId') ?></div>
        </div>
		<div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'wxAppSecret') ?></label>
            <div class="col-md-6">
                <?php
                echo $form->textField($model, 'wxAppSecret', array('class'=>'form-control')); ?><span class="help-inline">用于在分享部分页面到微信时可指定标题或预览图</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'wxAppSecret') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">资讯详情底部版权</label>
            <div class="col-md-6">
                <?php
                echo $form->textField($model, 'infoCP', array('class'=>'form-control')); ?><span class="help-inline">若为空则显示默认版权文字</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'infoCP') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">地图中心坐标配置</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">经度</span>
                        <?php echo $form->textField($model, 'map_x', array('class'=>'form-control')); ?>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">纬度</span>
                        <?php echo $form->textField($model, 'map_y', array('class'=>'form-control')); ?>
                    </div>
                    <span class="help-inline">若为空则地图中心坐标为默认城市</span>
                </div>
        </div>
    </div>


    <!-- 常规接口地址设置 -->
    <div role="tabpanel" class="tab-pane fade" id="jiekou">
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'esfZfApi') ?></label>
            <div class="col-md-6">
                <?php echo $form->textField($model, 'esfZfApi', array('class'=>'form-control','placeholder'=>'http://yourbbsdomain.com/tagesf')); ?><span class="help-inline">首页二手房租房数据调用api，请参考常规接口开发文档开发此接口。</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'esfZfApi') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'newEsfApi') ?></label>
            <div class="col-md-6">
                <?php echo $form->textField($model, 'newEsfApi', array('class'=>'form-control','placeholder'=>'http://yourbbsdomain.com/newesf')); ?><span class="help-inline">首页最新二手房数据调用api，请参考常规接口开发文档开发此接口。</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'newEsfApi') ?></div>
        </div>
    </div>

	<!-- 开关设置 -->
	<div role="tabpanel" class="tab-pane fade" id="kaiguan">
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'adType') ?></label>
            <div class="col-md-6 radio-list">
                <?php echo $form->radioButtonList($model, 'adType', array(1=>'百度广告',2=>'URM广告'),array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'adType') ?></div>
        </div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'enableWaterMark') ?></label>
			<div class="col-md-6 radio-list">
				<?php echo $form->radioButtonList($model, 'enableWaterMark', array(0=>'关闭',1=>'启用'),array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?><span class="help-inline">启用后请配置水印图片</span>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'enableWaterMark') ?></div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'waterMarkGravity') ?></label>
			<div class="col-md-6 radio-list">
				<?php echo $form->radioButtonList($model, 'waterMarkGravity', $model::$waterMarkGravityOptions,array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'waterMarkGravity') ?></div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'enableSubstation') ?></label>
			<div class="col-md-6 radio-list">
				<?php echo $form->radioButtonList($model, 'enableSubstation', array(0=>'关闭',1=>'启用'),array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?><span class="help-inline"><a href="<?php echo $this->createUrl('/admin/substation/edit'); ?>">启用并保存后点此设置分站信息</a></span>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'enableSubstation') ?></div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'enableAdviserPage') ?></label>
			<div class="col-md-6 radio-list">
				<?php echo $form->radioButtonList($model, 'enableAdviserPage', array(0=>'关闭',1=>'启用'),array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?><span class="help-inline">启用后前台导航会显示入口链接</span>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'enableAdviserPage') ?></div>
		</div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'enableSchool') ?></label>
            <div class="col-md-6 radio-list">
                <?php echo $form->radioButtonList($model, 'enableSchool', array(0=>'关闭',1=>'启用'),array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?><span class="help-inline">关闭后所有邻校房入口将被隐藏</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'enableSchool') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'enableSpecialPlot') ?></label>
            <div class="col-md-6 radio-list">
                <?php echo $form->radioButtonList($model, 'enableSpecialPlot', array(0=>'关闭',1=>'启用'),array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?><span class="help-inline">关闭后所有特价房入口将被隐藏</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'enableSpecialPlot') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'enableSpecialTuan') ?></label>
            <div class="col-md-6 radio-list">
                <?php echo $form->radioButtonList($model, 'enableSpecialTuan', array(0=>'关闭',1=>'启用'),array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?><span class="help-inline">关闭后所有特惠团入口将被隐藏</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'enableSpecialTuan') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'enableArticleKeywords') ?></label>
            <div class="col-md-6 radio-list">
                <?php echo $form->radioButtonList($model, 'enableArticleKeywords', array(0=>'关闭',1=>'启用'),array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?><span class="help-inline">关闭后所有文章的楼盘关键词将不会被匹配</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'enableArticleKeywords') ?></div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'enablePlotCall') ?></label>
            <div class="col-md-6 radio-list">
                <?php echo $form->radioButtonList($model, 'enablePlotCall', array(0=>'关闭',1=>'启用'),array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?><span class="help-inline">关闭后将隐藏楼盘页面回拨功能</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'enablePlotCall') ?></div>
        </div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'showLogin') ?></label>
			<div class="col-md-6 radio-list">
				<?php echo $form->radioButtonList($model, 'showLogin', array(0=>'否',1=>'是'),array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?><span class="help-inline"></span>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'showLogin') ?></div>
		</div>
	</div>


    <!-- 图片 -->
    <div role="tabpanel" class="tab-pane fade" id="tupian">
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'siteLogo') ?></label>
            <div class="col-md-4">
                <?php $this->widget('FileUpload',array('model'=>$model, 'attribute'=>'siteLogo','mode'=>2,'width'=>300)) ?><span class="help-inline">用于站点白底头部，推荐177x52px尺寸大小、或相同(或相近)长宽比例的图片</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'siteLogo') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'siteLogoRed') ?></label>
            <div class="col-md-4">
                <?php $this->widget('FileUpload',array('model'=>$model, 'attribute'=>'siteLogoRed','mode'=>2,'width'=>300)) ?><span class="help-inline">用于站点红底头部，推荐177x26px尺寸大小、或相同(或相近)长宽比例的图片</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'siteLogoRed') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'wapLogo') ?></label>
            <div class="col-md-4">
                <?php $this->widget('FileUpload',array('model'=>$model, 'attribute'=>'wapLogo','mode'=>2,'width'=>300)) ?><span class="help-inline">推荐240x34px尺寸大小、或相同(或相近)长宽比例的图片</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'wapLogo') ?></div>
        </div>
		<div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'wapLogoRed') ?></label>
            <div class="col-md-4">
                <?php $this->widget('FileUpload',array('model'=>$model, 'attribute'=>'wapLogoRed','mode'=>2,'width'=>162)) ?><span class="help-inline">推荐162x36px尺寸大小、或相同(或相近)长宽比例的图片</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'wapLogoRed') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'weixinQrCode') ?></label>
            <div class="col-md-4">
                <?php $this->widget('FileUpload',array('model'=>$model, 'attribute'=>'weixinQrCode','mode'=>2,'width'=>300)) ?><span class="help-inline">推荐115x115px尺寸大小、或相同(或相近)长宽比例的图片</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'weixinQrCode') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'loginLogo') ?></label>
            <div class="col-md-4">
                <?php $this->widget('FileUpload',array('model'=>$model, 'attribute'=>'loginLogo','mode'=>2,'width'=>300)) ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'loginLogo') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'siteNoPic') ?></label>
            <div class="col-md-4">
                <?php $this->widget('FileUpload',array('model'=>$model, 'attribute'=>'siteNoPic','mode'=>2,'width'=>300)) ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'siteNoPic') ?></div>
        </div>
		<div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'waterMark') ?></label>
            <div class="col-md-4">
                <?php $this->widget('FileUpload',array('model'=>$model, 'attribute'=>'waterMark','mode'=>2,'width'=>300)) ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'waterMark') ?></div>
        </div>
		<div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'adviserPageMascot') ?></label>
            <div class="col-md-4">
                <?php $this->widget('FileUpload',array('model'=>$model, 'attribute'=>'adviserPageMascot','mode'=>2,'width'=>300)) ?>
				<span class="help-inline">推荐356x284px尺寸大小、或相同(或相近)长宽比例的图片</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'adviserPageMascot') ?></div>
        </div>
		<div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'wapAdviserPageMascot') ?></label>
            <div class="col-md-4">
                <?php $this->widget('FileUpload',array('model'=>$model, 'attribute'=>'wapAdviserPageMascot','mode'=>2,'width'=>300)) ?>
				<span class="help-inline">推荐207x216px尺寸大小、或相同(或相近)长宽比例的图片</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'wapAdviserPageMascot') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'wapWxShareImg') ?></label>
            <div class="col-md-4">
                <?php $this->widget('FileUpload',array('model'=>$model, 'attribute'=>'wapWxShareImg','mode'=>2,'width'=>300)) ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'wapWxShareImg') ?></div>
        </div>
    </div>

    <!-- 楼盘回拨 -->
    <div role="tabpanel" class="tab-pane fade" id="loupanhuibo">
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'plotCallApiUrl') ?></label>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'plotCallApiUrl', array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'plotCallApiUrl') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'plotCallUserName') ?></label>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'plotCallUserName', array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'plotCallUserName') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'plotCallPwd') ?></label>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'plotCallPwd', array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'plotCallPwd') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'plotCallKey') ?></label>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'plotCallKey', array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'plotCallKey') ?></div>
        </div>

    </div>

	<!-- 论坛应用整合 -->
    <div role="tabpanel" class="tab-pane fade" id="newlogin">
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'enableNewLogin') ?></label>
            <div class="col-md-4">
                <?php echo $form->radioButtonList($model, 'enableNewLogin', array(0=>'否', 1=>'是'), array('class'=>'form-control', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input}{label}</label>'));  ?>            </div>
            <div class="col-md-2"><?php echo $form->error($model,'enableNewLogin') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'newLoginOptions[type]') ?></label>
            <div class="col-md-4">
                <?php echo $form->radioButtonList($model, 'newLoginOptions[type]', array('phpwind'=>'phpwind','ucenter'=>'discuz\ucenter'), array('class'=>'form-control', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input}{label}</label>'));  ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'newLoginOptions[type]') ?></div>
        </div>
		<div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'newLoginOptions[ucServer]') ?></label>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'newLoginOptions[ucServer]', array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'newLoginOptions[ucServer]') ?></div>
        </div>
		<div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'newLoginOptions[key]') ?></label>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'newLoginOptions[key]', array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'newLoginOptions[key]') ?></div>
        </div>
		<div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'newLoginOptions[appId]') ?></label>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'newLoginOptions[appId]', array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'newLoginOptions[appId]') ?></div>
        </div>

    </div>
</div>
</div>

<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" class="btn green">保存</button>
            <?php echo CHtml::link('返回',$this->createUrl('/admin/common/index'),array('class'=>'btn default')) ?>
        </div>
    </div>
</div>
<?php $this->endWidget() ?>

<!-- 导航sample -->
<div class="form-group sqnav" id="sqnav" style="display:none">
    <div class="col-md-2"></div>
    <div class="col-md-2">
        <?php echo $form->textField($model, 'siteSqNav[{k}][name]', array('class'=>'form-control','placeholder'=>'菜单标题')); ?>
    </div>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'siteSqNav[{k}][url]', array('class'=>'form-control','placeholder'=>'菜单链接')); ?>
    </div>
</div>

<!-- QQ sample -->
<div class="form-group qq" id="qq" style="display:none">
    <div class="col-md-2"></div>
    <div class="col-md-10">
        <?php
            echo $form->dropDownList($model,'maiFangQQ[{k}][type]',QqModel::$typeEnum,['class'=>'form-control input-inline qq_type','onchange'=>'showQQ()']);
            echo $form->textField($model,'maiFangQQ[{k}][name]',['class'=>'form-control input-inline','placeholder'=>'QQ昵称或群组名称']);
            echo $form->textField($model,'maiFangQQ[{k}][number]',['class'=>'form-control input-inline','placeholder'=>'QQ号或QQ群号']);
            echo $form->textField($model,'maiFangQQ[{k}][url]',['class'=>'form-control input-inline hide qq_url','placeholder'=>'QQ群链接']);
         ?>
    </div>
</div>


<script type="text/javascript">
<?php Tools::startJs(); ?>
    var sqnum = <?php echo $sqk; ?>;
    //添加社区导航
    $("#add_sqdh").click(function(){
        sqnum++;
        if($(".sqnav").length>4){
            toastr.error("最多添加4个");
            return;
        }
        $(".sqnav").eq(-2).after($("#sqnav").clone().removeAttr("id").show());
        $(".sqnav").eq(-2).find("input").each(function(){
            $(this).attr("name",$(this).attr("name").replace("{k}", sqnum));
            $(this).attr("id",$(this).attr("id").replace("{k}", sqnum));
        });
    });

    var qqnum = <?php echo count($model->maiFangQQ); ?>;
    //添加QQ填项
    $("#add_qq").click(function(){
        qqnum++;
        if(qqnum>4){
            toastr.error("最多添加4个");
            return;
        }
        $(".qq").eq(-2).after($("#qq").clone().removeAttr("id").addClass('qq').show());
        $(".qq").eq(-2).find("input").each(function(){
            $(this).attr("name",$(this).attr("name").replace("{k}",qqnum));
            $(this).attr("id",$(this).attr("id").replace("{k}",qqnum));
        });
        $(".qq").eq(-2).find("select").each(function(){
            $(this).attr("name",$(this).attr("name").replace("{k}",qqnum));
            $(this).attr("id",$(this).attr("id").replace("{k}",qqnum));
        });
    });

    function showQQ()
    {
        $('.qq .qq_type').each(function(){
            $(this).parent().find(":last").removeClass("hide");
            if($(this).val()=="qq"){$(this).parent().find(":last").addClass("hide");}
        });
    }
    showQQ();
	//解决切换tab无法初始化上传anniu
	function initimage(){
		setTimeout(function(){
			$(window).resize();
		},500);
	}
<?php Tools::endJs('js'); ?>
</script>
