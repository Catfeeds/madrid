<?php
/**
 	 * 租房
     * @author liyu
     * @created 2016年10月30日14:59:45
*/
class ZfController extends ResoldHomeController{
    /**
	 * [$viewRecordor 房源浏览记录器]
	 * @var [type]
	 */
	public $viewRecordor;
    /**
     * [$get GET]
     * [$otherParams 其他数据]
     * @var [string]
     */
    public $get;
    public $otherParams;
    public $zf;
    public $staff;
	public function init()
    {
        parent::init();
        $this->viewRecordor = new ResoldViewRecordor;
    }
    /**
 	 * 租房
	 */
	public function actions(){
        $alias = 'resoldhome.controllers.zf.';
        return array(
            'list'=>$alias.'ListAction',
            'info'=>$alias.'InfoAction',
        );
    }

}
