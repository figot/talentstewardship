#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `demand`;
CREATE TABLE `demand` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dtype` int(10) NOT NULL DEFAULT 0 COMMENT '需求信息类型',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，1编辑中,2已发布,3已结束,4已提交',
  `title` varchar(500) DEFAULT NULL COMMENT '需求信息标题',
  `url` varchar(500) DEFAULT NULL COMMENT '需求信息落地页链接',
  `content` text NOT NULL COMMENT '需求信息内容',
  `release_time` bigint NOT NULL DEFAULT 0 COMMENT '发布时间',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `release_time` (`release_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

