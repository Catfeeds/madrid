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
            array('label' => '首页', 'url' => array('/admin/common/index'), 'icon' => 'icon-speedometer'),
            array('label' => '内容管理', 'icon' => 'icon-speedometer', 'visible' => Yii::app()->user->checkAccess('guanlineirong'),
                'items' => array(
                    array('label' => '栏目管理', 'url' => array('/admin/info/cateList'), 'active' => $this->route == 'admin/info/cateedit'),
                    array('label' => '资讯管理', 'url' => array('/admin/info/List'), 'active' => $this->route == 'admin/info/edit'),
                )
            ),
            array('label' => '推荐管理', 'icon' => 'icon-speedometer', 'visible' => Yii::app()->user->checkAccess('guanlineirong'),
                'items' => array(
                    array('label' => '推荐位管理', 'url' => array('/admin/recommend/catelist'), 'active' => $this->route == 'admin/recommend/cateedit'),
                    array('label' => '推荐内容管理', 'url' => array('/admin/recommend/list'), 'active' => $this->route == 'admin/recommend/edit'),
                )
            ),
            array('label' => '问答管理', 'icon' => 'icon-speedometer', 'visible' => Yii::app()->user->checkAccess('guanlineirong'),
                'items' => array(
                    array('label' => '问答管理', 'url' => array('/admin/ask/list'), 'active' => $this->route == 'admin/ask/edit'),
                    array('label' => '问答分类', 'url' => array('/admin/ask/catelist'))
                )
            ),
            array('label' => '房源管理', 'icon' => 'icon-speedometer', 'visible' => Yii::app()->user->checkAccess('guanlineirong'),
                'items' => array(
                    array('label' => '楼盘库', 'url' => array('/admin/plot/list'), 'active' => $this->route == 'admin/plot/edit'),
                    array('label' => '特价房', 'url' => array('/admin/plotSpecial/list'), 'active' => $this->route == 'admin/plotSpecial/edit'),
                    array('label' => '看房团', 'url' => array('/admin/plot/kanlist'), 'active' => in_array($this->route, array('admin/plot/kanedit', 'admin/plot/kanimg'))),
                    array('label' => $this->t('特惠团'), 'url' => array('/admin/plotTuan/list'), 'active' => $this->route == 'admin/plotTuan/edit'),

                    array('label' => '价格走势', 'url' => array('/admin/plot/priceTrendList'), 'active' => $this->route == 'admin/plot/pricetrendedit'),
                )
            ),
            array('label' => '集客管理', 'icon' => 'icon-speedometer', 'visible' => (Yii::app()->user->checkAccess('jihuochi') || Yii::app()->user->checkAccess('guanlijike') || Yii::app()->user->checkAccess('maifangguwen')),
                'items' => array(
                    array('label' => '订单管理', 'url' => array('/admin/order/list'), 'active' => $this->route == 'admin/order/add', 'visible' => Yii::app()->user->checkAccess('guanlijike')),
                    array('label' => '用户管理', 'url' => array('/admin/user/list'), 'active' => $this->route == 'admin/user/add', 'visible' => Yii::app()->user->checkAccess('guanlijike')),
                    array('label' => '激活池', 'url' => array('/admin/user/revive'), 'visible' => Yii::app()->user->checkAccess('jihuochi') && SM::jikeConfig()->mode() == 1),
                    array('label' => '集客统计', 'url' => array('/admin/order/statistics'), 'visible' => Yii::app()->user->checkAccess('guanlijike')),
                    array('label' => '分销管理', 'url' => array('/admin/ec/list'), 'visible' => Yii::app()->user->checkAccess('guanlijike')),//最初叫电商管理
                    array('label' => '买房顾问', 'visible' => Yii::app()->user->checkAccess('maifangguwen'), 'items' => array(
                        array('label' => '人员管理', 'url' => array('/admin/staff/list'), 'active' => in_array($this->route, array('admin/staff/edit'))),
                        array('label' => '点评管理', 'url' => array('/admin/staff/commentList'), 'active' => in_array($this->route, array('admin/staff/commentEdit')))
                    )),
                )
            ),
            array('label' => '新房标签管理', 'icon' => 'icon-speedometer', 'url' => array('/admin/tag/list'), 'visible' => Yii::app()->user->checkAccess('guanlineirong'), 'active' => $this->route == 'admin/tag/edit'),
            array('label' => '后台管理', 'icon' => 'icon-settings',
                'items' => array(
                    array('label' => '广告设置', 'url' => array('/admin/ad/list'), 'visible' => Yii::app()->user->checkAccess('guanggaoguanli')),
                    // array('label' => '开关设置','url' => array('/admin/site/switchConfig'),'visible'=>Yii::app()->user->checkAccess('zhandianpeizhi')),
                    array('label' => '分站配置', 'url' => array('/admin/substation/list'), 'active' => $this->route == 'admin/substation/edit', 'visible' => Yii::app()->user->checkAccess('zhandianpeizhi')),
                    array('label' => '缓存管理', 'url' => array('/admin/site/cacheManager')),
                ),
            ),
            array('label' => '帮助中心', 'icon' => 'icon-settings', 'url' => 'http://www.hangjiayun.com/help/fcdsj', 'linkOptions' => array('target' => '_blank')),
            // array('label' => '升级新版', 'icon' =>'fa fa-level-up', 'url' => array('/admin/common/upgrade'),'linkOptions'=>['class'=>'list-group-item bg-grey-cascade'],'visible'=>Yii::app()->user->checkAccess('admin')&&!$this->getIsLatest()),
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
     * 获取公共菜单
     * @return array
     */
    public function getPublicMenu()
    {
        return [
            array('label' => '邻校房', 'icon' => 'icon-speedometer', 'url' => array('/admin/school/list'), 'active' => in_array($this->route, array('admin/school/edit', 'admin/school/rel'))),
            array('label' => '邻校区域', 'icon' => 'icon-speedometer', 'url' => array('/admin/school/areaList'), 'active' => $this->route == 'admin/school/areaedit'),
            array('label' => '知识库管理', 'icon' => 'icon-speedometer', 'visible' => Yii::app()->user->checkAccess('guanlineirong'),
                    'items' => array(
                        array('label' => '知识库分类管理', 'url' => array('/admin/baike/catelist'), 'active' => $this->route == 'admin/baike/cateEdit'),
                        array('label' => '知识库标签管理', 'url' => array('/admin/baike/taglist'), 'active' => $this->route == 'admin/baike/tagEdit'),
                        array('label' => '知识库管理', 'url' => array('/admin/baike/list'), 'active' => $this->route == 'admin/baike/edit'),
                    )
                ),
            array('label' => '后台管理', 'icon' => 'icon-settings',
                'items' => array(
                    array('label' => '工作人员管理', 'visible' => Yii::app()->user->checkAccess('gongzuorenyuan'),
                        'items' => array(
                            array('label' => '人员列表', 'url' => array('/admin/worker/list'), 'visible' => Yii::app()->user->checkAccess('gongzuorenyuan'), 'active' => in_array($this->route, array('admin/worker/edit'))),
                            array('label' => '添加员工', 'visible' => Yii::app()->user->checkAccess('gongzuorenyuan'), 'url' => array('/admin/worker/add')),
                        )
                    ),
                    array('label' => '权限管理', 'url' => array('/admin/rbac/index'), 'visible' => Yii::app()->user->checkAccess('gongzuorenyuan'),
                        'items' => array(
                            array('label' => '用户组管理', 'url' => array('/admin/rbac/list'), 'active' => in_array($this->route, array('admin/rbac/list'))),
                            array('label' => '添加用户组', 'url' => array('/admin/rbac/edit'))
                        )
                    ),
                    array('label' => '新房站点配置','url' => array('/admin/site/siteSettingMap'),'visible'=>Yii::app()->user->checkAccess('zhandianpeizhi'), 'active'=>$this->route=='admin/site/siteSetting'),
                    array('label' => '二手房站点配置','url' => array('/admin/site/resoldSiteSettingMap'),'visible'=>Yii::app()->user->checkAccess('ershoufangguanli'), 'active'=>$this->route=='admin/site/resoldSiteSetting'),
                    array('label'=>'分站配置','url'=>array('/admin/substation/list'),'active'=>$this->route=='admin/substation/edit','visible'=>Yii::app()->user->checkAccess('zhandianpeizhi')),
                    array('label' => '缓存管理','url' => array('/admin/site/cacheManager')),
                    array('label' => '技术开放接口', 'icon' => 'fa fa-database', 'url'=>array('/admin/common/openDoc')),
                ),
            ),
            array('label' => '区域管理','icon' => 'icon-settings', 'url' => array('/admin/area/areaList'), 'active' => $this->route == 'admin/area/areaedit'),

            ['label' => '帮助中心', 'icon' => 'icon-settings', 'url' => 'http://www.hangjiayun.com/help/fcdsj', 'linkOptions' => ['target' => '_blank']],

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
