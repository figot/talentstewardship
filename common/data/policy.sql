#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `policy`;
CREATE TABLE `policy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `department` varchar(255) NOT NULL COMMENT '政策发布部门',
  `policytype` int(10) NOT NULL DEFAULT 1 COMMENT '政策类型',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '政策状态，1编辑中,2已发布,3已结束',
  `title` varchar(500) DEFAULT NULL COMMENT '标题',
  `url` varchar(500) DEFAULT NULL COMMENT '落地页链接',
  `content` text COMMENT '内容',
  `suit_per` varchar(255) NOT NULL DEFAULT '' COMMENT '适用人才',
  `suit_area` varchar(255) NOT NULL DEFAULT '' COMMENT '适用区域',
  `can_share` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '是否可以分享, 0不能分享, 1能分享',
  `release_time` bigint NOT NULL DEFAULT 0 COMMENT '发布时间',
  `thumbnail` varchar(255) NOT NULL COMMENT '缩略图链接',
  `read_count` int(10) unsigned DEFAULT 0 NOT NULL COMMENT '阅读次数',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `release_time` (`release_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `policyapply`;
CREATE TABLE `policyapply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '申报人',
  `policyid` int(10) unsigned NOT NULL COMMENT '政策id',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '申报状态，0申报中,1待审核,2已审核,3已反馈',
  `applytime` bigint NOT NULL DEFAULT 0 COMMENT '申报时间',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY (`policyid`, `user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- INSERT INTO policy (department, policytype, pol_status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES ('人事管理局', 1, 2, '测试政策接口1', '政策内容1', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO policy (department, policytype, pol_status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES ('人事管理局', 1, 2, '测试政策接口2', '政策内容2', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO policy (department, policytype, pol_status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES ('人事管理局', 1, 2, '测试政策接口3', '政策内容3', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO policy (department, policytype, pol_status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES ('人事管理局', 1, 2, '测试政策接口4', '政策内容4', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO policy (department, policytype, pol_status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES ('人事管理局', 2, 2, '测试政策接口5', '政策内容5', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO policy (department, policytype, pol_status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES ('人事管理局', 2, 2, '测试政策接口6', '政策内容6', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO policy (department, policytype, pol_status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES ('人事管理局', 2, 2, '测试政策接口7', '政策内容7', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO policy (department, policytype, pol_status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES ('人事管理局', 2, 2, '测试政策接口8', '政策内容8', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO policy (department, policytype, pol_status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES ('人事管理局', 2, 2, '测试政策接口9', '政策内容9', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO policy (department, policytype, pol_status, title, content, release_time, thumbnail, read_count, created_at, updated_at) VALUES ('人事管理局', 2, 1, '测试政策接口10', '政策内容10', UNIX_TIMESTAMP(), 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
