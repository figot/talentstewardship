#create database if not exists talent default charset utf8;

#use talent;

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `hotelid` int(10) unsigned NOT NULL COMMENT '酒店id',
  `user_name` varchar(60) NOT NULL COMMENT '姓名',
  `id_number` varchar(20) NOT NULL COMMENT '身份证号',
  `chkindt` bigint NULL COMMENT '签入',
  `chkoutdt` bigint NULL COMMENT '签出',
  `startdt` bigint NOT NULL COMMENT '开始日期',
  `enddt` bigint NOT NULL COMMENT '结束日期',
  `rooms` int(30) NOT NULL DEFAULT 0 COMMENT '房间数',
  `roomtype` varchar(20) NOT NULL COMMENT '房间类型',
  `ischkinbeforedate` int NOT NULL COMMENT '是否18点前入住',
  `out_trade_no` varchar(256) NOT NULL COMMENT '订单id',
  `price` int(30) unsigned NOT NULL DEFAULT 0 COMMENT '支付金额',
  `pay_status` tinyint(6) unsigned NOT NULL DEFAULT 1 COMMENT '支付状态，1 未支付, 2支付成功, 3支付失败, 4退款中, 5退款完成',
  `pay_type` tinyint(6) unsigned NOT NULL DEFAULT 1 COMMENT '支付类型，1 支付宝, 2微信支付',
  `status` tinyint(6) unsigned NOT NULL COMMENT '状态，1未入住,2入住中,3已结束,4已取消',
  `hotelcheckstatus` tinyint(6) unsigned NOT NULL DEFAULT 1 COMMENT '状态，1未确认,2已确认通过,3酒店确认不通过',
  `created_at` bigint NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` bigint NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY(`id`),
  UNIQUE KEY(`out_trade_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;