<?php

/**
 * User: fanqi
 * Date: 2016/9/18
 * Time: 12:34
 */

/**
 * Class PriceTrendController
 * 二手房价格趋势
 */
class ResoldPriceTrendController extends AdminController
{
    /**
     * 二手房价格趋势列表
     */
    public function actionList($time="")
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
        $criteria = new CDbCriteria(array(
            'order' => 'time desc',
        ));
        if($time!=""){
            $daterangepicker = new DaterangepickerForm();
            $daterangepicker->setTime($time);
            if ($daterangepicker->check()) {
                $criteria->addCondition("time>=:beginTime");
                $criteria->addCondition("time<:endTime");
                $beginTime = TimeTools::getMonthBeginTime($daterangepicker->beginTime);
                $criteria->params[':beginTime'] = $beginTime;
                $endTime = TimeTools::getMonthEndTime($daterangepicker->endTime);
                $criteria->params[':endTime'] = $endTime;

            }
        }
        $area = AreaExt::model()->parent()->normal()->findAll(array(
            'index' => 'id',
        ));
        $data = ResoldPricetrendExt::model()->getList($criteria, 15);
        $this->render('list', array(
            'area' => $area,
            'data' => $data->data,
            'pager' => $data->pagination,
            'time' =>$time
        ));
    }

    /**
     * @param int $id
     * 二手房价格趋势新增/编辑
     */
    public function actionEdit($id = 0)
    {
        $model = $id ? ResoldPricetrendExt::model()->findByPk($id) : new ResoldPricetrendExt;
        if (Yii::app()->request->getIsPostRequest()) {
            $model->attributes = Yii::app()->request->getPost('ResoldPricetrendExt');
            if ($model->save()) {
                $this->setMessage('保存成功！', 'success', array('list'));
            } else {
                $this->setMessage($model->hasErrors() ? current(current($model->getErrors())) : '保存失败！', 'error');
            }
        }
        $area = AreaExt::model()->parent()->normal()->findAll();
        $this->render('edit', array('model' => $model, 'area' => $area));
    }

    /**
     * @param int $id
     * 删除二手房价格走势
     */
    public function actionDel()
    {
        $id = Yii::app()->request->getParam('id', 0);
        if ($id) {
            $count = ResoldPricetrendExt::model()->deleteByPk($id);
            if ($count > 0) {
                $this->setMessage('删除成功！', 'success');
                Yii::app()->end();
            }
        }
        $this->setMessage('删除失败！', 'error');
        Yii::app()->end();
    }
}