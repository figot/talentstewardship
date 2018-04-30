#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `welfare`;
CREATE TABLE `welfare` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `job` varchar(255) NOT NULL COMMENT '现任职位',
  `user_name` varchar(60) NOT NULL DEFAULT '' COMMENT '姓名',
  `gender` varchar(10) NOT NULL DEFAULT '' COMMENT '性别,男、女',
  `id_number` varchar(20) NOT NULL DEFAULT '' COMMENT '身份证号',
  `weltype` varchar(10) NOT NULL DEFAULT '' COMMENT '享受级别',
  `applytype` varchar(10) NOT NULL DEFAULT '' COMMENT '申报级别',
  `tlevel` varchar(10) NOT NULL DEFAULT '' COMMENT '人才类别',
  `content` varchar(500) NOT NULL DEFAULT '' COMMENT '个人诉求',
  `file` varchar(500) NOT NULL DEFAULT '' COMMENT '上传文件',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，认证中1,已受理2,未通过3',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  UNIQUE KEY (`user_id`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `needs`;
CREATE TABLE `needs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `title` varchar(255) NOT NULL COMMENT '问题',
  `content` varchar(500) NOT NULL DEFAULT '' COMMENT '个人需求',
  `department` varchar(255) NOT NULL COMMENT '部门',
  `subdepart` varchar(255) NOT NULL COMMENT '二级部门',
  `reason` text NULL COMMENT '原因',
  `applystatus` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，认证中1,已受理2,未通过3',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `needsapplyfiles`;
CREATE TABLE `needsapplyfiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `needsapplyid` int(10) unsigned NOT NULL COMMENT '待遇申请id',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `filesign` varchar(255) NOT NULL COMMENT '文件sign',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#专属待遇
DROP TABLE IF EXISTS `treatment`;
CREATE TABLE `treatment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '待遇标题',
  `url` varchar(500) DEFAULT NULL COMMENT '落地页链接',
  `brief` text NOT NULL COMMENT '待遇简介',
  `content` text NOT NULL COMMENT '待遇内容',
  `department` varchar(255) NOT NULL COMMENT '组织部门',
  `treattype` int NOT NULL DEFAULT 2 COMMENT '享受类型，1查看类型,2申请类别',
  `looktype` int NOT NULL DEFAULT 0 COMMENT '查看类型，1查看酒店,2查看景区,3查看vip',
  `treatlevel` varchar(4096) NOT NULL COMMENT '待遇级别',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `treattemplate`;
CREATE TABLE `treattemplate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `treatid` int(10) unsigned NOT NULL COMMENT '人才类别id',
  `isrequired` tinyint(1) NOT NULL DEFAULT 0  COMMENT '是否为必选材料,1必选，0可选',
  `filetemplateurl` varchar(255) NOT NULL COMMENT '文件模板地址',
  `templatename` varchar(255) NOT NULL COMMENT '模板名称',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `treatmentapply`;
CREATE TABLE `treatmentapply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `treatid` int(10) unsigned NOT NULL COMMENT '待遇id',
  `user_name` varchar(255) NOT NULL COMMENT '名称',
  `id_number` varchar(20) NOT NULL DEFAULT '' COMMENT '身份证号',
  `remark` text NOT NULL COMMENT '备注',
  `reason` text NULL COMMENT '原因',
  `applystatus` tinyint(6) unsigned NOT NULL DEFAULT 1 COMMENT '状态, 1正在受理 2已通过 3已领取',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  UNIQUE KEY (`treatid`, `user_id`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `treatapplyfiles`;
CREATE TABLE `treatapplyfiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `treatapplyid` int(10) unsigned NOT NULL COMMENT '待遇申请id',
  `templateid` int(10) unsigned NOT NULL COMMENT '材料模板id',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `filesign` varchar(255) NOT NULL COMMENT '文件sign',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO treatment (title, url, brief, content, treattype, looktype, status, created_at, updated_at) VALUES
('赣州市酒店入住', '', '简介', '赣州市酒店入住', 1, 1, 2, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO treatment (title, url,brief, content, treattype, looktype, status, created_at, updated_at) VALUES
('赣州市景区游玩', '', '简介','赣州市景区游玩', 1, 2, 2, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO treatment (title, url,brief,  content, treattype, looktype, status, created_at, updated_at) VALUES
('赣州市通勤VIP通道', '','简介', 'vip详情', 1, 3, 2, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO treatment (title, url,brief,  content, treattype, status, created_at, updated_at) VALUES
('申报市级奖励', '', '简介', '市级奖励', 2, 2, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO treatment (title, url,brief,  content, treattype, status, created_at, updated_at) VALUES
('申报县级奖励', '', '简介', '县级奖励', 2, 2, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

