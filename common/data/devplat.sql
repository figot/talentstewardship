#create database if not exists talent default charset utf8;

#use talent;

#科研动态
DROP TABLE IF EXISTS `devtrends`;
CREATE TABLE `devtrends` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，1编辑中,2已发布,3已结束',
  `title` varchar(500) DEFAULT NULL COMMENT '标题',
  `url` varchar(500) DEFAULT NULL COMMENT '落地页链接',
  `content` text NOT NULL COMMENT '内容',
  `release_time` bigint NOT NULL DEFAULT 0 COMMENT '发布时间',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `release_time` (`release_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

##科研平台
DROP TABLE IF EXISTS `devplat`;
CREATE TABLE `devplat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，1编辑中,2已发布,3已结束',
  `category` tinyint(6) unsigned NOT NULL DEFAULT 1 COMMENT '平台类别,1公共技术服务平台,2重点实验室,3工程技术研究中心',
  `platname` varchar(60) DEFAULT NULL COMMENT '名称',
  `field` varchar(60) DEFAULT NULL COMMENT '领域,软件与信息技术',
  `plevel` varchar(60) DEFAULT NULL COMMENT '平台级别，国际级，省级，市级',
  `url` varchar(500) DEFAULT NULL COMMENT '落地页链接',
  `content` text DEFAULT NULL COMMENT '内容',
  `plattype` varchar(60) DEFAULT NULL COMMENT '平台类型, 研发',
  `create_year` varchar(60) DEFAULT NULL COMMENT '建设年份',
  `release_time` bigint NOT NULL DEFAULT 0 COMMENT '发布时间',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `release_time` (`release_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

##设备共享
DROP TABLE IF EXISTS `deviceshare`;
CREATE TABLE `deviceshare` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，1编辑中,2已发布,3已结束',
  `category` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '类别',
  `devicename` varchar(60) DEFAULT NULL COMMENT '设备名称',
  `url` varchar(500) DEFAULT NULL COMMENT '落地页链接',
  `content` text DEFAULT NULL COMMENT '内容',
  `release_time` bigint NOT NULL DEFAULT 0 COMMENT '发布时间',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `release_time` (`release_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- INSERT INTO researchtrends (status, title, content, release_time, created_at, updated_at) VALUES (2, '软件园三期员工首次破万,是继软件园二期的又一人气高地1', '软件园三期员工首次破万,是继软件园二期的又一人气高地,详细内容1', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO researchtrends (status, title, content, release_time, created_at, updated_at) VALUES (2, '软件园三期员工首次破万,是继软件园二期的又一人气高地2', '软件园三期员工首次破万,是继软件园二期的又一人气高地,详细内容2', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO researchtrends (status, title, content, release_time, created_at, updated_at) VALUES (2, '软件园三期员工首次破万,是继软件园二期的又一人气高地3', '软件园三期员工首次破万,是继软件园二期的又一人气高地,详细内容3', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO researchplat (status, category, categoryname, platname, field, plevel, content, plattype,  create_year, release_time, created_at, updated_at) VALUES (2, 1, '公共技术服务平台', '宁波通信终端产业供应链继承服务公共平台1', '软件与信息技术', '', '宁波通信终端产业供应链继承服务公共平台1', '研发', '', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO researchplat (status, category, categoryname, platname, field, plevel, content, plattype,  create_year, release_time, created_at, updated_at) VALUES (2, 1, '公共技术服务平台', '宁波通信终端产业供应链继承服务公共平台2', '软件与信息技术', '', '宁波通信终端产业供应链继承服务公共平台1', '研发', '', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO researchplat (status, category, categoryname, platname, field, plevel, content, plattype,  create_year, release_time, created_at, updated_at) VALUES (2, 1, '公共技术服务平台', '宁波通信终端产业供应链继承服务公共平台3', '软件与信息技术', '', '宁波通信终端产业供应链继承服务公共平台1', '研发', '', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO researchplat (status, category, categoryname, platname, field, plevel, content, plattype,  create_year, release_time, created_at, updated_at) VALUES (2, 1, '公共技术服务平台', '宁波通信终端产业供应链继承服务公共平台4', '软件与信息技术', '', '宁波通信终端产业供应链继承服务公共平台1', '研发', '', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO researchplat (status, category, categoryname, platname, field, plevel, content, plattype,  create_year, release_time, created_at, updated_at) VALUES (2, 1, '公共技术服务平台', '宁波通信终端产业供应链继承服务公共平台5', '软件与信息技术', '', '宁波通信终端产业供应链继承服务公共平台1', '研发', '', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO researchplat (status, category, categoryname, platname, field, plevel, content, plattype,  create_year, release_time, created_at, updated_at) VALUES (2, 2, '重点实验室', '固体表面物理化学国家重点实验室1', '', '国家级', '固体表面物理化学国家重点实验室1', '', '2017', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO researchplat (status, category, categoryname, platname, field, plevel, content, plattype,  create_year, release_time, created_at, updated_at) VALUES (2, 2, '重点实验室', '固体表面物理化学国家重点实验室2', '', '国家级', '固体表面物理化学国家重点实验室2', '', '2017', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO researchplat (status, category, categoryname, platname, field, plevel, content, plattype,  create_year, release_time, created_at, updated_at) VALUES (2, 2, '重点实验室', '固体表面物理化学国家重点实验室1', '', '省级', '固体表面物理化学国家重点实验室3', '', '2017', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO researchplat (status, category, categoryname, platname, field, plevel, content, plattype,  create_year, release_time, created_at, updated_at) VALUES (2, 2, '重点实验室', '固体表面物理化学国家重点实验室1', '', '省级', '固体表面物理化学国家重点实验室4', '', '2017', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO researchplat (status, category, categoryname, platname, field, plevel, content, plattype,  create_year, release_time, created_at, updated_at) VALUES (2, 2, '重点实验室', '固体表面物理化学国家重点实验室1', '', '市级', '固体表面物理化学国家重点实验室5', '', '2017', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
-- INSERT INTO researchplat (status, category, categoryname, platname, field, plevel, content, plattype,  create_year, release_time, created_at, updated_at) VALUES (2, 2, '重点实验室', '固体表面物理化学国家重点实验室1', '', '市级', '固体表面物理化学国家重点实验室6', '', '2017', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
