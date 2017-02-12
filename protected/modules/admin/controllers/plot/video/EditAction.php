<?php
use Qiniu\Auth;

/**
 * 楼盘视频编辑页
 */
class EditAction extends CAction
{
    public function run($hid, $id = 0)
    {
        $this->controller->layout = '/layouts/modal_base';
        $hid = (int)$hid;
        $id = (int)$id;
        if ($id) {
            $model = PlotVideoExt::model()->findByPk($id);
        } else {
            $model = new PlotVideoExt();
        }

        if (Yii::app()->request->getIsPostRequest()) {
            $pr = Yii::app()->request->getPost('PlotVideoExt', array());
            $pr['hid'] = $hid;
            if (!isset($pr['img'])) {
                $pr['img'] = Yii::app()->request->getPost('PlotVideo_img', '');
            }
            if($model->status==1&&$model->img_id)
            {
                $image = PlotImgExt::model()->findByPk($model->img_id);
            }
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if(isset($image)){
                    $image->hid = $hid;
                    $image->type = SM::VideoConfig()->videoTag();
                    $image->title = $pr['title'];
                    $image->url = $pr['img'];
                    if ($image->save()) {
                        $pr['img_id'] = $image->id;
                    }else
                        throw new Exception('保存失败');
                }
                $model->attributes = $pr;
                if ($model->save()) {
                    $transaction->commit();
                    $this->controller->setMessage('保存成功！', 'success', array('videoList', 'hid' => $hid));
                }else
                    throw new Exception('保存失败');
            } catch (Exception $e) {
                $transaction->rollback();
                $this->controller->setMessage('保存失败！', 'error');
            }
        }
        $uptoken = $this->uploadToken();
        $this->controller->render('video/edit', array(
            'model' => $model,
            'hid' => $hid,
            'uptoken' => $uptoken
        ));
    }

    /**
     * 获得七牛上传token，并设置上传策略，上传成功后转码为mp4和flv
     */
    private function uploadToken()
    {
        $auth = new Auth(Yii::app()->file->accessKey, Yii::app()->file->secretKey);
        $bucket = Yii::app()->file->bucket;
        $pipeLine = isset(Yii::app()->params->qiniuPipeline)?Yii::app()->params->qiniuPipeline:'';
        $entry=$bucket . ':' . date('Y').'/'.date('m').'/'.date('d').'/'.time() . rand(1,999);
        $mp4entry = $this->urlsafe_b64encode($entry.'.mp4');
        $flventry = $this->urlsafe_b64encode($entry.'.flv');

        $pfopOps = "avthumb/mp4/s/1204x720|saveas/".$mp4entry.";avthumb/flv/s/1204x720|saveas/".$flventry;
        $persistentNotifyUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/api/video/notify';
        $policy = array(
            'persistentOps' => $pfopOps,
            'persistentNotifyUrl' => $persistentNotifyUrl,
            'insertOnly' => 0,
            'persistentPipeline' => $pipeLine,
        );

        $upToken = $auth->uploadToken($bucket, null, 3600, $policy);

        return $upToken;
    }

    /**
     * 安全的url base64转码
     * 注意，七牛要求编码最后的“=”不可以替换
     * @param $string
     * @return mixed|string
     */
    private function urlsafe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/'), array('-', '_'), $data);
        return $data;
    }
}

