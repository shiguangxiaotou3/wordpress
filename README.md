<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://www.shiguangxiaotou.com/favicon.ico" height="100px">
    </a>
    <h1 align="center">wordpress plugins CRUD </h1>
    <br>
</p>

### shiguangxiaotou/crud 是一个基于wordpress的MVC插件
~~~
microsoft/bingads
crud                        根
  |-app                     应用目录
  |--|--base 
  |--|-admin                admin模块
  |--|--|--models           M
  |--|--|--views            V
  |--|--|--controllers      C
  |--|--AdminModule         admin模块基类
  |--|--Activate.php        启用
  |--|--DeActivate.php      禁用
  |--|--Bootstrap.php       引导类
  |-assets                  前端资源包
  |--|--css
  |--|--js
  |--|--img
  |-vendor
  |-composer.json
  |-composer.lock
  |-crud.php
  |-README.md
  |-LICENSE.md
~~~

~~~sh
sudo ln -s /etc/apache2/sites-available/wp.shiguangxiaotou.com.conf /etc/apache2/sites-enabled/wp.shiguangxiaotou.com.conf
composer config --global --auth github-oauth.github.com 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
~~~


~~~php
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
  	<![CDATA[YII-BLOCK-HEAD]]><?php $this->head() ?>
</head>
<body>
<![CDATA[YII-BLOCK-BODY-BEGIN]]><?php $this->beginBody() ?> 
  	html....
<![CDATA[YII-BLOCK-BODY-END]]><?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
~~~

~~~
   1. Bing ads参数：

