#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `activity`;
CREATE TABLE `activity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `department` varchar(255) NOT NULL COMMENT '活动组织部门',
  `acttype` int(10) NOT NULL COMMENT '活动类型,1培训资讯2展会动态3学术交流4联谊活动',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '活动状态，1创键中,2进行中,3已结束',
  `title` varchar(255) NOT NULL COMMENT '活动标题',
  `url` varchar(500) DEFAULT NULL COMMENT '落地页链接',
  `content` text NOT NULL COMMENT '活动内容',
  `activity_time` DATETIME NOT NULL  COMMENT '活动时间',
  `activity_pos` varchar(255) NOT NULL COMMENT '活动地点',
  `user_cnt` bigint NOT NULL DEFAULT 0 COMMENT '活动报名人数',
  `thumbnail` varchar(255) NOT NULL COMMENT '缩略图链接',
  `read_count` int(10) unsigned NOT NULL DEFAULT 0  COMMENT '阅读次数',
  `release_time` bigint NOT NULL DEFAULT 0 COMMENT '发布时间',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `activity_user`;
CREATE TABLE `activity_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activity_id` int(10) unsigned NOT NULL COMMENT '活动id',
  `uid` int(10) unsigned NOT NULL COMMENT '活动报名人',
  `enroll_time` bigint NOT NULL DEFAULT 0 COMMENT '申报时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 1, 2, 'Autodesk modeFlow联合仿真新技术学术交流培训会', 'Autodesk modeFlow联合仿真新技术学术交流培训会', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 1, 2, 'Autodesk modeFlow联合仿真新技术学术交流培训会', 'Autodesk modeFlow联合仿真新技术学术交流培训会', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 1, 2, 'Autodesk modeFlow联合仿真新技术学术交流培训会', 'Autodesk modeFlow联合仿真新技术学术交流培训会', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 1, 2, 'Autodesk modeFlow联合仿真新技术学术交流培训会', 'Autodesk modeFlow联合仿真新技术学术交流培训会', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
--
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 2, 2, '2017年浙江海外留学人才与项目对接会1', '2017年浙江海外留学人才与项目对接会', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 2, 2, '2017年浙江海外留学人才与项目对接会2', '2017年浙江海外留学人才与项目对接会', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 2, 2, '2017年浙江海外留学人才与项目对接会3', '2017年浙江海外留学人才与项目对接会', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 2, 2, '2017年浙江海外留学人才与项目对接会4', '2017年浙江海外留学人才与项目对接会', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 2, 1, '2017年浙江海外留学人才与项目对接会5', '2017年浙江海外留学人才与项目对接会', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 2, 2, '2017年浙江海外留学人才与项目对接会', '2017年浙江海外留学人才与项目对接会', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
--
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 3, 2, 'Autodesk modeFlow联合仿真新技术学术交流', 'Autodesk modeFlow联合仿真新技术学术交流', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 3, 2, 'Autodesk modeFlow联合仿真新技术学术交流', 'Autodesk modeFlow联合仿真新技术学术交流', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 3, 2, 'Autodesk modeFlow联合仿真新技术学术交流', 'Autodesk modeFlow联合仿真新技术学术交流', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 3, 2, 'Autodesk modeFlow联合仿真新技术学术交流', 'Autodesk modeFlow联合仿真新技术学术交流', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
--
--
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 4, 2, '宁波市开展公益慈善主题人才活动1', '宁波市开展公益慈善主题人才活动', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 4, 2, '宁波市开展公益慈善主题人才活动2', '宁波市开展公益慈善主题人才活动', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 4, 2, '宁波市开展公益慈善主题人才活动3', '宁波市开展公益慈善主题人才活动', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 4, 2, '宁波市开展公益慈善主题人才活动4', '宁波市开展公益慈善主题人才活动', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 4, 2, '宁波市开展公益慈善主题人才活动5', '宁波市开展公益慈善主题人才活动', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 4, 2, '宁波市开展公益慈善主题人才活动6', '宁波市开展公益慈善主题人才活动', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO activity (department, acttype, status, title, content, activity_time, activity_pos, thumbnail, read_count, release_time, created_at, updated_at) VALUES (
-- '宁波市人才办', 4, 2, '宁波市开展公益慈善主题人才活动7', '宁波市开展公益慈善主题人才活动', CURDATE(), '宁波', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
