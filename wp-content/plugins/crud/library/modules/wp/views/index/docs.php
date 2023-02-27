<?php
/** @var $this yii\web\View */
?>

<!-- 01 -->
    <section>
        <div class="wrap">
            <div class="grid vertical-align">
                <div class="column">
                    <h5>Crud快速入门</h5>
                    <hr>
                    <div class="toc">
                        <ol>
                            <li>
                                <a href="" title="Go to Learning to see">
                                    <span class="chapter">Crud插件加载</span>
                                    <span class="toc-page">01</span>
                                </a>
                                <ol>
                                    <li>
                                        <a href="#slide=2" title="入口文件">
                                            <span class="chapter">入口文件</span>
                                            <span class="toc-page">02</span></a>
                                    </li>
                                    <li>
                                        <a href="#slide=3" title="应用实例化">
                                            <span class="chapter">应用配置加载</span>
                                            <span class="toc-page">03</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#slide=4" title="加载子模块配置">
                                            <span class="chapter">子模块配置加载</span>
                                            <span class="toc-page">04</span>
                                        </a>
                                    </li>
                                </ol>
                            </li>
                            <li>
                                <span class="chapter">Yii2核心</span>
                                <span class="toc-page">05</span>
                                <ol>
                                    <li>
                                        <a href="#slide=5" title="配置">
                                            <span class="chapter">Yii2核心:初始化</span>
                                            <span class="toc-page">05</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#slide=6" title="Yii2核心:属性">
                                            <span class="chapter">Yii2核心:属性</span>
                                            <span class="toc-page">06</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#slide=7" title="Yii2核心:事件和行为">
                                            <span class="chapter">Yii2核心:事件和行为</span>
                                            <span class="toc-page">07</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#slide=8" title="Yii2核心:配置">
                                            <span class="chapter">Yii2核心:配置</span>
                                            <span class="toc-page">08</span>
                                        </a>
                                    </li>
                                </ol>
                            </li>
                            <li>
                                <a href="#slide=9" title="初始化">
                                    <span class="chapter">初始化</span>
                                    <span class="toc-page">09</span>
                                </a>
                            </li>
                            <li>

                                <span class="chapter">挂载钩子到控制器</span>
                                <span class="toc-page">10</span>
                                <ol>
                                    <li>
                                        <a href="#slide=10" title="挂载钩子">
                                            <span class="chapter">挂载钩子1</span>
                                            <span class="toc-page">10</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#slide=11" title="挂载钩子">
                                            <span class="chapter">挂载钩子2</span>
                                            <span class="toc-page">11</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#slide=12" title="挂载钩子">
                                            <span class="chapter">挂载钩子3</span>
                                            <span class="toc-page">12</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#slide=13" title="挂载钩子">
                                            <span class="chapter">挂载钩子4</span>
                                            <span class="toc-page">13</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#slide=14" title="挂载钩子">
                                            <span class="chapter">挂载钩子5</span>
                                            <span class="toc-page">14</span>
                                        </a>
                                    </li>
                                </ol>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="column">
                    <h3>后台待完善</h3>
                    <hr>
                </div>
                <div class="column">
                    <h3>前台待完善</h3>
                    <hr>
                </div>
                <div class="column">
                    <h3>Api待完善</h3>
                    <hr>
                </div>
                <!-- end .toc -->
            </div>
            <!-- .end .wrap -->
    </section>

<!-- 02 -->
<?php
$php2 =<<<HTML
<span class="code-comment">&lt;!-- 常量配置 --&gt;</span>
defined("CRUD_DIR") or define("CRUD_DIR" ,__DIR__);
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
defined('DB_TABLE_PREFIX') or define('DB_TABLE_PREFIX', 'wp_');
<span class="code-comment">&lt;!-- 自动加载 --&gt;</span>
require_once __DIR__ . "/library/debug.php";
require_once __DIR__ . "/library/function.php";
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
<span class="code-comment">&lt;!-- 设置路由别名 --&gt;</span>
require_once __DIR__ . '/common/config/bootstrap.php';
<span class="code-comment">&lt;!-- 激活插件 --&gt;</span>
register_activation_hook(__FILE__, "crud_activate");
<span class="code-comment">&lt;!-- 禁用插件 --&gt;</span>
register_deactivation_hook(__FILE__, "crud_activate");
date_default_timezone_set('Asia/Shanghai');
<span class="code-comment">&lt;!-- 实例化应用 --&gt;</span>
global \$crud;
\$crud = new backend\web\App();
\$crud->run();
HTML;
?>
<section>
    <!--.wrap = container (width: 90%) -->
    <div class="wrap">
        <div class="grid sm">
            <div class="column">
                <h3><strong>Crud插件入口</strong></h3>
                <p class="text-intro">自动加载和常量配置 </p>
            </div>
            <!-- .end .column -->
            <div class="column bg-black-blue">
                <pre><?= $php2 ?></pre>
            </div>
            <!-- .end .column -->
        </div>
        <!-- .end .grid -->
    </div>
    <!-- .end .wrap -->
