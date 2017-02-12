<?php

class m161207_070126_alter_table_article extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{

		$sql="ALTER TABLE `article` DROP INDEX `hid`;ALTER TABLE `article` DROP INDEX `IDX_CID_SHOW_TIME`;ALTER TABLE `article` DROP INDEX `IDX_SHOW_TIME`;ALTER TABLE `article` ADD INDEX `IND_SHOWTIME_STATUS_CID` (`show_time`,`status`,`cid`);";
		$this->execute($sql);
		$this->refreshTableSchema('article');
	}

	public function safeDown()
	{
        echo "回滚".get_called_class()."成功\n";
	}
}
