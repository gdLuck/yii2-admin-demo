记录
===============================
> 扩展

```
后台主题：dmstr/yii2-adminlte-asset
权限管理：mdmsoft/yii2-admin
```

>侧边栏事件失效处理
```
根据yii2-adminlte-asset 里最新的扩展来修改 menu小工具
```

> 异常处理：

```
The file or directory to be published does not exist: `bower/jquery/dist`:
详见：https://github.com/fxpio/composer-asset-plugin/issues/164

先试着安装最新版安装最新的到全局再更新看是否可行。Composer Asset Plugin：
composer global require "fxp/composer-asset-plugin:^1.3.1"


YII2开发者提供的方法
composer self-update.
composer clear-cache.
composer create-project --prefer-dist yiisoft/yii2-app-basic delete_me.
Got \vendor\bower\bower-asset\*.
composer self-update 1.0.0-alpha11.
composer clear-cache.
Got \vendor\bower\*.

```

Yii 2 Advanced Project Template