</section>

<!-- 03 -->
<?php
$php3=<<<HTML
<span class="code-comment">&lt;!-- 加载应用配置 --&gt;</span>
public function __construct()
{
  require __DIR__ . '/../config/bootstrap.php';
  \$config = ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../../common/config/main-local.php',
    require __DIR__ . '/../config/main.php',
    require __DIR__ . '/../config/main-local.php',
    <span class="code-comment">&lt;!-- 加载子模块配置和子模块引导配置 --&gt;</span>
    \$this->loadModulesConfig()
  );
  <span class="code-comment">&lt;!-- 同Yii2将配置传递到父类 --&gt;</span>
  parent::__construct(\$config);
}
HTML;
?>
<section>
    <!--.wrap = container (width: 90%) -->
    <div class="wrap">
        <div class="grid sm">
            <div class="column">
                <h3><strong>App对象配置加载</strong></h3>
                <p class="text-intro">加载应用配置 </p>
                <p class="text-intro">启用子模块时,<code>backend\web\App::loadModulesConfig()</code>方法会将子模块中定义的配置合并到主配置中。 </p>
            </div>
            <!-- .end .column -->
            <div class="column bg-black-blue">
                <pre><?= $php3 ?></pre>
            </div>
            <!-- .end .column -->
        </div>
        <!-- .end .grid -->
    </div>
    <!-- .end .wrap -->
</section>

<!-- 04 -->
<?php
$php4 =<<<HTML
<span class="code-comment">/**
 * 引导模块初始化
 * backend\web\App初始化之后,执行所配置模块的init()方法
 * 例如：crud\modules\wp\Wp::init()方法优先级大于backend\web\App::run()方法
 * 请不要在init()调用global \$crud; 此时初始化未完成
 * 请不要将模块id和组件id重名
 * @return string[]
 */</span>
public static function loadModulesConfig()
{
    <span class="code-comment">// +----------------------------------------------------------------------
    // ｜子模块引导配置
    // ｜App实例化时候会根据bootstrap配置项调用模块的bootstrap(),引导wordpress钩子挂载
    // ｜例如:['bootstrap'=>['wp']] =>crud\modules\wp\Wp::bootstrap()
    // +----------------------------------------------------------------------</span>
    return ArrayHelper::merge(
        ['bootstrap' => ['wechat', 'wp', 'crud']],
        crud\modules\wp\Wp::config(),
    );
}
HTML;
?>
<section>
    <!--.wrap = container (width: 90%) -->
    <div class="wrap">
        <div class="grid sm">
            <div class="column">
                <h3><strong>加载子模块配置</strong></h3>
                <p class="text-intro">加载子模块配置 </p>
                <p class="text-intro">此时<code>backend\web\App</code>实例化完成</p>
            </div>
            <!-- .end .column -->
            <div class="column bg-black-blue">
                <pre><?= $php4 ?></pre>
            </div>
            <!-- .end .column -->
        </div>
        <!-- .end .grid -->
    </div>
    <!-- .end .wrap -->
</section>

<!-- 05 -->
<?php
$php5 =<<<HTML
namespace yii\components\MyClass;

use yii\base\Object;
use yii\base\BaseObject;
class MyClass extends Object
{
    public \$prop1;
    public \$prop2;
    <span class="code-comment">若你需要重写构造方法__construct
    传入\$config作为构造器方法最后一个参数, 然后把它传递给父类的构造方法。</span>
    public function __construct(\$param1, \$param2, \$config = []){
        <span class="code-comment">// ... 配置生效前的初始化过程</span>
        parent::__construct(\$config);
    }

