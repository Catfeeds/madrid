<?php

/**
 * User: fanqi
 * Date: 2016/8/9
 * Time: 16:11
 */
class ZfEditAction extends CAction
{
    public function run($id = 0)
    {
        $zf = ResoldZfExt::model()->getzf($id);

        $sourceArr = Yii::app()->params['source'];//房源来源
        if (Yii::app()->request->getIsPostRequest()) {
            $params = Yii::app()->request->getPost('ResoldZfExt', []);
            //信息来源 params.php source
            $source_arr = array_flip(Yii::app()->params['source']);
            // $params['origin'] = $source_arr['后台'];
            //封面赋值
            $params['image'] = Yii::app()->request->getPost('fm', '');
            $params['image_count'] = count(Yii::app()->request->getPost('images', []));
            $tip = $id > 0 ? '修改' : '添加';
            // 场景,用户验证规则
            $zf->scenario = Yii::app()->params['categoryPinyin'][$params['category']];
            $zf->attributes = $params;

            //销售状态默认上架、审核状态默认正常
            $saleStatus_arr = array_flip(Yii::app()->params['saleStatus']);
            $checkStatus_arr = array_flip(Yii::app()->params['checkStatus']);
            if(empty($zf->sale_status)) {
                $zf->sale_status = $saleStatus_arr["上架"];
            }
            if(empty($zf->status)){
                $zf->status = $checkStatus_arr['正常'];
            }
            $zf->setPay_jiao($params['pay_jiao']);
            $zf->setPay_ya($params['pay_ya']);
            //小编后台 发布即上架 上架时间和刷新时间即为当前时间
            if (empty($zf->sale_time)) {
                $zf->sale_time = $zf->refresh_time = time();
            }
            $params['source']=='3' && $zf->expire_time = time() + SM::resoldConfig()->resoldExpireTime() * 86400;
            if(empty($zf->sale_status) && $params['source']=='3')
                $zf->sale_status = 1;
            if(empty($zf->status) && $params['source']=='3')
                $zf->status = 1;
            //个人发布配额限制
            if($sourceArr[$zf->source] == '个人' && !$zf->getPersonalSalingNum())
            {
                Yii::app()->controller->setMessage('个人发布配额已满','error');
                $this->controller->redirect($_SESSION['adminLastUrl']?$_SESSION['adminLastUrl']:'zfList');
            }
            // 黑名单限制
            if(ResoldBlackExt::model()->count(['condition'=>'phone=:phone','params'=>[':phone'=>$zf->phone]]))
            {
                Yii::app()->controller->setMessage('该号码为黑名单用户','error');
                $this->controller->redirect($_SESSION['adminLastUrl']?$_SESSION['adminLastUrl']:'zfList');

            }
            // 中介不能发布个人房源
            if($sourceArr[$zf->source] == '个人' && ResoldStaffPhoneExt::model()->count(['condition'=>'phone=:phone','params'=>[':phone'=>$zf->phone]]))
            {
                Yii::app()->controller->setMessage('中介不能发布个人房源','error');
                $this->controller->redirect($_SESSION['adminLastUrl']?$_SESSION['adminLastUrl']:'zfList');

            }
            if ($zf->save()) {
                if ($images = Yii::app()->request->getPost('images', array())) {
                    $images = array_combine($images, Yii::app()->request->getPost('image_des', array()));
                    ResoldImageExt::model()->deleteAllByAttributes(array('fid' => $zf->id));
                    foreach ($images as $key => $v) {
                        $image_rel = new ResoldImageExt;
                        $image_rel->fid = $zf->id;
                        $image_rel->name = $v;
                        $image_rel->url = $key;
                        $image_rel->type = 2;
                        $image_rel->save();
                    }
                } else {
                    ResoldImageExt::model()->deleteAllByAttributes(array('fid' => $zf->id));
                }
                $msg = $tip . '成功!';
                $this->controller->setMessage($msg);
                $this->controller->redirect($_SESSION['adminLastUrl']?$_SESSION['adminLastUrl']:'zfList');
            } else {
                $msg = array_values($zf->errors)[0][0];
                $this->controller->setMessage($msg, 'error');
            }
        }
        return $this->controller->render('zfedit', ['zf' => $zf]);
    }
}
