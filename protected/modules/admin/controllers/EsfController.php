<?php
class EsfController extends AdminController
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
        $this->resoldBuy = ResoldQgExt::model();
        $this->resoldSale = ResoldEsfExt::model();
    }

    public function actions()
    {
        $alias = 'admin.controllers.esf.';
        $common = 'admin.controllers.common.';
        return [
            'esfList' => $alias . 'EsfListAction',//二手房列表
            'esfEdit' => $alias . 'EsfEditAction',//二手房添加\编辑
            'qgList' => $alias . 'QgListAction',//求购列表
            'qgEdit' => $alias . 'QgEditAction',//求购添加\编辑
            'ajaxDelQg'=>$common.'AjaxDelBuyAction',//ajax删除楼盘二手房求购
            'ajaxDel'=>$common.'AjaxDelSaleAction',//ajax删除楼盘二手房
            'phoneCheck'=>$common.'PhoneCheckAction',//电话确认
            'ajaxStatus'=>$common.'AjaxStatusSaleAction',//二手房修改状态
            'QgStatus'=>$common.'AjaxStatusBuyAction',//二手房求购修改状态
            'ajaxEsfSort'=>$common.'AjaxSortAction',//排序
        ];
    }
    public function behaviors()
    {
        return [
            'EsfZfCommonBehavior'=>'application.behaviors.EsfZfCommonBehavior'
        ];
    }

    /**
     * [actionCheckPhone 小编后台验证手机号是否存在]
     * @param  [type] $phone [description]
     * @param  [type] $type  [description]
     * @return [type]        [description]
     */
    public function actionCheckPhone($phone,$type)
    {
        $model = $type == 1 ? 'ResoldEsfExt' : 'ResoldZfExt';
        echo json_encode(['data'=>$model::model()->saling()->count(['condition'=>'phone=:phone','params'=>[':phone'=>$phone]])>0?'1':'0']);
    }
}
