<?php 
/**
 * 楼盘类
 * @author steven.allen <[<email address>]>
 * @date(2017.2.14)
 */
class PlotExt extends Plot{

    public static $tags = [
        'pinyin'=>'',
        'sale_status'=>'',
        'open_time'=>'',
        'delivery_time'=>'',
        'address'=>'',
        'sale_addr'=>'',
        'sale_tel'=>'',
        'map_lng'=>'',
        'map_lat'=>'',
        'map_zoom'=>'',
        // 'image'=>'',
        'price'=>'',
        'buildsize'=>'',
        'size'=>'',
        'capacity'=>'',
        'green'=>'',
        'manage_fee'=>'',
        'manage_company'=>'',
        'developer'=>'',
        'property_years'=>'',
        'household_num'=>'',
        'building_num'=>'',
        'floor_desc'=>'',
        // 'transit'=>'',
        // 'content'=>'',
        // 'peripheral'=>'',
        'wylx'=>'',
        'jzlb'=>'',
        'xmts'=>'',
        'zxzt'=>'',
        ''
    ];


    /**
     * @return array 验证规则
     */
    public function rules() {
        $rules = parent::rules();
        return array_merge($rules, array(
            array(implode(',',array_keys(self::$tags)), 'safe')
        ));
    }

    public function __set($name='',$value='')
    {
       if (isset(self::$tags[$name])){
            if(is_array($this->data_conf))
                $data_conf = $this->data_conf;
            else
                $data_conf = CJSON::decode($this->data_conf);
            self::$tags[$name] = $value;
            $data_conf[$name] = $value;
            $this->data_conf = json_encode($data_conf);
        }
        else
            parent::__set($name, $value);
    }

    public function __get($name='')
    {
        if (isset(self::$tags[$name])) {
            if(is_array($this->data_conf))
                $data_conf = $this->data_conf;
            else
                $data_conf = CJSON::decode($this->data_conf);

            if(!isset($data_conf[$name]))
                $value = self::$tags[$name];
            else
                $value = self::$tags[$name] ? self::$tags[$name] : $data_conf[$name];

            return $value;
        } else{
            return parent::__get($name);
        }
    }
	/**
     * 定义关系
     */
    public function relations()
    {
        return array(
            'hxs'=>array(self::HAS_MANY, 'PlotHxExt', 'hid'),
            'images'=>array(self::HAS_MANY, 'PlotImageExt', 'hid'),
        );
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

    public function afterSave()
    {
        parent::afterSave();
        if($this->deleted==1) {
            if($hxs = $this->hxs) {
                foreach ($hxs as $key => $value) {
                    $value->deleted = 1;
                    $value->save();
                }
            }
            if($images = $this->images) {
                foreach ($images as $key => $value) {
                    $value->deleted = 1;
                    $value->save();
                }
            }
        }
            
    }

    /**
     * 命名范围
     * @return array
     */
    public function scopes()
    {
        $alias = $this->getTableAlias();
        return array(
            'undeleted' => array(
                'condition' => $alias.'.'.'deleted=0',
            )
        );
    }
    /**
     * 绑定行为类
     */
    public function behaviors() {
        return array(
            'CacheBehavior' => array(
                'class' => 'application.behaviors.CacheBehavior',
                'cacheExp' => 0, //This is optional and the default is 0 (0 means never expire)
                'modelName' => __CLASS__, //This is optional as it will assume current model
            ),
            'BaseBehavior'=>'application.behaviors.BaseBehavior',
        );
    }
}