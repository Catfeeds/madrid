<?php
 $this->beginContent('/layouts/base');
 $commonHeader = SM::urmConfig()->commonHeader();
 ?>
<body>
<?php if($this->id=='index'): ?>
<div class="wapper">
    <?php $this->widget('AdWidget',['substationId'=>$this->substationId,'position'=>'sydfjl']); ?>
</div>
<?php endif; ?>
<div class="wapper-out top-nav-bg">
    <div class="wapper clearfix overvisible pr bgf6">
        <ul class="fl head_ul">
            <?php if(!empty($commonHeader['link1']['name'])): ?>
            <li><a href="<?php echo $commonHeader['link1']['url']; ?>" target="_blank"><i class="head-icon home">&nbsp;</i><?php echo $commonHeader['link1']['name']; ?></a></li>
            <?php endif; ?>
            <?php if(!empty($commonHeader['link2']['name'])): ?>
            <li><a href="<?php echo $commonHeader['link2']['url']; ?>" target="_blank"><i class="head-icon community">&nbsp;</i><?php echo $commonHeader['link2']['name']; ?></a></li>
            <?php endif; ?>
            <?php if(!empty($commonHeader['link3']['name'])): ?>
            <li><a href="<?php echo $commonHeader['link3']['url']; ?>" target="_blank"><i class="head-icon message">&nbsp;</i><?php echo $commonHeader['link3']['name']; ?></a></li>
            <?php endif; ?>
            <?php if(!empty($commonHeader['link4']['name'])): ?>
            <li><a href="<?php echo $commonHeader['link4']['url']; ?>" target="_blank"><i class="head-icon client">&nbsp;</i><?php echo $commonHeader['link4']['name']; ?></a></li>
            <?php endif; ?>
        </ul>
        <?php if(SM::ucConfig()->enableLogin()): ?>
        <ul class="fr login" id="userlogin">
            <li>
                <?php
                if(SM::ucConfig()->registerUrl()) {
                    $registerUrl = SM::ucConfig()->registerUrl();
                } elseif(isset($commonHeader['zhuce'])&&$commonHeader['zhuce']) {
                    $registerUrl = $commonHeader['zhuce'];
                } else {
                    $registerUrl = Yii::app()->uc->getRegisterPageUrl(Yii::app()->request->getHostInfo().Yii::app()->request->url);
                }
                if(SM::ucConfig()->loginStyle()):
                    $loginUrl = SM::ucConfig()->loginUrl() ? SM::ucConfig()->loginUrl() : Yii::app()->uc->getLoginPageUrl(Yii::app()->request->getHostInfo().Yii::app()->request->url);
                 ?>
                <a href="<?=$loginUrl; ?>" class=""><i class="head-icon user">&nbsp;</i>登录</a>
                <?php else: ?>
                <a href="javascript:;" class="login-trigger"><i class="head-icon user">&nbsp;</i>登录</a>
                <?php endif; ?>
                <em class="vertical">|</em>
                <a href="<?=$registerUrl ?>" target="_blank">注册</a>
                <div class="login-pop-up">
                    <div class="loginframe">
                        <form>
                            <div class="loginframe-blank mb10 clearfix">
                                <input type="text" name="nickname" class="loginframe-label-ipt userName" placeholder="用户名">
                            </div>
                            <div class="loginframe-blank mb10 clearfix">
                                <input type="password" name="pwd" class="loginframe-label-ipt userPwd" placeholder="请输入密码">
                            </div>
                            <div class="msg_box"><span class="login_msg"></span></div>
                            <div class="loginframe-blank">
                                    <span class="loginframe-label clearfix mb10">
                                        <label class="fl">
                                            <input type="checkbox" name="remember" class="loginframe-checkbox fl" checked="checked">
                                            <span class="fl">下次自动登入</span>
                                        </label>
                                        <?php if(isset($commonHeader['forget'])): ?>
                                        <a href="<?php echo $commonHeader['forget']; ?>" class="fr gc3">忘记密码？</a>
                                        <?php endif; ?>
                                    </span>
                                <input type="button" class="loginframe-btn userLogin" data-url="<?php echo $this->createUrl('/api/bbs/login'); ?>" value="登 入">
                            </div>
                        </form>
                    </div>
                </div>
            </li>
            <li class="pr0">
                <?php if(isset($commonHeader['qq']) && !empty($commonHeader['qq'])): ?>
                <a title="QQ"  onclick="window.open('<?php echo $commonHeader['qq']; ?>', 'weiboLogin', 'height=520, width=850, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no');" ><i class="head-icon qq login-label">&nbsp;</i></a>
                <?php endif; ?>
                <?php if(isset($commonHeader['weibo']) && !empty($commonHeader['weibo'])): ?>
                <a title="新浪微博"  onclick="window.open('<?php echo $commonHeader['weibo'];?>', 'weiboLogin', 'height=520, width=850, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no');" ><i class="head-icon sina-weibo login-label">&nbsp;</i></a>
                <?php endif; ?>
            </li>
        </ul>
        <?php endif; ?>
    </div>
