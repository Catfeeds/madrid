<?php

class UrmModule extends CWebModule {
	public function init() {
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
				 'urm.models.*',
				 'urm.models_ext.*',
				 'urm.components.*',
		 ));

		Yii::app()->setComponents(array(
				  'errorHandler' => array(
						  'errorAction' => 'urm/default/error',
				  )
		  ));
		  Yii::app()->user->setStateKeyPrefix('_urm');
	}

	public function beforeControllerAction($controller, $action) {
		if (parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
