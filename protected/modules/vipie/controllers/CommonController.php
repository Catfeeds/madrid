<?php 
/**
 * ie中介后台
 * @author steven.allen <[<email address>]>
 * @date(2017.1.16)
 */
class CommonController extends VipieController{
	public function actionIndex()
	{
		# code...
	}

	public function actionAjaxGetPlot($term='')
	{
		$criteria = new CDbCriteria(array('limit'=>20,'order'=>'sort desc , views desc'));
		if (!$term) {
			$criteria->limit = 15;
		}
		if (preg_match("/^[a-zA-Z\s]+$/", $term)) {
			$criteria->addSearchCondition('pinyin', $term);
		} else {
			$criteria->addSearchCondition('title', $term);
		}

		$data = array();
		$house = PlotExt::model()->normal()->findAll($criteria);
		if($house){
			foreach ($house as $v) {
				$data[] = array('value'=>$v->id, 'label'=>$v->title);
			}
		}
		echo CJSON::encode($data);
	}

	public function actionAjaxGetPlotInfo($hid,$infoId='',$modelName='')
	{
		$modelImages = [];
		if($infoId && $modelName) {
			$model = $modelName::model()->findByPk($infoId);
			if ($model)
				if ($modelImages = $model->images) {
					foreach ($modelImages as $key => $value) {
						$tmp[] = $value->url;
					}
					$modelImages = $tmp;
					unset($tmp);
				}
		}
		$plot = PlotExt::model()->findByPk($hid);
		if($images = PlotImgExt::model()->findAll(array('condition'=>'hid=:hid','params'=>[':hid'=>$hid],'order'=>'sort desc','limit'=>30))) {
			foreach ($images as $key => $value) {
				$tmp[] = ['key'=>$value->url,'pic'=>ImageTools::fixImage($value->url),'status'=>in_array($value->url, $modelImages)?true:false];
			}
			$images = $tmp;
		}
		
		$data = [
			'address'=>$plot?$plot->address:'',
			'images'=>$images,
		];
		echo json_encode($data);
	}
}