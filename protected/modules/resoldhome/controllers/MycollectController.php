<?php
/**
 * 我的收藏
 * User: jt
 * Date: 2016/11/11 8:47
 */
class MycollectController extends UcenterController{

    public function actionIndex($house_type=2){
        $with = isset(ResoldUserCollectionExt::$house_type_relations[$house_type]) ? ResoldUserCollectionExt::$house_type_relations[$house_type] : null;
        if(!$with){
            $with = ResoldUserCollectionExt::$house_type_relations[ResoldUserCollectionExt::HOUSE_TYPE_XF];
        }
        $criteria = new CDbCriteria(array(
            'condition'=>'t.uid=:uid',
            'params'=>array(':uid'=>$this->uid),
            'order'=>'t.created desc',
            'with'=>array($with),
        ));
        $dataProvider = ResoldUserCollectionExt::model()->getList($criteria,$this->pageSize);
        $this->render('index',array('dataProvider'=>$dataProvider,'with'=>$with));
    }

    public function actionDelete($id){
        if(Yii::app()->request->isAjaxRequest){
            $user_collect = ResoldUserCollectionExt::model()->findByPk($id,'uid=:uid',array(':uid'=>$this->uid));
            if(!$user_collect)
                $this->response(false,'找不到收藏');
            $user_collect->delete();
            $this->response(true,'删除成功');
        }
    }

}