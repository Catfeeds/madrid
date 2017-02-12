<?php
/**
 * 最近浏览的楼盘记录器
 */
class ResoldViewRecordor extends CComponent
{
    /**
     * cookie 名称
     */
    const COOKIE_NAME = 'recent_view_resold';
    /**
     * 存放浏览的楼盘id
     * @var array
     */
    private $_list = [];
    /**
     * 存放浏览的楼盘数据
     * @var array
     */
    private $_listData = [];

    public $categoryArr = [
        1=>'ResoldEsfExt',
        2=>'ResoldZfExt',
        3=>'ResoldQgExt',
        4=>'ResoldQzExt'
    ];

    private $_category = 1;

    public function __construct()
    {
        $this->getFromCookie();
    }

    /**
     * 将数据存储在cookie中
     * @return boolean
     */
    private function storeToCookie()
    {
        $cookie = new CHttpCookie(self::COOKIE_NAME, CJSON::encode($this->_listData), array(
            'expire' => time() + 3600*24*30
        ));
        Yii::app()->request->cookies[self::COOKIE_NAME] = $cookie;
        return true;
    }

    /**
     * 从cookie中获取浏览记录
     * @return array
     */
    private function getFromCookie()
    {
        $cookie = Yii::app()->request->getCookies();
        if(isset($cookie[self::COOKIE_NAME]) && $data = CJSON::decode($cookie[self::COOKIE_NAME]->value,true)){
            $this->_listData = $data;
        }

    }

    /**
     * 记录当前浏览楼盘
     * @param PlotExt $plot 要记录的楼盘AR类
     */
    public function add($id=0,$type=1)
    {
        $this->_category = $type;
        if($this->_listData)
            foreach ($this->_listData as $key => $value) {
                if($value['type']==$this->categoryArr[$type] && $value['id']==$id)
                    return '';
            }
        $this->_listData[] = ['id'=>$id,'type'=>$this->categoryArr[$type],'time'=>time()];
        if($this->getTotal()>10){
            array_shift($this->_listData);
        }
        $this->storeToCookie();
    }

    /**
     * 移除指定楼盘浏览记录，暂未实现，用不到
     */
    public function remove()
    {

    }

    /**
     * 获取浏览的楼盘AR实例
     * @return PlotExt[] 返回数组
     */
    public function getViewedInfos($type=0,$category=1,$limit=4)
    {
        $return = array();

        if(!$type && $this->_listData)
        {
            $listData = array_slice(array_reverse($this->_listData),0,$limit);
            foreach ($listData as $key => $value) {
                $model = $value['type'];
                $return[] = $model::model()->findByPk($value['id']);
            }
        }
        elseif(is_array($this->_listData) && $this->_listData){
            foreach (array_reverse($this->_listData) as $key => $value) {
                if(($model = $value['type'])==$this->categoryArr[$type])
                    $return[] = $model::model()->findByPk($value['id']);
                if(count($return)>=$limit)
                    return $return;
            }
        }
        return $return;
    }

    /**
     * 获取当前已经记录的浏览量
     * @return integer
     */
    public function getTotal()
    {
        return count($this->_listData);
    }
}
