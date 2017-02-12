<?php

class m160714_055827_alter_table_house_type extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql = "ALTER TABLE `plot_house_type`
		MODIFY COLUMN `inside_size`  decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT '套内面积' AFTER `cookroom`,
		MODIFY COLUMN `size`  decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT '面积' AFTER `inside_size`,
		MODIFY COLUMN `price`  decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT '参考价' AFTER `size`;";
		$this->execute($sql);
		$this->refreshTableSchema('plot_house_type');
	}

	public function safeDown()
	{
		return false;
	}

}
