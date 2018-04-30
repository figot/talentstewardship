#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `collect`;
CREATE TABLE IF NOT EXISTS `collect` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `cid` int(10) unsigned NOT NULL COMMENT '收藏的id，分别对应于资讯还是政策',
  `ctype` int(10) unsigned NOT NULL COMMENT '类型，1 政策, 2 资讯',
  `collect_status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，0 未收藏, 1 已收藏',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  UNIQUE KEY (`user_id`, `cid`, `ctype`),
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;