<?php

class m160906_004703_alter_table_article extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql = "ALTER TABLE `article` ADD COLUMN `data_conf`  text NOT NULL COMMENT '扩展配置' AFTER `keywords_switch`;";
		$this->execute($sql);
		$this->refreshTableSchema('article');
	}

	public function safeDown()
	{
		return false;
	}
}
