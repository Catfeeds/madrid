<?php
/**
 * 发布时通用字段
 */
class CommonInfoWidget extends CWidget{

	public $model = [];

	public $place = 'top';

	public function run()
	{
		$typeArr = $ptArr = $tsArr = [];

		$infoType = '';

		$modelName = is_object($this->model) ? get_class($this->model) : 'ResoldEsfExt';

		switch ($this->model->category) {
			case '1':
				$infoType = 'esfzfzztype';
				$infoPt = $modelName=='ResoldEsfExt'?'esfzzpt':'zfzzpt';
				$infoTs = $modelName=='ResoldEsfExt'?'esfzzts':'zfzzts';
				break;
			case '2':
				$infoType = 'esfzfsptype';
				$infoPt = $modelName=='ResoldEsfExt'?'esfsppt':'zfsppt';
				$infoTs = $modelName=='ResoldEsfExt'?'esfspts':'zfspts';
				break;
			case '3':
				$infoType = 'esfzfxzltype';
				$infoPt = $modelName=='ResoldEsfExt'?'esfxzlpt':'zfxzlpt';
				$infoTs = $modelName=='ResoldEsfExt'?'esfxzlts':'zfxzlts';
				break;
		}

		isset($infoType) && $typeArr = TagExt::model()->getTagByCate($infoType)->normal()->findAll();
		if($typeArr) {
			foreach ($typeArr as $key => $value) {
				$tmp[$value->id] = $value->name;
			}
			$typeArr = $tmp;

			unset($tmp);
		}

		isset($infoPt) && $ptArr = TagExt::model()->getTagByCate($infoPt)->normal()->findAll();
		if($ptArr) {
			foreach ($ptArr as $key => $value) {
				$tmp[$value->id] = $value->name;
			}
			$ptArr = $tmp;
			unset($tmp);
		}

		isset($infoTs) && $tsArr = TagExt::model()->getTagByCate($infoTs)->normal()->findAll();
		if($tsArr) {
			foreach ($tsArr as $key => $value) {
				$tmp[$value->id] = $value->name;
			}
			$tsArr = $tmp;
			unset($tmp);
		}

		$itemTypeId = '';
		$itemPtId = $itemTsId = [];
		if($modelName=='ResoldEsfExt') {
			$tags = $this->model->getEsfTag();
			$itemTypeId = isset($tags['type']['id'])?$tags['type']['id']:'';

			$itemPt = isset($tags['pt'])?$tags['pt']:[];
			if($itemPt) 
				foreach ($itemPt as $key => $value) {
					$itemPtId[] = $value['id'];
				}

			$itemTs = isset($tags['ts'])?$tags['ts']:[];
			if($itemTs) 
				foreach ($itemTs as $key => $value) {
					$itemTsId[] = $value['id'];
				}
		} else {
			$itemTypeId = $this->model->$infoType;
			$itemPtId = $this->model->$infoPt;
			$itemTsId = $this->model->$infoTs;
		}

		if($this->place == 'top') {
			$this->render('topInfo',['typeArr'=>$typeArr,'modelName'=>$modelName,'category'=>$this->model->category,'model'=>$this->model,'type'=>$itemTypeId,'infoType'=>$infoType]);
		} elseif($this->place == 'bottom') {
			$this->render('bottomInfo',['typeArr'=>$typeArr,'modelName'=>$modelName,'category'=>$this->model->category,'model'=>$this->model,'ptArr'=>$ptArr,'tsArr'=>$tsArr,'pt'=>$itemPtId,'ts'=>$itemTsId]);
		} elseif($this->place == 'image') {
			$this->render('imageInfo',['modelName'=>$modelName,'model'=>$this->model]);
		}
		
			
	}
}