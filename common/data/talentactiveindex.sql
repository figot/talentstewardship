#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `talentactiveindex`;
CREATE TABLE `talentactiveindex` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `county` varchar(255) NOT NULL COMMENT '县市',
  `onlinecnt` bigint NOT NULL DEFAULT 0 COMMENT '在线人数',
  `incnt` bigint NOT NULL DEFAULT 0 COMMENT '人才流人数',
  `outcnt` bigint NOT NULL DEFAULT 0 COMMENT '人才流出数',
  `url` varchar(2055) DEFAULT NULL COMMENT '落地页链接',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，认证中1,已认证2,未通过3',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  UNIQUE KEY (`county`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `activeindexcoff`;
CREATE TABLE `activeindexcoff` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `radix` bigint NOT NULL DEFAULT 0 COMMENT '基数值',
  `ratio` bigint NOT NULL DEFAULT 0 COMMENT '倍数',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bolerewardapply`;
CREATE TABLE IF NOT EXISTS `bolerewardapply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `applyfile` varchar(1024) NOT NULL COMMENT '申请文件sign',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，1提交待审核,2已审核通过,3已结束',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO talentactiveindex (county, onlinecnt, incnt, outcnt, url, status,  created_at, updated_at) VALUES
('章贡区', 52173, 4657, 456, 'http://47.93.42.27/f/web/wap/activeindex', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO talentactiveindex (county, onlinecnt, incnt, outcnt, url, status,  created_at, updated_at) VALUES
('南康区', 99321, 4366, 278, 'http://47.93.42.27/f/web/wap/activeindex', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO talentactiveindex (county, onlinecnt, incnt, outcnt, url, status,  created_at, updated_at) VALUES
('瑞金市', 45131, 4366, 467, 'http://47.93.42.27/f/web/wap/activeindex', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO talentactiveindex (county, onlinecnt, incnt, outcnt, url, status,  created_at, updated_at) VALUES
('赣县', 43565, 22343, 904, 'http://47.93.42.27/f/web/wap/activeindex', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO talentactiveindex (county, onlinecnt, incnt, outcnt, url, status,  created_at, updated_at) VALUES
('大余县', 78235, 1143, 493, 'http://47.93.42.27/f/web/wap/activeindex', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO talentactiveindex (county, onlinecnt, incnt, outcnt, url, status,  created_at, updated_at) VALUES
('上犹县', 12312, 5867, 482, 'http://47.93.42.27/f/web/wap/activeindex', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO talentactiveindex (county, onlinecnt, incnt, outcnt, url, status,  created_at, updated_at) VALUES
('崇义县', 24531, 1143, 493, 'http://47.93.42.27/f/web/wap/activeindex', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO talentactiveindex (county, onlinecnt, incnt, outcnt, url, status,  created_at, updated_at) VALUES
('安远县', 34631, 5867, 482, 'http://47.93.42.27/f/web/wap/activeindex', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO talentactiveindex (county, onlinecnt, incnt, outcnt, url, status,  created_at, updated_at) VALUES
('大余县', 78235, 1143, 493, 'http://47.93.42.27/f/web/wap/activeindex', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
INSERT INTO talentactiveindex (county, onlinecnt, incnt, outcnt, url, status,  created_at, updated_at) VALUES
('全南县', 47111, 5867, 482, 'http://47.93.42.27/f/web/wap/activeindex', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());