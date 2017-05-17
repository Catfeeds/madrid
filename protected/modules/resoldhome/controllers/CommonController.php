<?php
/**
 *
 * User: jt
 * Date: 2016/11/30 14:00
 */
class CommonController extends ResoldHomeController{

    public function actionAjaxGetPlot($kw)
    {
        $criteria = new CDbCriteria(array('limit'=>20,'order'=>'sort desc , views desc'));
        if (!$kw) {
            $criteria->limit = 15;
        }
        if (preg_match("/^[a-zA-Z\s]+$/", $kw)) {
            $criteria->addSearchCondition('pinyin', $kw);
        } else {
            $criteria->addSearchCondition('title', $kw);
        }

        $data = array();
        $house = PlotExt::model()->normal()->findAll($criteria);
        if($house){
            foreach ($house as $v) {
                $data[] = array('id'=>$v->id, 'name'=>$v->title);
            }
        }
        $data = array('results'=>$data, 'more'=>false);
        echo CJSON::encode($data);
    }

    public function actionGetStreet(){
        if(Yii::app()->request->isPostRequest){
            $area_id = Yii::app()->request->getPost('area_id');
            if(!$area_id)
                $this->response(false,'参数错误');
            $area = AreaExt::model()->normal()->getByParent($area_id)->findAll();
            $this->renderOutput(true,'ok',$area);
        }
    }

}