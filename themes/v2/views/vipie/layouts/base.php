<!DOCTYPE html>
<!-- HTML5 Boilerplate -->
<!--[if lt IE 7]><html class="no-js ie6 lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!-->
<html class="html5" lang="zh-CN">
<!--<![endif]-->
<head>
  <meta charset="UTF-8">
  <title><?php echo $this->pageTitle ?>-房产中介工作台</title>
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl?>/static/vipie/style/reset.css" media="all" />
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl?>/static/vipie/style/main.css" media="all" />
  <script type="text/javascript" src="<?=Yii::app()->theme->baseUrl?>/static/vipie/js/respond.min.js"></script>
    <!--[if IE 6]>
    <script src="<?=Yii::app()->theme->baseUrl?>/static/vipie/js/DD_belatedPNG.js"></script>
    <script>
    DD_belatedPNG.fix('*');
    </script>
    <![endif]-->
</head>
<body>
    <div class="g-sd">
        <div class="side-bar">
            <div class="title-box">
                <div class="username"><?php if(isset(Yii::app()->user->uid) && Yii::app()->user->uid) {
                                        $user = ResoldStaffExt::model()->findStaffByUid(Yii::app()->user->uid);
                                        echo '欢迎'.Yii::app()->user->name.(isset($user->is_manager)&&$user->is_manager?'[店长]':'');
                                    }else {
                                        echo '欢迎！';
                                    }
                            ?></div>
                <div class="product-name"><?php echo SM::globalConfig()->siteName() ?> &bull; 房产中介工作台</div>
            </div>
            <div class="nav">
                <?php $this->widget('vipie.widgets.IeMenu'); ?>
            </div>
            <div class="relate-us">
                <p>有事您找我<br/>客服电话：83022322</p>
                <!--简易文字链接列表-->
                <ul class="m-list">
                    <li><a href="#"><span class="icon-qq">客服1</span></a></li>
                    <li><a href="#"><span class="icon-qq">客服2</span></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="g-mn">
        <div class="quick-menu">
            <div class="m-hd m-hd-bg">
                <div class="more"><a href="#"><?=Yii::app()->user->name.(isset($user->is_manager)&&$user->is_manager?'[店长]':'')?></a></div>
                <ul>
                    <li class="z-crt on"><a href="#">查看商铺</a></li>
                    <li><a href="#">修改密码</a></li>
                    <li class="last"><a href="#">Logout</a></li>
                </ul>
            </div>
        </div>
        <?php echo $content ?>
    </div>
    <script type="text/template" id="modselect-tpl">
        <span class="u-btns">
            <span class="u-btn u-btn-c4 select-name">{{now.name}}</span>
            <span type="button" class="u-btn u-btn-c4 select-arrow"><span class="btnsel"></span></span>
            <ul class="u-menu u-menu-min">
                {{each datalist as v k}}
                    <li><a href="#" data-value="{{v.value}}">{{v.name}}</a></li>
                {{/each}}
            </ul>
        </span>
    </script>
    <script type="text/template" id="my-ui-dialog-tpl">
        <div class="my-ui-dialog">
            <div class="my-ui-dialog-title">{{title}}</div>
            <div class="my-ui-dialog-btns">
                <a href="javascript:void(0)" class="ok">确定</a><a href="javascript:void(0)" class="cancel">取消</a>
            </div>
            <a href="javascript:void(0)" class="my-ui-dialog-close"></a>
        </div>
    </script>
    <script type="text/javascript">
        var basedir = '<?=Yii::app()->theme->baseUrl?>/static/vipie/js/';
        var qn_domain = '<?=rtrim(ltrim(Yii::app()->file->host,'http://'),'\/')?>';
        var qn_url = '<?=Yii::app()->theme->baseUrl?>/static/vipie/js/qiniuapi.php';
        var plot_url = '<?=$this->createUrl('/vipie/common/ajaxGetPlot')?>';
        var plot_info_url = '<?=$this->createUrl('/vipie/common/ajaxGetPlotInfo')?>';

    </script>
    <script type="text/javascript" src="<?=Yii::app()->theme->baseUrl?>/static/vipie/js/do.js"></script>
    <script type="text/javascript" src="<?=Yii::app()->theme->baseUrl?>/static/vipie/js/main.js"></script>
    <script type="text/javascript" src="<?=Yii::app()->theme->baseUrl?>/static/vipie/js/vipie-publish.js"></script>
</body>
</html>
