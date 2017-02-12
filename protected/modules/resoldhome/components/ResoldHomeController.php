<?php
/**
 * 二手房控制器
 * @author steven allen <[<email address>]>
 * @date 2016.10.28
 */
class ResoldHomeController extends Controller
{
	/**
     * @var string 页面底部
     */
    public $siteFooter;
    /**
     * 是否展示右侧浮动跟滚菜单
     * @var boolean
     */
    public $showFloatMenu = true;
    /**
     * @var array 当前访问页面的面包屑. 这个值将被赋值给links属性{@link CBreadcrumbs::links}.
     */
    public $breadcrumbs = array();
    /**
     * @var string 布局文件路径
     */
    public $layout = '/layouts/base';

    //基本路径
    private $staticPath;

    //tag标签
    private $allTag;

    //顶部菜单
    private $menu;

    //注册链接
    private $registerUrl;

    //当前链接
    private $currentUrl;

    //登录链接
    private $loginUrl;

    //关键字
    private $keyword;

    //描述
    private $description;

    /**
     * [init 初始化方法]
     * @return [type] [description]
     */
    public function init()
    {
        parent::init();
        if($this->redirectWap()&&$this->module->id=='resoldhome'&&$this->id!='error')
        {
            $this->getWapUrl();
            Yii::app()->end();
        }
    }

    /**
     * 这个方法在被执行的动作之前、在所有过滤器之后调用
     * @param CAction $action 被执行的控制器
     * @return boolean whether 控制器是否被执行
     */

    protected function beforeAction($action) {
        return parent::beforeAction($action);
    }

    /**
     * 获取订单提交地址
     * @return string
     */
    public function getOrderSubmitUrl()
    {
        return $this->createUrl('/api/order/ajaxSubmit');
    }

    /**
     * 获取问题提交的地址
     * @return string
     */
    public function getAskSubmitUrl()
    {
        return $this->createUrl('/api/ask/ajaxSubmit');
    }

    /**
     * Yii片段缓存改造，加入删除指定片段缓存功能
     * @param  string $id         缓存标识id
     * @param  array  $skipRoutes 指定哪些route下不进行片段缓存，数组中每个元素都是一个route格式的字符串
     * @return boolean
     */
    public function startCache($id,$properties=array(),$skipRoutes=array())
    {
        $properties['varyByRoute'] = isset($properties['varyByRoute']) ? $properties['varyByRoute'] : false;
        if(in_array($this->route, $skipRoutes)){
            $properties = array(
                'duration' => -3600,
            );
        }
        return $this->beginCache($id,$properties);
    }

    /**
     * Yii片段缓存删除函数
     * @param  string $id 要删除的片段缓存标识id
     * @return null
     */
    public function deleteCache($id)
    {
        $this->beginCache($id,array('duration'=>0,'varyByRoute' => false));//删除缓存
    }

    /**
     * 在有渲染操作的页面输出额外的内容
     * 这里主要是同步登陆和同步退出的html代码
     */
    public function afterRender($view, &$output)
    {
        if(Yii::app()->user->hasFlash('synloginHtml')){
            $output .= Yii::app()->user->getFlash('synloginHtml');
        }
    }

    public function getRegisterUrl(){
        if($this->registerUrl === null){
            $registerUrl = SM::ucConfig()->registerUrl();
            if(empty($registerUrl))
            {
                $commonHeader = SM::urmConfig()->commonHeader();
                if (isset($commonHeader['zhuce']) && $commonHeader['zhuce'])
                {
                    $this->registerUrl = $commonHeader['zhuce'];
                }else {
                    $this->registerUrl = Yii::app()->uc->getRegisterPageUrl($this->currentUrl);
                }
            }else{
                $this->registerUrl = $registerUrl;
            }
        }
        return $this->registerUrl;
    }

    public function getLoginUrl(){
        if($this->loginUrl === null){
            $loginUrl = SM::ucConfig()->loginUrl();
            if(empty($loginUrl)){
                $this->loginUrl = Yii::app()->uc->getLoginPageUrl($this->getCurrentUrl());
            }else{
                $this->loginUrl = $loginUrl;
            }
        }
        return $this->loginUrl;
    }

