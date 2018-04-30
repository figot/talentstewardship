#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `recruit`;
CREATE TABLE `recruit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `department` varchar(255) NOT NULL DEFAULT '' COMMENT '招聘信息发布部门',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 1 COMMENT '招聘信息状态，1编辑中,2已发布,3已结束',
  `title` varchar(500) NOT NULL DEFAULT '' COMMENT '招聘标题',
  `url` varchar(500) DEFAULT NULL COMMENT '落地页链接',
  `content` text NOT NULL COMMENT '招聘内容',
  `job` varchar(255) NOT NULL DEFAULT '' COMMENT '招聘职位',
  `welfare` varchar(255) NOT NULL DEFAULT '' COMMENT '福利',
  `company` varchar(255) NOT NULL DEFAULT '' COMMENT '招聘单位',
  `attibute` varchar(255) NOT NULL DEFAULT '' COMMENT '单位性质',
  `salary` varchar(255) NOT NULL DEFAULT '' COMMENT '薪资',
  `release_time` bigint NOT NULL DEFAULT 0 COMMENT '发布时间',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `release_time` (`release_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `applier`;
CREATE TABLE `applier` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL COMMENT '应聘信息发布人',
  `applier_name` varchar(255) NOT NULL COMMENT '应聘人才',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 1 COMMENT '应聘信息状态，1编辑中,2已发布,3已结束',
  `atype` tinyint(6) unsigned NOT NULL DEFAULT 2 COMMENT '应聘信息类型，2自荐，3荐才',
  `tlevel` varchar(60) NOT NULL COMMENT '人才类别',
  `job` varchar(255) NOT NULL COMMENT '曾任职位',
  `company` varchar(255) NOT NULL COMMENT '曾任单位',
  `title` varchar(60) DEFAULT NULL COMMENT '应聘标题',
  `url` varchar(500) DEFAULT NULL COMMENT '落地页链接',
  `content` text NOT NULL COMMENT '应聘内容',
  `portrait` varchar(255) NOT NULL COMMENT '头像',
  `good_fields` varchar(2056) NOT NULL COMMENT '擅长领域',
  `release_time` bigint NOT NULL DEFAULT 0 COMMENT '发布时间',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `release_time` (`release_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO recruit (department, status, title, url, content, job, welfare, company, attibute, salary, release_time, created_at, updated_at) VALUES ('人事管理局', 2, '招聘宁波大学副校长', 'http://47.93.42.27/f/web/wap/recruit?id=', '招聘宁波大学副校长内容', '宁波大学副校长', '送房,科研经费,公费深造,家属安置,人才津贴', '宁波大学', '事业单位', '年薪:60万', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO recruit (department, status, title, url, content, job, welfare, company, attibute, salary, release_time, created_at, updated_at) VALUES ('人事管理局', 2, '招聘宁波大学数学系主任', 'http://47.93.42.27/f/web/wap/recruit?id=', '招聘宁波大学副校长内容', '宁波大学副校长', '送房,科研经费,公费深造,家属安置,人才津贴', '宁波大学', '事业单位', '年薪:60万', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO recruit (department, status, title, url, content, job, welfare, company, attibute, salary, release_time, created_at, updated_at) VALUES ('人事管理局', 2, '招聘宁波大学计算机学院院长', 'http://47.93.42.27/f/web/wap/recruit?id=', '招聘宁波大学副校长内容', '宁波大学副校长', '送房,科研经费,公费深造,家属安置,人才津贴', '宁波大学', '事业单位', '年薪:60万', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO recruit (department, status, title, url, content, job, welfare, company, attibute, salary, release_time, created_at, updated_at) VALUES ('人事管理局', 2, '招聘浙江大学校长', 'http://47.93.42.27/f/web/wap/recruit?id=', '招聘浙江大学校长内容', '宁波大学副校长', '送房,科研经费,公费深造,家属安置,人才津贴', '宁波大学', '事业单位', '年薪:60万', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO recruit (department, status, title, url, content, job, welfare, company, attibute, salary, release_time, created_at, updated_at) VALUES ('人事管理局', 2, '招聘宁波大学副校长', 'http://47.93.42.27/f/web/wap/recruit?id=', '招聘宁波大学副校长内容', '宁波大学副校长', '送房,科研经费,公费深造,家属安置,人才津贴', '宁波大学', '事业单位', '年薪:60万', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO recruit (department, status, title, url, content, job, welfare, company, attibute, salary, release_time, created_at, updated_at) VALUES ('人事管理局', 2, '招聘宁波大学副校长', 'http://47.93.42.27/f/web/wap/recruit?id=', '招聘宁波大学副校长内容', '宁波大学副校长', '送房,科研经费,公费深造,家属安置,人才津贴', '宁波大学', '事业单位', '年薪:60万', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());


INSERT INTO applier (user_id, applier_name, status, atype, tlevel, job, company, title, url, content, portrait, good_fields,release_time, created_at, updated_at) VALUES(16, '张涛', 2, 2, 'A类人才', '副校长', '浙江大学', '', 'http://47.93.42.27/f/web/wap/applier?id=', '', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', '石墨烯,光伏,核电', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO applier (user_id, applier_name, status, atype, tlevel, job, company, title, url, content, portrait, good_fields,release_time, created_at, updated_at) VALUES(3, '刘丽', 2, 2, 'A类人才', '副校长', '浙江大学', '', 'http://47.93.42.27/f/web/wap/applier?id=', '', 'http://pic23.photophoto.cn/20120530/0020033092420808_b.jpg', '石墨烯,光伏,核电', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
