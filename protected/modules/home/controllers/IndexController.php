<?php
class IndexController extends HomeController
{
    public function actionIndex()
    {
    	// 首页轮播图片
    	$site = SiteExt::model()->getSiteByCate('qjpz')->find();
    	$images = $site->pcIndexImages;
    	$this->layout = '/layouts/base';
    	// var_dump(SiteExt::getAttr('qjpz','qq'));exit;
        $this->render('index',['images'=>$images]);
    }
}