    public function getCurrentUrl(){
        if($this->currentUrl === null){
            $this->currentUrl = Yii::app()->request->hostInfo.Yii::app()->request->url;
        }
        return $this->currentUrl;
    }

    public function getKeyword(){
        if($this->keyword === null){
            $this->keyword = SM::urmConfig()->cityName.'二手房,'.SM::urmConfig()->cityName.'二手房出售,'.SM::urmConfig()->cityName.'二手房买卖';
        }
        return $this->keyword;
    }

    public function setKeyword($value){
        $this->keyword = $value;
    }

    public function setDescription($value){
        $this->description = $value;
    }

    public function getDescription(){
        if($this->description === null){
            $default = SM::globalConfig()->siteName.'房产{cityname}二手房网为您提供快速全面的{cityname}二手房信息及新发布{cityname}二手房价格。大量优质二手房实时更新，为您创造舒适二手房购房体验。';
            $this->description = str_replace('{cityname}',SM::urmConfig()->cityName,$default);
        }
        return $this->description;
    }

    /*
     * 获取静态文件地址
     */
    public function getStaticPath(){
        if($this->staticPath === null){
            $this->staticPath = Yii::app()->theme->baseUrl.'/static/resoldhome';
        }
        return $this->staticPath;
    }

    public function getAllTag(){
        if($this->allTag === null){
            $this->allTag = TagExt::getAllByCate();
        }
        return $this->allTag;
    }

    public function renderOutput($code,$msg,$data=array()){
        header('Content-Type: application/json');
        echo CJSON::encode(array(
            'code'=>$code,
            'msg'=>$msg,
            'data'=>$data
        ));
       Yii::app()->end();
    }

