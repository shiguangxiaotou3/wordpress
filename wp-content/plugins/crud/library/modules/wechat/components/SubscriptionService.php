<?php

namespace crud\modules\wechat\components;

use crud\modules\pay\behaviors\PayBehavior;
use Yii;
use Exception;
use yii\web\View;
use yii\base\Component;
use crud\components\Http;
use yii\helpers\ArrayHelper;
use crud\assets\WechatJsSdkAssets;
use yii\base\InvalidConfigException;
use GuzzleHttp\Exception\GuzzleException;
use crud\modules\wechat\assets\MarketAssets;
use crud\modules\wechat\models\ValidateServer;
use crud\modules\wechat\behaviors\SubscriptionServiceMessage;

/**
 * 微信公众号组件
 * @property string $appId
 * @property string $appSecret
 * @property string $token
 * @property Http $client
 * @property $menu
 * @property-read $templateList
 * @property-read $templateIds
 * @property-read string $authorizeUrl;
 * @property-read string $accessToken
 * @property-read string $ticket
 * @property-read array $jsConfig
 * @property-write array $conditionalMenu
 * @property-read array $jsApiList
 * @package crud\common\components\wechat
 */
class SubscriptionService extends Component
{

    public $appId;
    public $appSecret;
    public $token;
    public $redirect_uri;
    const  SUBSCRIPTION = 'subscription';
    const SNSAPI_BASE ='snsapi_base';
    const SNSAPI_USERINFO ='snsapi_userinfo';
    public $encodingAESKey;
    private $_client;

    public $domain = 'https://api.weixin.qq.com';

    public function behaviors(){
        return [
            SubscriptionServiceMessage::class
        ];
    }


    /**
     * 验证开发者服务器
     */
    public function ValidateServer()
    {
        $request = Yii::$app->request;
        $model = new ValidateServer();
        $model->token = $this->token;
        $model->signature = $request->get("signature");
        $model->echostr = $request->get("echostr");
        $model->timestamp = $request->get("timestamp");
        $model->nonce = $request->get("nonce");
        if ($model->validate() and $model->checkSignature()) {
            return $model->echostr;
        } else {
            return false;
        }
    }

    /**
     * 获取access token
     * @return false|mixed
     * @throws GuzzleException
     */
    public function getAccessToken()
    {
        $cache = Yii::$app->cache;
        $access_token = $cache->get(self::SUBSCRIPTION . "_access_token");
        if ($access_token) {
            return $access_token;
        } else {
            try {

                $results = $this->response($this->client->get("/cgi-bin/token", [
                    'query' => [
                        "grant_type" => 'client_credential',
                        'appid' => $this->appId,
                        'secret' => $this->appSecret,
                    ]
                ]));

                $cache->set(self::SUBSCRIPTION . "_access_token", $results["access_token"], $results["expires_in"]);
                return $results["access_token"];
            } catch (Exception $exception) {
                return false;
            }
        }
    }

    /**
     * 获取http对象
     * @return Http
     */
    public function getClient()
    {
        if (empty($this->_client)) {
            $this->_client = new Http($this->domain);
        }
        return $this->_client;
    }

    /**
     * 获取公众号菜单
     * @return array
     * @throws GuzzleException
     */
    public function getMenu()
    {
        return $this->response($this->client->get("/cgi-bin/get_current_selfmenu_info", [
                'query' => [
                    "access_token" => $this->accessToken,
                ],
            ]
        ));
    }

    /**
     * 创建菜单
     * @param $options
     * @return array
     * @throws GuzzleException
     */
    public function setMenu($options = [])
    {
        return $this->response($this->client->post("/cgi-bin/menu/create", [
                "headers" => [
                    'content-type' => 'application/json',
                ],
                'query' => [
                    "access_token" => $this->accessToken,
                ],
                "body" => $this->json_encode($options)
            ]
        ));
    }

    public function deleteMenu(){
        return $this->response($this->client->get("/cgi-bin/menu/delete", [
                "headers" => [
                    'content-type' => 'application/json',
                ],
                'query' => [
                    "access_token" => $this->accessToken,
                ],
            ]
        ));
    }

