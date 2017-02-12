<?php if(strpos(Yii::app()->request->getUserAgent(),'MicroMessenger')===false && !$this->getIsInQianFan()): ?>
    <?php if($this->id=='index'&&$this->action->id=='index'):?>
        <header class="title-bar">
            <div class="header-logo"><a href="<?php echo $this->createUrl('/wap/index/index'); ?>" class=" "><img src="<?php echo ImageTools::fixImage(SM::globalConfig()->wapLogo()); ?>"></a></div>
            <?php $this->renderPartial('/layouts/operate'); ?>
        </header>
    <?php else:?>
        <header class="title-bar <?php if(isset($bc)&&$bc) echo 'title-bar-hasbg'?>">
            <?php $this->widget('BackButton'); ?>
            <h1><?php echo isset($title) ? $title : '' ?></h1>
            <?php $this->renderPartial('/layouts/operate',['search'=>isset($search)&&$search ? $search : false]); ?>
        </header>
    <?php endif;?>
<?php else :?>
    <?php if($this->id=='index'&&$this->action->id=='index'):?>
        <header class="title-bar">
            <div class="header-logo"><a href="<?php echo $this->createUrl('/wap/index/index'); ?>" class=" "><img src="<?php echo ImageTools::fixImage(SM::globalConfig()->wapLogo()); ?>"></a></div>
        </header>
    <?php endif;?>
    <div class="right-side-menu">
        <a href="<?php echo $this->createUrl('/wap/index/nav'); ?>" class="icon-menus"></a>
        <?php if(isset($search)&&$search) :?>
            <a href="<?php echo $this->createUrl('/wap/plot/search'); ?>" class="icon-searchs"></a>
        <?php endif;?>
    </div>
    <div class="left-side-menu">
        <?php $this->widget('BackButton',['isIcon'=>true]); ?>
    </div>
<?php endif; ?>
