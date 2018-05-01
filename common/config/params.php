<?php
return [
    'h5urlprefix' => 'http://111.75.255.185/f/web/wap/',
    'hostname' => 'http://111.75.255.185',
    'user.passwordResetTokenExpire' => 3600,
    'talent.policyType' => [
        1 => '中央',
        2 => '省级',
        3 => '市级',
        4 => '县级',
        5 => '其他',
    ],
    'talent.status' => [
        'edit' => 1, //编辑中
        'published' => 2 , //已发布
        'finished' => 3 ,//已终止
    ],
    'talent.statusName' => [
        1 => '提交待审核',
        2 => '已审核通过',
        3 => '审核不通过',
        4 => '已终止',
    ],
    'talent.applystatus' => [
        'noapply' => 0,
        'apply' => 1,
        'checkok' => 2,
        'finished' => 3,
        'nopass' => 4,
    ],
    'talent.applystatusname' => [
        0 => '立即申请',
        1 => '正在受理',
        2 => '已通过',
        3 => '已领取',
        4 => '申请不通过',
    ],
    'talent.applystatus2' => [
        'noapply' => 0,
        'apply' => 1,
        'checkok' => 2,
        'nopass' => 3,
    ],
    'talent.applystatusname2' => [
        0 => '立即申请',
        1 => '正在受理',
        2 => '已通过',
        3 => '申请不通过',
    ],
    'talent.treat.looktype' => 1,
    'talent.treat.applytype' => 2,
    'talent.treattype' => [
        1 => '查看类型',
        2 => '申请类型',
    ],
    'talent.authstatus' => [
        'unauth' => 1, //未认证
        'authing' => 2 , //认证中
        'authfail' => 3 ,//认证失败
        'authsuccess' => 4,//认证成功
    ],
    'talent.authstatusname' => [
        1 => '未认证',
        2 => '认证中',
        3 => '认证失败',
        4 => '认证成功',
    ],
    'talent.catestatus' => [
        'eduauth' => 1, //学历自动认证状态
        'talentauth' => 2 , //人才后台认证
    ],
    'weixinlogin' => 1,
    'qqlogin' => 2,
    'weibologin' => 3,
    'talent.department' => [
        '市级部门',
        '县级部门',
    ],
    'talent.newsType' => [
        1 => '通知公告',
        2 => '人才资讯',
        //3 => '工作动态',
        4 => '理论探索',
        5 => '他山之石',
    ],
    'talent.projectType' => [
        1 => '中央',
        2 => '省级',
        3 => '市级',
        4 => '县级',
    ],
    'talent.coopType' => [
        1 => '我有技术',
        2 => '我有项目',
        3 => '我找技术',
        4 => '我找项目',
    ],
    'talent.devplatType' => [
        1 => '公共技术服务平台',
        2 => '重点实验室',
        3 => '工程技术研究中心',
    ],
    'talent.trainType' => [
        1 => '培训资讯',
        2 => '展会动态',
        3 => '学术交流',
        4 => '联谊活动',
    ],
    'talent.demandType' => [
        1 => '个人诉求',
        2 => '加入组织',
        3 => '寻求合作',
        4 => '人才需求',
        5 => '政策调研',
        6 => '其他',
    ],
    'talent.showinfo' => [
        'hide' => 1,
        'shown' => 2,
    ],
    'talent.showinfo' => [
        1 => '隐藏',
        2 => '展示',
    ],
    'talent.talentShowType' => [
        1 => '赣州籍人才',
        2 => '海外人才',
        3 => '本土人才',
        4 => '苏区人才发展合作研究院',
    ],
    'talent.recruitType' => [
        1 => '我要招聘',
        2 => '我要应聘',
    ],
    'talent.area' => [
        1 => '章贡区',
        2 => '南康区',
        3 => '瑞金市',
        4 => '赣县',
        5 => '信丰县',
        6 => '大余县',
        7 => '上犹县',
        8 => '崇义县',
        9 => '安远县',
        10 => '龙南县',
        11 => '定南县',
        12 => '全南县',
        13 => '兴国县',
        14 => '宁都县',
        15 => '于都县',
        16 => '会昌县',
        17 => '寻乌县',
        18 => '石城县',
    ],
    'talent.hotel.roomtype' => [
        1 => '单间',
        2 => '标间',
    ],
    'talent.hotel.roomtypename' => [
        '单间' => 1,
        '标间' => 2,
    ],
    'talent.hotel.star' => [
        1 => '1星',
        2 => '2星',
        3 => '3星',
        4 => '4星',
        5 => '5星',
    ],
    'talent.hotel.sort' => [
        1 => '智能排序',
        2 => '距离最近',
    ],
    'talent.polvisage' => [
        '中共党员',
        '中共预备党员',
        '共青团员',
        '民革党员',
        '民盟盟员',
        '民建会员',
        '民进会员',
        '农工党党员',
        '致公党党员',
        '九三学社社员',
        '台盟盟员',
        '无党派人士',
        '群众',
    ],
    'talent.level' => [
        'A类' => 'A类',
        'B类' => 'B类',
        'C类' => 'C类',
    ],
    'order.status' => [
        1 => '未入住',
        2 => '入住中',
        3 => '已结束',
        4 => '已取消',
    ],
    'hotel.rootlevel' => [
        1 => '所有酒店管理',
        2 => '当前酒店管理',
        3 => '酒店区域管理',
    ],
    'version.ostype' => [
        'android' => 'android',
        'ios' => 'ios',
    ],
    'order.hotelcheckstatus' => [
        1 => '未确认',
        2 => '确认通过',
        3 => '确认不通过',
    ],
    'talent.welfarelevel' => [
        0 => '享受类型一',
        1 => '享受类型二',
        2 => '享受类型三',
    ],
    'talent.applywelfarelevel' => [
        0 => '申报类型1',
        1 => '申报类型二',
        2 => '申报类型三',
    ],
    'talent.talentlevel' => [
        1 => 'A+类',
        2 => 'A类',
        3 => 'B类',
        4 => 'C类',
        5 => 'D类',
        6 => '准D类',
        7 => 'E类',
        8 => 'F类',
        9 => '准F类',
        10 => 'G类',
    ],
    'talent.talentlevelname' => [
        'A+类:产业领军人才' => 'A+类:产业领军人才',
        'A类:国内外顶尖人才' => 'A类:国内外顶尖人才',
        'B类:国家级高层次人才' => 'B类:国家级高层次人才',
        'C类:省级高层次人才' => 'C类:省级高层次人才',
        'D类:市级高层次人才' => 'D类:市级高层次人才',
        'E类:行业急需紧缺人才' => 'E类:行业急需紧缺人才',
        'F类:青年英才' => 'F类:青年英才',
        'G类:产业工匠' => 'G类:产业工匠',
        '准人才:准赣州市人才(大专及以上)' => '准人才:准赣州市人才(大专及以上)',
        '准人才:准赣州市急需紧缺人才(硕士)' => '准人才:准赣州市急需紧缺人才(硕士)',
        '准人才:准赣州市高层次人才(博士)' => '准人才:准赣州市高层次人才(博士)',
    ],

    'talent.education.degree' => [
        0 => '博士后',
        1 => '博士',
        2 => '硕士',
        3 => '本科',
        4 => '专科',
        5 => '专科以下',
    ],
    'talent.education.degreename' => [
        '博士后' => '博士后',
        '博士' => '博士',
        '硕士' => '硕士',
        '本科' => '本科',
        '专科' => '专科',
        '专科以下' => '专科以下',
    ],
    'talent.authmethod' => [
        1 => '学历自动认证',
        2 => '人才后台认证',
    ],
    'talent.devicetype' => [
        ['name' => '生物医药', 'ordertype' => 1],
        ['name' => '医药', 'ordertype' => 2],
        ['name' => '计算机', 'ordertype' => 3],
        ['name' => '材料', 'ordertype' => 4],
        ['name' => '机械工程', 'ordertype' => 5],
        ['name' => '海洋', 'ordertype' => 6],
        ['name' => '电子与测量', 'ordertype' => 7],
        ['name' => '有机化学', 'ordertype' => 8],
        ['name' => '生态环境', 'ordertype' => 9],
        ['name' => '石油化工', 'ordertype' => 10],
        ['name' => '大气物理', 'ordertype' => 11],
        ['name' => '农产品与食品', 'ordertype' => 12],
    ],
    'talent.honortype' => [
        0 => '长江学者',
        1 => '西部之光访问学者',
        2 => '千人计划',
        3 => '万人计划',
        4 => '海智计划',
    ],
];
