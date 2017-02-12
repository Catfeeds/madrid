<?php
/**
 * 添加/修改二手房信息
 * @author  steven.allen
 * @date 2016.08.10
  */
class EsfEditAction extends CAction
{
    public function run($id=0)
    {
        $new_esf = $id == 0 ? new ResoldEsfExt() : ResoldEsfExt::model()->findByPk($id);
        $sourceArr = Yii::app()->params['source'];//房源来源

    	if(Yii::app()->request->isPostRequest)
    	{
            // echo CJSON::encode($_POST);exit;
    		$values = Yii::app()->request->getPost('ResoldEsfExt', array());
  			//封面赋值
    		$values['image'] = Yii::app()->request->getPost('fm','');
    		$values['image_count'] = count(Yii::app()->request->getPost('images',array())); 
            //楼盘赋值
    		if($values['hid'])
    			$plot = PlotExt::model()->findByPk($values['hid']);
    		$values['plot_name'] = isset($plot)?$plot->title:'';
            //标签集成
            $category = $values['category'];
            // 场景,用户验证规则
            $new_esf->scenario = Yii::app()->params['categoryPinyin'][$values['category']];
            $new_esf->attributes = $values;
            $tags = array_filter($values['tagsArr']);
            $tsTags = Yii::app()->request->getPost('tagsArr', array());
            foreach ($tsTags as $key => $v) {
                $tags = array_merge($tags,$v);
            }
            //小编后台 发布即上架 上架时间和刷新时间即为当前时间
            $new_esf->sale_time = $new_esf->refresh_time = time();
            $values['source']=='3' && $new_esf->expire_time = time() + SM::resoldConfig()->resoldExpireTime() * 86400;
            // $source_arr = array_flip(Yii::app()->params['source']);
            // $new_esf->source = $source_arr['后台'];
            if(empty($new_esf->sale_status) && $values['source']=='3')
                $new_esf->sale_status = 1;
            if(empty($new_esf->status) && $values['source']=='3')
                $new_esf->status = 1;
            $new_esf->data_conf = CJSON::encode(['tags'=>$tags]);
            
            //个人发布配额限制
            if($sourceArr[$new_esf->source] == '个人' && !$new_esf->getPersonalSalingNum())
            {
                Yii::app()->controller->setMessage('个人发布配额已满','error');
                $this->controller->redirect($_SESSION['adminLastUrl']?$_SESSION['adminLastUrl']:'esfList');

            }
            // 黑名单限制
            if(ResoldBlackExt::model()->count(['condition'=>'phone=:phone','params'=>[':phone'=>$new_esf->phone]]))
            {
                Yii::app()->controller->setMessage('该号码为黑名单用户','error');
                $this->controller->redirect($_SESSION['adminLastUrl']?$_SESSION['adminLastUrl']:'esfList');

            }
            // 中介不能发布个人房源
            if($sourceArr[$new_esf->source] == '个人' && ResoldStaffPhoneExt::model()->count(['condition'=>'phone=:phone','params'=>[':phone'=>$new_esf->phone]]))
            {
                Yii::app()->controller->setMessage('中介不能发布个人房源','error');
                $this->controller->redirect($_SESSION['adminLastUrl']?$_SESSION['adminLastUrl']:'esfList');
            }
            // var_dump($new_esf->data_conf);exit;
            //二手房保存后保存图片
    		if($new_esf->save()){
    			if($images = Yii::app()->request->getPost('images', array()))
    			{
    				$images = array_combine($images,Yii::app()->request->getPost('image_des', array()));
    				ResoldImageExt::model()->deleteAllByAttributes(array('fid'=>$new_esf->id));
    				foreach ($images as $key => $v) {
    					$image_rel = new ResoldImageExt;
	    				$image_rel->fid = $new_esf->id;
	    				$image_rel->name = $v;
	    				$image_rel->url = $key;
	    				$image_rel->type = 1;
	    				$image_rel->save();
	    			}
    			}
                else
                {
                    ResoldImageExt::model()->deleteAllByAttributes(array('fid'=>$new_esf->id));
                }
                $this->controller->setMessage('操作成功！','success');	
                $this->controller->redirect($_SESSION['adminLastUrl']?$_SESSION['adminLastUrl']:'esfList');
    		}
            else
            {
                $error = current(current($new_esf->getErrors()));
                $this->controller->setMessage($error,'error');   
            }
    	}
        $this->controller->render('esfEdit',['esf'=>$new_esf]);
    }
}
