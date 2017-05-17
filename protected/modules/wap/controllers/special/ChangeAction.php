<?php
/**
 * wap首页特价房换一换
 * 规则：状态启用、售罄且未过期的，推荐过的
 * @author weibaqiu
 * @version 2016-06-07
 */
class ChangeAction extends CAction
{
    public function run()
    {
        $count = PlotSpecialExt::model()->normal()->recommend()->noExpire()->count();
        $criteria = new CDbCriteria;
        $criteria->limit = 3;
        $criteria->offset = $count>$criteria->limit ? rand(0, $count-$criteria->limit) : 0;
        $criteria->order = 'rand()';
        $plotSpecials = PlotSPecialExt::model()->normal()->recommend()->noExpire()->findAll($criteria);
        $lists = array();

        foreach($plotSpecials as $v) {
            $lists[] = array(
                'pic' => ImageTools::fixImage($v->image),
                'link' => $this->controller->createUrl('/wap/special/detail',['id'=>$v->id]),
                'title' => $v->plot?$v->plot->title:'---',
                'sale' => '劲省'.round($v->price_old-$v->price_new,1).'万',
                'detail' => $v->room.'&#160;&#160;'.$v->bed_room.'&#160;&#160;'.$v->size.'m<sup>2</sup>',
                'price' => PlotPriceExt::getPrice($v->plot->price,$v->plot->unit),
                'tprice' => '¥'.$v->price_new.'万元',
                'yprice' => '￥'.$v->price_old.'万'
            );
        }
        $data = array(
            'lists' => $lists
        );
        echo CJSON::encode($data);
    }
}
