<?php

class m161110_062935_alter_table_order extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql = "ALTER TABLE `order` ADD COLUMN `spm_d`  varchar(100) NOT NULL DEFAULT '' COMMENT 'spm_c对应的模型类的类名' AFTER `spm_c`;";
		$this->execute($sql);
		$this->refreshTableSchema('order');
	}

	public function safeDown()
	{
		return false;
	}

}
