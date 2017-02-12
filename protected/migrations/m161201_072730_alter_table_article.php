<?php

class m161201_072730_alter_table_article extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql = "ALTER TABLE `article` MODIFY COLUMN `image`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '封面图片' AFTER `editor`;";
		$this->execute($sql);
		$this->refreshTableSchema('article');

	}

	public function safeDown()
	{
		return false;
	}
}
