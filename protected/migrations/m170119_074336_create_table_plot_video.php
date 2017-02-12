<?php

class m170119_074336_create_table_plot_video extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql=<<<EOT
CREATE TABLE `plot_video` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `hid` int(10) NOT NULL COMMENT '楼盘id',
  `title` varchar(255) NOT NULL COMMENT '视频标题',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '转码前视频url',
  `mp_url` varchar(255) NOT NULL DEFAULT '' COMMENT 'mp4视频链接',
  `flv_url` varchar(255) NOT NULL DEFAULT '' COMMENT 'flv视频路径',
  `source` varchar(15) NOT NULL DEFAULT '' COMMENT '第三方视频来源',
  `views` int(10) NOT NULL DEFAULT '0' COMMENT '视频浏览次数',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `img` varchar(255) NOT NULL DEFAULT '',
  `img_id` int(10) NOT NULL DEFAULT '0',
  `transcoded` tinyint(1) NOT NULL DEFAULT '1' COMMENT '转码状态码：0成功，1等待处理，2正在处理，3处理失败，4通知提交失败',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `created` int(10) NOT NULL COMMENT '添加时间',
  `persistent_id` varchar(255) NOT NULL DEFAULT '' COMMENT '七牛持久化处理id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='楼盘视频表';
EOT;
		$this->execute($sql);
	}

	public function safeDown()
	{
		return false;
	}
}