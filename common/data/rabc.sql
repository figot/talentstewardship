DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(256) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  KEY `name` (`name`),
  KEY `route` (`route`(255)),
  KEY `order` (`order`),
  CONSTRAINT `dh_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `dh_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='系统管理员菜单权限表\r\n';

DROP TABLE IF EXISTS `yc_auth_rule`;
CREATE TABLE `yc_auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `name` (`name`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员权限规则表';

DROP TABLE IF EXISTS `yc_auth_item_child`;
CREATE TABLE `yc_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员权限关系表';

DROP TABLE IF EXISTS `yc_auth_item`;
CREATE TABLE `yc_auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`),
  KEY `name` (`name`),
  KEY `created_at` (`created_at`),
  CONSTRAINT `yc_auth_item_ibfk_2` FOREIGN KEY (`rule_name`) REFERENCES `yc_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理权权限条目';

DROP TABLE IF EXISTS `yc_auth_assignment`;
CREATE TABLE `yc_auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`),
  KEY `item_name` (`item_name`),
  CONSTRAINT `yc_auth_assignment_ibfk_2` FOREIGN KEY (`item_name`) REFERENCES `yc_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员授权表';