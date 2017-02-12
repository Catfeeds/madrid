<?php

class m160909_074631_alter_plottrend_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql = "ALTER TABLE `plot_pricetrend` MODIFY COLUMN `data`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '数据' AFTER `id`;";
		$this->execute($sql);
		$this->refreshTableSchema('plot_pricetrend');
	}

	public function safeDown()
	{
		return false;
	}
}