    public function getMenu(){
        if($this->menu === null){
            $route = $this->route;
            $esf_active = false;
            $zf_active = false;
            $xzl_active = false;
            $sp_active = false;
            if(in_array($route, array('resoldhome/esf/list','resoldhome/esf/info','resoldhome/myesf/sellinput','resoldhome/qg/index','resoldhome/qg/detail')) || $this instanceof PlotController || $this instanceof SchoolController || $this instanceof StaffController || $this instanceof ShopController)
            {
                $esf_active = true ;
                if(in_array($route,array('resoldhome/esf/info','resoldhome/esf/list','resoldhome/qg/index','resoldhome/qg/detail'))){
                    if(isset($_GET['type']) && ($_GET['type'] == 2 || $_GET['type']==3)){
                        $esf_active = false;
                        if($_GET['type'] == 2){
                            $sp_active = true;
                        }elseif($_GET['type'] == 3){
                            $xzl_active = true;
                        }
                    }
                }
            }
            if(in_array($route,array('resoldhome/zf/list','resoldhome/zf/info','resoldhome/myzf/rentinput','resoldhome/qz/index','resoldhome/qz/detail')))
            {
                $zf_active = true ;
                if(in_array($route,array('resoldhome/zf/info','resoldhome/zf/list','resoldhome/qz/index','resoldhome/qz/detail'))){
                    if(isset($_GET['type']) && ($_GET['type'] == 2 || $_GET['type']==3)){
                        $zf_active = false;
                        if($_GET['type'] == 2){
                            $sp_active = true;
                        }elseif($_GET['type'] == 3){
                            $xzl_active = true;
                        }
                    }
                }
            }
            // 整租合租查找
            $allTags = TagExt::getAllByCate();
            $rentTypes = (isset($allTags['zfmode']) && $allTags['zfmode']) ? $allTags['zfmode'] : [];
            if($rentTypes) {
                foreach ($rentTypes as $key => $value) {
                    $tmp[$value['name']] = $value['id'];
                }
                $rentTypes = $tmp;
            }

            $this->menu = array(
                array('label'=>'首页', 'url'=>array('/resoldhome/index/index'),'active'=>$this instanceof IndexController),
                array('label'=>'二手房','url'=>array('/resoldhome/esf/list'),'active'=>$esf_active,'items'=>array(
                    array('label'=>'在售房源','url'=>array('/resoldhome/esf/list')),
                    array('label'=>'个人房源','url'=>array('/resoldhome/esf/list?source=1')),
                    array('label'=>'邻校房','url'=>array('/resoldhome/school/index')),
                    array('label'=>'找小区','url'=>array('/resoldhome/plot/list')),
                    array('label'=>'找经纪人','url'=>array('/resoldhome/staff/staffList')),
                    array('label'=>'求购','url'=>array('/resoldhome/qg/index')),
                    array('label'=>'我要卖房','url'=>array('/resoldhome/myesf/sellinput'))
                )),
                array('label'=>'租房','url'=>array('/resoldhome/zf/list'),'active'=>$zf_active,'items'=>array(
                    array('label'=>'个人租房','url'=>array('/resoldhome/zf/list?source=1')),
                    array('label'=>'整租房源','url'=>array('/resoldhome/zf/list?way='.($rentTypes&&isset($rentTypes['整租'])?$rentTypes['整租']:''))),
                    array('label'=>'合租房源','url'=>array('/resoldhome/zf/list?way='.($rentTypes&&isset($rentTypes['合租'])?$rentTypes['合租']:''))),
                    array('label'=>'求租','url'=>array('/resoldhome/qz/index')),
                    array('label'=>'我要出租','url'=>array('/resoldhome/myzf/rentinput')),
                )),
                array('label'=>'写字楼','url'=>array('/resoldhome/esf/list?type=3'),'active'=>$xzl_active,'items'=>array(
                    array('label'=>'写字楼出售','url'=>array('/resoldhome/esf/list?type=3')),
                    array('label'=>'写字楼出租','url'=>array('/resoldhome/zf/list?type=3')),
                    array('label'=>'写字楼求购','url'=>array('/resoldhome/qg/index?type=3')),
                    array('label'=>'写字楼求租','url'=>array('/resoldhome/qz/index?type=3'))
                )),
                array('label'=>'商铺','url'=>array('/resoldhome/esf/list?type=2'),'active'=>$sp_active,'items'=>array(
                    array('label'=>'商铺出售','url'=>array('/resoldhome/esf/list?type=2')),
                    array('label'=>'商铺出租','url'=>array('/resoldhome/zf/list?type=2')),
                    array('label'=>'商铺求购','url'=>array('/resoldhome/qg/index?type=2')),
                    array('label'=>'商铺求租','url'=>array('/resoldhome/qz/index?type=2'))
                )),
            );
            // 关闭的导航元素
            $closedItems = SM::resoldNavConfig()->resoldPCNavConfig();
            foreach ($this->menu as $key => $value) {
                if(in_array($value['label'], $closedItems)) {
                    $this->menu[$key]['visible'] = false;
                }
                if(isset($value['items']))
                    foreach ($value['items'] as $k => $v) {
                        if(in_array($v['label'], $closedItems)) {
                            $this->menu[$key]['items'][$k]['visible'] = false;
                        }
                    }
            }
            if($extNavs = SM::resoldNavConfig()->homePlotIndexNav()) {

                foreach ($extNavs['name'] as $key => $value) {
                    array_push($this->menu, ['label'=>$value,'linkOptions'=>['target'=>'_blank'],'url'=>$extNavs['url'][$key]]);
                }
            }
        }
        return $this->menu;
    }

