#create database if not exists talent default charset utf8;
#use talent;

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL COMMENT '',
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(6) unsigned NOT NULL DEFAULT 10 COMMENT '',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `admin_log`;
CREATE TABLE `admin_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `route` varchar(255) NOT NULL COMMENT '',
  `url` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `gets` text DEFAULT NULL,
  `posts` text NOT NULL,
  `admin_id` int(11) unsigned NOT NULL COMMENT '',
  `admin_email` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO admin (username, auth_key, password_hash, password_reset_token, email, status, created_at, updated_at) VALUES ('18501171994', 'l1-qdj21Vu437bfbf7siDwowhXM55YWN', '$2y$13$5f5HA2q/HpNcEAaLbJNEoesU6ob6DOPxKBBasuwNyzVh1BlMAc6ve', null, 'fansufei@foxmail.com', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());