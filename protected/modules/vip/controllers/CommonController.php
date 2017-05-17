<?php
/**
 * common控制器
 * 后台首页、登录、退出、报错页
 * @author weibaqiu
 * @date 2015-09-07
 */
class CommonController extends VipController
{
    public function actionConfig()
    {
        Yii::import('application.models_ext.siteSetting.*');
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    /**
     * 后台登陆
     */
    public function actionLogin()
    {
        $this->layout = false;
        // 前台未登录
        if( !Yii::app()->user->isGuest )
            $this->redirect(array('/vip/common/index'));

        $model = new VipLoginForm;
        if( Yii::app()->request->isPostRequest )
        {
            $model->username = Yii::app()->request->getPost('username', '');
            $model->password = Yii::app()->request->getPost('password', '');
            $model->rememberMe = Yii::app()->request->getPost('rememberMe', 0);
            if( $model->validate() && $model->login() )
                $this->redirect(array('/vip/common/index'));
        }
        $this->render('login', array(
            'model' => $model,
        ));
    }

    /**
     * 退出登录
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        Yii::app()->uc->user->logout($this->createUrl('/vip/common/login'));
        $this->redirect(array('/vip/common/login'));
    }

    /**
     * 房产v2升级
     * 2016年8月23日全部升级完成，该方法禁止走入，但代码别删除，方便下次升级参考
     */
    public function actionUpgrade($process=0,$token='')
    {
        die;
        if($this->getIsLatest() || !Yii::app()->user->checkAccess('admin')){
            $this->redirect(['index']);
            Yii::app()->end();
        }

        if(time()-$process<30 && $token==md5('123')){
            $this->layout = false;
            set_time_limit(0);
            Yii::app()->clientScript->registerScript('iframePd',"if (self != top) {location.href='about:blank'}",CClientScript::POS_HEAD);
            Yii::import('application.commands.V2');
            $v2 = new V2;
            $v2->process();
            Yii::app()->end();
        }

        $pwRight = false;
        if(Yii::app()->request->isPostRequest) {
            $pw = Yii::app()->request->getPost('pw');
            $admin = AdminExt::model()->findByPk(Yii::app()->user->id);
            if($admin && md5($pw)==$admin->password) {
                $pwRight = true;
            } else {
                $this->setMessage('密码错误，请重新尝试','error');
            }
        }
        $this->render('upgrade', [
            'pwRight' => $pwRight,
        ]);
    }

    public function actionLog()
    {
        $content = file_get_contents(Yii::getPathOfAlias('application.runtime').DIRECTORY_SEPARATOR.'v2upgrade.log');
        echo nl2br($content);
    }

    /**
     * ajax获取楼盘
     * @param  [type]  $kw       [description]
     */
    public function actionAjaxGetHouse($kw,$isNew=1)
    {
        $criteria = new CDbCriteria();
        if (!$kw) {
            $criteria->limit = 15;
        }
        $isNew && $criteria->addCondition('is_new=1');
        if (preg_match("/^[a-zA-Z\s]+$/", $kw)) {
            $criteria->addSearchCondition('pinyin', $kw);
        } else {
            $criteria->addSearchCondition('title', $kw);
        }

        $data = array();
        $house = PlotExt::model()->normal()->findAll($criteria);
        foreach ($house as $v) {
            $data[] = array('id'=>$v->id, 'name'=>$v->title);
        }
        $data = array('results'=>$data, 'more'=>false);
        echo CJSON::encode($data);
    }

    /**
     * [actionAjaxGetImgs 根据hid获得楼盘图片]
     * @return [type] [description]
     */
    public function actionAjaxGetImgs($hid)
    {
        $images = [];
        $imgs = PlotImgExt::model()->findAll(array('condition'=>'hid=:hid','params'=>[':hid'=>$hid],'order'=>'sort desc','limit'=>30));
        $plot = PlotExt::model()->normal()->findByPk($hid);
        if(!$plot)
        {
            echo CJSON::encode(['msg'=>'error']);
        }
        elseif(!$imgs)
        {
            echo CJSON::encode(['data'=>[],'msg'=>'success','addr'=>$plot->address?$plot->address:'']);
        }
        else
        {
            foreach ($imgs as $key => $value) {
                $tmp['image'] = ImageTools::fixImage($value['url']);
                $tmp['ori_image'] = $value['url'];
                $tmp['img_id'] = $value['id'];
                $images['data'][] = $tmp;
            }
            $images['msg'] = 'success';
            $images['addr'] = $imgs?$imgs[0]->plot->address:'';
            echo CJSON::encode($images);
        }
    }
}
?>
