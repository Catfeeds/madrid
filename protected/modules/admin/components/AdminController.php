<?php

/**
 * 后台模块admin控制器基类
 * @author weibaqiu
 * @date 2015-04-20
 */
class AdminController extends Controller
{

    /**
     * @var string 布局文件路径
     */
    public $layout = '/layouts/base';

    /**
     * @var array 当前访问页面的面包屑. 这个值将被赋值给links属性{@link CBreadcrumbs::links}.
     */
    public $breadcrumbs = array();

    /**
     * 过滤器
     */
    public function filters()
    {
        return array(
            'accessControl - admin/common/login,admin/common/logout,admin/common/init',
            'sensitiveWordControl + admin/esf/esfEdit,admin/esf/qgEdit,admin/zf/zfEdit,admin/zf/qzEdit'
        );
    }

    /**
     * @param $chain
     * 敏感词过滤器
     * 将post数据转换成json字符串将敏感词切成数组循环遍历
     */
    public function filterSensitiveWordControl($chain)
    {
        if(!SM::resoldSensitiveConfig()->resoldUseSensitiveWordFilter()) {
            $chain->run();
        }else {
            $filterFile = SM::resoldSensitiveConfig()->resoldSensitive();
            $flag = true;
            if ($filterFile) {
                $words = preg_split("/,|，/", $filterFile);
                if (Yii::app()->request->isPostRequest) {
                    $postData = json_encode($_POST, JSON_UNESCAPED_UNICODE);
                    foreach ($words as $word) {
                        if (strpos($postData, $word)) {
                            $this->setMessage("数据中存在敏感词汇({$word})", "error");
                            $flag = false;
                            break;
                        }
                    }
                }
            }
            if($flag){
                $chain->run();
            }else{
                $this->redirect(Yii::app()->request->urlReferrer);
            }
        }

    }

    /**
     * 自定义访问规则
     * @return array 返回一个类似{@link accessRules}中的规则数组
     */
    public function RBACRules()
    {
        return array();
    }

    /**
     * 访问控制规则，子类控制器中自定义规则需重写{@link RBACRules()}方法，返回的数组形式相同
     * @return array 访问控制规则
     */
    final public function accessRules()
    {
        $rules = array(
            array('deny',
                'users' => array('?')
            ),
        );
        return array_merge($this->RBACRules(), $rules);
    }

    /**
     * 自定义左侧菜单，设置方法与zii.widget.CMenu相似，详见CMenu.php
     * 使用技巧：
     * 1、系统会自动将'url'与当前访问路由匹配的菜单进行高亮，使用'active'可指定需要高亮的菜单项，只需设置'active'元素的值为一个布尔值的表达式即可。
     * 假设要访问非admin/index/index页面时使得该菜单项高亮，则进行如下设置：
     * array('label'=>'首页','url'=>array('/admin/index/index', 'active'=>$this->route=='admin/index/test'))
     * 这会使得在访问admin/index/test时，admin/index/index菜单项进行高亮
     */
    public function getXinfangMenu()
    {
        return array(
            array('label' => '楼盘导入', 'url' => array('/admin/house/import'), 'active' => $this->route == 'admin/house/import'),
            array('label' => '楼盘列表', 'url' => array('/admin/house/list'), 'active' => $this->route == 'admin/house/list'||$this->route == 'admin/house/edit'),
        );
    }

