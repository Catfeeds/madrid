<?php
/**
 * 地图找房搜索框autocomplete请求接口
 * @author weibaqiu
 * @version 2016-06-14
 */
class SearchAction extends CAction
{
    public function run($key)
    {
        if(!empty($key)) {
            $xs = Yii::app()->search->house_plot;
            $xs->setQuery($key);
            $xs->addRange('status',1,1);
            $xs->addRange('is_new',1,1);
            $xs->addRange('deleted', 0, 0);
            $xs->setLimit(10);
            $docs = $xs->search();
            $lists = array();
            foreach($docs as $v) {
                $lists[] = array(
                    'name' => $v['title'],
                    'lat' => $v['map_lat'],
                    'lng' => $v['map_lng']
                );
            }
            echo CJSON::encode(array('lists'=>$lists));
        }
    }
}
