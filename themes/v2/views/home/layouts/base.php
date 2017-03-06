<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title><?php echo $this->pageTitle; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="keywords" content="<?php echo $this->keyword; ?>"/>
<meta name="description" content="<?php echo $this->description; ?>"/>
<meta name="author" content="YY-MO">
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />
<meta name="baidu-site-verification" content="2nn5PXRAlF" />
<link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl?>/static/vip/pc/css/lib.css">
<link rel="stylesheet" type="text/css"  href="<?=Yii::app()->theme->baseUrl?>/static/vip/pc/css/style.css">
<link rel="stylesheet" type="text/css"  href="<?=Yii::app()->theme->baseUrl?>/static/vip/pc/css/376.css">
<script type="text/javascript" src="<?=Yii::app()->theme->baseUrl?>/static/vip/pc/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="<?=Yii::app()->theme->baseUrl?>/static/vip/pc/js/org1480746227.js" data-main="<?=$this->banner?'baseMain':'indexMain'?>"></script>
</head>
    <body class="<?=$this->banner?>">
        <div id="header" class="<?=$this->banner?'':'index_nav'?>">
          <div class="content"><a href="" id="logo"><img src="<?=ImageTools::fixImage(SiteExt::getAttr('qjpz','pcLogo'))?>" height="40" /></a>
            <ul id="nav">
            <?php $path = trim(Yii::app()->request->getPathInfo(),'/');?>
                    <li class="navitem"><a class="nav-a <?=$path=='home/index/index'?'active':''?>" href="<?=$this->createUrl('/home/index/index')?>" target="_self"><span  data-title="首页">首页</span></a></li>
                    <li class="navitem"><a class="nav-a <?=$path=='home/product/list'||$path=='home/product/info'?'active':''?>" href="<?=$this->createUrl('/home/product/list')?>" target="_self"><span data-title="酒款">酒款</span></a></li>
                    <li class="navitem"><a class="nav-a <?=$path=='home/house/list'||$path=='home/house/info'?'active':''?>" href="<?=$this->createUrl('/home/house/list')?>" target="_self"><span data-title="酒庄">酒庄</span></a></li>
                    <li class="navitem"><a class="nav-a <?=$path=='home/news/list'||$path=='home/news/info'?'active':''?>" href="<?=$this->createUrl('/home/news/list')?>" target="_self"><span data-title="资讯">资讯</span></a></li>
                    
                    <!-- <li class="navitem"><a class="nav-a <?=$path=='home/index/index'?'active':''?>" href="<?=$this->createUrl('index')?>" target="_self"><span data-title="图册">图册</span></a></li> -->
                    <li class="navitem"><a class="nav-a <?=$path=='home/serve/list'||$path=='home/serve/info'?'active':''?>" href="<?=$this->createUrl('/home/serve/list')?>" target="_self"><span data-title="服务">服务</span></a></li>
                    <li class="navitem"><a class="nav-a <?=$path=='home/team/list'||$path=='home/team/info'||$path=='home/contact/index'?'active':''?>" href="javascript:;" target=""><span data-title="关于">关于</span><i class="fa fa-angle-down"></i></a>        
                        <ul class="subnav">
                            <li><a href="<?=$this->createUrl('/home/team/list')?>" target="_self"><span data-title="团队">团队</span><i class="fa fa-angle-right"></i></a></li>
                            <li><a href="<?=$this->createUrl('/home/contact/index')?>" target="_self"><span data-title="联系">联系</span><i class="fa fa-angle-right"></i></a></li>
                      </ul>
                    </li>
                  </ul>
            <div class="clear"></div>
          </div>
          <a id="headSHBtn" href="javascript:;"><i class="fa fa-bars"></i></a>
        </div>
        <?=$content?>
        <div id="footer">
          <p>COPYRIGHT (©) 2017  常州马德里公馆. <a class="beian" href="http://www.miitbeian.gov.cn/" style="display:inline; width:auto; color:#8e8e8e" target="_blank"></a></p>
        </div>
        <div id="shares">
          <a id="sshare"><i class="fa fa-share-alt"></i></a><a href="http://service.weibo.com/share/share.php?appkey=3206975293&" target="_blank" id="sweibo"><i class="fa fa-weibo"></i></a><a href="javascript:;" id="sweixin1" onclick="showQr()"><i class="fa fa-weixin"></i></a><a href="javascript:;" id="gotop"><i class="fa fa-angle-up"></i></a>
        </div>
        <div class="fixed" id="fixed_weixin" url='<?=ImageTools::fixImage(SiteExt::getAttr('qjpz','wxQr'),220,220)?>'>
            <div class="fixed-container">
                <div id="qrcode" url='<?=ImageTools::fixImage(SiteExt::getAttr('qjpz','wxQr'),220,220)?>'>
                </div>
                <p>扫描二维码关注微信</p>
            </div>
        </div>
        <div id="online_open">
            <i class="fa fa-comments-o"></i>
        </div>
        <div id="online_lx">
            <div id="olx_head">
                在线咨询<i class="fa fa-times fr" id="online_close"></i>
            </div>
            <ul id="olx_qq"><li><a href="tencent://message/?uin=<?=SiteExt::getAttr('qjpz','qq')?>&Site=uelike&Menu=yes"><i class="fa fa-qq"></i><?=SiteExt::getAttr('qjpz','qq')?></a></li>
            </ul>
            <div id="olx_tel">
                <div><i class="fa fa-phone"></i>联系电话</div><p><?=SiteExt::getAttr('qjpz','sitePhone')?><br /></p>
            </div>
        </div>
        <div class="hide">
                        <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1261416854'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/z_stat.php%3Fid%3D1261416854' type='text/javascript'%3E%3C/script%3E"));</script>
        </div>
        <script>
            function showQr() {
                $('#qrcode').empty();
                $('#fixed_weixin').attr('class','fixed show');
                $('#qrcode').append('<img src="<?=ImageTools::fixImage(SiteExt::getAttr('qjpz','wxQr'),220,220)?>">');
            }
        </script>
    </body> 
</html>