    <span class="code-comment">如果你重写了yii\base\BaseObject::init()方法或者其子类,
    请确保你在init方法的开头处调用了父类的init方法</span>
    public function init(){
        parent::init();
        <span class="code-comment">// ... 配置生效后的初始化过程</span>
    }
}
HTML;
?>
<section>
    <!--.wrap = container (width: 90%) -->
    <div class="wrap">
        <div class="grid sm">
            <div class="column">
                <h3><strong>Yii2核心</strong></h3>
                <p class="text-intro">Crud基于Yii2所有你必须了解Yii2核心,只有了解了Yii2核心才能理解子模块加载</p>
            </div>
            <!-- .end .column -->
            <div class="column bg-black-blue">
                <pre><?= $php5 ?></pre>
            </div>
            <!-- .end .column -->
        </div>
        <!-- .end .grid -->
    </div>
    <!-- .end .wrap -->
</section>

<!-- 06 -->
<?php
$php6 =<<<HTML
class Foo extends BaseObject{
    private \$_label;
    public function getLabel(){
        return \$this->_label;
    }

    public function setLabel(\$value){
        \$this->_label = trim(\$value);
    }
}<span class="code-comment">
getter方法是名称以ge开头的方法,而setter方法名以set开头;
方法名中get或set后面的部分就定义了该属性的名字.
如下面代码所示:
getter方法getLabel()和setter方法setLabel()操作的是label属性</span>
\$foo = new Foo();
\$foo->label; <span class="code-comment">等效与</span> \$foo->getLabel();
\$foo->label='abc'; <span class="code-comment">等效与</span> \$foo->setLabel('abc');
HTML;
?>
<section>
    <!--.wrap = container (width: 90%) -->
    <div class="wrap">
        <div class="grid sm">
            <div class="column">
                <h3><strong>Yii2核心:属性</strong></h3>
                <p class="text-intro">getter()和setter():</p>
            </div>
            <!-- .end .column -->
            <div class="column bg-black-blue">
                <pre><?= $php6 ?></pre>
            </div>
            <!-- .end .column -->
        </div>
        <!-- .end .grid -->
    </div>
    <!-- .end .wrap -->
</section>

<!-- 07 -->
<?php
$php7 =<<<HTML
<span class="code-comment"><a target='_blank' href="https://www.yiiframework.com/doc/guide/2.0/zh-cn/concept-events">事件</a>:https://www.yiiframework.com/doc/guide/2.0/zh-cn/concept-events
<a target='_blank' href="https://www.yiiframework.com/doc/guide/2.0/zh-cn/concept-behaviors" >行为</a>:https://www.yiiframework.com/doc/guide/2.0/zh-cn/concept-behaviors</span>
HTML;
?>
<section>
    <!--.wrap = container (width: 90%) -->
    <div class="wrap">
        <div class="grid sm">
            <div class="column">
                <h3><strong>Yii2核心:事件,行为</strong></h3>
                <p class="text-intro">篇幅太长,请前往官方查看</p>
            </div>
            <!-- .end .column -->
            <div class="column bg-black-blue">
                <pre><?= $php7 ?></pre>
            </div>
            <!-- .end .column -->
        </div>
        <!-- .end .grid -->
    </div>
    <!-- .end .wrap -->
</section>

<!-- 08 -->
<?php
$php8 =<<<HTML
return [
  'components' => [
    <span class="code-comment">//组件配置</span>
     "subscription" => [
      <span class="code-comment">//完成类名</span>
      "class" => "crud\modules\wechat\components\SubscriptionService",
      'propertyName' => 'propertyValue',<span class="code-comment">//配置属性</span>
      'on eventName' => \$eventHandler,<span class="code-comment">//配置事件</span>
      'as behaviorName' => \$behaviorConfig,<span class="code-comment">//配置行为</span>
    ]
  ],
  'modules' => [
     <span class="code-comment">//模块配置</span>
     'wp' => [
        'class' => "crud\modules\wp\Wp"
     ],
  ],
];

HTML;
?>
<section>
    <!--.wrap = container (width: 90%) -->
    <div class="wrap">
        <div class="grid sm">
            <div class="column">
                <h3><strong>Yii2核心:配置</strong></h3>
            </div>
            <!-- .end .column -->
            <div class="column bg-black-blue">
                <pre><?= $php8 ?></pre>
            </div>
            <!-- .end .column -->
        </div>
        <!-- .end .grid -->
    </div>
    <!-- .end .wrap -->
</section>

