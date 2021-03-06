<?php
class IndexController extends HomeController
{
    public function actionIndex()
    {
        $this->banner = '';
    	if(Yii::app()->request->getIsPostRequest()) {
            // var_dump(1);exit;
    		$guest = new GuestExt;
    		$data['name'] = Yii::app()->request->getPost('name','');
    		$data['mail'] = Yii::app()->request->getPost('email','');
    		$data['phone'] = Yii::app()->request->getPost('tel','');
    		$data['msg'] = Yii::app()->request->getPost('content','');
    		$guest->attributes = $data;
    		if($guest->save()) {
    			$this->redirect('/');
                Yii::app()->end();
    		}
    	} 
    	// 首页轮播图片
    	$site = SiteExt::model()->getSiteByCate('qjpz')->find();
    	$images = $site->pcIndexImages;
    	$this->layout = '/layouts/base';
    	// 红酒类型
    	$cates = CHtml::listData(TagExt::model()->getTagByCate('hjdq')->normal()->findAll(),'id','name');
    	// 八款红酒
    	$wines = ProductExt::model()->normal()->findAll(['limit'=>10]);
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
