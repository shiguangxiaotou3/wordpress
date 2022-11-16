<p align="center">
    <a href="https://https://github.com/shiguangxiaotou3/wordpress" target="_blank">
        <img src="https://www.shiguangxiaotou.com/favicon.ico" height="100px">
    </a>
    <h1 align="center">wordpress plugin CRUD for MVC </h1>
    <br>
</p>

### CRUD 是一个wordpress插件
 这是一个基于Yii2的MVC的插件框架,部分功能可能有待完善.
 对于习惯了面向对象的开发模式开发者,很不习惯wordpress面向函数,面向勾子的编程模式。那么crud能解决你的痛点
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

