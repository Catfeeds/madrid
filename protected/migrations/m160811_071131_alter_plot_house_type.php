<?php

class m160811_071131_alter_plot_house_type extends CDbMigration
{	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql = "ALTER TABLE `plot_house_type`
				ADD COLUMN `ave_price`  decimal(15,2) NOT NULL DEFAULT 0 COMMENT '均价' AFTER `size`;";
		$this->execute($sql);
		$this->refreshTableSchema('plot_house_type');
	}

	public function safeDown()
	{
		return false;
	}
	
}