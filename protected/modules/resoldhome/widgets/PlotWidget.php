<?php
/**
 * 感兴趣的新房
 * User: jt
 * Date: 2016/12/21 13:56
 */
class PlotWidget extends CWidget{
    /**
     * 同区域
     * @var string
     */
    public $areaid;
    /**
     * 同街道
     * @var string
     */
    public $streetid;
    /**
     * 排序
     * @var string
     */
    public $order = 'open_time desc';
    /**
     * 限制个数
     * @var int
     */
    public $limit = 5;

    public function run(){
        $criteria = new CDbCriteria(array(
            'order'=>$this->order,
            'limit'=>$this->limit
        ));
        if($this->areaid && $this->streetid){
            $criteria->addCondition('street=:street');
            $criteria->params[':street'] = $this->streetid;
            $data = PlotExt::model()->normal()->isNew()->findAll($criteria);
            $count = count($data);
            if($count < $this->limit){
                $temp_c = new CDbCriteria(array(
                    'condition'=>'area=:area and street!=:street',
                    'params'=>array(':area'=>$this->areaid,':street'=>$this->streetid),
                    'order'=>$this->order,
                    'limit'=>$this->limit - $count
                ));
                $temp_d = PlotExt::model()->normal()->isNew()->findAll($temp_c);
                $data = array_merge($data,$temp_d);
            }
//            $criteria->params[':area'] = $this->areaid;
        }else{
            $data = PlotExt::model()->normal()->isNew()->findAll($criteria);
        }
        $this->render('plot_nearby',array('data'=>$data));
    }
}