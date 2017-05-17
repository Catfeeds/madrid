<?php

class ZfController extends AdminController
{
    /**
     * resoldQz或resoldQg
     */
    private $resoldBuy;
    /**
     * resoldZf或resoldEsf
     */
    private $resoldSale;

    /**
     * @return mixed
     */
    public function getResoldBuy()
    {
        return $this->resoldBuy;
    }

    /**
     * @return mixed
     */
    public function getResoldSale()
    {
        return $this->resoldSale;
    }
    public function init()
    {
        parent::init();
        $this->resoldBuy = ResoldQzExt::model();
        $this->resoldSale = ResoldZfExt::model();
    }

    public function actions()
    {
        $alias = 'admin.controllers.zf.';
        $common = 'admin.controllers.common.';
        return [
            'zfList' => $alias . 'ZfListAction',//租房列表
            'zfEdit' => $alias . 'ZfEditAction',//租房添加\编辑
            'qzList' => $alias . 'QzListAction',//求租列表
            'qzEdit' => $alias . 'QzEditAction',//求租添加\编辑
            'ajaxDelQz'=>$common.'AjaxDelBuyAction',//ajax删除楼盘求租
            'ajaxDelZf'=>$common.'AjaxDelSaleAction',//ajax删除楼盘租房
            'phoneCheck'=>$common.'PhoneCheckAction',//电话确认
            'zfAjaxStatus'=>$common.'AjaxStatusSaleAction',//租房修改状态
            'qzAjaxStatus'=>$common.'AjaxStatusBuyAction',//求租修改状态
            'ajaxZfSort'=>$common.'AjaxSortAction',//求租修改状态
        ];
    }

    public function behaviors()
    {
        return [
            'EsfZfCommonBehavior'=>'application.behaviors.EsfZfCommonBehavior'
        ];
    }

}
