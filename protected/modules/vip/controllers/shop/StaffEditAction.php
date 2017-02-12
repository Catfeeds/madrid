<?php
/**
 * 添加/修改职员
 * @author  steven.allen
 * @date 2016.09.02
  */
class StaffEditAction extends CAction
{
    public function run($id=0)
    {
        if(Yii::app()->request->isPostRequest)
        {
            $values = Yii::app()->request->getPost('ResoldStaffExt',[]);
            $new_staff = $id == 0 ? new ResoldStaffExt :ResoldStaffExt::model()->findByPk($id);
            $new_staff->attributes = $values;
            if($new_staff->save())
            {
                //保存关联套餐
                $new_staff->savePackage();
                $this->controller->setMessage('保存成功','success');
                $this->controller->redirect('staff');
            }
            else
            {
                var_dump($new_staff->errors);exit;
                $this->controller->setMessage('保存失败','error');
            }
        }
        $staff = $id == 0 ? new ResoldStaffExt : ResoldStaffExt::model()->findByPk($id);
        $this->controller->render('staffEdit',['staff'=>$staff]);
    }
}
