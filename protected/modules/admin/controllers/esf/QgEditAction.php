<?php
/**
 * 求购二手房信息
 * @author  steven.allen
 * @date 2016.08.19
  */
class QgEditAction extends CAction
{
    public function run($id=0)
    {
        $new_qg = $id == 0 ? new ResoldQgExt : ResoldQgExt::model()->findByPk($id);
    	if(Yii::app()->request->isPostRequest)
    	{
            $model = Yii::app()->request->getPost('ResoldQgExt',[]);
            // $new_qg = $id == 0 ? new ResoldQgExt : ResoldQgExt::model()->findByPk($id);
            $new_qg->scenario = Yii::app()->params['categoryPinyin'][$model['category']];

            $new_qg->attributes = $model;
            //标签放data_conf
            if($tags = array_filter($model['tags']))
            {
                $transTags = [];
                foreach ($tags as $key => $value) {
                    if(is_array($value))
                        $transTags = array_merge($transTags,$value);
                    else
                        $transTags[] = $value;
                }
                if($postTags = Yii::app()->request->getPost('tags',[]))
                foreach ($postTags as $key => $value) {
                    if(is_array($value))
                        $transTags = array_merge($transTags,$value);
                    else
                        $transTags[] = $value;
                }
                $new_qg->data_conf = json_encode(['tags'=>array_filter($transTags)]);
            }
            else
                $new_qg->data_conf = json_encode(['tags'=>array_filter($model['tags'])]);
            // var_dump($model['tags'],$new_qg->data_conf);exit;
            $new_qg->hid = json_encode($model['hid']);
           // var_dump($new_qg->attributes,$model);exit;
            !$new_qg->uid && $new_qg->uid = SM::resoldConfig()->resoldAdminUid();
            if($new_qg->save())
            {
                $this->controller->setMessage('保存成功','success');
                $this->controller->redirect($_SESSION['adminLastUrl']?$_SESSION['adminLastUrl']:'qgList');
            }
            else
            {
                $msg = array_values($new_qg->errors)[0][0];
                $this->controller->setMessage($msg,'error');
            }
    	}
    	// exit;
    	
        $this->controller->render('qgEdit',['qg'=>$new_qg]);
    }
}
