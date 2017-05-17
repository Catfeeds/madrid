<?php

/**
 * 后台模块vip控制器基类
 * @author steven.allen
 * @date 2016-08-29
 */
class VipieController extends Controller {

    private $menu;
    /**
     * [$staff 当前职员]
     * @var [type]
     */
    protected $staff;

    public function init(){
        parent::init();
        $this->staff = ResoldStaffExt::model()->findStaffByUid(28);
    }
    /**
     * 过滤器
     */
    public function filters() {
        return array(
            // 'accessControl - vipie/common/login,vipie/common/logout,vipie/common/init',
            // 'sensitiveWordControl + vipie/esf/publish,vipie/esf/publish'
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
     * @var string 布局文件路径
     */
    public $layout = '/layouts/base';

    /**
     * @var array 当前访问页面的面包屑. 这个值将被赋值给links属性{@link CBreadcrumbs::links}.
     */
    public $breadcrumbs = array();

    public function getMenu(){
        if(empty($this->menu)) {
            $this->menu = [
                ['label' => '管理中心', 'url' => array('/vipie/common/index'), 'itemOptions' => ['class' => 'n1'], 'linkOptions' => ['class' => 'icon-setting n1-link']],
                ['label' => '管理二手房', 'url' => 'javascript:;', 'itemOptions' => ['class' => 'n1'], 'linkOptions' => ['class' => 'icon-esf n1-link'], 'items' => [
                    ['label' => '发布二手房', 'url' => array('/vipie/esf/publish')],
                    ['label' => '上架二手房', 'url' => array('/vipie/esf/saleUp')],
                    ['label' => '下架二手房', 'url' => array('/vipie/esf/saleDown')]
                ]],
                ['label' => '管理租房', 'url' => 'javascript:;', 'itemOptions' => ['class' => 'n1'], 'linkOptions' => ['class' => 'icon-esf n1-link'], 'items' => [
                    ['label' => '发布租房', 'url' => array('/vipie/zf/publish')],
                    ['label' => '上架租房', 'url' => array('/vipie/zf/saleUp')],
                    ['label' => '下架租房', 'url' => array('/vipie/zf/saleDown')]
                ]],
                ['label'=>'商铺管理','url'=>'javascript:;','itemOptions'=>['class'=>'n1'],'linkOptions' => ['class' => 'icon-shop n1-link'],'items'=>[
                    ['label'=>'商家档案','url'=>['/vipie/shop/info']],
                    ['label'=>'职员管理','url'=>['/vipie/shop/staff']]
                ]],
            ];
        }
        return $this->menu;
    }

    /**
     * 这个方法在被执行的动作之前、在所有过滤器之后调用
     * @param CAction $action 被执行的控制器
     * @return boolean whether 控制器是否被执行
     */
    protected function beforeAction($action) {
        if(isset(Yii::app()->user->uid)) {
            $this->staff = ResoldStaffExt::model()->findStaffByUid(Yii::app()->user->uid);
        }
        return parent::beforeAction($action);
    }

    /**
     * [actionAjaxGetImgs 根据hid获得楼盘图片]
     * @return [type] [description]
     */
    public function actionAjaxGetImgs($hid)
    {
        $images = [];
        $imgs = PlotImgExt::model()->findAll(array('condition'=>'hid=:hid','params'=>[':hid'=>$hid],'limit'=>30));
        if(!$imgs)
        {
            echo CJSON::encode(['msg'=>'error']);
        }
        else
        {
            foreach ($imgs as $key => $value) {
                $tmp['image'] = ImageTools::fixImage($value['url']);
                $tmp['ori_image'] = $value['url'];
                $tmp['img_id'] = $value['id'];
                $images['data'][] = $tmp;
            }
            $images['msg'] = 'success';
            $images['addr'] = $imgs?$imgs[0]->plot->address:'';
            echo CJSON::encode($images);
        }
    }


}
