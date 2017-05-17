<?php
/**
 * 楼盘户型列表页面
 * @author steven_allen
 * @version 2016-06-17
 */
class HuxingAction extends CAction
{
    public function run()
    {
    	$plot = $this->controller->plot;
    	$t = Yii::app()->request->getParam('t', 0);
        $criteria = array(
                'select' => 'count(id) as count,bedroom',
                'condition' => 'hid=:hid',
                'group' => 'bedroom',
                'order' => 'bedroom asc',
                'limit' => 10,
                'params' => array(':hid'=>$plot->id)
        );
        $hx_cate = PlotHouseTypeExt::model()->findAll($criteria);
        $criteria = new CDbCriteria;
        $criteria->addCondition('hid = :hid');
        $criteria->params = array(':hid'=>$plot->id);
        //先按设定的顺序排，再按在售、待售、售罄排
        $criteria->order = 'sort desc,field(sale_status,1,2,0),id desc';
        if ($t>0) {
            $criteria->addCondition('bedroom=:room');
            $criteria->params[':room'] = $t;
        }
        $data = PlotHouseTypeExt::model()->getList($criteria,12);
        $data1 = PlotHouseTypeExt::model()->findAll($criteria);
        $key0 = 0;
        $key1 = 0;
        $key2 = 0;
        $key3 = 0;
        $key4 = 0;
        $key5 = 0;
        $key6 = 0;
        $key7 = 0;
        $key8 = 0;
        foreach($data1 as $v){
            if($v->bedroom == 1){
                $v->reset_offset = $key0;
                $key0++;
            }elseif($v->bedroom == 2){
                $v->reset_offset = $key1;
                $key1++;
            }elseif($v->bedroom == 3){
                $v->reset_offset = $key2;
                $key2++;
            }elseif($v->bedroom == 4){
                $v->reset_offset = $key3;
                $key3++;
            }elseif($v->bedroom == 5){
                $v->reset_offset = $key4;
                $key4++;
            }elseif($v->bedroom == 6){
                $v->reset_offset = $key5;
                $key5++;
            }elseif($v->bedroom == 7){
                $v->reset_offset = $key6;
                $key6++;
            }elseif($v->bedroom == 8){
                $v->reset_offset = $key7;
                $key7++;
            }else{
                $v->reset_offset = $key8;
                $key8++;
            }
        }
        $this->controller->render('plot_huxing', array(
                't' => $t,
                'hx_cate' => $hx_cate,
                'list' => $data->data,
                'list1' => $data1,
                'pager' => $data->pagination
            )
        );
    }
}
