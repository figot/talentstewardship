#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `hotel`;
CREATE TABLE `hotel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hotelname` varchar(255) NOT NULL COMMENT '酒店名称',
  `area` varchar(255) NOT NULL COMMENT '酒店地区',
  `address` varchar(2055) NOT NULL COMMENT '详细地址',
  `suitper` varchar(4096) NOT NULL COMMENT '适用人才级别',
  `star` int(10) unsigned NOT NULL COMMENT '星级',
  `thumbnail` varchar(2055) NOT NULL COMMENT '缩略图链接',
  `image` varchar(2055) NOT NULL DEFAULT 0 COMMENT '酒店图片链接',
  `score` int(10) unsigned NULL COMMENT '评分',
  `content` text NULL COMMENT '详细信息',
  `longitude` double DEFAULT NULL COMMENT '经度',
  `latitude` double DEFAULT NULL COMMENT '纬度',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 1 COMMENT '状态，1编辑中,2已发布,3已下线',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  UNIQUE KEY (`hotelname`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `hotelimages`;
CREATE TABLE IF NOT EXISTS `hotelimages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hotelid` int(10) unsigned NOT NULL COMMENT '酒店id',
  `imageurl` varchar(1024) NOT NULL COMMENT '图片链接',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `room`;
CREATE TABLE IF NOT EXISTS `room` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hotelid` int(10) unsigned NOT NULL COMMENT '酒店id',
  `roomtype` varchar(50) NOT NULL COMMENT '房间类型：单间, 标间,',
  `price` int(10) unsigned NOT NULL COMMENT '价格',
  `roomnumber` int(10) unsigned NOT NULL COMMENT '数量',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 1 COMMENT '状态，1编辑中,2已发布,3已下线',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `hotelmanage`;
CREATE TABLE IF NOT EXISTS `hotelmanage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '',
  `hotelid` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '酒店id',
  `hotelname` varchar(255) NOT NULL DEFAULT '' COMMENT '酒店名称',
  `isroot` tinyint(6) unsigned NOT NULL DEFAULT 1 COMMENT '状态，1管理员用户 2普通用户 3 区域管理员',
  `hotelarea` varchar(4096) NOT NULL COMMENT '管理区域',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  UNIQUE KEY(`user_id`),
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

