#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `ad`;
CREATE TABLE `ad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '资讯信息状态，1编辑中,2已发布,3已结束',
  `title` varchar(500) DEFAULT NULL COMMENT '资讯标题',
  `url` varchar(500) DEFAULT NULL COMMENT '落地页链接',
  `jumpurl` varchar(500) DEFAULT NULL COMMENT '第三方跳转链接',
  `content` text NOT NULL COMMENT '资讯内容',
  `release_time` bigint NOT NULL DEFAULT 0 COMMENT '发布时间',
  `thumbnail` varchar(255) NOT NULL COMMENT '缩略图链接',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `release_time` (`release_time`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;