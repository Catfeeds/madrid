<?php
/**
 * 添加/修改套餐信息
 * @author  steven.allen
 * @date 2016.08.24
  */
class PackageEditAction extends CAction
{
    public function run($id=0)
    {
        $new_package = $id == 0 ? new ResoldTariffPackageExt() : ResoldTariffPackageExt::model()->findByPk($id);
    	if(Yii::app()->request->isPostRequest)
    	{
            $values = Yii::app()->request->getPost('ResoldTariffPackageExt',[]);
            $new_package->attributes = $values;
            $new_package->content = json_encode($new_package->content);
            if($new_package->save())
            {
                $this->controller->redirect('packageList');
            }
            else
            {
                // var_dump($new_package->errors);
                $this->controller->setMessage('保存失败','error');
            }
            
    	}
        if($new_package)
            $new_package->content = json_decode($new_package['content'],true);
        $this->controller->render('packageEdit',['package'=>$new_package]);
    }
}