    /**
     * 创建自定义菜单
     * @param $options
     * @return array
     * @throws GuzzleException
     */
    public function setConditionalMenu($options = [])
    {
        return $this->response($this->client->post("/cgi-bin/menu/addconditional", [
                "headers" => [
                    'content-type' => 'application/json',
                ],
                'query' => [
                    "access_token" => $this->accessToken,
                ],
                "body" => $this->json_encode($options)
            ]
        ));
    }

    /**
     * @param $response
     * @return array
     * @throws Exception
     */
    public function response($response)
    {
        $error = [
            -1 => "系统繁忙，此时请开发者稍候再试",
            0 => "请求成功",
            40001 => "获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口",
            40002 => "不合法的凭证类型",
            40003 => "不合法的 OpenID ，请开发者确认 OpenID （该用户）是否已关注公众号，或是否是其他公众号的 OpenID",
            40004 => "不合法的媒体文件类型",
            40005 => "不合法的文件类型",
            40006 => "不合法的文件大小",
            40007 => "不合法的媒体文件 id",
            40008 => "不合法的消息类型",
            40009 => "不合法的图片文件大小",
            40010 => "不合法的语音文件大小",
            40011 => "不合法的视频文件大小",
            40012 => "不合法的缩略图文件大小",
            40013 => "不合法的 AppID ，请开发者检查 AppID 的正确性，避免异常字符，注意大小写",
            40014 => "不合法的 access_token ，请开发者认真比对 access_token 的有效性（如是否过期），或查看是否正在为恰当的公众号调用接口",
            40015 => "不合法的菜单类型",
            40016 => "不合法的按钮个数",
            40017 => "不合法的按钮类型",
            40018 => "不合法的按钮名字长度",
            40019 => "不合法的按钮 KEY 长度",
            40020 => "不合法的按钮 URL 长度",
            40021 => "不合法的菜单版本号",
            40022 => "不合法的子菜单级数",
            40023 => "不合法的子菜单按钮个数",
            40024 => "不合法的子菜单按钮类型",
            40025 => "不合法的子菜单按钮名字长度",
            40026 => "不合法的子菜单按钮 KEY 长度",
            40027 => "不合法的子菜单按钮 URL 长度",
            40028 => "不合法的自定义菜单使用用户",
            40029 => "无效的 oauth_code",
            40030 => "不合法的 refresh_token",
            40031 => "不合法的 openid 列表",
            40032 => "不合法的 openid 列表长度",
            40033 => "不合法的请求字符，不能包含 \uxxxx 格式的字符",
            40035 => "不合法的参数",
            40038 => "不合法的请求格式",
            40039 => "不合法的 URL 长度",
            40048 => "无效的url",
            40050 => "不合法的分组 id",
            40051 => "分组名字不合法",
            40060 => "删除单篇图文时，指定的 article_idx 不合法",
            40117 => "分组名字不合法",
            40118 => "media_id 大小不合法",
            40119 => "button 类型错误",
            40120 => "子 button 类型错误",
            40121 => "不合法的 media_id 类型",
            40125 => "无效的appsecret",
            40132 => "微信号不合法",
            40137 => "不支持的图片格式",
            40155 => "请勿添加其他公众号的主页链接",
            40163 => "oauth_code已使用",
            40227 => "标题为空",
            41001 => "缺少 access_token 参数",
            41002 => "缺少 appid 参数",
            41003 => "缺少 refresh_token 参数",
            41004 => "缺少 secret 参数",
            41005 => "缺少多媒体文件数据",
            41006 => "缺少 media_id 参数",
            41007 => "缺少子菜单数据",
            41008 => "缺少 oauth code",
            41009 => "缺少 openid",
            42001 => "access_token 超时，请检查 access_token 的有效期，请参考基础支持 - 获取 access_token 中，对 access_token 的详细机制说明",
            42002 => "refresh_token 超时",
            42003 => "oauth_code 超时",
            42007 => "用户修改微信密码， accesstoken 和 refreshtoken 失效，需要重新授权",
            42010 => "相同 media_id 群发过快，请重试",
            43001 => "需要 GET 请求",
            43002 => "需要 POST 请求",
            43003 => "需要 HTTPS 请求",
            43004 => "需要接收者关注",
            43005 => "需要好友关系",
            43019 => "需要将接收者从黑名单中移除",
            44001 => "多媒体文件为空",
            44002 => "POST 的数据包为空",
            44003 => "图文消息内容为空",
            44004 => "文本消息内容为空",
            45001 => "多媒体文件大小超过限制",
            45002 => "消息内容超过限制",
            45003 => "标题字段超过限制",
            45004 => "描述字段超过限制",
            45005 => "链接字段超过限制",
            45006 => "图片链接字段超过限制",
            45007 => "语音播放时间超过限制",
            45008 => "图文消息超过限制",
            45009 => "接口调用超过限制",
            45010 => "创建菜单个数超过限制",
            45011 => "API 调用太频繁，请稍候再试",
            45015 => "回复时间超过限制",
            45016 => "系统分组，不允许修改",
            45017 => "分组名字过长",
            45018 => "分组数量超过上限",
            45047 => "客服接口下行条数超过上限",
            45064 => "创建菜单包含未关联的小程序",
            45065 => "相同 clientmsgid 已存在群发记录，返回数据中带有已存在的群发任务的 msgid",
            45066 => "相同 clientmsgid 重试速度过快，请间隔1分钟重试",
            45067 => "clientmsgid 长度超过限制",
            45110 => "作者字数超出限制",
            46001 => "不存在媒体数据",
            46002 => "不存在的菜单版本",
            46003 => "不存在的菜单数据",
            46004 => "不存在的用户",
            47001 => "解析 JSON/XML 内容错误",
            47003 => "参数值不符合限制要求，详情可参考参数值内容限制说明",
            48001 => "pi 功能未授权，请确认公众号已获得该接口，可以在公众平台官网 - 开发者中心页中查看接口权限",
            48002 => "粉丝拒收消息（粉丝在公众号选项中，关闭了 “ 接收消息 ” ）",
            48004 => "api 接口被封禁，请登录 mp.weixin.qq.com 查看详情",
            48005 => "api 禁止删除被自动回复和自定义菜单引用的素材",
            48006 => "api 禁止清零调用次数，因为清零次数达到上限",
            48008 => "没有该类型消息的发送权限",
            48021 => "自动保存的草稿无法预览/发送，请先手动保存草稿",
            50001 => "用户未授权该 api",
            50002 => "用户受限，可能是违规后接口被封禁",
            50005 => "用户未关注公众号",
            53500 => "发布功能被封禁",
            53501 => "频繁请求发布",
            53502 => "Publish ID 无效",
            53600 => "Article ID 无效",
            61451 => "参数错误 (invalid parameter)",
            61452 => "无效客服账号 (invalid kf_account)",
            61453 => "客服帐号已存在 (kf_account exsited)",
            61454 => "客服帐号名长度超过限制 ( 仅允许 10 个英文字符，不包括 @ 及 @ 后的公众号的微信号 )(invalid   kf_acount length)",
            61455 => "客服帐号名包含非法字符 ( 仅允许英文 + 数字 )(illegal character in     kf_account)",
            61456 => "客服帐号个数超过限制 (10 个客服账号 )(kf_account count exceeded)",
            61457 => "无效头像文件类型 (invalid   file type)",
            61450 => "系统错误 (system error)",
            61500 => "日期格式错误",
            63001 => "部分参数为空",
            63002 => "无效的签名",
            65301 => "不存在此 menuid 对应的个性化菜单",
            65302 => "没有相应的用户",
            65303 => "没有默认菜单，不能创建个性化菜单",
            65304 => "MatchRule 信息为空",
            65305 => "个性化菜单数量受限",
            65306 => "不支持个性化菜单的帐号",
            65307 => "个性化菜单信息为空",
            65308 => "包含没有响应类型的 button",
            65309 => "个性化菜单开关处于关闭状态",
            65310 => "填写了省份或城市信息，国家信息不能为空",
            65311 => "填写了城市信息，省份信息不能为空",
            65312 => "不合法的国家信息",
            65313 => "不合法的省份信息",
            65314 => "不合法的城市信息",
            65316 => "该公众号的菜单设置了过多的域名外跳（最多跳转到 3 个域名的链接）",
            65317 => "不合法的 URL",
            65320 => "匹配规则违反隐私",
            87009 => "无效的签名",
            9001001 => "POST 数据参数不合法",
            9001002 => "远端服务不可用",
            9001003 => "Ticket 不合法",
            9001004 => "获取摇周边用户信息失败",
            9001005 => "获取商户信息失败",
            9001006 => "获取 OpenID 失败",
            9001007 => "上传文件缺失",
            9001008 => "上传素材的文件类型不合法",
            9001009 => "上传素材的文件尺寸不合法",
            9001010 => "上传失败",
            9001020 => "帐号不合法",
            9001021 => "已有设备激活率低于 50% ，不能新增设备",
            9001022 => "设备申请数不合法，必须为大于 0 的数字",
            9001023 => "已存在审核中的设备 ID 申请",
            9001024 => "一次查询设备 ID 数量不能超过 50",
            9001025 => "设备 ID 不合法",
            9001026 => "页面 ID 不合法",
            9001027 => "页面参数不合法",
            9001028 => "一次删除页面 ID 数量不能超过 10",
            9001029 => "页面已应用在设备中，请先解除应用关系再删除",
            9001030 => "一次查询页面 ID 数量不能超过 50",
            9001031 => "时间区间不合法",
            9001032 => "保存设备与页面的绑定关系参数错误",
            9001033 => "门店 ID 不合法",
            9001034 => "设备备注信息过长",
            9001035 => "设备申请参数不合法",
            9001036 => "查询起始值 begin 不合法",
        ];
        if (isset($response['errcode']) and $response['errcode'] !== 0) {
            $msg = isset($error[$response['errcode']]) ? $error[$response['errcode']] : $response['errmsg'];
          throw new Exception($msg);
        } else {
            return $response;
        }
    }

