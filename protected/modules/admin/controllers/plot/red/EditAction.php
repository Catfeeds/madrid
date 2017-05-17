<?php
/**
 * 楼盘评红包编辑页
 * @author steven.allen
 * @version 2016-05-04
 */
class EditAction extends CAction
{
    public function run($hid,$id=0)
    {
        $this->controller->layout = '/layouts/modal_base';
        $hid = (int)$hid;
        $id = (int)$id;

        if($id){
            $model = PlotRedExt::model()->findByPk($id);
        } else {
            $model = new PlotRedExt;
        }

        if(Yii::app()->request->getIsPostRequest()){
            $pr = Yii::app()->request->getPost('PlotRedExt', array());
            $pr['hid'] = $hid;
            $model->attributes = $pr;
            if($model->save()){
                $this->controller->setMessage('保存成功！', 'success', array('redList','hid'=>$hid));
            }else{
                $msg = $model->hasErrors() ? current(current($model->getErrors())) : '保存失败';
                $this->controller->setMessage($msg, 'error');
            }
        }

        $this->controller->render('red/edit', array(
            'model' => $model,
            'hid' => $hid,
        ));
    }
}
