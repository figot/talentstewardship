#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `lifeservice`;
CREATE TABLE `lifeservice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称',
  `category` varchar(255) NOT NULL COMMENT '类别',
  `iconurl` varchar(2056) NOT NULL COMMENT 'icon图标地址',
  `url` varchar(2056) NOT NULL COMMENT '跳转链接',
  `appurl` varchar(2056) NOT NULL COMMENT '跳转链接',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，1编辑中,2已发布,3已结束,4审核中',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `otherservice`;
CREATE TABLE `otherservice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称',
  `category` varchar(255) NOT NULL COMMENT '类别',
  `iconurl` varchar(2056) NOT NULL COMMENT 'icon图标地址',
  `url` varchar(2056) NOT NULL COMMENT '跳转链接',
  `appurl` varchar(2056) NOT NULL COMMENT '跳转链接',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，1编辑中,2已发布,3已结束,4审核中',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;