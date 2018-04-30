#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `area`;
CREATE TABLE `area` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(2055) DEFAULT NULL COMMENT '区域名称',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;