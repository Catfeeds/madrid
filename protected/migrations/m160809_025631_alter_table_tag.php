<?php

class m160809_025631_alter_table_tag extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql = "ALTER TABLE `tag`
			MODIFY COLUMN `name`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标签名称' AFTER `id`,
			MODIFY COLUMN `cate`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '分类标识' AFTER `name`,
			ADD COLUMN `min`  int(10) NOT NULL DEFAULT 0 COMMENT '最小值' AFTER `cate`,
			ADD COLUMN `max`  int(10) NOT NULL DEFAULT 0 COMMENT '最大值' AFTER `min`;";
		$this->execute($sql);
		$this->refreshTableSchema('tag');
	}

	public function safeDown()
	{
		return false;
	}
}
