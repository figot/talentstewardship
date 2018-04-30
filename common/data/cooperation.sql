#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `cooperation`;
CREATE TABLE `cooperation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ctype` int(10) NOT NULL DEFAULT 0 COMMENT '项目合作类型,1我有技术，2我有项目，3我找技术，4我找项目',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，1已提交,2已发布,3已结束',
  `title` varchar(500) DEFAULT NULL COMMENT '项目合作通知标题',
  `url` varchar(500) DEFAULT NULL COMMENT '项目合作通知落地页链接',
  `content` text NOT NULL COMMENT '项目合作内容',
  `user_id` int(10) unsigned NOT NULL COMMENT '项目合作发布人',
  `release_time` bigint NOT NULL DEFAULT 0 COMMENT '发布时间',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `release_time` (`release_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- INSERT INTO cooperation (ctype, status, title, content, user_id, release_time, created_at, updated_at) VALUES (1, 2, '一种异氟尔酮选择性加氢设备3，3，5-三甲基环己酮的方法1', '一种异氟尔酮选择性加氢设备3，3，5-三甲基环己酮的方法1', 1,UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO cooperation (ctype, status, title, content, user_id, release_time, created_at, updated_at) VALUES (1, 2, '一种异氟尔酮选择性加氢设备3，3，5-三甲基环己酮的方法2', '2016年国家千人计划申报工作的通知如下总体要求2', 1,UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO cooperation (ctype, status, title, content, user_id, release_time, created_at, updated_at) VALUES (1, 2, '一种异氟尔酮选择性加氢设备3，3，5-三甲基环己酮的方法3', '2016年国家千人计划申报工作的通知如下总体要求3', 1,UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO cooperation (ctype, status, title, content, user_id, release_time, created_at, updated_at) VALUES (2, 2, '异氟尔酮选择性加氢设备3，3，5-三甲基环己酮的成熟技术，寻找项目合伙人1', '异氟尔酮选择性加氢设备3，3，5-三甲基环己酮的成熟技术，寻找项目合伙人1', 1,UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO cooperation (ctype, status, title, content, user_id, release_time, created_at, updated_at) VALUES (2, 2, '异氟尔酮选择性加氢设备3，3，5-三甲基环己酮的成熟技术，寻找项目合伙人2', '异氟尔酮选择性加氢设备3，3，5-三甲基环己酮的成熟技术，寻找项目合伙人2', 1,UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO cooperation (ctype, status, title, content, user_id, release_time, created_at, updated_at) VALUES (2, 2, '异氟尔酮选择性加氢设备3，3，5-三甲基环己酮的成熟技术，寻找项目合伙人3', '异氟尔酮选择性加氢设备3，3，5-三甲基环己酮的成熟技术，寻找项目合伙人3', 1,UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO cooperation (ctype, status, title, content, user_id, release_time, created_at, updated_at) VALUES (3, 2, '寻找"薄膜开发、人机互动"方面的专利或者相关项目技术1', '寻找"薄膜开发、人机互动"方面的专利或者相关项目技术1', 1,UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO cooperation (ctype, status, title, content, user_id, release_time, created_at, updated_at) VALUES (3, 2, '寻找"薄膜开发、人机互动"方面的专利或者相关项目技术2', '寻找"薄膜开发、人机互动"方面的专利或者相关项目技术2', 1,UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO cooperation (ctype, status, title, content, user_id, release_time, created_at, updated_at) VALUES (3, 2, '寻找"薄膜开发、人机互动"方面的专利或者相关项目技术3', '寻找"薄膜开发、人机互动"方面的专利或者相关项目技术3', 1,UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
