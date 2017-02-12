<div class="content-box">
    <div class=" top-mark"></div>
    <header class="title-bar">
        <div class="header-logo fl"><img src="<?=ImageTools::fixImage(SM::globalConfig()->wapLogo()); ?>"></div>
        <span class="ml10 mr10 c-white fl fs24">|</span>
        <span class="fl fs24 c-white"> 购房管家</span>
        <?php $this->renderPartial('/layouts/operate', ['search'=>false]); ?>
    </header>
    <div class="gj gj-login gj-login-bg">
    <div class="main">
        <h2>管家登录</h2>
        <form class="form" action="" method="post">
            <p class="ele"><input id="" type="text" name="username" placeholder="用户名"/></p>
            <p class="ele"><input id="" type="password" name="password" placeholder="密码"/></p>
            <p class="subbtn"><input type="submit" value="立即登录" /></p>
        </form>
    </div>
</div>
