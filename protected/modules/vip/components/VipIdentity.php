<?php
/**
 * 后台验证登录类
 * @author weibaqiu
 * @date 2015-04-22
 */
class VipIdentity extends CUserIdentity
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
		if($this->username=='madrid'&&md5($this->password)=='de05befc376bfca352d81e6280f8b1ba')
		{
			$this->errorCode = self::ERROR_NONE;
			$this->setState('id',1);
			$this->setState('username','admin');
			$this->setState('avatar','');
		} else {
			$this->errorCode = 10000;
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
