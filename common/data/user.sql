#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` char(11) NOT NULL COMMENT '手机号',
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，公开1、隐藏2',
  `uuid` varchar(255) NOT NULL COMMENT '用户uuid',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`, `openid`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `thirdauth`;
CREATE TABLE `thirdauth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `appid` varchar(255) NOT NULL COMMENT 'appid',
  `app_secret` varchar(255) NOT NULL COMMENT 'appkey',
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `access_token` varchar(255) NOT NULL COMMENT 'access_token',
  `source_type` int(10) unsigned NOT NULL COMMENT '来源渠道,  微信1，qq2，微博3',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第三方登录';

DROP TABLE IF EXISTS `talentinfo`;
CREATE TABLE `talentinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `mobile` char(11) DEFAULT NULL COMMENT '手机号',
  `user_name` varchar(60) NOT NULL DEFAULT '' COMMENT '姓名',
  `gender` varchar(10) NOT NULL DEFAULT '' COMMENT '性别,男、女',
  `id_number` varchar(20) NULL COMMENT '身份证号',
  `idcardup` varchar(255) NULL COMMENT '身份证正面',
  `idcarddown` varchar(255) NULL COMMENT '身份证反面',
  `certificate` varchar(255) NOT NULL DEFAULT '' COMMENT '学位证书',
  `pol_visage` varchar(20) NOT NULL DEFAULT '' COMMENT '政治面貌,中共党员,中国民主同盟,中国民主建国会,无党派人士',
  `maxdegree` varchar(10) NOT NULL DEFAULT '' COMMENT '最高学历，1博士后、2博士、3硕士、4本科、5专科、6专科以下',
  `address` varchar(511) NOT NULL DEFAULT '' COMMENT '联系地址',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '邮箱',
  `qq` char(20) NOT NULL DEFAULT '' COMMENT 'qq',
  `wechat` char(50) NOT NULL DEFAULT '' COMMENT '微信号',
  `brief` text DEFAULT NULL COMMENT '个人简介',
  `portrait` text DEFAULT NULL COMMENT '头像',
  `good_fields` varchar(511) DEFAULT NULL COMMENT '擅长领域',
  `authstatus` tinyint(6) unsigned NOT NULL DEFAULT 2 COMMENT '人才认证状态, 1未认证, 2认证中, 3认证失败, 4认证成功',
  `category` varchar(255) NULL COMMENT '人才级别',
  `catestatus` varchar(255) NULL COMMENT '人才级别状态, 1学历自动认证状态，2人才后台认证',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 1 COMMENT '状态，公开1、隐藏2',
  `isshow` tinyint(6) unsigned NOT NULL DEFAULT 1 COMMENT '状态，隐藏1、公开展示2、',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `id_number` (`id_number`),
  KEY `created_at` (`created_at`,`updated_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `education`;
CREATE TABLE `education` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `school` varchar(255) NOT NULL COMMENT '学校名称',
  `institute` varchar(255) NOT NULL COMMENT '学院',
  `degree` varchar(10) NOT NULL DEFAULT '' COMMENT '学历，1博士后、2博士、3硕士、4本科、5专科、6专科以下',
  `vcode` varchar(255) NOT NULL DEFAULT '' COMMENT '学信网学历报告验证码',
  `degreereport` text DEFAULT NULL COMMENT '学信网报告',
  `graduation_year` varchar(255) NOT NULL COMMENT '毕业年份',
  `certificate` varchar(255) NOT NULL DEFAULT '' COMMENT '学位证书',
  `diploma` varchar(255) NOT NULL DEFAULT '' COMMENT '学历证书',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，公开0、隐藏1',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `honor`;
CREATE TABLE `honor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `name` varchar(255) NOT NULL COMMENT '人才名称//长江学者、西部之光访问学者、国千、万人计划、海智计划',
  `year` varchar(10) NOT NULL COMMENT '评选年份',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，公开0、隐藏1',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `honorfiles`;
CREATE TABLE `honorfiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `honorid` int(10) unsigned NOT NULL COMMENT '荣誉id',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `filesign` varchar(255) NOT NULL COMMENT '文件sign',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `talentcard`;
CREATE TABLE `talentcard` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `cardid` int(10) unsigned NOT NULL COMMENT ' 人才卡id',
  `tlevel` varchar(10) NOT NULL DEFAULT '' COMMENT '人才级别',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，认证中1,已认证2,未通过3',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  UNIQUE KEY (`cardid`),
  UNIQUE KEY (`user_id`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `userback`;
CREATE TABLE `userback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` char(11) NOT NULL COMMENT '手机号',
  `nickname` varchar(60) DEFAULT NULL COMMENT '昵称',
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL COMMENT '邮箱',
  `portrait` text DEFAULT NULL COMMENT '头像',
  `user_name` varchar(60) DEFAULT NULL COMMENT '姓名',
  `gender` enum('male','female','other') NOT NULL DEFAULT 'male' COMMENT '性别',
  `id_number` varchar(20) DEFAULT NULL COMMENT '身份证号',
  `pol_visage` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '政治面貌',
  `address` varchar(511) DEFAULT NULL COMMENT '联系地址',
  `qq` char(20) NOT NULL COMMENT 'qq',
  `brief` text DEFAULT NULL COMMENT '个人简介',
  `good_fields` varchar(255) DEFAULT NULL COMMENT '擅长领域',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，公开0、隐藏1',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`),
  UNIQUE KEY `email` (`email`),
  KEY `created_at` (`created_at`,`updated_at`),
  KEY `gender` (`gender`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
