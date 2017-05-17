<?php
/**
 * 特惠团换一换接口
 * @author weibaqiu
 * @version 2016-06-07
 */
class ChangeAction extends CAction
{
    public function run()
    {
        $count = PlotTuanExt::model()->noExpire()->normal()->count();
        $criteria = new CDbCriteria;
        $criteria->limit = 3;
        $criteria->offset = $count>$criteria->limit ? rand(0, $count-$criteria->limit) : 0;
        $criteria->order = 'rand()';
        $tuan =  PlotTuanExt::model()->noExpire()->normal()->findAll($criteria);
        $lists = array();

        foreach($tuan as $v) {
            $lists[] = array(
                'pic' => ImageTools::fixImage($v->wap_img),
                'link' => $this->controller->createUrl('/wap/plot/index',['py'=>$v->plot->pinyin,'md'=>'tht']),
                'title' => $v->s_title,
                'name' => $v->plot ? $v->plot->title : '---',
                'price' => $v->plot->price.PlotPriceExt::$unit[$v->plot->unit],
                'num' => $v->stat+$v->tuanNum,
                'over' => $v->getRemainingTime(),
            );
        }
        $data = array(
            'lists' => $lists,
        );
        echo CJSON::encode($data);
    }
}
