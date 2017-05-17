<?php

/**
 * 百度地区
 * @author SC
 * @date 2015-10-14
 */
class MapController extends HomeController{
    public function actionMap(){
        $lng = $this->cleanXss(Yii::app()->request->getParam('lng',''));
        $lat = $this->cleanXss(Yii::app()->request->getParam('lat',''));
        $ids = $this->cleanXss(Yii::app()->request->getParam('ids',''));

        $arrids = explode (',', $ids);
        $criteria = new CDbCriteria();
        $criteria ->addInCondition('id', $arrids);
        $school = SchoolExt::model()->findAll($criteria);
        $this->renderPartial('map',array('lng'=>$lng,'lat'=>$lat,'school'=>$school));
    }

    public function actionMapSchool(){
        $schoolid = Yii::app()->request->getParam('id','');

        $school = SchoolExt::model()->find('id = :id',array(':id'=>$schoolid));

        $this->renderPartial('mapschool',array('school'=>$school));
    }

    /**
     * 地图找房
     */
    public function actionIndex()
    {
        $this->layout = false;
        $this->render('index');
    }
}
