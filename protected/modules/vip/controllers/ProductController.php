<?php
/**
 * 产品控制器
 * @author steven.allen <[<email address>]>
 * @date(2017.2.12)
 */
class ProductController extends VipController{
	// 红酒类型
	public $cates = [];
	// 红酒系列
	public $xls = [];
	// 葡萄品种
	public $ptpzs = [];
	// 葡萄品种
	public $areas = [];

	public function init()
	{
		parent::init();
		foreach (['cates'=>'hjlx','xls'=>'hjxl','ptpzs'=>'ptpz','areas'=>'hjdq'] as $key => $value) {
			$this->$key = CHtml::listData(TagExt::model()->getTagByCate($value)->normal()->findAll(),'id','name');
		}
	}

	public function actionList($type='title',$value='',$time_type='created',$time='',$cate='',$xl='',$ptpz='',$house='')
	{
		$criteria = new CDbCriteria;
		$criteria->order = 'sort desc,updated desc';
		if($value = trim($value))
            if ($type=='title') {
                $criteria->addSearchCondition('name', $value);
            } 
        //添加时间、刷新时间筛选
        if($time_type!='' && $time!='')
        {
            list($beginTime, $endTime) = explode('-', $time);
            $beginTime = (int)strtotime(trim($beginTime));
            $endTime = (int)strtotime(trim($endTime));
            $criteria->addCondition("{$time_type}>=:beginTime");
            $criteria->addCondition("{$time_type}<:endTime");
            $criteria->params[':beginTime'] = TimeTools::getDayBeginTime($beginTime);
            $criteria->params[':endTime'] = TimeTools::getDayEndTime($endTime);

        }
		if($cate) {
			$criteria->addCondition('cid=:cid');
			$criteria->params[':cid'] = $cate;
		}
		if($xl) {
			$criteria->addCondition('xl=:xl');
			$criteria->params[':xl'] = $xl;
		}
		if($ptpz) {
			$criteria->addCondition('ptpz=:ptpz');
			$criteria->params[':ptpz'] = $ptpz;
		}
		if($house) {
			$criteria->addCondition('house=:house');
			$criteria->params[':house'] = $house;
		}
		$news = ProductExt::model()->undeleted()->getList($criteria,20);
		$houses = [];
		if($prs = $news->data) 
			foreach ($prs as $key => $v) {
				$v->houseInfo && $houses[$v->house] = $v->houseInfo->name;
			}
		
		$this->render('list',[
			'cates'=>$this->cates,
			'xls'=>$this->xls,
			'ptpzs'=>$this->ptpzs,
			'houses'=>$houses,
			'list'=>$prs,
			'pager'=>$news->pagination,
			'type' => $type,
            'value' => $value,
            'time' => $time,
            'time_type' => $time_type,
            'cate'=>$cate,
			'xl'=>$xl,
			'ptpz'=>$ptpz,
			'house'=>$house,]);
	}

	public function actionEdit($id = 0)
	{
		$info = $id ? ProductExt::model()->findByPk($id) : new ProductExt;
		if(Yii::app()->request->getIsPostRequest()) {
			$info->attributes = Yii::app()->request->getPost('ProductExt',[]);

			if($info->save()) {
				if($images = Yii::app()->request->getPost('images',[])) {
					AlbumExt::model()->deleteAllByAttributes(['pid'=>$info->id]);
					$images = array_combine($images, Yii::app()->request->getPost('image_des',[]));
					foreach ($images as $key => $value) {
						$image = new AlbumExt;
						$image->pid = $info->id;
						$image->url = $key;
						$image->name = $value;
						$image->save();
					}
				} else {
					AlbumExt::model()->deleteAllByAttributes(['pid'=>$info->id]);
				}
				$this->setMessage('操作成功','success',['list']);
			} else {
				$this->setMessage(array_values($info->errors)[0][0],'error');
			}
		} 
		$this->render('edit',['article'=>$info,'cates'=>$this->cates,'xls'=>$this->xls,'ptpzs'=>$this->ptpzs,'houses'=>CHtml::listData(HouseExt::model()->sorted()->findAll(),'id','name'),'areas'=>$this->areas]);
	}

	public function actionAjaxSort($id=0,$sort=0)
	{
		if($id) {
			$model = ProductExt::model()->findByPk($id);
			$model->sort = $sort;
			if($model->save()) {
				$this->setMessage('操作成功！','success');
				echo json_encode(['success'=>'1']);
			} else {
				echo json_encode(['success'=>'0']);
			}
		}
	}

	public function actionAjaxChangeStatus($id=0)
	{
		if($id) {
			$model = ProductExt::model()->findByPk($id);
			$model->status = $model->status==1?0:1;
			if($model->save()) {
				$this->setMessage('操作成功！','success');
				echo json_encode(['success'=>'1']);
			} else {
				echo json_encode(['success'=>'0']);
			}
		}
	}

	public function actionAjaxDel($id=0)
	{
		if($id) {
			$model = ProductExt::model()->findByPk($id);
			$model->deleted = 1;
			if($model->save()) {
				$this->setMessage('操作成功！','success');
				echo json_encode(['success'=>'1']);
			} else {
				echo json_encode(['success'=>'0']);
			}
		}
	}

}