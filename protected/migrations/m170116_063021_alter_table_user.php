<?php

class m170116_063021_alter_table_user extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql="ALTER TABLE `user` ADD COLUMN `data_conf`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '用户其他信息' AFTER `concern_remark`;";
		$this->execute($sql);
		$data_conf=CJSON::encode(['viewTime'=>time()]);
		$updateSql="UPDATE `user` SET `data_conf`=:data_conf";
		$this->execute($updateSql,[':data_conf'=>$data_conf]);
		$this->refreshTableSchema('user');
	}

	public function safeDown()
	{
		return false;
	}
}