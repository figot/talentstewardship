#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `depart`;
CREATE TABLE `depart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `department` varchar(2055) DEFAULT NULL COMMENT '一级区域名称',
  `subdepart` varchar(2055) DEFAULT NULL COMMENT '二级区域名称',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;