DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
tests                    contains various tests for the advanced application
    codeception/         contains tests developed with Codeception PHP Testing Framework
```


我想使用Yii2 Framework手动安装选择2扩展，而无需使用composer。

 PHP致命错误 -  yii\base\ErrorException。类
'kartik\select2\Select2'not found

手动安装解决方案

但是如果你想手动执行：

  1) 从Github下载所需版本的归档文件。

  2）打开 composer.json 。

  3）查找PSR-4自动加载部分并记住它，在您的情况下： kartik/select2 。

  4）将文件解压缩到  vendor/ 。

  5）添加到 vendor/composer/autoload_psr4.php ：

 'kartik\\select2\\'=> array（$ vendorsDir。'/kartik/select2'），

  6）添加到 vendor / yiisoft / extensions.php ：

    'kartik-v/yii2-widget-select2' =>
        array (
            'name' => 'kartik-v/yii2-widget-select2',
            'version' => '9999999-dev',
            'alias' =>
                array (
                    '@kartik/file' => $vendorDir . '/kartik-v/yii2-widget-select2',
                ),
        ),
 ),