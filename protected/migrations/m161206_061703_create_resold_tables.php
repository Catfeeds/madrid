<?php

class m161206_061703_create_resold_tables extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$sql = <<<EOT
CREATE TABLE `resold_appoint` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '职员id',
  `fid` int(10) NOT NULL DEFAULT '0' COMMENT '房源id',
  `appoint_time` int(10) NOT NULL DEFAULT '0' COMMENT '预约时间戳',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '房源类型',
  `created` int(10) NOT NULL COMMENT '添加时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '刷新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_black` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `phone` varchar(11) NOT NULL COMMENT '手机号',
  `created` int(10) NOT NULL COMMENT '创建时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='黑名单';

CREATE TABLE `resold_daily` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `esf_price` varchar(10) NOT NULL DEFAULT '' COMMENT '二手房挂牌均价',
  `esf_size` varchar(100) NOT NULL DEFAULT '' COMMENT '二手房挂牌总面积',
  `esf_num` varchar(20) NOT NULL DEFAULT '' COMMENT '二手房数量',
  `zf_price` varchar(10) NOT NULL DEFAULT '' COMMENT '租房挂牌均价',
  `zf_size` varchar(100) NOT NULL DEFAULT '' COMMENT '租房挂牌总面积',
  `zf_num` varchar(20) NOT NULL DEFAULT '' COMMENT '租房数量',
  `areainfo` text NOT NULL COMMENT '板块数据',
  `date` int(10) NOT NULL DEFAULT '0' COMMENT '日期',
  `created` int(10) NOT NULL COMMENT '添加时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_erp_loginlog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `sid` int(10) NOT NULL DEFAULT '0' COMMENT '商家ID',
  `end_time` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `online_time` int(10) NOT NULL DEFAULT '0' COMMENT '在线时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `created` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家员工登录考勤表';

CREATE TABLE `resold_esf` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '房源标题',
  `area` int(10) NOT NULL DEFAULT '0' COMMENT '区域id',
  `street` int(10) NOT NULL DEFAULT '0' COMMENT '街道id',
  `plot_name` varchar(255) NOT NULL DEFAULT '' COMMENT '楼盘名称',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '房源地址',
  `hid` int(10) NOT NULL DEFAULT '0' COMMENT '楼盘id',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '封面图',
  `image_count` tinyint(3) NOT NULL DEFAULT '0' COMMENT '图片数量',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总价',
  `ave_price` int(10) NOT NULL DEFAULT '0' COMMENT '单价',
  `source` tinyint(2) NOT NULL DEFAULT '0' COMMENT '信息来源',
  `size` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '面积',
  `age` int(4) NOT NULL DEFAULT '0' COMMENT '建造年代',
  `floor` tinyint(3) NOT NULL DEFAULT '0' COMMENT '所在楼层',
  `total_floor` tinyint(3) NOT NULL DEFAULT '0' COMMENT '总楼层',
  `towards` int(5) NOT NULL DEFAULT '0' COMMENT '朝向',
  `decoration` int(5) NOT NULL DEFAULT '0' COMMENT '装修程度',
  `category` tinyint(1) NOT NULL DEFAULT '0' COMMENT '房源分类',
  `bedroom` tinyint(2) NOT NULL DEFAULT '0' COMMENT '几室',
  `livingroom` tinyint(2) NOT NULL DEFAULT '0' COMMENT '几厅',
  `bathroom` tinyint(2) NOT NULL DEFAULT '0' COMMENT '几卫',
  `cookroom` tinyint(2) NOT NULL DEFAULT '0' COMMENT '几厨',
  `content` longtext COMMENT '房源内容',
  `sort` tinyint(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `sale_time` int(10) NOT NULL DEFAULT '0' COMMENT '上架时间',
  `expire_time` int(10) NOT NULL DEFAULT '0' COMMENT '下架时间',
  `refresh_time` int(10) NOT NULL DEFAULT '0' COMMENT '刷新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态',
  `contacted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否电话确认',
  `sale_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '销售状态',
  `top` int(10) NOT NULL DEFAULT '0' COMMENT '置顶时间',
  `hurry` int(10) NOT NULL DEFAULT '0' COMMENT '加急时间',
  `hits` int(10) NOT NULL DEFAULT '0' COMMENT '点击次数',
  `ip` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布人IP',
  `sid` int(10) NOT NULL DEFAULT '0' COMMENT '商家id',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '论坛账号id',
  `account` varchar(255) NOT NULL DEFAULT '' COMMENT '论坛账号名',
  `username` varchar(255) DEFAULT '' COMMENT '发布人名称',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `year` int(4) NOT NULL DEFAULT '0' COMMENT '发布年份',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '发布月份',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '发布日',
  `data_conf` text COMMENT '扩展字段',
  `appoint_time` int(10) NOT NULL DEFAULT '0' COMMENT '预约时间',
  `wuye_fee` varchar(10) NOT NULL DEFAULT '' COMMENT '物业费',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `recommend` int(10) NOT NULL DEFAULT '0' COMMENT '推荐',
  `old_id` int(10) NOT NULL DEFAULT '0' COMMENT '旧数据id',
  `deleted` int(10) NOT NULL DEFAULT '0' COMMENT '删除时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `created` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '标题',
  `keyword` varchar(20) NOT NULL COMMENT '关键词',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '外链',
  `content` text COMMENT '内容',
  `created` int(11) NOT NULL COMMENT '创建时间',
  `updated` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_image` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `fid` int(10) NOT NULL DEFAULT '0' COMMENT '房源id',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '图片标题',
  `sort` tinyint(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '图片来源',
  `deleted` int(10) NOT NULL DEFAULT '0' COMMENT '删除时间',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '二手房or租房',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `created` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_plot_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `hid` int(11) NOT NULL COMMENT '关联楼盘id',
  `price` mediumint(8) NOT NULL COMMENT '均价',
  `year` smallint(4) NOT NULL COMMENT '年份',
  `month` tinyint(3) NOT NULL,
  `new_time` int(10) NOT NULL DEFAULT '0' COMMENT '用户自定义添加时间',
  `created` int(10) NOT NULL COMMENT '添加时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `hid_type_ind` (`hid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_pricetrend` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `data` tinytext NOT NULL COMMENT '数据',
  `time` int(10) NOT NULL COMMENT '房价时间',
  `year` smallint(4) NOT NULL COMMENT '年份',
  `month` tinyint(3) NOT NULL COMMENT '月份',
  `created` int(10) NOT NULL COMMENT '添加时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_qg` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `title` varchar(255) NOT NULL COMMENT '求购标题',
  `area` int(10) NOT NULL DEFAULT '0' COMMENT '区域id',
  `street` int(10) NOT NULL DEFAULT '0' COMMENT '街道id',
  `price` mediumint(5) NOT NULL DEFAULT '0' COMMENT '求购价格',
  `age` tinyint(3) NOT NULL DEFAULT '0' COMMENT '房龄',
  `hid` varchar(100) NOT NULL DEFAULT '' COMMENT '求购小区id',
  `floor` int(5) NOT NULL DEFAULT '0' COMMENT '楼层',
  `bedroom` tinyint(2) NOT NULL DEFAULT '0' COMMENT '几室',
  `livingroom` tinyint(2) NOT NULL DEFAULT '0' COMMENT '几厅',
  `bathroom` tinyint(2) NOT NULL DEFAULT '0' COMMENT '几卫',
  `cookroom` tinyint(2) NOT NULL DEFAULT '0',
  `size` decimal(7,2) NOT NULL DEFAULT '0.00' COMMENT '面积',
  `towards` int(10) NOT NULL DEFAULT '0' COMMENT '朝向',
  `decoration` int(10) NOT NULL DEFAULT '0',
  `data_conf` text COMMENT '其他字段',
  `content` longtext COMMENT '求购内容',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '论坛账号id',
  `account` varchar(255) NOT NULL DEFAULT '' COMMENT '论坛账号名',
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '发布人名称',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `hits` int(10) NOT NULL DEFAULT '0' COMMENT '点击数',
  `ip` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布人IP',
  `category` tinyint(1) NOT NULL COMMENT '房源分类',
  `old_id` int(10) NOT NULL DEFAULT '0' COMMENT '旧数据id',
  `refresh_time` int(10) NOT NULL DEFAULT '0' COMMENT '刷新时间',
  `deleted` int(10) NOT NULL DEFAULT '0' COMMENT '删除时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `created` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_qz` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '求租标题',
  `area` int(10) NOT NULL DEFAULT '0' COMMENT '求租区域',
  `street` int(10) NOT NULL DEFAULT '0' COMMENT '求租街道',
  `price` int(6) NOT NULL DEFAULT '0' COMMENT '租金',
  `size` decimal(7,2) NOT NULL DEFAULT '0.00' COMMENT '面积',
  `hid` varchar(255) NOT NULL DEFAULT '' COMMENT '期望小区',
  `towards` int(10) NOT NULL DEFAULT '0' COMMENT '朝向',
  `rent_type` int(10) NOT NULL DEFAULT '0' COMMENT '租赁方式',
  `decoration` int(10) NOT NULL DEFAULT '0' COMMENT '装修程度',
  `content` longtext,
  `data_conf` text COMMENT '扩展字段',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '论坛账号id',
  `account` varchar(255) NOT NULL DEFAULT '' COMMENT '论坛账号名',
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '发布人名称',
  `phone` varchar(11) NOT NULL COMMENT '手机号',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `hits` int(10) NOT NULL DEFAULT '0' COMMENT '点击数',
  `ip` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布人IP',
  `category` tinyint(1) NOT NULL COMMENT '房源分类',
  `deleted` int(10) NOT NULL DEFAULT '0' COMMENT '删除时间',
  `bedroom` tinyint(2) DEFAULT '0',
  `livingroom` tinyint(2) DEFAULT '0',
  `bathroom` tinyint(2) DEFAULT '0',
  `cookroom` tinyint(2) DEFAULT '0',
  `old_id` int(10) NOT NULL DEFAULT '0' COMMENT '旧数据id',
  `refresh_time` int(10) NOT NULL DEFAULT '0' COMMENT '刷新时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `created` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_recom` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `cid` int(10) NOT NULL DEFAULT '0' COMMENT '分类id',
  `fid` int(10) NOT NULL DEFAULT '0' COMMENT '关联房源ID',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '二手房or租房',
  `title` varchar(50) NOT NULL COMMENT '主标题',
  `s_title` varchar(25) NOT NULL DEFAULT '' COMMENT '短标题',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '摘要',
  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接',
  `author_id` int(10) NOT NULL COMMENT '推荐人id',
  `author` varchar(16) NOT NULL COMMENT '推荐人用户名',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `substation_id` int(10) NOT NULL DEFAULT '0' COMMENT '分站区域id，主站默认为0',
  `config` text NOT NULL COMMENT '推荐配置',
  `created` int(10) NOT NULL COMMENT '添加时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `sort` (`sort`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='二手房/租房推荐表';

CREATE TABLE `resold_recom_cate` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) NOT NULL COMMENT '推荐位名',
  `pinyin` varchar(20) NOT NULL COMMENT '推荐位拼音缩写',
  `parent` int(10) NOT NULL DEFAULT '0' COMMENT '父类',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `created` int(10) NOT NULL COMMENT '添加时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `pinyin` (`pinyin`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='二手房/租房推荐分类表';

