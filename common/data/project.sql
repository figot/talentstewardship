#create database if not exists talent default charset utf8;

#use talent;

#项目合作表
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ptype` int(10) NOT NULL DEFAULT 1 COMMENT '申报通知类型,1国家级，2省级，3市级',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，1编辑中,2已发布,3已结束,4审核中',
  `title` varchar(500) DEFAULT NULL COMMENT '申报通知标题',
  `brief` text NULL  COMMENT '项目简介',
  `department` varchar(255) NOT NULL COMMENT '组织部门',
  `url` varchar(500) DEFAULT NULL COMMENT '落地页链接',
  `jumpurl` varchar(2096) DEFAULT NULL COMMENT '第三方跳转链接',
  `content` text NULL COMMENT '申报通知内容',
  `release_time` bigint NOT NULL DEFAULT 0 COMMENT '发布时间',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `release_time` (`release_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `projecttemplate`;
CREATE TABLE `projecttemplate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `projectid` int(10) unsigned NOT NULL COMMENT '人才类别id',
  `isrequired` tinyint(1) NOT NULL DEFAULT 1  COMMENT '是否为必选材料,1必选，0可选',
  `filetemplateurl` varchar(255) NOT NULL COMMENT '文件模板地址',
  `templatename` varchar(255) NOT NULL COMMENT '模板名称',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#项目申报申请
DROP TABLE IF EXISTS `projectapply`;
CREATE TABLE `projectapply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '申报人',
  `projectid` int(10) unsigned NOT NULL COMMENT '项目id',
  `applystatus` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '申报状态，认证中1,已受理2,未通过3',
  `remark` text NULL COMMENT '备注',
  `reason` text NULL COMMENT '原因',
  `applytime` bigint NOT NULL DEFAULT 0 COMMENT '申报时间',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY (`projectid`, `user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `projectapplyfiles`;
CREATE TABLE `projectapplyfiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `projectapplyid` int(10) unsigned NOT NULL COMMENT '待遇申请id',
  `templateid` int(10) unsigned NOT NULL COMMENT '材料模板id',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `filesign` varchar(255) NOT NULL COMMENT '文件sign',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  UNIQUE KEY (`templateid`, `user_id`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


#市委考核项目
DROP TABLE IF EXISTS `checkproject`;
CREATE TABLE `checkproject` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ptype` int(10) NOT NULL DEFAULT 1 COMMENT '申报通知类型,1国家级，2省级，3市级',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，1编辑中,2已发布,3已结束,4审核中',
  `title` varchar(500) DEFAULT NULL COMMENT '申报通知标题',
  `brief` text NULL  COMMENT '项目简介',
  `department` varchar(255) NOT NULL COMMENT '组织部门',
  `url` varchar(500) DEFAULT NULL COMMENT '落地页链接',
  `jumpurl` varchar(2096) DEFAULT NULL COMMENT '第三方跳转链接',
  `content` text NULL COMMENT '申报通知内容',
  `release_time` bigint NOT NULL DEFAULT 0 COMMENT '发布时间',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `release_time` (`release_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#市委考核项目申报申请
DROP TABLE IF EXISTS `checkprojectapply`;
CREATE TABLE `checkprojectapply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `department` varchar(255) DEFAULT NULL COMMENT '申报单位',
  `projectid` int(10) unsigned NOT NULL COMMENT '项目id',
  `applystatus` tinyint(6) unsigned NOT NULL DEFAULT 1 COMMENT '申报状态，认证中1,已受理2,未通过3',
  `remark` text NULL COMMENT '备注',
  `reason` text NULL COMMENT '原因',
  `applytime` bigint NOT NULL DEFAULT 0 COMMENT '申报时间',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY (`projectid`, `department`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- INSERT INTO project (ptype, status, title, content, release_time, created_at, updated_at) VALUES (1, 2, '2016年国家千人计划申报工作的通知', '2016年国家千人计划申报工作的通知如下总体要求1', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO project (ptype, status, title, content, release_time, created_at, updated_at) VALUES (1, 2, '2016年国家千人计划申报工作的通知', '2016年国家千人计划申报工作的通知如下总体要求2', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO project (ptype, status, title, content, release_time, created_at, updated_at) VALUES (1, 2, '2016年国家千人计划申报工作的通知', '2016年国家千人计划申报工作的通知如下总体要求3', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO project (ptype, status, title, content, release_time, created_at, updated_at) VALUES (2, 2, '关于印发高新技术企业认定管理工作指引的通知', '关于印发高新技术企业认定管理工作指引的通知1', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO project (ptype, status, title, content, release_time, created_at, updated_at) VALUES (2, 2, '关于印发高新技术企业认定管理工作指引的通知', '关于印发高新技术企业认定管理工作指引的通知2', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO project (ptype, status, title, content, release_time, created_at, updated_at) VALUES (2, 2, '关于印发高新技术企业认定管理工作指引的通知', '关于印发高新技术企业认定管理工作指引的通知3', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO project (ptype, status, title, content, release_time, created_at, updated_at) VALUES (3, 2, '关于联合发布《宁波市科技计划申报指南》的通知', '关于联合发布《宁波市科技计划申报指南》的通知1', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO project (ptype, status, title, content, release_time, created_at, updated_at) VALUES (3, 2, '关于联合发布《宁波市科技计划申报指南》的通知', '关于联合发布《宁波市科技计划申报指南》的通知2', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO project (ptype, status, title, content, release_time, created_at, updated_at) VALUES (3, 2, '关于联合发布《宁波市科技计划申报指南》的通知', '关于联合发布《宁波市科技计划申报指南》的通知3', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
