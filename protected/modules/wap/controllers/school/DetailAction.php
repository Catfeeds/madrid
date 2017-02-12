<?php
/**
 * 学校楼盘页
 * @author steven_allen
 * @version 2016-06-08
 */
class DetailAction extends CAction
{
    public function run($id=0,$type='')
    {
    	 $id = Yii::app()->request->getParam('id','');
        $school = SchoolExt::model()->find(array(
            'condition'=>'id=:id',
            'params'=>array(':id'=>$id),
        ));

        $ids= array();
        foreach($school->plotSchool as  $key=>$v){
            $ids[$key] = $v->hid;
        }
        
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $ids);
        $dataProvider = PlotExt::model()->isNew()->getList($criteria,10);
        $plot = $dataProvider->data;
        $pager = $dataProvider->pagination;
        
        $this->controller->render('detail',array(
           'count' => $pager->itemCount,
           'id' => $id,
           'school' => $school,
        ));
    }
}
