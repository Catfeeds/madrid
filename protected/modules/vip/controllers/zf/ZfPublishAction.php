<?php

/**
 * User: fanqi
 * Date: 2016/8/30
 * Time: 10:21
 */
class ZfPublishAction extends CAction
{
    public function run($id = 0)
    {
        $zf = ResoldZfExt::model()->getZf($id);
        if (Yii::app()->request->isPostRequest) {
            $images = Yii::app()->request->getPost('images', array());
            $images = array_combine($images,Yii::app()->request->getPost('image_des', array()));
            $params = Yii::app()->request->getPost('ResoldZfExt', []);

            //信息来源 params.php source
            $source_arr = array_flip(Yii::app()->params['source']);
            $params['origin'] = $source_arr['中介']; //信息来源为中介

            //封面赋值
            $params['image'] = Yii::app()->request->getPost('fm', ""); //封面图
            $params['image_count'] = count(Yii::app()->request->getPost('images', []));//上传图片数量

            //发布人姓名、ID、手机号、所属商家
            $params['uid'] = $this->controller->getStaff()->uid;
            $params['sid'] = $this->controller->getStaff()->sid;
            $params['username'] = $this->controller->getStaff()->name;
            $params['phone'] = $this->controller->getStaff()->phone;
            $tip = $id > 0 ? '修改' : '添加';
            $zf->scenario = $params['category']==1?'zhuzhai':($params['category']==2?'shangpu':'xiezilou');

            $zf->attributes = $params;
            $dataconf = [];
            foreach ([
        'esfzfzztype' => '',//二手房租房住宅类型
        'esfzfsptype' => '',//二手房租房商铺类型
        'zfspkjyxm' => [],//租房商铺可经营项目
        'esfzfxzltype' => '',//二手房租房写字楼类型
        'resoldface' => '',//朝向
        'zfzzpt' => [],//租房住宅配套
        'zfzzts' => [],//租房住宅特色
        'zfsppt' => [],//租房商铺配套
        'zfspts' => [],//租房商铺特色
        'zfxzlts' => [],//租房写字楼特色
        'zfxzlpt' => [],//租房写字楼配套
        'zfxzllevel' => '',//租房写字楼等级
        'esfsplevel' => '',//租房商铺等级
        'esffloorcate' => ''//租房楼层等级
    ] as $key => $value) {
                if(isset($params[$key]) && $params[$key])
                    $dataconf[$key] = $params[$key];
            }
            $zf->data_conf = json_encode($dataconf);
            $zf->source = 2;

            //后台中介，无需审核，默认为上架
            $status_arr = array_flip(Yii::app()->params['checkStatus']);
            $saleStatus_arr = array_flip(Yii::app()->params['saleStatus']);
            if (empty($zf->status)) {
                $zf->status = $status_arr["正常"];
            }
            if(!$zf->id && $zf->sale_status!=2)
                $zf->refresh_time = $zf->sale_time = time();
            $zf->sale_status = ($zf->sale_status != $saleStatus_arr['下架'] && $this->controller->getStaff()->getCanSaleNum() > 0) ? $saleStatus_arr['上架'] : $saleStatus_arr['下架'];
            if($zf->sale_status == 1) {
                $zf->expire_time = time() + SM::resoldConfig()->resoldExpireTime() * 86400;
            }
            // 有相册无封面取第一张图作为封面
            $imgs = [];
            if($images)
                foreach ($images as $key => $value) {
                    $imgs[] = $key;
                }
            if($imgs && !in_array($zf->image, $imgs))
                $zf->image = $imgs[0];
            elseif(!$imgs)
                $zf->image = '';
            if ($zf->save()) {
                //图片处理
                if ($images) {
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
                if ($zf->sale_status == $saleStatus_arr['上架']) {
                    $this->controller->redirect('saleUp');
                } else {
                    $this->controller->redirect('saleDown');
                }
            } else {
                $errors = array_values($zf->errors);;
                $this->controller->setMessage($errors[0][0], 'error');
            }
        }
        $this->controller->render("publish", ["zf" => $zf]);
    }
}