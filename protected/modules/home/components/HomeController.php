<?php
/**
 * 前台模块home控制器基类
 * @author weibaqiu
 * @date 2015-09-22
 */
class HomeController extends Controller
{
    //关键字
    private $keyword;

    //描述
    private $description;
    public $banner = 'nobanner';
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

    public function getKeyword(){
        if($this->keyword === null){
            $this->keyword = '里奥哈葡萄酒,进口红酒,西班牙红酒,里奥哈酒庄,进口顶级红酒';
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
            $this->description = '马德里公馆主营西班牙进口红酒,介绍西班牙里奥哈葡萄酒历史、文化和知识。为追求品质吃喝的你带来高价值的红酒及橄榄油科普,提供全国线下产品体验中心。';
        }
        return $this->description;
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
        if(Yii::app()->uc->user->hasFlash('synloginHtml')){
            $output .= Yii::app()->uc->user->getFlash('synloginHtml');
        }
    }

}