CREATE TABLE `resold_report` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `reason` varchar(40) NOT NULL DEFAULT '' COMMENT '原因',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `account` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `infoid` int(10) NOT NULL COMMENT '房源ID',
  `infoname` varchar(40) NOT NULL DEFAULT '' COMMENT '信息标题',
  `content` text NOT NULL COMMENT '举报内容',
  `created` int(10) NOT NULL COMMENT '添加时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `deal` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `type` tinyint(1) NOT NULL COMMENT '房源类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_shop` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(255) NOT NULL COMMENT '商家名称',
  `area` int(10) NOT NULL DEFAULT '0' COMMENT '区域id',
  `street` int(10) NOT NULL DEFAULT '0' COMMENT '街道id',
  `pinyin` varchar(255) NOT NULL DEFAULT '' COMMENT '商家拼音',
  `sort` tinyint(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '状态',
  `description` text COMMENT '介绍',
  `phone` varchar(100) NOT NULL DEFAULT '' COMMENT '电话',
  `work_time` varchar(100) NOT NULL DEFAULT '' COMMENT '工作时间',
  `work_day` varchar(100) NOT NULL DEFAULT '' COMMENT '工作日时间',
  `qq` varchar(100) NOT NULL DEFAULT '' COMMENT 'qq',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '商家地址',
  `link` varchar(255) NOT NULL DEFAULT '' COMMENT '外链',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '封面图',
  `bus` varchar(255) NOT NULL DEFAULT '' COMMENT '公交线路',
  `map_lng` decimal(60,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度',
  `map_lat` decimal(60,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度',
  `map_zoom` decimal(60,10) NOT NULL DEFAULT '0.0000000000' COMMENT '地图缩放',
  `parent` int(10) NOT NULL DEFAULT '0' COMMENT '总店id',
  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `data_conf` text COMMENT '其他字段信息',
  `old_id` int(10) NOT NULL DEFAULT '0' COMMENT '旧数据id',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `created` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_shop_img` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sid` int(10) NOT NULL COMMENT '商家id',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `created` int(10) NOT NULL COMMENT '添加时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_sms` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `phone` varchar(13) NOT NULL COMMENT '手机号',
  `msg` varchar(100) NOT NULL COMMENT '发送内容',
  `origin` varchar(100) NOT NULL DEFAULT '' COMMENT '来源',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `code` int(8) NOT NULL DEFAULT '0' COMMENT '验证码',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_staff` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `uid` int(10) NOT NULL COMMENT '论坛账号',
  `account` varchar(255) NOT NULL DEFAULT '' COMMENT '论坛账号',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `sid` int(10) NOT NULL DEFAULT '0' COMMENT '商家id',
  `note` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `ip` int(10) unsigned NOT NULL DEFAULT '0',
  `id_card` varchar(255) NOT NULL DEFAULT '' COMMENT '身份证',
  `licence` varchar(255) NOT NULL DEFAULT '' COMMENT '认证执照',
  `phone` varchar(15) NOT NULL DEFAULT '' COMMENT '电话',
  `qq` varchar(15) NOT NULL DEFAULT '' COMMENT 'qq',
  `is_manager` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否店长',
  `views` int(10) NOT NULL DEFAULT '0' COMMENT '访问次数',
  `last_login` int(10) NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `hurry_num` int(10) NOT NULL DEFAULT '0' COMMENT '加急数',
  `id_expire` int(10) NOT NULL DEFAULT '0' COMMENT '账号到期时间',
  `old_id` int(10) NOT NULL DEFAULT '0' COMMENT '旧数据id',
  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `created` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_staff_package` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `staff` int(10) NOT NULL DEFAULT '0' COMMENT '职员id',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '套餐id',
  `expire_time` int(10) NOT NULL DEFAULT '0' COMMENT '套餐到期时间',
  `created` int(10) NOT NULL COMMENT '添加时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_staff_phone` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `phone` varchar(11) NOT NULL COMMENT '手机号',
  `created` int(10) NOT NULL COMMENT '创建时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='中介电话库';

