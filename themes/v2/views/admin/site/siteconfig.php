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
    <!-- <li role="presentation"><a href="#waihu" aria-controls="settings" role="tab" data-toggle="tab">外呼配置</a></li> -->
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
            <label class="col-md-2 control-label"><?php echo $form->label($model,'sensitiveWord')?></label>
            <div class="col-md-6">
                <?php
                echo $form->textField($model,'sensitiveWord',array('class'=>'form-control'));?><span class="help-inline">资讯敏感词，请用逗号分隔</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'sensitiveWord')?></div>
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
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'jikeMode') ?></label>
			<div class="col-md-6 radio-list">
				<?php echo $form->radioButtonList($model, 'jikeMode', array(0=>'常规模式',1=>'平均分单模式'),array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?><span class="help-inline">常规模式：编辑人工分单给买房顾问，回访、复盘等由编辑处理；<br>平均分单模式：系统自动分单给买房顾问，由买房顾问直接处理。</span>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'jikeMode') ?></div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'jikeAssignLimit') ?></label>
			<div class="col-md-6 radio-list">
				<?php echo $form->textField($model, 'jikeAssignLimit', array('class'=>'form-control')); ?><span class="help-inline">系统自动平均分单模式下，每个买房顾问每天最多被分配到用户的限额</span>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'jikeAssignLimit') ?></div>
		</div>
        <!-- <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'resoldExtraSaleNum') ?></label>
            <div class="col-md-6">
                <?php
                echo $form->textField($model, 'resoldExtraSaleNum', array('class'=>'form-control')); ?><span class="help-inline">二手房/租房中介没有购买套餐或套餐到期后额外的上架条数</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'resoldExtraSaleNum') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'resoldRefreshInterval') ?></label>
            <div class="col-md-6">
                <?php
                echo $form->textField($model, 'resoldRefreshInterval', array('class'=>'form-control')); ?><span class="help-inline">单位为分钟</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'resoldRefreshInterval') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'resoldHurryTime') ?></label>
            <div class="col-md-6">
                <?php
                echo $form->textField($model, 'resoldHurryTime', array('class'=>'form-control')); ?><span class="help-inline">单位为小时</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'resoldHurryTime') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'resoldAdminUid') ?></label>
            <div class="col-md-6">
                <?php
                echo $form->textField($model, 'resoldAdminUid', array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'resoldAdminUid') ?></div>
        </div> -->
		<div class="col-md-12">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<div class="alert alert-warning alert-dismissable">
		            为了解决站点在迁移到新平台后，对之前旧平台在搜索引擎收入网址的问题，我们对楼盘相关页面以及资讯详情页等重要页面提供转向功能，网友在通过旧路由地址可以被跳转到新的地址。在以下输入框按要求填写旧平台相关页面网址的规则后，基本能解决该类问题（不能解决的可能是因为旧平台中的路由规则在新平台中已经被占用了）。
		        </div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'diyRules[plot]') ?></label>
			<div class="col-md-6 radio-list">
				<?php echo $form->textField($model, 'diyRules[plot]', array('class'=>'form-control')); ?><span class="help-inline">路由规则不要以“/”开始，规则中出现的楼盘id请使用占位符{id}代替，如果规则中使用拼音则以占位符{pinyin}代替，规则示例："househome/{id}"，而不是"/househome/{id}"</span>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'diyRules[plot]') ?></div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'diyRules[plotDetail]') ?></label>
			<div class="col-md-6 radio-list">
				<?php echo $form->textField($model, 'diyRules[plotDetail]', array('class'=>'form-control')); ?><span class="help-inline">路由规则不要以“/”开始，规则中出现的楼盘id请使用占位符{id}代替，如果规则中使用拼音则以占位符{pinyin}代替，规则示例："househome/{id}"，而不是"/househome/{id}"</span>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'diyRules[plotDetail]') ?></div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'diyRules[plotEvaluate]') ?></label>
			<div class="col-md-6 radio-list">
				<?php echo $form->textField($model, 'diyRules[plotEvaluate]', array('class'=>'form-control')); ?><span class="help-inline">路由规则不要以“/”开始，规则中出现的楼盘id请使用占位符{id}代替，如果规则中使用拼音则以占位符{pinyin}代替，规则示例："househome/{id}"，而不是"/househome/{id}"</span>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'diyRules[plotEvaluate]') ?></div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'diyRules[plotHouseType]') ?></label>
			<div class="col-md-6 radio-list">
				<?php echo $form->textField($model, 'diyRules[plotHouseType]', array('class'=>'form-control')); ?><span class="help-inline">路由规则不要以“/”开始，规则中出现的楼盘id请使用占位符{id}代替，如果规则中使用拼音则以占位符{pinyin}代替，规则示例："househome/{id}"，而不是"/househome/{id}"</span>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'diyRules[plotHouseType]') ?></div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'diyRules[plotAlbum]') ?></label>
			<div class="col-md-6 radio-list">
				<?php echo $form->textField($model, 'diyRules[plotAlbum]', array('class'=>'form-control')); ?><span class="help-inline">路由规则不要以“/”开始，规则中出现的楼盘id请使用占位符{id}代替，如果规则中使用拼音则以占位符{pinyin}代替，规则示例："househome/{id}"，而不是"/househome/{id}"</span>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'diyRules[plotAlbum]') ?></div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'diyRules[plotAround]') ?></label>
			<div class="col-md-6 radio-list">
				<?php echo $form->textField($model, 'diyRules[plotAround]', array('class'=>'form-control')); ?><span class="help-inline">路由规则不要以“/”开始，规则中出现的楼盘id请使用占位符{id}代替，如果规则中使用拼音则以占位符{pinyin}代替，规则示例："househome/{id}"，而不是"/househome/{id}"</span>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'diyRules[plotAround]') ?></div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'diyRules[plotPrice]') ?></label>
			<div class="col-md-6 radio-list">
				<?php echo $form->textField($model, 'diyRules[plotPrice]', array('class'=>'form-control')); ?><span class="help-inline">路由规则不要以“/”开始，规则中出现的楼盘id请使用占位符{id}代替，如果规则中使用拼音则以占位符{pinyin}代替，规则示例："househome/{id}"，而不是"/househome/{id}"</span>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'diyRules[plotPrice]') ?></div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'diyRules[plotNews]') ?></label>
			<div class="col-md-6 radio-list">
				<?php echo $form->textField($model, 'diyRules[plotNews]', array('class'=>'form-control')); ?><span class="help-inline">路由规则不要以“/”开始，规则中出现的楼盘id请使用占位符{id}代替，如果规则中使用拼音则以占位符{pinyin}代替，规则示例："househome/{id}"，而不是"/househome/{id}"</span>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'diyRules[plotNews]') ?></div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'diyRules[plotAsk]') ?></label>
			<div class="col-md-6 radio-list">
				<?php echo $form->textField($model, 'diyRules[plotAsk]', array('class'=>'form-control')); ?><span class="help-inline">路由规则不要以“/”开始，规则中出现的楼盘id请使用占位符{id}代替，如果规则中使用拼音则以占位符{pinyin}代替，规则示例："househome/{id}"，而不是"/househome/{id}"</span>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'diyRules[plotAsk]') ?></div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'diyRules[plotComment]') ?></label>
			<div class="col-md-6 radio-list">
				<?php echo $form->textField($model, 'diyRules[plotComment]', array('class'=>'form-control')); ?><span class="help-inline">路由规则不要以“/”开始，规则中出现的楼盘id请使用占位符{id}代替，如果规则中使用拼音则以占位符{pinyin}代替，规则示例："househome/{id}"，而不是"/househome/{id}"</span>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'diyRules[plotComment]') ?></div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo $form->label($model,'diyRules[article]') ?></label>
			<div class="col-md-6 radio-list">
				<?php echo $form->textField($model, 'diyRules[article]', array('class'=>'form-control')); ?><span class="help-inline">路由规则不要以“/”开始，规则中出现资讯id请使用占位符{id}代替，规则示例："news/{id}"，而不是"/news/{id}"</span>
			</div>
			<div class="col-md-2"><?php echo $form->error($model,'diyRules[article]') ?></div>
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
            <label class="col-md-2 control-label"><?php echo $form->label($model, 'adType') ?></label>
            <div class="col-md-4">
                <?php echo $form->radioButtonList($model, 'adType', array(1 =>'百度广告', 2 =>'URM广告'), array('class'=>'form-control', 'separator'=>''));?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model, 'adType') ?></div>
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
            <label class="col-md-2 control-label"><?php echo $form->label($model,'enableKan') ?></label>
            <div class="col-md-6 radio-list">
                <?php echo $form->radioButtonList($model, 'enableKan', array(0=>'关闭',1=>'启用'),array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?><span class="help-inline">关闭后所有看房团入口将被隐藏</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'enableKan') ?></div>
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
		<div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'enableBaike') ?></label>
            <div class="col-md-6 radio-list">
                <?php echo $form->radioButtonList($model, 'enableBaike', array(0=>'关闭',1=>'启用'),array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?><span class="help-inline">是否显示前台的买房宝典页面入口</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'enableBaike') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'enableMfgw') ?></label>
            <div class="col-md-6 radio-list">
                <?php echo $form->radioButtonList($model, 'enableMfgw', array(0=>'关闭',1=>'启用'),array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?><span class="help-inline">如果站点没有配备买房顾问或者不是买房顾问带看房的运营模式，可以在这里关闭相关内容的显示</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'enableMfgw') ?></div>
        </div>
		<div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'smsEnable') ?></label>
            <div class="col-md-6 radio-list">
                <?php echo $form->radioButtonList($model, 'smsEnable', array(0=>'关闭',1=>'启用'),array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?><span class="help-inline"></span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'smsEnable') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'enableRankingList') ?></label>
            <div class="col-md-6 radio-list">
                <?php echo $form->radioButtonList($model, 'enableRankingList', array(0=>'关闭',1=>'启用'),array('class'=>'form-control','separator'=>'','template'=>'<label>{input} {label}</label>')); ?><span class="help-inline">关闭首页不显示房产排行榜</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'enableRankingList') ?></div>
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
				<span class="help-inline">推荐640x400px尺寸大小、或相同(或相近)长宽比例的图片</span>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'wapAdviserPageMascot') ?></div>
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
            <label class="col-md-2 control-label"><?php echo $form->label($model,'loginStyle') ?></label>
            <div class="col-md-4">
                <?php echo $form->radioButtonList($model, 'loginStyle', array(0=>'浮窗形式', 1=>'跳转形式'), array('class'=>'form-control', 'separator'=>'&nbsp;&nbsp;','template'=>'<label>{input}{label}</label>'));  ?>            </div>
            <div class="col-md-2"><?php echo $form->error($model,'loginStyle') ?></div>
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

    <!-- 外呼配置 -->
    <!-- <div role="tabpanel" class="tab-pane fade" id="waihu">
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'waihuId') ?></label>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'waihuId', array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'waihuId') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'waihuPBX') ?></label>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'waihuPBX', array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'waihuPBX') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'waihuIP') ?></label>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'waihuIP', array('class'=>'form-control')); ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model,'waihuIP') ?></div>
        </div>
    </div> -->
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
