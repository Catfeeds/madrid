<?php

class m161027_063216_add_table_site_setting extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql = "CREATE TABLE `site_setting` (
		  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键id',
		  `name` varchar(100) NOT NULL COMMENT '配置标识',
		  `class_name` varchar(255) NOT NULL COMMENT '配置归属类名',
		  `value` text,
		  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
		  `created` int(10) NOT NULL COMMENT '添加时间',
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配置项表'";
		$this->execute($sql);
	}

	public function safeDown()
	{
		return false;
	}
}
