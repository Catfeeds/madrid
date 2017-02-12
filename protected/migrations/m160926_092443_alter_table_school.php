<?php

class m160926_092443_alter_table_school extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql = "ALTER TABLE `school`
			MODIFY COLUMN `name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学校名称' AFTER `id`,
			MODIFY COLUMN `pinyin`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '学校拼音' AFTER `name`,
			MODIFY COLUMN `address`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '学校地址' AFTER `scope`,
			MODIFY COLUMN `image`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '封面图' AFTER `address`;";
		$this->execute($sql);
		$this->refreshTableSchema('school');
	}

	public function safeDown()
	{
		return false;
	}
}
