<?php
/**
 * 特价房
 */
class SpecialController extends WapController
{
    public function actions()
    {
        $this->layout = '/layouts/body';
        $alias = 'wap.controllers.special.';
        return array(
            'index' => $alias.'ListAction',
            'detail' => $alias.'DetailAction',
            'change' => $alias.'ChangeAction',
        );
    }

    /**
     * 特价房加载更多API
     */
    public function actionAddMore($hid){
        $criteria = new CDbCriteria(array(
            'condition' => 'hid=:hid',
            'params'=>array(':hid'=>$hid)
        ));
        $pager = new CPagination(PlotSpecialExt::model()->normal()->count($criteria));
        $pager->pageSize = 3;
        $pager->pageVar = 'p';
        $pager->applyLimit($criteria);
        $data = PlotSpecialExt::model()->normal()->findAll($criteria);
        if(Yii::app()->request->getQuery($pager->pageVar,0)>$pager->pageCount)
            $data = array();
        $this->renderPartial('addmore',array(
            'data'=>$data,
        ));
    }
}
