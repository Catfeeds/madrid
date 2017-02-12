<?php

class BlackController extends AdminController
{
    //黑名单列表
    public function actionList($phone = "")
    {
        $criteria = new CDbCriteria(array(
            'order' => 'created desc',
        ));
        if ($phone) {
            $criteria->addCondition("phone=:phone");
            $criteria->params[':phone'] = $phone;
        }
        $dataProvider = ResoldBlackExt::model()->getList($criteria,40);
        $this->render('list', array(
            'models' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'phone' => $phone
        ));
    }  

    //新增黑名单
    public function actionEdit()
    {
        if (Yii::app()->request->isPostRequest) {
            $phones = Yii::app()->request->getPost('phones', '');
            if(strpos($phones,','))
                $phones = explode(',', $phones);
            elseif(strpos($phones,'，'))
                $phones = explode('，', $phones);
            else
                $phones = [$phones];
            if (is_array($phones) && ($phones = array_filter($phones))) {
                $phones = array_unique($phones);
                $success_flag = 0;
                foreach ($phones as $phone) {
                    $black = new ResoldBlackExt();
                    $black->phone = trim($phone);
                    if ($black->save()) {
                        $success_flag++;
                    }
                }
                $this->setMessage("成功添加{$success_flag}条");
                $this->redirect('list');
            }
        }
        $this->render('edit');
    }

    //删除黑名单(有单选和多选两种)
    public function actionAjaxDel()
    {
        if (Yii::app()->request->isPostRequest) {
            $ids = Yii::app()->request->getPost('ids');
            if ($ids && is_array($ids = explode(",", $ids)) && $ids = array_filter($ids)) {
                $success_flag = 0;
                foreach ($ids as $id) {
                    $black = ResoldBlackExt::model()->findByPk($id);
                    if ($black->delete()) {
                        $success_flag++;
                    }
                }
                $this->setMessage("成功删除{$success_flag}条");
            } elseif ($id = Yii::app()->request->getPost('id')) {
                $black = ResoldBlackExt::model()->findByPk($id);
                if ($black->delete()) {
                    $this->setMessage("删除成功");
                }
            }
        }
    }
}
