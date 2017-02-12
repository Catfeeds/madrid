<?php

class m170119_074442_alter_table_plot_img extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql="ALTER TABLE `plot_img` MODIFY COLUMN `type` int(11) NOT NULL COMMENT '图片类型' AFTER `hid`;";
		$this->execute($sql);
		$this->refreshTableSchema('plot_img');
	}

	public function safeDown()
	{
		return false;
	}
}