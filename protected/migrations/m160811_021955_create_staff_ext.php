<?php

class m160811_021955_create_staff_ext extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql = "CREATE TABLE `staff_extra` (
		  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键id',
		  `staff` int(10) NOT NULL DEFAULT '0' COMMENT '管家id',
		  `key` varchar(255) NOT NULL DEFAULT '' COMMENT '属性名',
		  `value` varchar(255) NOT NULL DEFAULT '' COMMENT '属性值',
		  `created` int(10) NOT NULL COMMENT '创建时间',
		  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$this->execute($sql);
		$this->refreshTableSchema('staff_extra');
	}

	public function safeDown()
	{
		return false;
	}
	
}