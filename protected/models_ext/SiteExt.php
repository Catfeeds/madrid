<?php 
/**
 * 站点配置类
 * 数据结构为 name为 qjpz value为 属性分类的key-value组成的json数据
 * @author steven.allen <[<email address>]>
 * @date(2017.2.13)
 */
class SiteExt extends Site{

    // 属性
    public static $cates = [
        // pc首页轮播图
        'pcIndexImages'=>[],
        // pcLogo
        'pcLogo'=>'',
        // 站点客服
        'sitePhone'=>'',
        // 联系qq
        'qq'=>'',
        // 微信二维码
        'wxQr'=>'',
        // pc首页新闻背景图
        'pcIndexNews'=>'',
        // pc首页关于背景图
        'pcIndexAbout'=>'',
        // pc首页服务背景图
        'pcIndexServe'=>'',
        // pc首页关于
        'pcIndexAboutText'=>'',
        // pc资讯列表头图
        'pcNewsTop'=>'',
        // pc联系列表头图
        'pcContactTop'=>'',
        // pc服务列表头图
        'pcServeTop'=>'',
        // pc团队列表头图
        'pcTeamTop'=>'',
        // 产品默认图
        'productNoPic'=>'',
        // 酒庄默认图
        'houseNoPic'=>'',

    ];
    public static $cateName = [
        'qjpz' => '全局配置',
    ];

    // 属性分类
    public static $cateTag = [
        'qjpz'=> [
            'pcIndexImages'=>['type'=>'multiImage','max'=>3,'name'=>'pc首页轮播图'],
            'pcLogo'=>['type'=>'image','max'=>1,'name'=>'pc版logo'],
            'sitePhone'=>['type'=>'text','name'=>'站点客服'],
            'qq'=>['type'=>'text','name'=>'联系qq'],
            'pcIndexAboutText'=>['type'=>'text','name'=>'pc首页关于'],
            'wxQr'=>['type'=>'image','max'=>1,'name'=>'微信二维码'],
            'pcIndexNews'=>['type'=>'image','max'=>1,'name'=>'pc首页新闻背景图'],
            'pcIndexAbout'=>['type'=>'image','max'=>1,'name'=>'pc首页关于背景图'],
            'pcIndexServe'=>['type'=>'image','max'=>1,'name'=>'pc首页服务背景图'],
            'pcNewsTop'=>['type'=>'image','max'=>1,'name'=>'pc资讯列表头图'],
            'pcContactTop'=>['type'=>'image','max'=>1,'name'=>'pc联系列表头图'],
            'pcServeTop'=>['type'=>'image','max'=>1,'name'=>'pc服务列表头图'],
            'pcTeamTop'=>['type'=>'image','max'=>1,'name'=>'pc团队列表头图'],
            'productNoPic'=>['type'=>'image','max'=>1,'name'=>'产品默认图'],
            'houseNoPic'=>['type'=>'image','max'=>1,'name'=>'酒庄默认图'],
            ],
    ];

	/**
     * 定义关系
     */
    public function relations()
    {
        return array(
            // 'baike'=>array(self::BELONGS_TO, 'BaikeExt', 'bid'),
        );
    }

    /**
     * @return array 验证规则
     */
    public function rules() {
        $rules = parent::rules();
        return array_merge($rules, array(
            array(implode(",", array_keys(self::$cates)) ,'safe'),
        ));
    }

    /**
     * 返回指定AR类的静态模型
     * @param string $className AR类的类名
     * @return CActiveRecord Admin静态模型
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function afterFind() {
        parent::afterFind();
    }

    public function beforeValidate() {
        if($this->getIsNewRecord())
            $this->created = $this->updated = time();
        else
            $this->updated = time();
        return parent::beforeValidate();
    }

    /**
     * 命名范围
     * @return array
     */
    public function scopes()
    {
        $alias = $this->getTableAlias();
        return array(
            'sorted' => array(
                'order' => 'sort desc',
            )
        );
    }

    // 重写get魔术方法
    public function __get($value)
    {
        if(in_array($value, array_keys(self::$cates))) {
            $dc = json_decode($this->value,true);
            if($dc && isset($dc[$value])) {
                return $dc[$value];
            }
        } else {
            return parent::__get($value);
        }
    }

    // 重写set魔术方法
    public function __set($name, $value)
    {
        if(isset(self::$cates[$name])) {
            if(is_array($this->value))
                $data_conf = $this->value;
            else
                $data_conf = CJSON::decode($this->value);
            self::$cates[$name] = $value;
            $data_conf[$name] = $value;
            $this->value = json_encode($data_conf);
        }
        else
            parent::__set($name, $value);
    }

    /**
     * 通过name获取
     */
    public function getSiteByCate($cate)
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition' => 'name=:cate',
            'order' => 'id ASC',
            'params' => array(':cate'=>$cate)
        ));
        return $this;
    }

    public static function getAttr($cate='',$attr='')
    {
        $model = self::model()->getSiteByCate($cate)->find();
        return $model->$attr?$model->$attr:'';

    }

}