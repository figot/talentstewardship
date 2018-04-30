#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `educationlevelconf`;
CREATE TABLE `educationlevelconf` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `educate` varchar(255) NOT NULL COMMENT '教育级别',
  `talentlevel` varchar(500) DEFAULT NULL COMMENT '人才级别名称',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `departmenu`;
CREATE TABLE `departmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`parent`) REFERENCES `departmenu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='部门菜单';