    /**
     * [getWapUrl 二手房pc跳wap规则]
     * @return [type] [description]
     */
    public function getWapUrl()
    {
        $url = Yii::app()->request->getUrl();
        $pathInfo = Yii::app()->request->getPathInfo();
        preg_match_all('/[a-z]+\/[a-z]+\/[a-z]+/', $pathInfo,$match);
        $pathInfo = $match&&$match[0]?$match[0][0]:Yii::app()->request->getPathInfo();

        // 首页地址
        $index = Yii::app()->request->getHostInfo().'/resoldwap/#/index';
        // 列表页
        $listConfigArr = [
        '/resoldhome'=>'index',
        '/resoldhome/index/index'=>'index',
        '/resoldhome/esf/list'=>             'list/sell/esf/////////',
        '/resoldhome/esf/list?type=2'=>      'list/sell/sp////////',
        '/resoldhome/esf/list?type=3'=>      'list/sell/xzl////////',
        '/resoldhome/zf/list'=>              'list/rent/esf/////////',
        '/resoldhome/zf/list?type=2'=>       'list/rent/sp////////',
        '/resoldhome/zf/list?type=3'=>       'list/rent/xzl////////',
        '/resoldhome/qg/index'=>             'list/qg/esf////////',
        '/resoldhome/qg/index?type=2'=>      'list/qg/sp///////',
        '/resoldhome/qg/index?type=3'=>      'list/qg/xzl///////',
        '/resoldhome/qz/index'=>             'list/qz/esf////////',
        '/resoldhome/qz/index?type=2'=>      'list/qz/sp///////',
        '/resoldhome/qz/index?type=3'=>      'list/qz/xzl///////',
        '/resoldhome/plot/list'=>            'list/xiaoqu////////',
        '/resoldhome/school/index'=>         'schoolhouse/////',
        '/resoldhome/my/index'=>             'my',
        ];
        // 房源详情页
        $infoConfigArr = [
        'resoldhome/esf/info' => [1=>'detail/sell/zz',2=>'detail/sell/sp',3=>'detail/sell/xzl','model'=>'ResoldEsfExt'],
        'resoldhome/zf/info' => [1=>'detail/rent/zz',2=>'detail/rent/sp',3=>'detail/rent/xzl','model'=>'ResoldZfExt'],
        'resoldhome/qg/detail' => [1=>'detail/qg/zz',2=>'detail/qg/sp',3=>'detail/qg/xzl','model'=>'ResoldQgExt'],
        'resoldhome/qz/detail' => [1=>'detail/qz/zz',2=>'detail/qz/sp',3=>'detail/qz/xzl','model'=>'ResoldQzExt'],
        ];
        // 小区页面
        $plotConfigArr = [
        'resoldhome/plot/index' => 'list/xiaoqu/////////xiaoqu/infoid',
        'resoldhome/plot/pesflist' => 'detail/xiaoqu/infoid/esflist/////',
        'resoldhome/plot/pzflist' => 'detail/xiaoqu/infoid/zflist/////',
        ];

        if(in_array($url, array_keys($listConfigArr)))
        {
            $this->redirect(Yii::app()->request->getHostInfo().'/resoldwap/#/'.$listConfigArr[$url]);
        }elseif(in_array($pathInfo, array_keys($infoConfigArr)) && $infoId = Yii::app()->request->getQuery('id')) {
            $model = $infoConfigArr[$pathInfo]['model'];
            $obj = $model::model()->findByPk($infoId);
            if($obj)
                $this->redirect(Yii::app()->request->getHostInfo().'/resoldwap/#/'.$infoConfigArr[$pathInfo][$obj->category].'/'.$infoId);
        }elseif(strstr($pathInfo,'resoldhome/plot')) {
            if(in_array($pathInfo, array_keys($plotConfigArr)) && $py = Yii::app()->request->getQuery('py')) {

                $plot = PlotExt::model()->find(['condition'=>'pinyin=:py','params'=>[':py'=>$py]]);
                if($plot) {
                    $plotUrl = str_replace('infoid', $plot->id, $plotConfigArr[$pathInfo]);
                    $this->redirect(Yii::app()->request->getHostInfo().'/resoldwap/#/'.$plotUrl);
                }
            }else {
                $this->redirect(Yii::app()->request->getHostInfo().'/resoldwap/#/list/xiaoqu////////');
            }
        }elseif(strstr($pathInfo,'resoldhome/school')) {
            if($pathInfo == 'resoldhome/school/plot' && $pinyin = Yii::app()->request->getQuery('pinyin')) {
                $school = SchoolExt::model()->find(['condition'=>'pinyin=:py','params'=>[':py'=>$pinyin]]);
                if($school) {
                    $this->redirect(Yii::app()->request->getHostInfo().'/resoldwap/#/schooldetail/'.$school->id);
                }
            }else {
                $this->redirect(Yii::app()->request->getHostInfo().'/resoldwap/#/schoolhouse/////');
            }
        }elseif(strstr($pathInfo,'resoldhome/map/index')) {
            $type = Yii::app()->request->getQuery('type',1);
            $this->redirect(Yii::app()->request->getHostInfo().'/resoldwap/#/map/'.$type);
        }
        else {
            $this->redirect($index);
        }
    }


}
