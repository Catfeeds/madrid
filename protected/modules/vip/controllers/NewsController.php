<?php
/**
 * 文章控制器
 * @author steven.allen <[<email address>]>
 * @date(2017.2.5)
 */
class NewsController extends VipController{

	public $cates = [];

	public function init()
	{
		parent::init();
		$this->cates = CHtml::listData(TagExt::model()->getTagByCate('wzlm')->normal()->findAll(),'id','name');
	}

	public function actionList($type='title',$value='',$time_type='created',$time='',$cate='')
	{
		$criteria = new CDbCriteria;
		$criteria->order = 'sort desc,updated desc';
		if($value = trim($value))
            if ($type=='title') {
                $criteria->addSearchCondition('title', $value);
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
		$news = ArticleExt::model()->getList($criteria,20);
		
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
		$info = $id ? ArticleExt::model()->findByPk($id) : new ArticleExt;
		if(Yii::app()->request->getIsPostRequest()) {
			$info->attributes = Yii::app()->request->getPost('ArticleExt',[]);

			if($info->save()) {
				$this->setMessage('操作成功','success',['list']);
			} else {
				$this->setMessage(array_values($info->errors)[0][0],'error');
			}
		} 
		$this->render('edit',['article'=>$info,'cates'=>$this->cates]);
	}

	public function actionAjaxSort($id=0,$sort=0)
	{
		if($id) {
			$model = ArticleExt::model()->findByPk($id);
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
			$model = ArticleExt::model()->findByPk($id);
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
			$model = ArticleExt::model()->findByPk($id);
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