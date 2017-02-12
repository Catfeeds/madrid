<?php

/**
 * User: fanqi
 * Date: 2016/8/29
 * Time: 8:38
 * 短信验证码列表控制器
 */
class CodeController extends AdminController
{
    public function actionList($phone = "")
    {
        $criteria = new CDbCriteria(array(
            'order' => 'created desc',
        ));
        if($phone){
            $criteria->addCondition("phone=:phone");
            $criteria->params[':phone'] = $phone;
        }
        $dataProvider = ResoldSmsExt::model()->getList($criteria);
        $this->render('list', array(
            'models' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'phone'=>$phone
        ));
    }
}