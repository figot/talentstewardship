#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `experience`;
CREATE TABLE `experience` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `company` varchar(255) NOT NULL COMMENT '单位名称',
  `industry` varchar(255) NOT NULL COMMENT '行业',
  `job` varchar(255) NOT NULL COMMENT '职位',
  `jobcontent` text NOT NULL COMMENT '工作内容',
  `expstart` varchar(255) NOT NULL COMMENT '开始时间',
  `expend` varchar(255) NOT NULL COMMENT '结束时间',
  `status` tinyint(6) unsigned NOT NULL DEFAULT 0 COMMENT '状态，公开0、隐藏1',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;