    /**
     * @param $arr
     * @return string
     */
    public function json_encode($arr)
    {
        $parts = array();
        $is_list = false;
        $keys = array_keys($arr);
        $max_length = count($arr) - 1;
        if (($keys [0] === 0) && ($keys [$max_length] === $max_length)) {
            $is_list = true;
            for ($i = 0; $i < count($keys); $i++) {
                if ($i != $keys [$i]) {
                    $is_list = false;
                    break;
                }
            }
        }
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                if ($is_list)
                    $parts [] = self::json_encode($value);
                else
                    $parts [] = '"' . $key . '":' . self::json_encode($value);
            } else {
                $str = '';
                if (!$is_list)
                    $str = '"' . $key . '":';

                if (is_numeric($value) && $value < 2000000000)
                    $str .= $value;
                elseif ($value === false)
                    $str .= 'false';
                elseif ($value === true)
                    $str .= 'true';
                else
                    $str .= '"' . addslashes($value) . '"';

                $parts [] = $str;
            }
        }
        $json = implode(',', $parts);
        if ($is_list)
            return '[' . $json . ']';
        return '{' . $json . '}';
    }

    /**
     * 获取票据
     * @return false|mixed
     * @throws GuzzleException
     */
    public function getTicket()
    {
        $cache = Yii::$app->cache;
        $ticket = $cache->get(self::SUBSCRIPTION . "_ticket");
        if ($ticket) {
            return $ticket;
        } else {
            try {
                $results = $this->response($this->client->get('/cgi-bin/ticket/getticket', [
                    'query' => [
                        "access_token" => $this->accessToken,
                        'type' => 'jsapi'
                    ]
                ]));
                $cache->set(self::SUBSCRIPTION . "_ticket", $results["ticket"], $results["expires_in"]);
                return $results["ticket"];
            } catch (Exception $exception) {
                return false;
            }
        }
    }

    /**
     * @param $url
     * @param $jsApiList
     * @param $debug
     * @return array
     */
    public function getJsConfig($url = '', $jsApiList = [], $debug = true)
    {
        if (empty($url)) {
            $url = Yii::$app->request->getHostInfo() . Yii::$app->request->url;
        }
        if (empty($jsApiList)) {
            try {
                $jsApiList = $this->jsApiList;
            } catch (Exception $exception) {
                $jsApiList = [];
            }

        }
        $timestamp = time();
        $nonceStr = $this->createNonceStr();
        $jsapiTicket = $this->ticket;
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);
        return array(
            'debug' => true,
            'appId' => $this->appId,
            'timestamp' => $timestamp,
            'nonceStr' => $nonceStr,
            'signature' => $signature,
            'jsApiList' => $jsApiList
        );
    }

    /**
     * 返回授权url
     * @param $redirect_uri
     * @param string $scope
     * @return string
     */
    public function authorizationUrl($redirect_uri, $scope = "snsapi_userinfo")
    {
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize";
        $query = http_build_query([
            'appid' => $this->appId,
            'redirect_uri' => $redirect_uri,
            'response_type' => 'code',
            'scope' => $scope,
            'state' => 'STATE',
        ]);
        return $url . "?" . $query . "#wechat_redirect";
    }

    /**
     * 注册分享js
     */
    public function share()
    {
        /** @var View $view */
        $view = Yii::$app->getView();
        global $wp;
        WechatJsSdkAssets::register($view);
        $config = json_encode($this->getJsConfig());

        $title = get_option('blogname');
        $desc = get_option('blogdescription');
        $imgUrl = get_option('home') . "favicon.ico";
        $url = Yii::$app->request->getHostInfo() . Yii::$app->request->url;

        $id = get_the_ID();
        $title = get_the_title($id);

        $data = json_encode([
            // 分享标题
            'title' => $title,
            // 分享描述
            'desc' => $desc,
            /// 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            'link' => $url,
            // 分享图标
            'imgUrl' => $imgUrl,
            'success' => 'function(res){console.log(res) }'
        ]);
        $data2 = json_encode([
            // 分享标题
            'title' => $title,
            'link' => $url,
            // 分享图标
            'imgUrl' => $imgUrl,
            'success' => 'function(res){console.log(res) }'
        ]);
        $js = "
wx.config($config); 
wx.ready(function(res){
    wx.updateAppMessageShareData($data);
    wx.onMenuShareTimeline($data2);
})";
        $view->registerJs($js);

    }

    /**
     * 获取授权用户信息
     * @param $code
     * @return mixed
     * @throws GuzzleException
     */
    public function getUserAccessTokenByCode($code)
    {
        $cache = Yii::$app->cache;
        try {
            $data = $this->response($this->client->get("/sns/oauth2/access_token", [
                'query' => [
                    'appid' => $this->appId,
                    'secret' => $this->appSecret,
                    'code' => $code,
                    'grant_type' => 'authorization_code',
                ],
            ]));
            $data['expires_in'] = time() + $data['expires_in'];
            $cache->set(self::SUBSCRIPTION . '_' . $data['openid'], $data, 24 * 60 * 60 * 30);
            return $data;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * 刷新用户的access_token
     * @param $openid
     * @return false
     * @throws GuzzleException
     */
    public function refreshUserToken($openid)
    {
        $cache = Yii::$app->cache;
        $refresh_token = $cache->get(self::SUBSCRIPTION . '_' . $openid);
        if ($refresh_token) {
            try {
                $data = $this->response(json_decode($this->client->get("/sns/oauth2/refresh_token", [
                    'query' => [
                        'appid' => $this->appId,
                        'grant_type' => 'refresh_token',
                        'refresh_token' => $refresh_token['refresh_token'],
                    ],
                ]), true));
                if ($data) {
                    $data['expires_in'] = time() + $data['expires_in'];
                    unset($refresh_token['access_token']);
                    unset($refresh_token['expires_in']);
                    unset($refresh_token['refresh_token']);
                    $refresh_token = ArrayHelper::merge($refresh_token, $data);
                    return $cache->get(self::SUBSCRIPTION . '_' . $openid, $refresh_token, 24 * 60 * 60 * 30);
                }
            } catch (Exception $exception) {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 获取用户信息
     * @param $openid
     * @return false|mixed
     * @throws GuzzleException
     */
    public function getUserInfo($openid)
    {
        $cache = Yii::$app->cache;
        $refresh_token = $cache->get(self::SUBSCRIPTION . '_' . $openid);
        if ($refresh_token) {
            try {
                if (time() > $refresh_token['expires_in']) {
                    $this->refreshUserToken($openid);
                    $refresh_token = $cache->get(self::SUBSCRIPTION . '_' . $openid);
                }
                $res = $this->client->get("/sns/userinfo", [
                    'query' => [
                        'access_token' => $refresh_token['access_token'],
                        'openid' => $openid,
                        'lang' => 'zh_CN'
                    ],
                ]);
                return $this->response(json_decode($res, true));
            } catch (Exception $exception) {
                return false;
            }

        }
    }

    /**
     * 通过accessToken 获取用户信息
     * @param $accessToken
     * @param $openid
     * @return array|false
     * @throws GuzzleException
     */
    public function getUserInfoByAccessToken($accessToken, $openid)
    {
        $res = $this->client->get("/sns/userinfo", [
            "headers" => [
                'content-type' => 'application/json',
            ],
            'query' => [
                'access_token' => $accessToken,
                'openid' => $openid,
                'lang' => 'zh_CN'
            ],
        ]);
        $data = $this->response(json_decode($res, true));
        if ($data['code'] == 1) {
            return $data['data'];
        } else {
            return false;
        }

    }

    /**
     * @param $code
     * @return false|mixed|void
     * @throws GuzzleException
     */
    public function getUserInfoByCode($code)
    {
        $accessToken = $this->getUserAccessTokenByCode($code);
        if ($accessToken) {
            return $this->getUserInfo($accessToken['openid']);
        }
    }

    /**
     *
     * 生成随机字符串
     * @param $length
     * @return string
     */
    private function createNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 获取默认的微信JSSDK接口名称
     * @return false|string[]
     */
    public function getJsApiList()
    {
        $str = get_option('crud_group_wechat_jsApiList');
        $str = str_replace(PHP_EOL, '', $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('\'', '', $str);
        return explode(',', $str);
    }

    /**
     * 用户授权url
     * @param $redirect_uri
     * @param $scope
     * @param $state
     * @return string
     */
    public function getAuthorizeUrl($redirect_uri='',$scope =self::SNSAPI_USERINFO,$state=''){
        if(empty( $redirect_uri)){
            $redirect_uri =getRequireUrl(2);
        }
        $config =[
            'appid'=>$this->appId,
            //授权后重定向的回调链接地址
            'redirect_uri'=>$redirect_uri,
            'response_type'=>'code',
            // snsapi_base:(不弹出授权页面,直接跳转,只能获取用户openid)
            // snsapi_userinfo:(弹出授权页面,可通过openid拿到昵称、性别、所在地.并且即使在未关注的情况下,只要用户授权,也能获取其信息)
            'scope'=>$scope,
            'state'=>$state,
        ];
        $query = http_build_query($config);
        return 'https://open.weixin.qq.com/connect/oauth2/authorize?'.$query."#wechat_redirect";
    }


    public function autoEcho(){

    }

    /**
     * 获取模版列表
     * @return array
     * @throws GuzzleException
     */
    public function getTemplateList(){
        return $this->response($this->client->post("/cgi-bin/template/get_all_private_template", [
                'query' => [
                    "access_token" => $this->accessToken,
                ],
            ]
        ));
    }

    /**
     * 删除模版列表
     * @param $template_id
     * @return array
     * @throws GuzzleException
     */
    public function deleteTemplate($template_id){
        return $this->response($this->client->post("/cgi-bin/template/del_private_template", [
                'query' => [
                    "access_token" => $this->accessToken,
                ],
                'json'=>[
                    'template_id'=>$template_id
                ]
            ]
        ));
    }


    /**
     * 获取模版消息ids
     * @return array
     * @throws GuzzleException
     */
    public function getTemplateIds(){
        return $this->response($this->client->post("/cgi-bin/template/api_add_template", [
                'query' => [
                    "access_token" => $this->accessToken,
                ],
            ]
        ));
    }

    /**
     * 发生模版消息
     * @param $template_id
     * @param $return_url
     * @param $openid
     * @param $data
     * @return array
     * @throws GuzzleException
     */
    public function sendTemplateMessage($template_id,$openid,$data,$return_url=[]){
        $config =[
            "touser" => $openid,
            "template_id" => $template_id,
            "data"=>$data
        ];
        $json = ArrayHelper::merge($config,$return_url);
        return $this->response($this->client->post("/cgi-bin/message/template/send", [
                'query' => [
                    "access_token" => $this->accessToken,
                ],
                'json' =>$json
            ]
        ));
    }


}