<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="keywords" content="西班牙红酒，里奥哈酒庄，进口顶级红酒">
<meta name="description" content="西班牙进口红酒">
<meta name="author" content="YY-MO">
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />
<link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl?>/static/vip/pc/css/lib.css">
<link rel="stylesheet" type="text/css"  href="<?=Yii::app()->theme->baseUrl?>/static/vip/pc/css/style.css">
<link rel="stylesheet" type="text/css"  href="<?=Yii::app()->theme->baseUrl?>/static/vip/pc/css/376.css">
<script type="text/javascript" src="<?=Yii::app()->theme->baseUrl?>/static/vip/pc/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="<?=Yii::app()->theme->baseUrl?>/static/vip/pc/js/org1480746227.js" data-main="indexMain"></script>
<title>马德里公馆</title>
</head>
    <body>
        <div id="header" class="index_nav">
          <div class="content"><a href="" id="logo"><img src="<?=ImageTools::fixImage(SiteExt::getAttr('qjpz','pcLogo'),40,20)?>" height="40" /></a>
            <ul id="nav">
                    <li class="navitem"><a class="nav-a  active " href="<?=$this->createUrl('/home/index/index')?>" target="_self"><span  data-title="首页">首页</span></a></li>
                    <li class="navitem"><a class="nav-a " href="<?=$this->createUrl('index')?>project/" target="_self"><span data-title="酒款">酒款</span></a></li>
                    <li class="navitem"><a class="nav-a " href="<?=$this->createUrl('index')?>project/" target="_self"><span data-title="酒庄">酒庄</span></a></li>
                    <li class="navitem"><a class="nav-a " href="<?=$this->createUrl('index')?>project/" target="_self"><span data-title="资讯">资讯</span></a></li>
                    <!-- <li class="navitem"><a class="nav-a " href="javascript:;" target=""><span data-title="关于">关于</span><i class="fa fa-angle-down"></i></a>        <ul class="subnav">
                            <li><a href="" target="_self"><span data-title="关于">关于</span><i class="fa fa-angle-right"></i></a></li>
                            <li><a href="" target="_self"><span data-title="团队">团队</span><i class="fa fa-angle-right"></i></a></li>
                            <li><a href="" target="_self"><span data-title="新闻">新闻</span><i class="fa fa-angle-right"></i></a></li>
                          </ul>
                </li> -->
                    <li class="navitem"><a class="nav-a " href="<?=$this->createUrl('index')?>page/5739/" target="_self"><span data-title="图册">图册</span></a></li>
                    <li class="navitem"><a class="nav-a " href="<?=$this->createUrl('index')?>service/" target="_self"><span data-title="服务">服务</span></a></li>
                    <li class="navitem"><a class="nav-a " href="<?=$this->createUrl('index')?>page/5740/" target="_self"><span data-title="联系">联系</span></a></li>
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