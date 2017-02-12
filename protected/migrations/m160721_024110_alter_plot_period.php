<?php

class m160721_024110_alter_plot_period extends CDbMigration
{
	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql = "ALTER TABLE `plot_period` ADD COLUMN `open_time`  int(10) NOT NULL DEFAULT 0 COMMENT '开盘时间' AFTER `status`;";
		$this->execute($sql);
		$this->refreshTableSchema('plot_period');
	}
	public function safeDown()
	{
		return false;
	}
	
}