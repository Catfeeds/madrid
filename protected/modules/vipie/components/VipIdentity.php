<?php
/**
 * 后台验证登录类
 * @author weibaqiu
 * @date 2015-04-22
 */
class VipieIdentity extends CUserIdentity
{
	public $isUcUser = false;

	public $ucUser;
	/**
	 * 验证身份
	 * @return bool
	 */
	public function authenticate()
	{
		//内置帐号
		if($this->username=='hj_test'&&md5($this->password)=='ed6de327f1bd480a4c98ade520021ad1')
		{
			$this->errorCode = self::ERROR_NONE;
			$this->setState('id',1);
			$this->setState('username','admin');
			$this->setState('avatar','');
			return $this->errorCode;
		}

		$user = $this->isUcUser ? $this->ucUser : Yii::app()->uc->login($this->username, $this->password);
		// var_dump($user->icon);exit;
		if(is_object($user)) {
			$user = [
				'uid' => $user->uid,
				'username' => $user->name,
				'icon' => $user->icon,
			];
		}
		if(Yii::app()->uc->hasError() || !isset($user['uid']))
			$this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
		else
		{	
			$loginForm = new PptLoginForm('synlogin');
	        $arr = array(
	            'uid' => $user['uid'],
	        );
	        $loginForm->attributes = $arr;
	        $loginForm->login();
			$this->errorCode = self::ERROR_NONE;
			//为该登录用户设置全局变量信息
			$this->setState('username', $user['username']);
			$this->setState('avatar', $user['icon']);
			$this->setState('uid', $user['uid']);

			$staff = ResoldStaffExt::model()->find(['condition'=>'uid=:uid','params'=>[':uid'=>$user['uid']]]);
			if($staff && $staff->status==1 && $staff->id_expire > time())
			{
				$staff->last_login = time();
				$staff->save();
				$this->setState('id', $staff->id);
				$this->setState('sid', $staff->sid);
				$this->setState('name', $staff->name);
				$this->setState('account', $staff->account);
				$this->setState('phone', $staff->phone);
				$this->errorCode = self::ERROR_NONE;
				if(ResoldBlackExt::model()->count(['condition'=>'phone=:phone','params'=>[':phone'=>$staff->phone]]))
				{
					$this->errorCode = 20000;
					return $this->errorCode;
				}
			}
			else
			{
				$this->errorCode = 10000;
				return $this->errorCode;
			}
		}

		return $this->errorCode;
	}

	public function getId()
	{
		return $this->getState('id');
	}

	public function getName()
	{
		return $this->getState('name');
	}

	public function setUcUser($value)
	{
		$this->ucUser = $value;
	}

	public function getUcUser()
	{
		return $this->ucUser;;
	}
}
