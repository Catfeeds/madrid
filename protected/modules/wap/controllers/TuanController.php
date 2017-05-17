<?php
/**
 * @Author: anchen
 * @Date:   2015-10-29 13:56:26
 */
class TuanController extends WapController{

    public function actions()
    {
        $alias = 'wap.controllers.tuan.';
        return array(
            'index' => $alias.'IndexAction',
        );
    }
}
