#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `userdepartmap`;
CREATE TABLE `userdepartmap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `subdepartid` int(10) unsigned NULL COMMENT '二级区域id',
  `isroot` tinyint(6) unsigned NOT NULL DEFAULT 3 COMMENT '状态，1管理员用户 2普通用户 3 区域管理员',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `departmenu`;
CREATE TABLE `departmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`parent`) REFERENCES `departmenu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='部门菜单';