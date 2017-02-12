<?php

class m160919_055141_alter_plot_special extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql = "ALTER TABLE `plot_special` ADD `htid` INT(10) NOT NULL DEFAULT 0 COMMENT '户型id' AFTER `hid`";
		$this->execute($sql);
		$this->refreshTableSchema('plot_special');
	}

	public function safeDown()
	{
		return false;
	}

}