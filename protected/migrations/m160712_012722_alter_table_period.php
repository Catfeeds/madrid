<?php

class m160712_012722_alter_table_period extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql = "ALTER TABLE `plot_period` ADD COLUMN `delivery_time`  int(10) NOT NULL DEFAULT 0 COMMENT '交付时间' AFTER `status`;";
		$this->execute($sql);
		$this->refreshTableSchema('plot_period');
	}

	public function safeDown()
	{
		return false;
	}
}