CREATE TABLE `resold_tag_rel` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `fid` int(10) NOT NULL DEFAULT '0' COMMENT '房源id',
  `tag_id` int(10) NOT NULL DEFAULT '0' COMMENT '标签id',
  `cate` varchar(20) NOT NULL DEFAULT '' COMMENT '标签分类',
  `type` tinyint(1) NOT NULL COMMENT '二手房or租房',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `created` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_tariff_package` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(255) NOT NULL COMMENT '套餐名称',
  `content` text NOT NULL COMMENT '套餐内容',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '套餐描述',
  `sort` tinyint(1) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `created` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '姓名',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '论坛id',
  `account` varchar(255) NOT NULL COMMENT '账号姓名',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '姓名',
  `created` int(10) NOT NULL COMMENT '添加时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '刷新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_user_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `house_id` int(11) NOT NULL COMMENT '新房ID|二手房ID|租房ID',
  `uid` int(11) NOT NULL COMMENT '论坛ID',
  `house_type` tinyint(4) NOT NULL COMMENT '收藏房屋类型',
  `created` int(11) NOT NULL COMMENT '收藏时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resold_zf` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `title` varchar(255) NOT NULL COMMENT '房源标题',
  `area` int(10) NOT NULL DEFAULT '0' COMMENT '区域id',
  `street` int(10) NOT NULL DEFAULT '0' COMMENT '街道id',
  `hid` int(10) NOT NULL DEFAULT '0' COMMENT '楼盘id',
  `plot_name` varchar(255) NOT NULL DEFAULT '' COMMENT '楼盘名称',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '房源地址',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '封面图',
  `image_count` tinyint(3) NOT NULL DEFAULT '0' COMMENT '图片数量',
  `price` int(7) NOT NULL DEFAULT '0' COMMENT '租金',
  `source` tinyint(2) unsigned NOT NULL COMMENT '信息来源',
  `size` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '面积',
  `pay_type` varchar(30) NOT NULL DEFAULT '' COMMENT '付款方式',
  `rent_type` int(10) NOT NULL COMMENT '整租合租',
  `floor` tinyint(3) NOT NULL DEFAULT '0' COMMENT '所在楼层',
  `total_floor` int(5) NOT NULL DEFAULT '0' COMMENT '总楼层',
  `towards` int(5) NOT NULL DEFAULT '0' COMMENT '朝向',
  `decoration` int(5) NOT NULL DEFAULT '0' COMMENT '装修程度',
  `category` tinyint(1) NOT NULL COMMENT '房源分类',
  `bedroom` tinyint(2) NOT NULL DEFAULT '0' COMMENT '几室',
  `livingroom` tinyint(2) NOT NULL DEFAULT '0' COMMENT '几厅',
  `bathroom` tinyint(2) NOT NULL DEFAULT '0' COMMENT '几卫',
  `cookroom` tinyint(2) NOT NULL DEFAULT '0' COMMENT '几厨',
  `content` longtext COMMENT '房源内容',
  `sort` tinyint(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `sale_time` int(10) NOT NULL DEFAULT '0' COMMENT '上架时间',
  `expire_time` int(10) NOT NULL DEFAULT '0' COMMENT '下架时间',
  `status` tinyint(1) NOT NULL COMMENT '审核状态',
  `contacted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否电话确认',
  `sale_status` tinyint(1) NOT NULL COMMENT '销售状态',
  `top` int(10) NOT NULL DEFAULT '0' COMMENT '置顶时间',
  `hurry` int(10) NOT NULL DEFAULT '0' COMMENT '加急时间',
  `hits` int(10) NOT NULL DEFAULT '0' COMMENT '点击次数',
  `ip` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布人IP',
  `sid` int(10) NOT NULL DEFAULT '0' COMMENT '商家id',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '论坛账号id',
  `account` varchar(255) NOT NULL DEFAULT '' COMMENT '论坛账号名',
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '发布人名称',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `year` int(4) NOT NULL COMMENT '发布年份',
  `month` tinyint(2) NOT NULL COMMENT '发布月份',
  `day` tinyint(2) NOT NULL COMMENT '发布日',
  `appoint_time` int(10) NOT NULL DEFAULT '0' COMMENT '预约时间',
  `wuye_fee` varchar(10) NOT NULL DEFAULT '' COMMENT '物业费',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `recommend` int(10) NOT NULL DEFAULT '0' COMMENT '推荐',
  `deleted` int(10) NOT NULL DEFAULT '0' COMMENT '删除时间',
  `old_id` int(10) NOT NULL DEFAULT '0' COMMENT '旧数据id',
  `data_conf` text COMMENT '扩展字段',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `created` int(10) NOT NULL COMMENT '添加时间',
  `refresh_time` int(10) NOT NULL DEFAULT '0',
  `age` int(4) NOT NULL DEFAULT '0' COMMENT '房屋年代',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `plot_resold_daily` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `hid` int(10) NOT NULL DEFAULT '0' COMMENT '楼盘id',
  `esf_num` varchar(100) NOT NULL DEFAULT '0' COMMENT '二手房总数',
  `zf_num` varchar(100) NOT NULL DEFAULT '0' COMMENT '租房数',
  `esf_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二手房均价',
  `zf_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '租房均价',
  `category` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分类',
  `year` int(4) NOT NULL DEFAULT '0' COMMENT '年份',
  `month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '月份',
  `day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '天',
  `date` int(10) NOT NULL DEFAULT '0' COMMENT '当天',
  `created` int(10) NOT NULL COMMENT '创建时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `baike_tag` ADD COLUMN `cate`  tinyint(1) NOT NULL DEFAULT '0' COMMENT '百科分类' AFTER `recom`;
ALTER TABLE `school` ADD COLUMN `zf_num`  int(10) NOT NULL DEFAULT 0 COMMENT '租房数' AFTER `house_num`;
ALTER TABLE `school` ADD COLUMN `esf_num`  int(10) NOT NULL DEFAULT 0 COMMENT '二手房数' AFTER `house_num`;

INSERT INTO `resold_recom_cate` VALUES ('1', 'wap首页精品二手房（二手房列表推荐）', 'wapsyjpesf', '16', '1', '1473651400', '1480389721');
INSERT INTO `resold_recom_cate` VALUES ('2', 'wap首页热门租房（租房列表推荐）', 'wapsyjpzf', '16', '1', '1475041620', '1480060784');
INSERT INTO `resold_recom_cate` VALUES ('3', 'wap首页中部推荐位', 'wapsyzb', '16', '1', '1475053256', '1480389699');
INSERT INTO `resold_recom_cate` VALUES ('4', '二手房搜索推荐', 'wapesfzzss', '15', '1', '1475109947', '1480403081');
INSERT INTO `resold_recom_cate` VALUES ('5', '商铺搜索推荐', 'wapesfspcsss', '15', '1', '1476950273', '1480404148');
INSERT INTO `resold_recom_cate` VALUES ('6', '写字楼搜索推荐', 'wapesfxzlcsss', '15', '1', '1476950304', '1480403553');
INSERT INTO `resold_recom_cate` VALUES ('7', '租房搜索推荐', 'wapzfzzss', '15', '1', '1476950339', '1480403066');
INSERT INTO `resold_recom_cate` VALUES ('8', '商铺出租搜索推荐', 'wapzfspczss', '15', '1', '1476950356', '1480404198');
INSERT INTO `resold_recom_cate` VALUES ('9', '写字楼出租搜索推荐', 'wapzfxzlczss', '15', '1', '1476950375', '1480404175');
INSERT INTO `resold_recom_cate` VALUES ('10', '邻校房学校搜索推荐', 'wapschoolss', '15', '1', '1477029860', '1480402227');
INSERT INTO `resold_recom_cate` VALUES ('11', '小区找房小区搜索推荐', 'wapxqss', '15', '1', '1477536621', '1480402241');
INSERT INTO `resold_recom_cate` VALUES ('12', 'PC搜索推荐', 'pcss', '14', '1', '1478853727', '1478997857');
INSERT INTO `resold_recom_cate` VALUES ('13', 'wap推荐位', 'wap', '0', '1', '1478855700', '0');
INSERT INTO `resold_recom_cate` VALUES ('14', 'PC推荐位', 'pc', '0', '1', '1478855909', '0');
INSERT INTO `resold_recom_cate` VALUES ('15', 'wap搜索推荐位', 'wapss', '13', '1', '1478997370', '0');
INSERT INTO `resold_recom_cate` VALUES ('16', 'wap首页推荐位', 'wapsy', '13', '1', '1478997508', '1479780049');
INSERT INTO `resold_recom_cate` VALUES ('17', 'pc底部热门街区推荐', 'pcdbrmjq', '14', '1', '1478998062', '0');
INSERT INTO `resold_recom_cate` VALUES ('18', 'pc底部热门小区推荐', 'pcdbrmxq', '14', '1', '1478998087', '0');
INSERT INTO `resold_recom_cate` VALUES ('19', 'pc底部友情链接推荐', 'pcdbyqlj', '14', '1', '1478998117', '0');
INSERT INTO `resold_recom_cate` VALUES ('20', 'pc首页推荐', 'pcsy', '14', '1', '1479003552', '1479003562');
INSERT INTO `resold_recom_cate` VALUES ('21', '首页区域搜索', 'pcsyqyss', '35', '1', '1479003579', '1479783200');
INSERT INTO `resold_recom_cate` VALUES ('22', '首页金牌经纪人（150*185）', 'pcsyjpjjr', '20', '1', '1479003705', '1480389760');
INSERT INTO `resold_recom_cate` VALUES ('23', 'pc首页资讯', 'pcsyzx', '20', '1', '1479003737', '1479004088');
INSERT INTO `resold_recom_cate` VALUES ('24', 'pc首页品牌中介', 'pcsyppzj', '20', '1', '1479004118', '0');
INSERT INTO `resold_recom_cate` VALUES ('25', '首页低总价二手房（200*150）', 'pcsyzdjesf', '33', '1', '1479004547', '1480389769');
INSERT INTO `resold_recom_cate` VALUES ('26', '首页三口之家二手房（200*150）', 'pcsyskzjesf', '33', '1', '1479004591', '1480389779');
INSERT INTO `resold_recom_cate` VALUES ('27', '首页邻校房二手房（200*150）', 'pcsylxfesf', '33', '0', '1479004609', '1480904460');
INSERT INTO `resold_recom_cate` VALUES ('28', '首页热门商圈二手房（200*150）', 'pcsyrmsqesf', '33', '0', '1479004629', '1480904430');
INSERT INTO `resold_recom_cate` VALUES ('29', '首页整租租房（200*150）', 'pcsyzzzf', '34', '1', '1479004656', '1480389805');
INSERT INTO `resold_recom_cate` VALUES ('30', '首页合租租房（200*150）', 'pcsyhzzf', '34', '1', '1479004665', '1480389814');
INSERT INTO `resold_recom_cate` VALUES ('31', '首页面积搜索', 'pcsymjss', '35', '1', '1479004834', '1479783190');
INSERT INTO `resold_recom_cate` VALUES ('32', '首页价格搜索', 'pcsyjgss', '35', '1', '1479004869', '1479783182');
INSERT INTO `resold_recom_cate` VALUES ('33', 'pc首页二手房推荐', 'pcsyesf', '20', '1', '1479004998', '0');
INSERT INTO `resold_recom_cate` VALUES ('34', 'pc首页租房推荐', 'pcsyzf', '20', '1', '1479004999', '0');
INSERT INTO `resold_recom_cate` VALUES ('35', 'pc首页搜索推荐', 'pcsyss', '20', '1', '1479005000', '0');
INSERT INTO `resold_recom_cate` VALUES ('36', '首页中部通栏顶部（800*200）', 'wapsyzbtldb', '3', '1', '1480055639', '1480402415');
INSERT INTO `resold_recom_cate` VALUES ('37', '首页中部通栏左部（400*200）', 'wapsyzbtlzb', '3', '1', '1480055684', '1480402405');
INSERT INTO `resold_recom_cate` VALUES ('38', '首页中部通栏右部（400*200）', 'wapsyzbtlyb', '3', '1', '1480055696', '1480402390');
EOT;
$this->execute($sql);
	}

	public function safeDown()
	{
		return false;
	}
	
}