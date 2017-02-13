<?php
class IndexController extends HomeController
{
    public function actionIndex()
    {
    	// 首页轮播图片
    	$images = [];
        $this->render('index');
    }
}
