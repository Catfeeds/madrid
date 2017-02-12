<?php
class ResoldTariffPackageController extends AdminController
{
    public function actions()
    {
        $alias = 'admin.controllers.resoldTariffPackage.';
        return [
            'packageList' => $alias . 'PackageListAction',//套餐列表页
            'packageEdit' => $alias . 'PackageEditAction',//套餐编辑页 
        ];
    }

    /**
     * [actionAjaxDelQg 删除二手房]
     * @return [type] [description]
     */
    public function actionAjaxDelPackage()
    {
        if (Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getPost('id', 0);
            if (ResoldTariffPackageExt::model()->deleteAllByAttributes(['id'=>$id])) {
                $this->setMessage('删除成功！', 'success');
            } else {
                $this->setMessage('删除失败！', 'error');
            }
        }
    }

    public function actionPackageStatus()
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
                $data = ResoldTariffPackageExt::model()->findAll($criteria);
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
    public function actionAjaxPackageSort()
    {
        $id = (int)Yii::app()->request->getParam('id', 0);
        $sort = (int)Yii::app()->request->getParam('sort', 0);
        $esf = ResoldTariffPackageExt::model()->findByPk($id);
        if ($esf) {
            $esf->sort = $sort;
            if($esf->save())
               $this->setMessage('操作成功!', 'success');
            else
                $this->setMessage('操作失败!', 'error');
        }
    }
}
