<?php
/**
 * 学校列表页
 * @author steven_allen
 * @version 2016-06-08
 */
class IndexAction extends CAction
{
    public function run($id=0,$type='',$kw='')
    {
        $kw=$this->controller->cleanXss($kw);
    	Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());

        $areaOne  = AreaExt::model()->find(array(
            'condition'=>'id = :id',
            'params'=>array(':id'=>$id), 
        ));

        $name = $areaOne ? $areaOne->name : '';

        $schoolarea = SchoolAreaExt::model()->normal()->findAll();

        $criteria = new CDbCriteria();
        if(isset($id) && !empty($id)){
            $criteria->addCondition("t.area=:area");
            $criteria->params[':area']=$id;
        }

        if(isset($type) && !empty ($type)){
            $criteria->addCondition("t.type=:type");
            if($type == 'xx'){
                $criteria->params[':type'] = $schoolType = 1; 
            }elseif($type == 'zx'){
                $criteria->params[':type'] = $schoolType = 2; 
            }
        }
        if($kw)
        {
            $criteria->addSearchCondition('t.name',$kw);
        }
        $criteria->select='t.*,count(p.id) as num';
        $criteria->join='left join school_plot_rel p on p.sid=t.id left join plot pp on pp.id = p.hid';
        $criteria->addCondition("pp.is_new=1");
        $criteria->group ='t.id';

        $this->controller->render('index',array(
            'id' =>$id,
            'schoolarea'=>$schoolarea,
            'schoolType'=>isset($schoolType)?$schoolType:'',
            'name' =>$name,
            'kw' =>$kw,
            'count'=>SchoolExt::model()->normal()->count($criteria)
            ));
    }
}
