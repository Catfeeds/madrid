<?php
/**
 * 楼盘评点评编辑页
 * @author weibaqiu
 * @version 2016-04-28
 */
class EditAction extends CAction
{
    public function run($hid,$id=0)
    {
        $this->controller->layout = '/layouts/modal_base';
        $hid = (int)$hid;
        $id = (int)$id;
        if(!$plot = PlotExt::model()->findByPk($hid)) {
            throw new CHttpExpcetion(404, '楼盘不存在');
        }

        if($id){
            $model = PlotCommentExt::model()->findByPk($id);
        } else {
            $model = new PlotCommentExt;
        }

        if(Yii::app()->request->getIsPostRequest()){
            //传入该字hid段的值由于需要参与验证器的rules配置，所以不能在验证器实例后再赋值
            //也就是说不能在给attributes赋值后再给hid赋值，那时验证器已经生成了实例了，顺序要注意
            $model->hid = $hid;
            $model->attributes = Yii::app()->request->getPost('PlotCommentExt', array());
            if($model->save()){
                $this->controller->setMessage('保存成功！', 'success', array('commentList','hid'=>$hid));
            }else{
                $msg = $model->hasErrors() ? current(current($model->getErrors())) : '保存失败';
                $this->controller->setMessage($msg, 'error');
            }
        }

        $staffs = array();
        foreach(StaffExt::model()->normal()->findAll() as $staff){
            $staffs[$staff->id] = $staff->username.'('.$staff->name.')';
        }
        $this->controller->render('comment/edit', array(
            'model' => $model,
            'staffs' => $staffs,
            'hid' => $hid,
        ));
    }
}
