<?php
/**
 * wap首页类 
 */
class IndexController extends WapController{
    public function actionIndex()
    {
        $this->render('index');
    }

}