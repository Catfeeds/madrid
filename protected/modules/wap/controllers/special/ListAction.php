<?php
/**
 * 特价房列表页
 * @author weibaqiu
 * @version 2016-05-25
 */
class ListAction extends CAction
{
    public function run($ajax=0)
    {
        if($ajax>0){
            $rows = array();
            $criteria = new CDbCriteria();
            $criteria->order = 'created desc';
            $dataProvider = PlotSpecialExt::model()->normal()->noExpire()->getList($criteria,10);
            foreach($dataProvider->data as $v){
                if($v->htid==0){
                    $detail=$v->room.'&nbsp;'.$v->bed_room.'&nbsp;'.$v->size.'㎡';
                }
                else
                    $detail=$v->room.'&nbsp;'.$v->houseType->bedroom.'室'.$v->houseType->livingroom.'厅'.$v->houseType->bathroom.'卫&nbsp;'.$v->houseType->size.'㎡';
                $rows[] = array(
                    'pic' => ImageTools::fixImage($v->image,166,124),
                    'link' => $this->controller->createUrl('/wap/special/detail',['id'=>$v->id]),
                    'sale' => '劲省'.round($v->price_old-$v->price_new,1).'万',
                    'title' => $v->plot->title,
                    'price' => PlotPriceExt::getPrice($v->plot->price,$v->plot->unit),
                    'detail' => $detail,
                    'tprice' => '￥'.$v->price_new.'万元',
                    'yprice' => '￥'.$v->price_old.'万元',
                );
            }
            $data = array(
                'totalPage' => $dataProvider->pagination->getPageCount(),
                'lists' => $rows,
            );
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        $this->controller->render('index');
    }
}
