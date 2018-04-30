#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `username` varchar(32) NOT NULL COMMENT '',
  `companyname` varchar(60) NOT NULL DEFAULT '' COMMENT '公司注册备案名称',
  `address` varchar(511) NOT NULL DEFAULT '' COMMENT '联系地址',
  `taxno` varchar(511) NOT NULL DEFAULT '' COMMENT '税号',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '邮箱',
  `mobile` char(11) NOT NULL COMMENT '手机号',
  `business_license` varchar(255) NULL COMMENT '营业执照图片sign',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 1 COMMENT '状态，1待审核,2审核通过,3审核不通过',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `companyname` (`companyname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;