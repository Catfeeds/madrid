<?php
/**
 * 特价房
 * @author sc
 * @date 2015-09-15
 */
class PlotSpecialController extends AdminController
{
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
     * 特价房列表
     */
    public function actionList($type='', $value='') {

        Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
        $criteria = new CDbCriteria();
        if($type=='title')
            $criteria->addSearchCondition('title', $value);
        if($type=='plotTitle' && $value!=''){
            $plotCriteria = new CDbCriteria();
            $plotCriteria->addSearchCondition('title', $value);
            $plothid = PlotExt::model()->find($plotCriteria);
            if(!empty($plothid->id)){
                $criteria->addCondition('hid=:hid');
                $criteria->params[':hid'] =$plothid->id;
            }
        }
        $criteria->order='sort desc , created desc';
        $dataProvider = PlotSpecialExt::model()->getList($criteria);
        if (Yii::app()->request->isPostRequest && !empty($_POST['id'])) {
            if (PlotSpecialExt::changeStatus())
                $this->setMessage('修改成功！', 'success');
            else
                $this->setMessage('修改失败！', 'error');
            Yii::app()->end();
        }
        $this->render('list', array(
            'data' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
        ));
    }

    /**
     * 添加、编辑特价房
     * default
     */
    public function actionEdit()
    {
        $id = Yii::app()->request->getParam('id', 0);
        $special = PlotSpecialExt::getSpecial($id);
        $htidParent = PlotHouseType::model()->findAll(array('select'=>'id,title','condition'=>'hid=:hid','params'=>array(':hid'=>$special->hid)));
        $htid = array();
        foreach($htidParent as $v){
            $htid[$v->id]=$v->title;
        }
        if (Yii::app()->request->getIsPostRequest()) {
            $params = Yii::app()->request->getPost('PlotSpecialExt');
            $params['end_time'] = strtotime($params['end_time']);
            if ($id > 0) {
                $params['id'] = $id;
                $tip = '修改';
            } else {
                $params['created'] = time();
                $tip = '添加';
            }
            $special->attributes = $params;
            if ($special->save()) {
                $msg = $tip . '成功!';
                $this->setMessage($msg, 'success', array('list'));
            } else {
                $msg = $special->hasErrors() ? current(current($special->getErrors())) : '保存失败！';
                $this->setMessage($msg, 'danger');
            }

        }
        $this->render('edit', array('special' => $special,'htid'=>$htid));
    }


    /**
     * 删除特价房
     */
    public function actionDel() {
        $id = Yii::app()->request->getParam('id', 0);
        if ($id) {
            $count = PlotSpecialExt::model()->deleteByPk($id);
            if ($count > 0) {
                Yii::app()->user->setFlash('success', '删除成功！');
                Yii::app()->end();
            }
        }
        Yii::app()->user->setFlash('danger', '删除失败！');
        Yii::app()->end();
    }


    /**
     * 特价房的推荐和开启状态
     */
    public function actionAjaxStatusRecom(){
        if(Yii::app()->request->isAjaxRequest){
            $id = Yii::app()->request->getPost('id',0);
            $recom = Yii::app()->request->getPost('recom',0);
            $model = PlotSpecialExt::model()->findByPk($id);
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
                $data = PlotSpecialExt::model()->findAll($criteria);
                foreach($data as $v)
                {
                    $v->changeState($status);
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
                $data = PlotSpecialExt::model()->findAll($criteria);
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
}
?>
