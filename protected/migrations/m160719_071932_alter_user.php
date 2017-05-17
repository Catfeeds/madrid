<?php

class m160719_071932_alter_user extends CDbMigration
{	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql = "ALTER TABLE `user` ADD COLUMN `wechat`  varchar(150) NOT NULL DEFAULT '' COMMENT '微信号' AFTER `gender`, ADD COLUMN `is_validate`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '微信是否验证通过' AFTER `wechat`;";
		$this->execute($sql);
		$this->refreshTableSchema('user');
	}

	public function safeDown()
	{
		return false;
	}
	
}