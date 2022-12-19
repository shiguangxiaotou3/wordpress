### Bing Ads 组件使用说明
#### 说明
- 官方文档 https://learn.microsoft.com/en-us/advertising/guides/?view=bingads-13
- Bing Ads没有php的进程守护程序SDK,所以必须使用OAuth获取用户同意.
- 在使用前需要配置`clientId`,`clientSecret`,`developerToken`,`redirect_uri`四个参数并且在Microsoft Azure控制台做权限配置,配置过程见下文
- 点击`获取访问许可`执行步骤
  - 1.浏览器理解跳转到Microsoft
  - 2.登录并同意
  - 3.重定向`redirect_uri`,默认是http://youdome/ads.php
  - 4.ads.php 会检测是否携带`code`参数,并开启`$_SESSION`并携带`code`参数,跳转到Wordpress后台
  - 5.控制器 asd/index 会自动获取`AccessToken`并在记录文件，之后或自动根据Refresh Token自动刷新`token`(注意:它不用主动去刷新,而是发现失效后被动刷新)


### 组件说明
 ads组件集成自`yii\base\Component`全局可访问

~~~php
$ads = Yii::$app->ads;
//或
global $crud;
$ads = $crud->backend->app->ads;
~~~

asd组件封装五个可读的属性,`Microsoft\BingAds\Auth\ServiceClient`公共api链接对象
~~~php
<?php

use Yii;

$ads = Yii::$app->ads;
$ads->customerManagementProxy; //客户管理代理
$ads->adInsightProxy; //广告洞察代理
$ads->bulkProxy; //批量代理
$ads->campaignManagementProxy; //活动管理代理
$ads->reportingProxy; //报告管理代理
$ads->customerBillingManagementProxy; //客户账单管理代理
~~~
### 用法
~~~php
<?php
// 获取广告关键词
use Microsoft\BingAds\V13\CampaignManagement\GetKeywordsByAdGroupIdRequest;

$ads = Yii::$app->ads;
$adGroupId ="1229254305018244";
$request = new GetKeywordsByAdGroupIdRequest();
$request->AdGroupId = $adGroupId;
$ads->campaignManagementProxy->GetService()->GetKeywordsByAdGroupId($request);
~~~
### Microsoft Azure 后台配置
###  获取clientId
![clientId](https://www.shiguangxiaotou.com/wp-content/uploads/2022/11/截屏2022-11-17-03.30.28.png)
### 获取clientSecret
![clientId](https://www.shiguangxiaotou.com/wp-content/uploads/2022/11/截屏2022-11-17-03.35.20.png)
### 授权公共api及权限
![api](https://www.shiguangxiaotou.com/wp-content/uploads/2022/11/截屏2022-11-17-03.39.51.png)
![及权限](https://www.shiguangxiaotou.com/wp-content/uploads/2022/11/截屏2022-11-17-03.44.31.png)