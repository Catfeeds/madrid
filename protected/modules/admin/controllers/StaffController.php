<?php
/**
 * 管家相关
 * @author weibaqiu
 * @date 2015-09-21
 */
class StaffController extends AdminController
{
    public function actions()
    {
        $alias = 'admin.controllers.staff.';
        return array(
            'commentList' => $alias.'CommentListAction',
            'commentEdit' => $alias.'CommentEditAction',
            'commentAjax' => $alias.'CommentAjaxAction',
        );
    }

    /**
     * 管家列表页
     */
    public function actionList($username='', $status='')
    {
        $criteria = new CDbCriteria();
        if($username!='')
        {
            $criteria->addCondition('username=:username');
            $criteria->params[':username'] = $username;
        }
        if($status!='')
        {
            $criteria->addCondition('status=:status');
            $criteria->params[':status'] = $status;
        }
        $dataProvider = StaffExt::model()->noDeleted()->getList($criteria);
        $this->render('list', array(
            'data' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'username' => $username,
            'status' => $status,
        ));
    }

    /**
     * 添加\编辑买房顾问信息页
     * @param  integer $id 管家id
     */
    public function actionEdit($id=0)
    {
        $staff = StaffExt::model()->findByPk($id);
        if($staff===null) $staff = new StaffExt;

        if(Yii::app()->request->isPostRequest)
        {
            $staff->attributes = Yii::app()->request->getPost('StaffExt', array());
            if($staff->save())
                $this->setMessage('保存成功！', 'success', array('/admin/staff/list'));
            else
                $this->setMessage('保存失败！', 'error');
        }
        $this->render('edit', array(
            'staff' => $staff,
        ));
    }

    /**
     * ajax修改买房顾问状态
     */
    public function actionAjaxStatus()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $id = Yii::app()->request->getPost('id', 0);
            $model = StaffExt::model()->findByPk($id);
            if($model && $model->changeStatus())
                $this->setMessage('修改成功！', 'success');
            else
                $this->response(false, '修改失败！');
        }
    }

    /**
     * ajax进行推荐
     */
    public function actionAjaxRecommend()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $id = Yii::app()->request->getPost('id', 0);
            $model = StaffExt::model()->findByPk($id);
            if($model && $model->triggerRecommend()){
                $this->setMessage('操作成功！', 'success');
                $this->response(true, '操作成功！');
            }
            else
                $this->response(false, '操作失败！');
        }
    }

    /**
     * [actionAjaxChangeIsWork 更改状态]
     */
    public function actionAjaxChangeIsWork()
    {
        if(Yii::app()->request->isPostRequest)
        {
            $sid = Yii::app()->request->getPost('id', 0);
            $staff = StaffExt::model()->findByPk($sid);
            if($staff && $staff->triggerIsWork()->save()){
                $this->setMessage('修改成功','success');
            } else {
                $this->setMessage('提交失败','error');
            }
        }
    }
}
?>
