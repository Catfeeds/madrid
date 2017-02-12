<?php

/**
 * 后台模块vip控制器基类
 * @author steven.allen
 * @date 2016-08-29
 */
class VipController extends Controller {
    /**
     * 过滤器
     */
    public function filters() {
        return array(
            'accessControl - vip/common/login,vip/common/logout,vip/common/init',
        );
    }

    /**
     * 访问控制规则，子类控制器中自定义规则需重写{@link RBACRules()}方法，返回的数组形式相同
     * @return array 访问控制规则
     */
    final public function accessRules() {
        $rules = array(
            array('deny',
                'users' => array('?')
            ),
        );
        return  $rules;
    } 

    /**
     * @var string 布局文件路径
     */
    public $layout = '/layouts/base';

    /**
     * @var array 当前访问页面的面包屑. 这个值将被赋值给links属性{@link CBreadcrumbs::links}.
     */
    public $breadcrumbs = array();

    /**
     * 获取中介后台数组项
     * @return array
     */
    public function getVipMenu() {
        return [
            ['label'=>'管理中心','icon'=>'icon-settings','url'=>'/vip/common/index','active'=>$this->route=='vip/common/index'],
            ['label' => '文章管理','icon' => 'icon-speedometer', 'url' => ['/vip/news/list'],'active'=>$this->route=='vip/news/edit'||$this->route=='vip/news/list'],
            ['label' => '产品管理', 'icon' => 'icon-speedometer', 'items' => [
                ['label' => '发布租房', 'url' => ['/vip/zf/publish']],
                ['label' => '上架租房', 'url' => ['/vip/zf/saleUp'],'active'=>$this->route=='vip/zf/setAppoint'||$this->route=='vip/zf/appointList'],
                ['label' => '下架租房', 'url' => ['/vip/zf/saleDown']],
            ]],
            ['label' => '酒庄管理','icon' => 'icon-speedometer', 'url' => ['/vip/house/list'],'active'=>$this->route=='vip/house/edit'||$this->route=='vip/house/list'],
            ['label'=>'标签管理','icon'=>'icon-speedometer','url'=>['/vip/tag/list'],'active'=>$this->route=='vip/tag/edit'],
            ['label' => '系统管理', 'icon' => 'icon-speedometer','items' => [
                ['label' => '商家档案', 'url' => ['/vip/shop/info']],
                ['label' => '职员管理', 'url' => ['/vip/shop/staff'],'active'=>$this->route=='vip/shop/staffEdit'],
            ]],
        ];
    }

    /**
     * 这个方法在被执行的动作之前、在所有过滤器之后调用
     * @param CAction $action 被执行的控制器
     * @return boolean whether 控制器是否被执行
     */
    protected function beforeAction($action) {
        return parent::beforeAction($action);
    }

}
