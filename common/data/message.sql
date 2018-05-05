#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '消息信息状态，1编辑中,2已发布,3已结束',
  `title` varchar(500) DEFAULT NULL COMMENT '标题',
  `url` varchar(500) DEFAULT NULL COMMENT '消息落地页链接',
  `content` text NOT NULL COMMENT '消息内容',
  `release_time` bigint NOT NULL DEFAULT 0 COMMENT '发布时间',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `release_time` (`release_time`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `adminmessage`;
CREATE TABLE `adminmessage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `department` varchar(255) NULL COMMENT '组织部门',
  `area` varchar(255) NULL COMMENT '酒店地区',
  `msgtype` tinyint(6) unsigned NULL COMMENT '消息类型，1酒店消息 2申报消息',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 1 COMMENT '消息信息状态，1未读,2已读',
  `title` varchar(500) DEFAULT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '消息内容',
  `url` varchar(500) DEFAULT NULL COMMENT '消息落地页链接',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO message (status, title, content, release_time, user_id, url, created_at, updated_at) VALUES (2, '赣州经济技术开发区吸引大学生就业创业实施办法', '赣州经济技术开发区吸引大学生就业创业实施办法', UNIX_TIMESTAMP(), 16, 'http://47.93.42.27/f/web/wap/policy?id=25', UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO message (status, title, content, release_time, user_id, url, created_at, updated_at) VALUES ( 2, '赣州市“苏区人才伯乐奖”申领暂行办法', '赣州市“苏区人才伯乐奖”申领暂行办法', UNIX_TIMESTAMP(), 16, 'http://47.93.42.27/f/web/wap/talentbolelist', UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