</div>
<div class="blank20"></div>
<div class="wapper overvisible">
    <div class="logo-tel fl mt10">
        <a href="/" class="db fl"><img src="<?php echo ImageTools::fixImage(SM::globalConfig()->siteLogo()); ?>"></a>
        <?php
            //分站
            if(SM::globalConfig()->enableSubstation()&&isset($this->substationId)):
        ?>
        <div class="other-web fl">
            <p class="check-now"><?php echo isset($this->substations[$this->substationId]) ? $this->substations[$this->substationId]->name : '主站'; ?><i class="head-icon"></i></p>
            <ul>
                <?php
                    $arr = $this->substations;
                    unset($arr[$this->substationId]);
                    foreach(array_values($arr) as $k=>$v):
                        if($v->area_id!=$this->substationId):
                ?>
                <li <?php if($k==count($arr)-1): ?>class="last"<?php endif; ?>><a href="<?php echo $this->createUrl('/home/index/index', $v->area->pinyin?['fenzhan'=>$v->area->pinyin]:[]); ?>"><?php echo $v->name; ?></a></li>
                <?php endif;endforeach; ?>
            </ul>
        </div>
    <?php else: ?>
        <div class="fl">
            <p class="nub c-red"><i class="head-icon t-phone">&nbsp;</i><?php echo SM::GlobalConfig()->sitePhone() ?></p>
            <p class="bigfs c-ga fs14 mt4">房产消费一站式服务平台</p>
        </div>
    <?php endif; ?>
    </div>
    <div class="fl bigfs search-box mt10">
        <div class="head-search">
            <form action="<?php echo $this->id=='news'?$this->createUrl('/home/news/index'):($this->id=='baike'?$this->createUrl('/home/baike/list'):$this->createUrl('/home/plot/list'));?>" method="get" target="_blank">
                <div class="head-icon fl c-g3" id="search-select">
                    <span id="action-selected" rel="all"><?php echo $this->id=='news' ? '资讯' : ($this->id=='baike' ? '百科' :'新房' )?></span>
                    <ul class="action-select" id="action-select" rel="">
                        <li rel="" lang="" data-url="<?php echo $this->createUrl('/home/plot/list'); ?>">新房</li>
                        <li rel="" lang="information"  data-url="<?php echo $this->createUrl('/home/news/index'); ?>">资讯</li>
                        <?php if(SM::baikeConfig()->enable()):?><li rel="" lang=""  data-url="<?php echo $this->createUrl('/home/baike/list'); ?>">百科</li><?php endif;?>
                    </ul>
                </div>
                <div class="search-about">
                <input type="text" class="fl bigfs" id="searchtxt" name="kw" value="<?php echo CHtml::encode(Yii::app()->request->getQuery('kw','')); ?>" placeholder="请输入搜索关键词" />
                <ul style="display: none;">
                </ul>
                <input type="submit" class="searchbut head-icon" id="searchbut" value="">
                </div>
            </form>
        </div>
        <div class="hot-search">
        <?php foreach(RecomExt::model()->getRecom('pcrstj', 5)->findAll() as $v): ?>
        <a href="<?php echo $v->url; ?>" target="_blank"><?php echo $v->title; ?></a>
        <?php endforeach; ?>
        </div>
    </div>
    <div class="fr head-ad">
        <?php foreach(RecomExt::model()->getRecom('sysskycggw',1)->findAll() as $v): ?>
        <a href="<?php echo $v->url; ?>" target="_blank"><img src="<?php echo ImageTools::fixImage($v->image,200,80); ?>"> </a>
        <?php endforeach;?>
    </div>