    /**
     * 获取二手房菜单栏数组项，原理同上
     * @return array
     */
    public function getResoldMenu()
    {
        return [
            ['label' => ' 首页', 'icon' => 'icon-home', 'url' => ['/admin/common/esfIndex'], 'active' => $this->route == ('admin/common/esfIndex')],
            ['label' => ' 二手房', 'icon' => 'icon-rocket', 'items' => [
                ['label' => ' 二手房列表', 'url' => ['/admin/esf/esfList'], 'icon'=> 'icon-docs', 'active' => $this->route == ('admin/esf/esfEdit')],
                ['label' => ' 求购列表', 'url' => ['/admin/esf/qgList'], 'active' => $this->route == ('admin/esf/qgEdit'), 'icon'=> 'icon-docs'],
            ]],
            ['label' => ' 租房', 'icon' => 'icon-cup', 'items' => [
                ['label' => ' 租房列表', 'url' => ['/admin/zf/zfList'],'icon'=> 'icon-docs', 'active' => $this->route == ('admin/zf/zfEdit')],
                ['label' => ' 求租列表', 'url' => ['/admin/zf/qzList'],'icon'=> 'icon-docs','active' => $this->route == ('admin/zf/qzEdit'),],
            ]],
            ['label' => ' 小区列表', 'url' => ['/admin/resoldPlot/list'],'icon'=> 'icon-map', 'active' => $this->route == ('admin/resoldPlot/edit')],
            ['label' => ' 推荐管理', 'icon' => 'icon-share-alt', 'items' => [
                ['label' => ' 推荐位管理', 'url' => ['/admin/resoldRecommend/cateList'], 'active' => $this->route == ('admin/resoldRecommend/cateedit'),'icon'=> 'icon-docs'],
                ['label' => ' 推荐内容管理', 'url' => ['/admin/resoldRecommend/list'], 'active' => $this->route == ('admin/resoldRecommend/edit'),'icon'=> 'icon-docs'],
            ]],
            ['label' => ' 中介管理', 'icon' => 'icon-diamond', 'items' => [
                ['label' => ' 商家列表', 'url' => ['/admin/shop/shopList'],'active'=>$this->route==('admin/shop/shopEdit'),'icon'=> 'icon-docs'],
                // ['label' => '新增商家', 'url' => ['/admin/shop/shopEdit']],
                // ['label' => '新增职员', 'url' => ['/admin/resoldStaff/resoldStaffEdit']],
                ['label' => ' 职员列表', 'url' => ['/admin/resoldStaff/resoldStaffList'],'active'=>$this->route==('admin/resoldStaff/resoldStaffEdit'),'icon'=> 'icon-docs'],
                ['label' => ' 套餐列表', 'url' => ['/admin/resoldTariffPackage/packageList'],'active'=>$this->route==('admin/resoldTariffPackage/packageEdit'),'icon'=> 'icon-docs'],
                // ['label' => '新增套餐', 'url' => ['/admin/resoldTariffPackage/packageEdit']],
            ]],
            ['label' => ' 价格走势', 'icon' => 'icon-bar-chart', 'items' => [
                ['label'=>' 二手房价格走势','icon' => 'icon-docs','url'=>['/admin/resoldPriceTrend/list'],'active'=>$this->route=='admin/resoldPriceTrend/edit'],
                ['label' => ' 每日价格统计', 'icon' => 'icon-docs', 'url' => ['/admin/resoldDaily/list']],
            ]],
            ['label' => ' 房源举报列表', 'icon' => 'icon-flag', 'url' => ['/admin/resoldReport/list']],
            ['label' => ' 二手房标签管理', 'icon' => 'icon-tag', 'url' => ['/admin/tag/resoldTag'],'active'=>$this->route=='admin/tag/resoldTagEdit'],
            ['label'=>' 黑名单','icon'=>'icon-dislike','url'=>['/admin/black/list']],
            ['label'=>' 中介电话库','icon'=>'icon-call-end','url'=>['/admin/resoldStaffPhone/list']],
            // ['label' => ' 敏感词编辑', 'icon' => 'icon-dislike', 'url' => ['/admin/sensitiveWords/edit']],
            ['label' => ' 短信验证码', 'icon' => 'icon-envelope', 'url' => ['/admin/code/list']],
            ['label' => ' 用户管理', 'icon' => 'icon-user', 'url' => ['/admin/resoldUser/list'],'active'=>$this->route=='admin/resoldUser/list'],
            ['label' => ' 帮助','icon'=>'icon-question','url'=>['/admin/resoldHelp/index'],'active'=>($this instanceof ResoldHelpController)]
        ];
    }

    /**
     * [getPersonalSalingNum 个人可以上架数目]
     * @return [type] [description]
     */
    public function getPersonalSalingNum($uid=0)
    {
        if(!$uid)
            return 0;
        $userPubNum = SM::resoldConfig()->resoldPersonalSaleNum();
        $salingEsfNum = ResoldEsfExt::model()->saling()->count(['condition'=>'uid=:uid','params'=>[':uid'=>$uid]]);
        $salingZfNum = ResoldZfExt::model()->saling()->count(['condition'=>'uid=:uid','params'=>[':uid'=>$uid]]);
        $salingQgNum = ResoldQgExt::model()->undeleted()->enabled()->count(['condition'=>'uid=:uid','params'=>[':uid'=>$uid]]);
        $salingQzNum = ResoldQzExt::model()->undeleted()->enabled()->count(['condition'=>'uid=:uid','params'=>[':uid'=>$uid]]);
        $totalCanSaleNum = $userPubNum -$salingEsfNum - $salingZfNum - $salingQgNum - $salingQzNum;
        $totalCanSaleNum < 0 && $totalCanSaleNum = 0;
        return $totalCanSaleNum;
    }

}
