<?php
/**
 * 楼盘户型列表页
 * @author weibaqiu
 * @version 2016-05-25
 */
class ListAction extends CAction
{
    /**
     * @param  integer $br 居室数量
     */
    public function run($br=0,$bid=0)
    {
        $br = (int)$br;
        $bid = (int)$bid;
        //筛选分类
        $bedrooms = PlotHouseTypeExt::model()->findAll(array(
            'condition' => 'hid=:hid and bedroom>0',
            'params' => array(':hid'=>$this->controller->plot->id),
            'group' => 'bedroom',
            'order' => 'bedroom asc'
        ));
        if($br==0 && $bedrooms) {
            $br = (int)$bedrooms[0]->bedroom;
        }
        
        //楼栋对应户型,有bid走houseTypeBuildings关系
        if($bid)
        {
            $criteria = new CDbCriteria([
                'with' => 'houseTypeBuildings',
                'condition' => 't.bedroom=:br and houseTypeBuildings.bid=:bid',
                'params' => [':br'=>$br,':bid'=>$bid],
                //先按设定的顺序排，再按在售、待售、售罄排
                'order' => 't.sort desc,field(t.sale_status,1,2,0),t.id desc',
            ]);
        }
        else
        {
            //列表数据
            $criteria = new CDbCriteria([
                'condition' => 'bedroom=:br',
                'params' => [':br'=>$br],
                //先按设定的顺序排，再按在售、待售、售罄排
                'order' => 'sort desc,field(sale_status,1,2,0),id desc',
            ]);
        }
        $list = PlotHouseTypeExt::model()->enabled()->findAllByHid($this->controller->plot->id,$criteria);
        $this->controller->render('housetype/list', array(
            'br' => $br,
            'bid' => $bid,
            'bedrooms' => $bedrooms,
            'list' => $list,
        ));
    }
}
