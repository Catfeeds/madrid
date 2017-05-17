<?php
/**
 * wap首页类 
 */
class IndexController extends WapController{
    public function actionIndex()
    {
    	$this->banner = '';
    	if(Yii::app()->request->getIsPostRequest()) {
    		$guest = new GuestExt;
    		$data['name'] = Yii::app()->request->getPost('name','');
    		$data['mail'] = Yii::app()->request->getPost('email','');
    		$data['phone'] = Yii::app()->request->getPost('tel','');
    		$data['msg'] = Yii::app()->request->getPost('content','');
    		$guest->attributes = $data;
    		if($guest->save()) {
    			$this->redirect('index');
    		}
    	} 
    	// 首页轮播图片
    	$site = SiteExt::model()->getSiteByCate('qjpz')->find();
    	$images = $site->pcIndexImages;
    	$this->layout = '/layouts/base';
    	// 红酒类型
    	$cates = CHtml::listData(TagExt::model()->getTagByCate('hjlx')->normal()->findAll(),'id','name');
    	// 八款红酒
    	$wines = ProductExt::model()->normal()->findAll(['limit'=>8]);
    	// 四个新闻
    	$news = ArticleExt::model()->getNormal()->sorted()->normal()->findAll(['limit'=>4]);
    	// 三个团队
    	$teams = ArticleExt::model()->getTeam()->normal()->findAll(['limit'=>3]);
        // 三个服务
        $serves = ArticleExt::model()->getServe()->normal()->findAll();
        // 八个酒庄
        $houses = HouseExt::model()->sorted()->findAll(['limit'=>3]);
    	// var_dump(SiteExt::getAttr('qjpz','qq'));exit;
        $this->render('index',['images'=>$images,'cates'=>$cates,'wines'=>$wines,'news'=>$news,'teams'=>$teams,'serves'=>$serves,'houses'=>$houses]);
    }

}