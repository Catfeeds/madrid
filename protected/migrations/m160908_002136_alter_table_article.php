<?php

class m160908_002136_alter_table_article extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql = "ALTER TABLE `article` ADD COLUMN `old_id`  int(10) NOT NULL DEFAULT 0 COMMENT '旧主键id' AFTER `updated`;";
		$this->execute($sql);
		$this->refreshTableSchema('article');
	}

	public function safeDown()
	{
		return false;
	}
}