</div>
<div class="blank20"></div>
<div class="wapper-out nav-bg ovisible">
    <div class="wapper nav clearfix ovisible">
        <ul class="clearfix">
            <li> <a <?php if($this->id == 'index'):?> class="current"<?php endif;?> href="<?php echo $this->createUrl('/home/index/index')?>">首页</a></li>
            <?php if(SM::specialConfig()->enable() || SM::tuanConfig()->enable()): ?>
            <?php if($this->t('特惠团')=='特惠团'): ?>
            <li><a <?php if($this->id == 'special'):?> class="current"<?php endif;?> href="<?php if(SM::specialConfig()->enable())
                                    {
                                        echo $this->createUrl('/home/special/trade');
                                    }else{
                                        echo $this->createUrl('/home/special/tuan');
                                    } ?>">团购</a></li>
            <?php else: ?>
            <li><a href="<?php echo $this->createUrl('/home/special/tuan'); ?>" <?php if($this->id=='special'): ?>class="current"<?php endif; ?>><?php echo $this->t('特惠团'); ?></a></li>
            <?php endif; ?>
            <?php endif; ?>
            <li><a <?php if($this->id == 'plot'):?> class="current"<?php endif;?> href="<?php echo $this->createUrl('/home/plot/list',SM::globalConfig()->enableSubstation()&&isset($this->substationId)&&$this->substationId?['place'=>$this->substationId]:[])?>" class="pr ">新房</a></li>

            <?php if(SM::adviserConfig()->enable() && SM::adviserConfig()->showAdviserPage()): ?>
            <li><a <?php if($this->id == 'adviser'):?> class="current"<?php endif;?> href="<?php echo $this->createUrl('/home/adviser/index')?>" class="pr ">预约看房</a></li>
            <?php endif; ?>

            <?php if(SM::kanConfig()->enable()): ?>
            <li><a <?php if($this->id == 'tuan'):?> class="current"<?php endif;?> href="<?php echo $this->createUrl('/home/tuan/index')?>" class="pr ">看房团</a></li>
            <?php endif; ?>

            <?php if(SM::schoolConfig()->enable()): ?>
            <li><a <?php if($this->id == 'school'):?> class="current"<?php endif;?> href="<?php echo $this->createUrl('/home/school/index')?>">邻校房</a></li>
            <?php endif; ?>

            <?php if(SM::baikeConfig()->enable()): ?>
            <li class="pr raiders">
                    <a href="<?=$this->createUrl('/home/baike/index'); ?>" class="<?=($this->id == 'baike'||$this->id == 'wenda')?'current':''?> cbox">买房攻略</a>
                    <ol class="lis">
                        <li><a href="<?=$this->createUrl('/home/baike/index')?>">买房宝典</a></li>
                        <li><a href="<?=$this->createUrl('/home/wenda/index')?>">问答</a></li>
                    </ol>
            </li>
            <?php else: ?>
                <li><a <?php if($this->id == 'wenda'):?> class="current"<?php endif;?> href="<?=$this->createUrl('/home/wenda/index')?>">问答</a></li>
            <?php endif; ?>

            <li><a <?php if($this->id == 'news'):?> class="current"<?php endif;?> href="<?php echo $this->createUrl('/home/news/index')?>">资讯</a></li>

            <?php if(SM::pageUrlConfig()->esfListUrl()): ?>
            <li><a href="<?php echo SM::pageUrlConfig()->esfListUrl(); ?>" target="_blank" >二手房</a></li>
            <?php endif; ?>

            <?php if(SM::pageUrlConfig()->zfListUrl()): ?>
            <li><a href="<?php echo SM::pageUrlConfig()->zfListUrl(); ?>" target="_blank" >租房</a></li>
            <?php endif; ?>
            <li><a class="sep">&nbsp;</a></li>
            <?php
                $siteNav = SM::pageUrlConfig()->pcNav();
                foreach(array_slice($siteNav['name'],0,SM::adviserConfig()->enable()?4:4) as $k=>$v):
             ?>
            <li><a href="<?php echo $siteNav['url'][$k]; ?>" target="_blank"><?php echo $siteNav['name'][$k]; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<?php
    if(isset($this->breadcrumbs))
        $this->widget('HomeBreadcrumbs',array('links'=>$this->breadcrumbs));
?>
    <?php echo $content ?>
<?php $this->endContent(); ?>
