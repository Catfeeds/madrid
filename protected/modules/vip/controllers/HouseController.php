<?php
/**
 * 酒庄控制器
 * @author steven.allen <[<email address>]>
 * @date(2017.2.7)
 */
class HouseController extends VipController{

	public $cates = [];

	public $levels = [];

	public function init()
	{
		parent::init();
		$this->cates = CHtml::listData(TagExt::model()->getTagByCate('jzdq')->normal()->findAll(),'id','name');
		$this->levels = CHtml::listData(TagExt::model()->getTagByCate('jzdj')->normal()->findAll(),'id','name');
	}

	public function actionList($type='title',$value='',$time_type='created',$time='',$cate='')
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
			$criteria->addCondition('place=:cid');
			$criteria->params[':cid'] = $cate;
		}
		$news = HouseExt::model()->getList($criteria,20);
		
		$this->render('list',[
			'cates'=>$this->cates,
			'news'=>$news->data,
			'pager'=>$news->pagination,
			'type' => $type,
            'value' => $value,
            'time' => $time,
            'time_type' => $time_type,
            'cate'=>$cate]);
	}

	public function actionEdit($id = 0)
	{
		$info = $id ? HouseExt::model()->findByPk($id) : new HouseExt;
		if(Yii::app()->request->getIsPostRequest()) {
			$info->attributes = Yii::app()->request->getPost('HouseExt',[]);

			if($info->save()) {
				$this->setMessage('操作成功','success',['list']);
			} else {
				$this->setMessage(array_values($info->errors)[0][0],'error');
			}
		} 
		$this->render('edit',['article'=>$info,'cates'=>$this->cates,'levels'=>$this->levels]);
	}

	public function actionAjaxSort($id=0,$sort=0)
	{
		if($id) {
			$model = HouseExt::model()->findByPk($id);
			$model->sort = $sort;
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
			if(HouseExt::model()->deleteByPk($id)) {
				$this->setMessage('操作成功！','success');
				echo json_encode(['success'=>'1']);
			} else {
				echo json_encode(['success'=>'0']);
			}
		}
	}
}