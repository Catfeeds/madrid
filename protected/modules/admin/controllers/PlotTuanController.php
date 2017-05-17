<?php

/**
 * 特惠团
 */
class PlotTuanController extends AdminController {
    /**
	 * 权限控制
	 */
	public function RBACRules()
	{
		return array(
            // array('allow',
            //     'action' => array(),
            // ),
			array('allow',
				'roles' => array('guanlineirong'),
			),
			array('deny',
				'users'=>array('*')
			)
		);
	}

    /**
     * 特惠团列表
     */
    public function actionList($type='',$value='') {
        Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
        $criteria = new CDbCriteria();
        if($type=='title')
            $criteria->addSearchCondition('title', $value);
        if($type=='id' && $value!=''){
            $criteria->addCondition('id=:id');
            $criteria->params[':id'] = $value;
        }
        $criteria->order ='created desc';
        $dataProvider = PlotTuanExt::model()->getList($criteria);
        if (Yii::app()->request->isPostRequest && !empty($_POST['id'])) {
            if (PlotTuanExt::changeStatus())
                Yii::app()->user->setFlash('success', '修改成功！');
            else
                Yii::app()->user->setFlash('error', '修改失败！');
            Yii::app()->end();
        }
        $this->render('list', array(
            'data' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
        ));
    }

    /**
     * 特惠团的推荐和开启状态
     */
    public function actionAjaxStatusRecom(){
        if(Yii::app()->request->isAjaxRequest){
            $id = Yii::app()->request->getPost('id',0);
            $recom = Yii::app()->request->getPost('recom',0);
            $model = PlotTuanExt::model()->findByPk($id);
            if($recom){
                if($model && $model->changeStatusRecom($recom))
                    $this->setMessage('保存成功！','sucess');
                else
                    $this->response (false, '修改失败！');
            }else{
                if($model && $model->changeStatusRecom())
                    $this->setMessage('保存成功！','sucess');
                else
                    $this->response (false, '修改失败！');
                }
            }
        }

    /**
     * 删除特惠团
     */
    public function actionDel() {
        $id = Yii::app()->request->getParam('id', 0);
        if ($id) {
            $count = PlotTuanExt::model()->deleteByPk($id);
            if ($count > 0) {
                Yii::app()->user->setFlash('success', '删除成功！');
                Yii::app()->end();
            }
        }
        Yii::app()->user->setFlash('danger', '删除失败！');
        Yii::app()->end();
    }

    /**
     * 添加/编辑特惠团
     */
    public function actionEdit($id = 0) {

        $tuan = PlotTuanExt::getTuan($id);
        if (Yii::app()->request->getIsPostRequest()) {
            $params = Yii::app()->request->getPost('PlotTuanExt');
            $params['end_time'] = strtotime($params['end_time']);
            $referrer = Yii::app()->request->getParam('referrer');
            $tip = $id > 0 ? '修改' : '添加';
            $tuan->attributes = $params;
            if ($tuan->save()) {
                $msg = $tip . '成功!';
                $this->setMessage($msg, 'success', true);
                if ($referrer)
                    $this->redirect($referrer);
                else
                    $this->redirect(array('plottuan/list'));
            } else {
                $msg = $tip . '失败!';
                $this->setMessage($msg, 'error',true);
            }
        }
        $this->render('edit', array('tuan' => $tuan));
    }

    /**
     * 修改推荐状态
     */
    public function actionAjaxRecomStatus()
    {
        $ids = Yii::app()->request->getPost('ids', false);
        $status = Yii::app()->request->getPost('status', false);
        if($ids!==false && $status!==false)
        {
            $ids = explode(',', $ids);
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id',$ids);
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $data = PlotTuanExt::model()->findAll($criteria);
                foreach($data as $v)
                {
                    $v->changeStatus($status);
                }
                $transaction->commit();
                $this->setMessage('操作成功','success');
                Yii::app()->end();
            }
            catch(Exception $e)
            {
                $transaction->rollback();
            }
        }
        $this->setMessage('操作失败!','error');
    }

    /**
     * 删除推荐
     */
    public function actionAjaxDelRecom()
    {
        $ids = Yii::app()->request->getPost('ids', false);
        if($ids!==false)
        {
            $ids = explode(',', $ids);
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id',$ids);
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $data = PlotTuanExt::model()->findAll($criteria);
                foreach($data as $v)
                {
                    $v->delete();
                }
                $transaction->commit();
                $this->setMessage('操作成功','success');
                Yii::app()->end();
            }
            catch(Exception $e)
            {
                $transaction->rollback();
            }
        }
        $this->setMessage('操作失败!','error');
    }

    /**
     * ajax修改特惠团排序
     */
    public function actionAjaxPlotTuanSort()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $id = (int)Yii::app()->request->getParam('id', 0);
            $sort = (int)Yii::app()->request->getParam('sort', 0);
            $plot = PlotTuanExt::model()->findByPk($id);
            if ($plot && $plot->sort($sort)) {
                echo CJSON::encode(array('num'=>1, 'sort'=>$sort));
            }
        }
    }
}
