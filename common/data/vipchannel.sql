#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `vipchannel`;
CREATE TABLE `vipchannel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'vip通道名称',
  `area` varchar(255) NOT NULL COMMENT 'vip通道地区',
  `address` varchar(500) NOT NULL COMMENT '详细地址',
  `thumbnail` varchar(255) NOT NULL COMMENT '缩略图链接',
  `url` varchar(500) DEFAULT NULL COMMENT '落地页链接',
  `content` text NULL COMMENT '详细信息',
  `longitude` double DEFAULT NULL COMMENT '经度',
  `latitude` double DEFAULT NULL COMMENT '纬度',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 1 COMMENT '状态，1编辑中,2已发布,3已下线',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  UNIQUE KEY (`name`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `vipchannelorder`;
CREATE TABLE IF NOT EXISTS `vipchannelorder` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `vipchannelid` int(10) unsigned NOT NULL COMMENT 'vip通道id',
  `chkindt` bigint NULL COMMENT '签入',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，1签入未确认,2签入已审核通过,3签入已审核不通过',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;