<?php
/**
 * 站点相关控制器
 * @author weibaqiu
 * @date 2015-09-24
 */
class SiteController extends AdminController
{
    /**
	 * 权限控制
	 */
	public function RBACRules()
	{
		return array(
            array('allow',
                'actions' => array('cacheManager'),
                'users'=>array('@'),
            ),
			//集客所有内容的权限设置
			array('allow',
				'roles' => array('zhandianpeizhi'),
			),
			array('deny',
				'users'=>array('*')
			)
		);
	}

    public function actions()
    {
        $alias = 'admin.controllers.resoldSite.';
        return array(
            'resoldSiteSettingMap' => $alias.'MapAction',
            'resoldSiteSetting' => $alias.'SetAction',
        );
    }

    /**
     * 配置中心导航
     */
    public function actionSiteSettingMap($search='')
    {
        $map = [];
        $allConfig = SM::getAll();
        if($search) {
            foreach($allConfig as $model) {
                foreach($model->attributes as $pinyin => $attribute) {
                    if(strpos($model->attributeLabels()[$pinyin], $search)!==false || strpos($attribute->description, $search)!==false) {
                        $map[$model->getClassName()] = $model;
                    }
                }
            }
        } else {
            $map = $allConfig;
        }

        $this->render('sitesettingmap', ['map'=>$map, 'search'=>$search]);
    }

    public function actionSiteSetting($type)
    {
        try{
            $model = SM::$type();
        }catch(Exception $e) {
            throw new CHttpException(500, '参数不正确');
        }

        if(Yii::app()->request->getIsPostRequest() && $postData = Yii::app()->request->getPost(get_class($model), null)) {
            $model->attributes = $postData;
            if($model->save()) {
                $this->setMessage('保存成功', 'success');
            } else {
                $msg = $model->hasErrors() ? current(current($model->getErrors())) : '保存失败！';
                $this->setMessage($msg, 'error');
            }
        }

        $this->render('sitesetting', ['model'=>$model]);
    }

    /**
     * 站点配置
     */
    public function actionSiteConfig()
    {
        $model = SiteConfigModel::model();
        if(Yii::app()->request->isPostRequest)
        {
            $model->attributes = Yii::app()->request->getPost('SiteConfigModel', array());
            if($model->save())
                $this->setMessage('保存成功！', 'success');
            else
            {
                $msg = $model->hasErrors() ? current(current($model->getErrors())) : '保存失败！';
                $this->setMessage($msg, 'error');
            }
        }
        $this->render('siteconfig', array(
            'model' => $model,
        ));
    }

    /**
     * 开关配置页面
     */
    public function actionSwitchConfig()
    {
        $model = SwitchConfigModel::model();
        if(Yii::app()->request->isPostRequest){
            $model->attributes = Yii::app()->request->getPost('SwitchConfigModel', array());
            if($model->save()){
                $this->setMessage('保存成功！', 'success');
            }else{
                $msg = $model->hasErrors() ? current(current($model->errors)) : '保存失败';
                $this->setMessage($msg, 'error');
            }
        }
        $this->render('switchconfig', array(
            'model' => $model,
        ));
    }

    /**
     * 对配置项单个字段进行配置
     * @param  string $attr 配置项名称，SiteConfigModel中的一个属性名
     */
    public function actionEditSiteConfigAttr()
    {
        if($data = Yii::app()->request->getPost('QqModel'))
        {
            $model = new QqModel;
            $model->attributes = $data;
            $model->save();
        }
    }

    /**
     * 导入数据接口配置
     * @return [type] [description]
     */
    public function actionImportApiConfig()
    {
        $model = SiteConfigModel::model();
        if(Yii::app()->request->isPostRequest)
        {
            $model->attributes = Yii::app()->request->getPost('SiteConfigModel', array());
            if($model->save())
                $this->setMessage('保存成功！', 'success');
            else
                $this->setMessage('保存失败！', 'error');
        }
        $this->render('importapiconfig', array(
            'model' => $model,
        ));
    }

    /**
     * 缓存管理
     */
    public function actionCacheManager($name='')
    {
        $id = Yii::app()->request->getQuery('id','');
        if($id)
        {
            CacheExt::delete($id);
            $this->setMessage('删除成功！', 'success', array('cacheManager'));
        }
        $list = CacheExt::getCacheMap();

        if(!empty($name))
        {
            $_list = array();
            foreach($list as $k=>$v)
            {
                if(strpos($v[1], $name)!==false)
                {
                    $_list[$k] = $v;
                }
            }
            $list = $_list;
        }
        $pager = new CPagination(count($list));
        $pager->pageSize = 20;
        $list = array_splice($list, $pager->offset, $pager->limit);

        $this->render('cachemanager', array(
            'list' => $list,
            'pager' => $pager,
            'name' => $name
        ));
    }

    /**
     * 后台操作日志
     */
    public function actionLog($action='')
    {
        $criteria = new CDbCriteria(array(
            'order'=>'created desc'
        ));
        if($action){
            $criteria->addCondition('action=:action');
            $criteria->params[':action'] = $action;
        }
        $dataProvidor = ActiveRecordLogExt::model()->getList($criteria);
        $data = $dataProvidor->data;
        $pager = $dataProvidor->pagination;
        $this->render('log', array(
            'data' => $data,
            'pager' => $pager,
        ));
    }
}
?>
