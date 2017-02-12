<?php

class m160725_021558_alter_plot_building extends CDbMigration
{
	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql = "ALTER TABLE `plot_building`
				ADD COLUMN `open_time`  int(10) NOT NULL DEFAULT 0 COMMENT '开盘时间' AFTER `point_y`,
				ADD COLUMN `delivery_time`  int(10) NOT NULL DEFAULT 0 COMMENT '交付时间' AFTER `open_time`;";
		$this->execute($sql);
		$this->refreshTableSchema('plot_building');
	}

	public function safeDown()
	{
		return false;
	}
	
}