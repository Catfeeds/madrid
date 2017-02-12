<header class="title-bar title-bar-hasbg">
    <?php $this->widget('BackButton', ['backUrl'=>$this->backUrl]); ?>
    <h1><?=$this->pageTitle; ?></h1>
    <div class="operate">
        <a href="<?=$this->createUrl('/wap/staff/logout'); ?>" class="quit"><i class="icon-exit"></i></a>
    </div>
</header>