<!-- 09 -->
<?php
$php9 =<<<HTML
\$crud = new backend\web\App();
<span class="code-comment">在App实例化之后</span>
crud\modules\wp\Wp::init();
crud\modules\wp\Wp::bootstrap();
<span class="code-comment">在App::run()执行之前</span>
\$crud->run();
<span class="code-comment">App实例化之后,会自动调用子模块init()和bootstrap()
init()方法主要作用:配置参数,
bootstrap()方法作用:用来挂载wordpress钩子到Yii2控制器
子模块::bootstrap()挂载的钩子<code>大于</code>App::run()中挂载的钩子</span>
HTML;
?>
<section>
    <!--.wrap = container (width: 90%) -->
    <div class="wrap">
        <div class="grid sm">
            <div class="column">
                <h3><strong>初始化</strong></h3>
                <p class="text-intro">初始化发生在App实例化之后App::run()之前</p>
                <p class="text-intro ">
                    <code style="color: red">
                        <b>这里特别要注意优先级</b>
                    </code>
                </p>
            </div>
            <!-- .end .column -->
            <div class="column bg-black-blue">
                <pre><?= $php9 ?></pre>
            </div>
            <!-- .end .column -->
        </div>
        <!-- .end .grid -->
    </div>
    <!-- .end .wrap -->
</section>

    <!-- 10 -->
<?php
$php10 =<<<HTML
<span class="code-comment">/**
 * 核心:将Yii2操作、事件等挂载到wordpress钩子上
 */</span>
public function run(){
<span class="code-comment">// +----------------------------------------------------------------------
// ｜配置wp模块和公共api路由
// +----------------------------------------------------------------------
// ｜http://youdomain.com/crud/ => wp/index/index
// ｜http://youdomain.com/crud/&#60;controller&#62;/ => wp/&#60;controller&#62;/index
// ｜http://youdomain.com/crud/&#60;controller&#62;/&#60;action&#62;/ => wp/&#60;controller&#62;/&#60;action&#62;
// ｜http://youdomain.com/crud/&#60;controller&#62;/&#60;action&#60;/&#60;id>/ => wp/&#60;controller&#62;/&#60;action&#62;/&#60;id&#62;</span>
    add_action('init', function () {
        add_rewrite_rule("^crud$",
            'index.php?crud=index/index', "top");
        add_rewrite_rule("^crud/([\w]+)$",
            'index.php?crud=\$matches[1]/index', "top");
        add_rewrite_rule("^crud/([\w]+)/([\w]+)$",
            'index.php?crud=\$matches[1]/\$matches[2]', "top");
        add_rewrite_rule("^crud/([\w]+)/([\w]+)/([0-9]+)$",
            'index.php?crud=\$matches[1]/\$matches[2]&id=\$matches[3]', "top");
    });
HTML;
$php11 =<<<HTML
    add_filter('query_vars', function (\$public_query_vars) {
        \$public_query_vars[] = 'crud';
        \$public_query_vars[] = 'id';

        return \$public_query_vars;
    });
    add_action("template_redirect", [\$this, "templateRedirect"]);

    <span class="code-comment">// +----------------------------------------------------------------------
    // ｜后台页面、设置、菜单，挂载到wordpress钩子中
    // +----------------------------------------------------------------------</span>
    add_action("admin_init", [\$this, "registerSettings"]);
    add_action("admin_menu", [\$this, "registerPage"]);

    <span class="code-comment">// +----------------------------------------------------------------------
    // ｜Ajax、RestfulApi、路由配置、解析规则，挂载到wordpress钩子中
    // +----------------------------------------------------------------------</span>
    add_action("admin_init", [\$this, "registerAjax"]);
    add_action("rest_api_init", [\$this, "registerRestfulApi"]);
HTML;

$php12 =<<<HTML
    <span class="code-comment">// +----------------------------------------------------------------------
    // ｜将yii\web\View事件挂载到wordpress钩子中
    // +----------------------------------------------------------------------</span>
    add_action("admin_init", [\$this, "beginPage"]);
    add_action("admin_head", [\$this, "registerCsrfMetaTags"]);
    add_action("admin_head", [\$this, "head"]);
    add_action("admin_body_open", [\$this, "beginBody"]);
    add_action("admin_footer", [\$this, "endBody"]);
    add_action("admin_footer", [\$this, "endPage"]);

    <span class="code-comment">// +----------------------------------------------------------------------
    // ｜配置邮箱
    // +----------------------------------------------------------------------</span>
    add_action('phpmailer_init', [\$this, "smtp"]);

    <span class="code-comment">// +----------------------------------------------------------------------
    // ｜过滤评论
    // +----------------------------------------------------------------------</span>
    add_action('preprocess_comment', [\$this, 'preprocessComment']);
HTML;

$php13 =<<<HtML
    <span class="code-comment">// +----------------------------------------------------------------------
    // ｜静止自动更新
    // +----------------------------------------------------------------------</span>
    add_filter('pre_site_transient_update_core', function () {
        return null;
    }); <span class="code-comment">// 关闭核心提示</span>
    add_filter('pre_site_transient_update_plugins', function () {
        return null;
    }); <span class="code-comment">// 关闭插件提示</span>
    add_filter('pre_site_transient_update_themes', function () {
        return null;
    }); <span class="code-comment">// 关闭主题提示</span>
     <span class="code-comment">// 禁止 WordPress 检查更新</span>
    remove_action('admin_init', '_maybe_update_core');   
     <span class="code-comment">// 禁止 WordPress 更新插件</span>
    remove_action('admin_init', '_maybe_update_plugins');
    remove_action('admin_init', '_maybe_update_themes');
HtML;
$php14 =<<<HTML
    <span class="code-comment">// +----------------------------------------------------------------------
    // ｜中国地区头像代理
    // +----------------------------------------------------------------------</span>
    add_filter('get_avatar', function (\$avatar) {
        return str_replace([
            'www.gravatar.com',
            '0.gravatar.com',
            '1.gravatar.com',
            '2.gravatar.com',
            'secure.gravatar.com',
            'cn.gravatar.com',
        ], 'wpcdn.shiguangxiaotou.com', \$avatar);
    });
}
HTML;


