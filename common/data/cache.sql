#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `verifycodecache`;
CREATE TABLE `verifycodecache` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `verificode` int(6) unsigned NOT NULL COMMENT '短信验证码',
  `cachekey` varchar(255) NOT NULL COMMENT 'rediskey',
  `timeout` bigint NOT NULL DEFAULT 0 COMMENT '超时',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY (`cachekey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;