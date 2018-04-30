#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `newstype` int(10) NOT NULL DEFAULT 1 COMMENT '资讯类型',
  `typename` varchar(20) NOT NULL COMMENT '资讯类型名称',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '资讯信息状态，1编辑中,2已发布,3已结束',
  `title` varchar(500) DEFAULT NULL COMMENT '资讯标题',
  `url` varchar(500) DEFAULT NULL COMMENT '落地页链接',
  `content` text NOT NULL COMMENT '资讯内容',
  `release_time` bigint NOT NULL DEFAULT 0 COMMENT '发布时间',
  `thumbnail` varchar(255) NOT NULL COMMENT '缩略图链接',
  `can_share` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '是否可以分享, 0不能分享, 1能分享',
  `read_count` int(10) unsigned DEFAULT 0 NOT NULL COMMENT '阅读次数',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `release_time` (`release_time`),
  KEY `newstype` (`newstype`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- INSERT INTO news (newstype, typename, status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES (1, '通知公告', 2, '测试资讯中心接口1', '测试资讯中心内容1', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO news (newstype, typename, status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES (1, '通知公告', 2, '测试资讯中心接口2', '测试资讯中心内容2', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO news (newstype, typename, status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES (1, '通知公告', 2, '测试资讯中心接口3', '测试资讯中心内容3', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO news (newstype, typename, status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES (1, '通知公告', 2, '测试资讯中心接口4', '测试资讯中心内容4', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO news (newstype, typename, status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES (1, '通知公告', 2, '测试资讯中心接口5', '测试资讯中心内容5', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO news (newstype, typename, status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES (1, '通知公告', 2, '测试资讯中心接口6', '测试资讯中心内容6', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO news (newstype, typename, status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES (1, '通知公告', 2, '测试资讯中心接口7', '测试资讯中心内容7', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO news (newstype, typename, status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES (1, '通知公告', 2, '测试资讯中心接口8', '测试资讯中心内容8', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO news (newstype, typename, status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES (1, '通知公告', 2, '测试资讯中心接口9', '测试资讯中心内容9', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO news (newstype, typename, status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES (1, '通知公告', 2, '测试资讯中心接口10', '测试资讯中心内容10', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO news (newstype, typename, status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES (1, '通知公告', 2, '测试资讯中心接口11', '测试资讯中心内容11', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