?>
    <section>
        <!--.wrap = container (width: 90%) -->
        <div class="wrap">
            <div class="grid sm">
                <div class="column">
                    <h3><strong>挂载钩子到控制器1</strong></h3>
                </div>
                <!-- .end .column -->
                <div class="column bg-black-blue">
                    <pre><?= $php10  ?></pre>
                </div>
                <!-- .end .column -->
            </div>
            <!-- .end .grid -->
        </div>
        <!-- .end .wrap -->
    </section>
    <section>
        <!--.wrap = container (width: 90%) -->
        <div class="wrap">
            <div class="grid sm">
                <div class="column">
                    <h3><strong>挂载钩子到控制器2</strong></h3>
                </div>
                <!-- .end .column -->
                <div class="column bg-black-blue">
                    <pre><?= $php11  ?></pre>
                </div>
                <!-- .end .column -->
            </div>
            <!-- .end .grid -->
        </div>
        <!-- .end .wrap -->
    </section>
    <section>
        <!--.wrap = container (width: 90%) -->
        <div class="wrap">
            <div class="grid sm">
                <div class="column">
                    <h3><strong>挂载钩子到控制器3</strong></h3>
                </div>
                <!-- .end .column -->
                <div class="column bg-black-blue">
                    <pre><?= $php12  ?></pre>
                </div>
                <!-- .end .column -->
            </div>
            <!-- .end .grid -->
        </div>
        <!-- .end .wrap -->
    </section>
    <section>
        <!--.wrap = container (width: 90%) -->
        <div class="wrap">
            <div class="grid sm">
                <div class="column">
                    <h3><strong>挂载钩子到控制器4</strong></h3>
                </div>
                <!-- .end .column -->
                <div class="column bg-black-blue">
                    <pre><?= $php13  ?></pre>
                </div>
                <!-- .end .column -->
            </div>
            <!-- .end .grid -->
        </div>
        <!-- .end .wrap -->
    </section>
    <section>
        <!--.wrap = container (width: 90%) -->
        <div class="wrap">
            <div class="grid sm">
                <div class="column">
                    <h3><strong>挂载钩子到控制器5</strong></h3>
                </div>
                <!-- .end .column -->
                <div class="column bg-black-blue">
                    <pre><?= $php14  ?></pre>
                </div>
                <!-- .end .column -->
            </div>
            <!-- .end .grid -->
        </div>
        <!-- .end .wrap -->
    </section>
<?php
$js =<<<JS
window.ws = new WebSlides();
JS;
$this->registerJs($js);