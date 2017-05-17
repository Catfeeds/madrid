<?php
/**
 * Created by PhpStorm.
 * User: sc
 * Date: 2016/2/1
 * Time: 15:46
 * 楼盘地图
 */
class MapController extends WapController{

    public function actions()
    {
        $alias = 'wap.controllers.map.';
        return array(
            'index' => $alias.'IndexAction',//地图找房
            'search' => $alias.'SearchAction'//搜索框autocomplete
        );
    }
}
