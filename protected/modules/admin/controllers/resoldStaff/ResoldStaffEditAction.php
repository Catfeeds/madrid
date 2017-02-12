<?php
/**
 * 添加/修改商家职员信息
 * @author  steven.allen
 * @date 2016.08.24
  */
class ResoldStaffEditAction extends CAction
{
    public function run($id=0)
    {
    	if(Yii::app()->request->isPostRequest)
    	{
            $values = Yii::app()->request->getPost('ResoldStaffExt',[]);
            $new_staff = $id == 0 ? new ResoldStaffExt :ResoldStaffExt::model()->findByPk($id);
            $new_staff->uid = Yii::app()->request->getPost('true_uid',0);
           
            if($new_staff->sid && $new_staff->sid != $values['sid']) {
                $new_staff->scenario = 'changeShop'; // 换商家场景
            } elseif($new_staff->phone && $new_staff->phone != $values['phone']) {
                $new_staff->scenario = 'changePhone'; // 换手机号场景
            } elseif($new_staff->name && $new_staff->name != $values['name']) {
                $new_staff->scenario = 'changeName'; // 换姓名场景
            } else {
                $new_staff->scenario = '';
            }

            $new_staff->attributes = $values;

            if($new_staff->save())
            {
                if($new_staff->scenario) {
                    $new_staff->changeInfos();
                }
                //保存关联套餐
                $new_staff->savePackage();
                $this->controller->setMessage('保存成功','success');
                $this->controller->redirect('resoldStaffList');
            }
            else
            {
                $this->controller->setMessage(array_values($new_staff->errors)[0][0],'error');
            }
            
    	}
    	$staff = $id == 0 ? new ResoldStaffExt : ResoldStaffExt::model()->findByPk($id);
        $this->controller->render('staffEdit',['staff'=>$staff]);
    }
}
