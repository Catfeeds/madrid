<?php

class VipModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
            // you may place code here to customize the module or the application

            // import the module-level models and components
            $this->setImport(array(
                'vip.models.*',
                'vip.components.*',
                'vip.widgets.*'

            ));
        Yii::app()->setComponents(array(
            //系统js设置
            'clientScript' => array(
                'scriptMap' => array(
                    'jquery.js' => false,//不加载系统自带的jquery
                    'jquery.min.js' => false,//不加载系统自带的jquery
                ),
                'coreScriptPosition' => CClientScript::POS_END,	//核心js加载到网页尾部
            ),
            'user' => array(
                'allowAutoLogin' => true,
                'loginUrl' => Yii::app()->createUrl('vip/common/login'),
                'stateKeyPrefix' => '_vip',
                'authTimeout' => 3600 * 2,//用户登录后2小时不活动则过期，需要重新登陆
            ),
        ));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
