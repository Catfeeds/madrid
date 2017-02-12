<?php
$this->beginContent('/layouts/base');
Yii::app()->clientScript->registerCssFile($this->staticPath.'/js/jquery-ui-1.12.1.custom/jquery-ui.css');
Yii::app()->clientScript->registerCssFile($this->staticPath.'/style/my.css');
?>
    <div class="wapper-out search-wrap clearfix">
        <form method="get" action="<?php echo $this->createUrl('/resoldhome/esf/list')?>">
            <div class="search-box clearfix">
                <div class="search-input fl">
                    <input name="kw" data-template="esf-search-list" data-url="<?php echo $this->createUrl('/api/resoldwapapi/plotsearchajax');?>" class="input" placeholder="请输入二手房名称" autocomplete="off">
                </div>
                <input type="submit" class="btn fl" value="搜索">
                <div class="search-list-box"></div>
                <?php $this->widget('CommonWidget'); ?>
            </div>
        </form>
    </div>
<?php $this->widget('HomeBreadcrumbs',array('links'=>array('个人中心'=>$this->createUrl('/resoldhome/my/index'),$this->pageTitle)));?>
<div class="my">
    <div class="my-nav">
        <div class="m-title">个人中心首页</div>
        <div class="my-sub-nav">
            <div class="sub-title">二手房管理</div>
            <ul class="sub-items">
                <li>
                    <a class="<?php if($this->getRoute() == 'resoldhome/myesf/sellinput' || $this->getRoute() == 'resoldhome/myesf/selledit'){echo 'on';} ?>" href="<?php echo $this->createUrl('/resoldhome/myesf/sellinput'); ?>">发布出售房源</a>
                </li>
                <li>
                    <a class="<?php if($this->getRoute() == 'resoldhome/myesf/sellindex' || $this->getRoute() == 'resoldhome/myesf/buyindex'){echo 'on';} ?>" href="<?php echo $this->createUrl('/resoldhome/myesf/sellindex'); ?>">管理出售房源</a>
                </li>
                <li>
                    <a class="<?php if($this->getRoute() == 'resoldhome/myesf/buyinput' || $this->getRoute() == 'resoldhome/myesf/buyedit'){echo 'on';} ?>" href="<?php echo $this->createUrl('/resoldhome/myesf/buyinput')?>">我要求购</a>
                </li>
            </ul>
        </div>
        <div class="line"></div>
        <div class="my-sub-nav">
            <div class="sub-title">租房管理</div>
            <ul class="sub-items">
                <li>
                    <a class="<?php if($this->getRoute() == 'resoldhome/myzf/rentinput'  || $this->getRoute() == 'resoldhome/myzf/rentedit'){echo 'on';} ?>" href="<?php echo $this->createUrl('/resoldhome/myzf/rentinput')?>">发布出租房源</a>
                </li>
                <li>
                    <a class="<?php if($this->getRoute() == 'resoldhome/myzf/rentindex' || $this->getRoute() == 'resoldhome/myzf/forrentindex'){echo 'on';} ?>" href="<?php echo $this->createUrl('/resoldhome/myzf/rentindex')?>">管理出租房源</a>
                </li>
                <li>
                    <a class="<?php if($this->getRoute() == 'resoldhome/myzf/forrentinput' || $this->getRoute() == 'resoldhome/myzf/forrentedit' ){echo 'on';} ?>" href="<?php echo $this->createUrl('/resoldhome/myzf/forrentinput')?>">我要求租</a>
                </li>
            </ul>
        </div>
        <div class="line"></div>
        <div class="my-sub-nav close my-fav-nav">
            <div class="sub-title">
                <a class="<?php if($this->getRoute() == 'resoldhome/mycollect/index'){ echo 'on'; }?>" href="<?php echo $this->createUrl('/resoldhome/mycollect/index');?>">
                    我的收藏
                </a>
            </div>
        </div>
        <div class="line"></div>
        <div class="my-sub-nav">
            <div class="sub-title">账户管理</div>
            <ul class="sub-items">
                <li>
                    <a class="<?php if($this->getRoute() == 'resoldhome/my/profile'){ echo 'on'; }?>" href="<?php echo $this->createUrl('/resoldhome/my/profile');?>">个人资料</a>
                </li>
                <li>
                    <a href="<?php  echo Yii::app()->uc->getUpdatePwdPageUrl($this->currentUrl);?>">修改密码</a>
                </li>
                <li>
                    <a href="<?php  echo Yii::app()->uc->getUpdatePhonePageUrl($this->currentUrl);?>">绑定手机</a>
                </li>
            </ul>
        </div>
        <div class="line"></div>
        <div class="my-sub-nav close my-fav-nav">
            <div class="sub-title">
                <a href="<?php echo SM::resoldConfig()->resoldHelpUrl()?SM::resoldConfig()->resoldHelpUrl() : $this->createUrl('/resoldhome/help/index'); ?>">帮助中心</a>
            </div>
        </div>
    </div>
    <div class="my-content">
        <?php echo $content ; ?>
    </div>
    <div class="clear"></div>
</div>
<div class="dialog dn">
    <div class="pop-content j-ok-dialog">
        <i class="icon-oks"></i>
        <p class="text">恭喜您！信息提交成功</p>
        <p class="shenghe">该信息已成功发布，您的信息需要审核才能展示，请在个人中心关注信息状态</p>
        <div class="btn-box clearfix">
            <a class="info-url">查看信息</a>
            <a class="list-url">管理信息</a>
            <a class="input-url">再发一条</a>
            <a href="javascript:;" class="closed">关闭窗口</a>
        </div>
    </div>
</div>
<script type="text/html" id="esf-search-list">
    <ul>
        {{each data as value}}
        <li>
            <a href="/resoldhome/esf/list?kw={{value.name}}">
                <span>{{value.name}}</span>
                <span class="right">约{{value.saling_esf_num}}条房源</span>
            </a>
        </li>
        {{/each}}
    </ul>
</script>
<?php $this->endContent(); ?>
