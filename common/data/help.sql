#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `help`;
CREATE TABLE `help` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(1024) NOT NULL COMMENT '标题',
  `content` text NULL COMMENT '内容',
  `url` varchar(2048) DEFAULT NULL COMMENT '落地页链接',
  `showorder` int(10) unsigned NOT NULL COMMENT '排序',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;