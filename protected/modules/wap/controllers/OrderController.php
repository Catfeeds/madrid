<?php
/**
 * wap集客表单
 * @author weibaqiu
 * @date 2015-11-06
 */
class OrderController extends WapController
{
    public function actions()
    {
        $alias = 'wap.controllers.order.';
        return array(
            'form' => $alias.'FormAction',
            'deal' => $alias.'DealAction',
            'kanDeal' => $alias.'KanDealAction',
        );
    }
}
