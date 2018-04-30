#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `talentcategory`;
CREATE TABLE `talentcategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `talentlevel` varchar(4096) DEFAULT NULL COMMENT '人才级别',
  `talentcondition` text NOT NULL COMMENT '人才条件',
  `isshow` tinyint(6) unsigned NOT NULL DEFAULT 1 COMMENT '状态，隐藏1,公开展示2',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `talentfiles`;
CREATE TABLE `talentfiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `talentcategoryid` int(10) unsigned NOT NULL COMMENT '人才类别id',
  `isrequired` tinyint(1) NOT NULL DEFAULT 0  COMMENT '是否为必选材料,1必选，0可选',
  `filetemplateurl` varchar(255) NOT NULL COMMENT '文件模板地址',
  `templatename` varchar(255) NOT NULL COMMENT '模板名称',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `talentapply`;
CREATE TABLE `talentapply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `talentcategoryid` int(10) unsigned NOT NULL COMMENT '人才级别id',
  `remark` text NOT NULL COMMENT '备注',
  `reason` text NULL COMMENT '原因',
  `applystatus` tinyint(6) unsigned NOT NULL DEFAULT 1 COMMENT '状态',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  UNIQUE KEY (`talentcategoryid`, `user_id`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `talentapplyfiles`;
CREATE TABLE `talentapplyfiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `talentapplyid` int(10) unsigned NOT NULL COMMENT '申请id',
  `templateid` int(10) unsigned NOT NULL COMMENT '材料模板id',
  `filesign` varchar(255) NOT NULL COMMENT '文件sign',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

