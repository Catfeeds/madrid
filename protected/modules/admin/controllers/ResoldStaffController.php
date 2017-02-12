<?php
class ResoldStaffController extends AdminController
{
    public function actions()
    {
        $alias = 'admin.controllers.resoldStaff.';
        return [
            'resoldStaffList' => $alias . 'ResoldStaffListAction',//商家列表页
            'resoldStaffEdit' => $alias . 'ResoldStaffEditAction',//商家编辑页 
        ];
    }

    /**
     * [actionAjaxDelQg 删除职员]
     * 解除商家、关闭套餐、去除中介电话库号码
     * @return [type] [description]
     */
    public function actionAjaxDelStaff()
    {
        if (Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getPost('id', 0);
            $esf = ResoldStaffExt::model()->findByPk($id);
            $esf->deleted = 1;
            $esf->sid = 0;

            if ($esf->save()) {
                ResoldStaffPackageExt::model()->deleteAllByAttributes(['staff'=>$id]);
                ResoldStaffPhoneExt::model()->deleteAllByAttributes(['phone'=>$esf->phone]);
                $this->setMessage('删除成功！', 'success');
            } else {
                $this->setMessage('删除失败！', 'error');
            }
        }
    }

    public function actionStaffStatus()
    {
        if (Yii::app()->request->isPostRequest) 
        {
            $ids = Yii::app()->request->getPost('ids', false);
            $kw = Yii::app()->request->getPost('kw', false);
        }
        else
        {
            $ids = Yii::app()->request->getQuery('ids', false);
            $kw = Yii::app()->request->getQuery('kw', false);
        }
        if ($ids!==false && $kw!==false) {
            $ids = explode(',', $ids);
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $ids);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $data = ResoldStaffExt::model()->findAll($criteria);
                foreach ($data as $v) {
                    switch ($kw) {
                        case 'open':
                            $v->status = 1;
                            break;
                        case 'close':
                            $v->status = 2;
                            break;
                        case 'check':
                            $v->status = 0;
                            break;
                    }
                    $v->save();
                }
                $transaction->commit();
                $this->setMessage('操作成功', 'success');
                Yii::app()->end();
            } catch (Exception $e) {
                $transaction->rollback();
            }
        }
        $this->setMessage('操作失败!', 'error');

    }

    /**
     * ajax修改排序
     */
    public function actionAjaxStaffSort()
    {
        $id = (int)Yii::app()->request->getParam('id', 0);
        $sort = (int)Yii::app()->request->getParam('sort', 0);
        $esf = ResoldStaffExt::model()->findByPk($id);
        if ($esf) {
            $esf->sort = $sort;
            if($esf->save())
               $this->setMessage('操作成功!', 'success');
            else
                $this->setMessage('操作失败!', 'error');
        }
    }

    /**
     * [actionCheckUid uid检查]
     * @param  [type] $account [description]
     * @return [type]      [description]
     */
    public function actionCheckUid($account)
    {
        $account = urldecode($account);
        $result = Yii::app()->uc->getUser($account,1);

        if(Yii::app()->uc->hasError())
            echo CJSON::encode(['success'=>'0']);
        else
            echo CJSON::encode(['success'=>'1','uid'=>array_keys($result)]);
    }

    /**
     * [actionCheckStaff 是否已有商家检查]
     * @param  [type] $account [description]
     * @return [type]      [description]
     */
    public function actionCheckStaff($account)
    {
        $staff = ResoldStaffExt::model()->enabled()->find(['condition'=>'account=:account and sid>0','params'=>[':account'=>$account]]);

        if(!$staff)
            echo CJSON::encode(['success'=>'0']);
        else
            echo CJSON::encode(['success'=>'1','name'=>$staff->shop->name]);
    }

    /**
     * [actionPackageEdit 职员套餐编辑]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function actionPackageEdit($id)
    {
        if(Yii::app()->request->getIsPostRequest())
        {
            $model = Yii::app()->request->getPost('ResoldStaffExt',[]);
            $staff = ResoldStaffExt::model()->findByPk($model['id']);
            $staff->attributes = $model;
            if($staff->save())
            {
                //保存关联套餐
                $staff->savePackage();
                $this->setMessage('保存成功','success');
            }
            else
            {
                $this->setMessage('保存失败','error');
            }

        }
        $staff = ResoldStaffExt::model()->findByPk($id);
        $this->layout = '/layouts/modal_base';
        $this->render('packageEdit',['staff'=>$staff]);
    }
}
