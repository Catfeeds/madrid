<?php

class m160812_004242_alter_table_staff_extra extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql = "ALTER TABLE `staff_extra`
			CHANGE COLUMN `staff` `sid`  int(10) NOT NULL COMMENT '管家id' AFTER `id`,
			MODIFY COLUMN `value`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '属性值' AFTER `key`;";
		$this->execute($sql);
		$this->refreshTableSchema('staff_extra');
	}

	public function safeDown()
	{
		return false;
	}

}
