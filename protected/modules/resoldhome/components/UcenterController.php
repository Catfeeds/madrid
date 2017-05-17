<?php
/**
 *
 * User: jt
 * Date: 2016/11/5 10:28
 */
class UcenterController extends ResoldHomeController{

    public $uid;

    public $layout = '/layouts/my_base';

    public $pageSize = 5;

    public $user;

    public $status;

    public $source;

    public function init()
    {
        parent::init();
        if(Yii::app()->uc->user->getisGuest() || empty(Yii::app()->uc->user->uid)){
            if(Yii::app()->request->isAjaxRequest){
                $this->response(false,'你还没有登录');
            }else{
                $this->redirect($this->getLoginUrl());
            }
        }
        $this->uid = Yii::app()->uc->user->uid;
        $staff = ResoldStaffExt::findStaffByUid($this->uid);
        if($staff){
            $this->redirect($this->createUrl('/vip'));
        }
        $phone = Yii::app()->uc->getPhoneByUids($this->uid);
        if(Yii::app()->uc->user->phone != $phone){ //更新绑定的号码
            Yii::app()->uc->user->phone = $phone[$this->uid];
        }
        $this->user = Yii::app()->uc->user;
        $check_arr = array_flip(Yii::app()->params['checkStatus']);
        $source_arr = array_flip(Yii::app()->params['source']);
        $this->source = $source_arr['个人'];
        if(empty(SM::resoldConfig()->resoldUserMode())){
            $this->status = $check_arr['正常'];
        }else{
            $this->status = $check_arr['审核中'];
        }
    }

    public function filters()
    {
        return array(
            'postData + resoldhome/myesf/sellsave,resoldhome/myesf/buysave,resoldhome/myzf/rentsave,resoldhome/myzf/forrentsave',
        );
    }

    public function filterPostData($chain){
        // 敏感词过滤
        if(SM::resoldSensitiveConfig()->resoldUseSensitiveWordFilter()) {
            $filterFile = SM::resoldSensitiveConfig()->resoldSensitive();
            if ($filterFile) {
                $words = preg_split("/,|，/", $filterFile);
                if (Yii::app()->request->isPostRequest) {
                    $postData = json_encode($_POST['content'].$_POST['title'], JSON_UNESCAPED_UNICODE);
                    foreach ($words as $word) {
                        if (strpos($postData, $word)) {
                            $this->response(false,"数据中存在敏感词汇({$word})");
                        }
                    }
                }
            }
        }
        if(isset($_POST['content']) && !empty($_POST['content'])){
            $_POST['content'] = $this->cleanXss($_POST['content']); //过滤xxs攻击
        }
        if(isset($_POST['phone']) && $phone = $_POST['phone']){
            if(ResoldBlackExt::model()->count(['condition'=>'phone=:phone','params'=>[':phone'=>$phone]])){
                $this->response(false,'此号码发布违规信息，不能发布信息');
            }
            if(ResoldStaffPhoneExt::model()->getIsExist($phone)){
                $this->response(false,'此号码是中介，不能用个人账户不发信息');
            }
            if(!isset($_POST['id']) || empty($_POST['id'])) {
                $userPubNum = SM::resoldConfig()->resoldPersonalSaleNum();
                $criteria = new CDbCriteria(array(
                    'condition' => 'phone=:phone',
                    'params' => array(':phone' => $phone)
                ));
                $salingEsfNum = ResoldEsfExt::model()->normal()->count($criteria);
                $salingZfNum = ResoldZfExt::model()->normal()->count($criteria);
                $salingQgNum = ResoldQgExt::model()->undeleted()->count($criteria);
                $salingQzNum = ResoldQzExt::model()->undeleted()->count($criteria);
                $totalCanSaleNum = $userPubNum - $salingEsfNum - $salingZfNum - $salingQgNum - $salingQzNum;
                if ($totalCanSaleNum <= 0) {
                    $this->response(false, '此号码已发布' . $userPubNum . '条不能再发布了；联系客服 开通中介套餐可以发布更多哦！');
                }
            }
        }
        $chain->run();
    }


    protected function checkPhone($phone=0,$code=0,$oldphone=0){
        if(empty($phone))
            $this->response(false,'手机号不能为空');
        if(!$oldphone)
        {
            if( ($this->user->phone && $this->user->phone != $phone) || (!$this->user->phone)) {
                if (!$code)
                    $this->response(false,'验证码不能为空');
                elseif (ResoldSmsExt::findCodeByMobile($phone) != $code)
                    $this->response(false,'验证码错误或已过期');
            }
        }
        elseif($phone != $oldphone)
        {
            if (!$code)
                $this->response(false,'验证码不能为空');
            elseif (ResoldSmsExt::findCodeByMobile($phone) != $code)
                $this->response(false,'验证码错误或已过期');
        }
        return true ;
    }

}