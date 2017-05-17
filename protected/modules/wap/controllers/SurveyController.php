<?php 
class SurveyController extends WapController{
	public function actionIndex()
	{
		if($_GET && array_filter($_GET)) {
			$get = $_GET;
			$get['created'] = time();
			if(Yii::app()->db->createCommand("insert into survey(area,place,msg,created) values('".$get['area']."','".$get['place']."','".$get['msg']."','".$get['created']."')")->execute()) {
				// echo "提交成功！感谢您的建议！";
				// sleep(3);
				$this->redirect('/wap/survey','');
			}
		}
		$areaList = ['园区'=>'园区','平江区'=>'平江区'];
		$placeList = ['久光'=>'久光','圆融'=>'圆融'];
		$this->render('index',['areaList'=>$areaList,'placeList'=>$placeList]);
	}
}