#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `version`;
CREATE TABLE `version` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL COMMENT '版本',
  `url` varchar(500) DEFAULT NULL COMMENT '下载链接',
  `ostype` varchar(255) NOT NULL COMMENT '系统类型, ios android',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO version (version, url, ostype, created_at, updated_at) VALUES ('1.1.6', 'http://www.baidu.com', 'android',  UNIX_TIMESTAMP(), UNIX_TIMESTAMP());