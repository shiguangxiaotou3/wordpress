## PHP常用拓展
#### PostgreSQL
`https://www.php.net/manual/en/book.pgsql.php`
PostgreSQL数据库是一个开源产品,无需成本.Postgres,最初在加州大学伯克利分校计算机中开发科学系,开创了许多对象关系概念现在可以在一些商业数据库中使用.它提供SQL92/SQL99 语言支持、事务、引用完整性、存储过程和类型扩展性.PostgreSQL是一个开源的这个原始伯克利代码的后代.  


#### Sync
`https://www.php.net/manual/en/book.sync.php`
"sync"扩展将跨平台同步对象引入PHP. 命名和未命名互斥锁、信号量、事件、读取器-写入器和命名共享内存 对象在 POSIX(例如 Linux)和 Windows 上提供操作系统级同步 平台.  
在扩展期间自动清理获取的同步对象 拆卸. 这意味着如果 PHP 过早终止脚本(例如脚本 超过执行时间),对象不会处于未知状态. 这 唯一的例外是 PHP 本身崩溃(例如内部缓冲区溢出).  
未命名的同步对象在多线程之外没有太多用途 场景. 未命名的对象与 pthreads PECL 结合使用更有用 外延.  
命名对象需要格外小心才能在所有系统上使用. 如果对象是使用一组特定的参数实例化的,则它必须始终 使用这些参数进行实例化,否则对象可能会以 状态不一致,直到下次重新启动或系统管理员清理 一团糟.


#### Apache
`https://www.php.net/manual/en/book.apache.php`
这些函数仅在将 PHP 作为 Apache 模块运行时可用.  


#### Yaml
`https://www.php.net/manual/en/book.yaml.php`
此扩展实现了 [»&nbsp;YAML Ain't标记语言 (YAML)](http://www.yaml.org/) 数据序列化标准.解析和发射由 [处理»&nbsp;LibYAML图书馆](http://pyyaml.org/wiki/LibYAML).  


#### Ev
`https://www.php.net/manual/en/book.ev.php`
此扩展提供接口[»&nbsp;libev](http://software.schmorp.de/pkg/libev.html)库 - 用 C 编写的高性能全功能事件循环.  
`Libev`是一个事件循环:对某些事件(例如文件)注册兴趣描述符是可读的或发生的超时),它将管理这些事件源,并为程序提供事件.  
为此,它必须或多或少地完全控制流程(或thread) 通过执行事件循环处理程序,然后进行通信通过回调机制的事件.  
您可以通过注册所谓的事件来注册对某些事件的兴趣观察者,然后通过启动观察者将其移交给 Libev.  
有关详细信息,请参阅[»&nbsp;文档 利贝夫](http://pod.tst.eu/http://cvs.schmorp.de/libev/ev.pod)  


#### ScoutAPM
`https://www.php.net/manual/en/book.scoutapm.php`

ScoutAPM 的 PHP 扩展为应用程序提供了额外的功能仅使用基本的 PHP 用户空间库进行监控.  


#### Password Hashing
`https://www.php.net/manual/en/book.password.php`
密码哈希 API 提供了一个易于使用的包装器[crypt()](function.crypt.php) 和其他一些密码哈希算法,轻松创建和管理密码以安全的方式.  


#### XML Parser
`https://www.php.net/manual/en/book.xml.php`
XML(可扩展标记语言)是一种结构化的数据格式Web 上的文档交换. 它是由以下定义的标准万维网联盟 (W3C). 有关 XML 和相关技术可以在[»&nbsp;http://www.w3.org/XML/找到](http://www.w3.org/XML/).  
这个PHP扩展实现了对James Clark的支持expat in PHP 此工具包可让您解析但不验证XML文档. 它支持三个源 [字符编码](XML.encoding.php)同样由 PHP 提供:`US-ASCII`,<code class="literal">ISO-8859-1 和 `UTF-8`</code>.不支持`UTF-16`.  
此扩展允许您[create XML 解析器](function.xml-parser-create.php)然后为不同的 XML 定义`处理程序`事件. 每个XML解析器还有一些<一个href="function.xml-parser-set-option.php" class="link">参数</a>可以调整.  


#### TCP
`https://www.php.net/manual/en/book.tcpwrap.php`
TCP包装器提供了一个经典的Unix机制,它已经旨在检查远程客户端是否能够从给定的 IP 进行连接地址.  


#### CUBRID
`https://www.php.net/manual/en/book.cubrid.php`
这些函数允许您访问 CUBRID 数据库服务器.有关CUBRID的更多信息可以在[»&nbsp;CUBRID中找到](http://www.cubrid.org/).  
CUBRID 的文档可以在 [»&nbsp;CUBRID 文档中找到](http://www.cubrid.org/documentation/).  


#### FDF
`https://www.php.net/manual/en/book.fdf.php`


#### SPL
`https://www.php.net/manual/en/book.spl.php`
标准PHP库(SPL)是旨在解决的接口和类的集合.常见问题.  
SPL 提供了一组标准数据结构、一组遍历对象的迭代器、一组接口、一组标准异常、许多用于处理文件的类,它提供了一组函数,如 [spl_autoload_register()](function.spl-autoload-register.php)  


#### Data Structures
`https://www.php.net/manual/en/book.ds.php`
PHP 7 的高效数据结构,作为 数组的替代方案提供.  
请参阅[»&nbsp;这篇博文](https://medium.com/p/9dda7af674cd) 有关基准、讨论和常见问题.  


#### Semaphore
`https://www.php.net/manual/en/book.sem.php`
这些模块为系统 V IPC 系列函数提供包装器.它包括信号量、共享内存和进程间消息传递 (IPC).  
信号量可用于提供对当前计算机上的资源,或限制可能同时使用资源的进程.  
该模块还使用系统 V 提供共享内存功能共享内存.共享内存可用于提供对全局变量.不同的httpd守护进程甚至其他程序(如Perl,C,...)能够访问此数据以提供全球数据交换.请记住,共享内存是不安全的反对同时访问.使用信号量进行同步.
消息传递功能可用于向/从中发送和接收消息其他流程.它们提供了一种简单有效的交换方式进程之间的数据,无需设置替代方案使用 Unix 域套接字.  


#### Rar
`https://www.php.net/manual/en/book.rar.php`
Rar 是由 Eugene Roshal 创建的强大而有效的存档器.此扩展程序使您可以阅读 Rar 存档,但不支持编写 Rar 存档,因为这不受支持由 UnRar 图书馆,并被其许可证直接禁止.  
有关 Rar 和 UnRar 的更多信息,请访问 [»&nbsp;http://www.rarlabs.com/](http://www.rarlabs.com/).  


#### XLSWriter
`https://www.php.net/manual/en/book.xlswriter.php`
高效快速的xlsx文件导出扩展名.  


#### Streams
`https://www.php.net/manual/en/book.stream.php`
流引用为:`scheme://``target` 


#### Trader
`https://www.php.net/manual/en/book.trader.php`
交易者扩展是一个基于 TA-Lib 的免费开源库存库.它致力于需要对金融市场数据进行技术分析的交易软件开发人员.除了 ADX、MACD、RSI、随机振荡指标、TRIX 等许多指标外,还存在烛台模式识别和几个向量算术和代数函数.  
计算可以在两种模式下完成 - TA-Lib和Metastock.使用 [trader_set_compat() 更改它](function.trader-set-compat.php)会影响某些交易者函数的工作方式.  
一些交易者函数根据所涉及的数据的"起点"提供不同的结果.这通常被称为具有记忆的功能.此类函数的一个例子是指数移动平均线.可以使用[trader_set_unstable_period() 函数来控制不稳定周期(要剥离的数据量](function.trader-set-unstable-period.php)).  
有关其他编程语言的指标、公式和实现的扩展文档可以在 [»&nbsp;tadoc.org 下找到](http://tadoc.org/).  


#### Program execution
`https://www.php.net/manual/en/book.exec.php`
这些函数提供了在系统本身,以及保护此类命令的手段.  
所有执行函数都通过以下方式调用命令 `cmd.exe` 在 Windows 下.因此,用户调用这些 函数需要适当的权限才能运行此命令.唯一的 例外是 [proc_open()](function.proc-open.php) `bypass_shell`选项.


#### Seaslog
`https://www.php.net/manual/en/book.seaslog.php`
<abbr>Seaslog</abbr> 是 PHP 的一个有效、快速、稳定的日志扩展.  
日志日志,通常是系统的运行记录,  软件和应用记录.  通过对日志的分析,可以方便用户了解系统的运行情况,  软件和应用情况.  如果您的应用程序日志足够丰富,  它还可以分析以前使用的操作行为,类型,  区域分布或其他更多信息.  应用程序日志还同时指向多个级别,  您可以轻松获得运行状况的应用程序分析,  及时发现问题并快速定位,并解决问题,弥补损失.  
PHP内置的error_log系统日志功能强大,性能优异,  但由于各种缺陷(error_log没有错误级别,没有固定的格式,无论模块如何,  并与系统日志混合),降低了很大的灵活性,并且不能满足应用程序的要求.  
好消息是已经建立了许多第三方日志类库  弥补缺陷,如log4php,plog,monolog(当然,  日志类的项目开发中有许多应用程序).  
那么是否有满足以下要求的库日志: 
目前提供的内容: 
阅读更多 [»&nbsp;Github上的SeasLog document](https://seasx.github.io/SeasLog/).  


#### Yaconf
`https://www.php.net/manual/en/book.yaconf.php`
`又一个配置容器`(<abbr>Yaconf</abbr>) 是一个配置容器,它解析INI文件,并存储结果在 PHP 中,当 PHP 启动时,结果与整个 PHP 生命周期.  
Yaconf 将所有配置存储为暂留字符串或不可变数组,这意味着它们是不可重新计数,因此当您检索配置时从Yaconf来看,它可以被认为是零拷贝的,非常快.  
Yaconf支持部分和部分INI 文件中的继承.如果 PHP 是作为非 ZTS 构建构建的,Yaconf还支持在INI文件后自动重新加载都变了.  
Yaconf 需要 PHP 7.0 或更高版本.  


#### GD
`https://www.php.net/manual/en/book.image.php`
PHP 不仅限于创建 HTML 输出. 它也可以是用于创建和操作各种不同的图像文件图像格式,包括`GIF`,`PN`, `JPEG` `WBMP`和`XPM`.更方便的是,PHP可以将图像流直接输出到浏览器.你需要使用`GD图像库编译PHP`.函数才能正常工作.`GD`和`PHP`可能还需要其他库,具体取决于要使用的图像格式.  
您可以使用 PHP 中的图像函数来获取`JPEG`, `GIF`,`PNG`,`SWF`,`TIFF`和`JPEG2000`图像.  
使用 [exif扩展名称](ref.exif.php),您可以处理存储在标头中的信息`JPEG`和`TIFF`图像.这样你可以读取数码相机生成的元数据.前言函数不需要`GD`库.  

GD支持多种格式,以下是GD支持的格式列表和注释它们的可用性,包括读/写支持.  

尽管上表中大多数格式都可用于读取和写入,但意味着PHP是在支持它们的情况下编译的.了解可用的格式在编译过程中使用 [gd_info()](function.gd-info.php) 函数,以获取更多信息有关编译对一种或多种格式的支持,请参阅安装章节.  


#### Mysqlnd
`https://www.php.net/manual/en/book.mysqlnd.php`
MySQL 本机驱动程序是 MySQL 客户端库的替代品(libmysqlclient).MySQL 本机驱动程序是官方 PHP 源代码的一部分,作为PHP 5.3.0.  
MySQL 数据库扩展 MySQL 扩展,`mysqli` 和 pdo MYSQL 都与 MySQL 通信服务器.过去,这是通过使用服务的扩展完成的由 MySQL 客户端库提供.扩展已编译针对 MySQL 客户端库,以便使用其客户端-服务器协议.  
使用MySQL本机驱动程序,现在有另一种选择,如MySQL数据库扩展可以编译为使用 MySQL 本机驱动程序的 MySQL 客户端库.  
MySQL Native Driver 是用 C 编写的,作为 PHP 扩展.  


#### FANN
`https://www.php.net/manual/en/book.fann.php`
用于实现多层的 FANN(快速人工神经网络)库的 PHP 绑定支持全连接和稀疏连接的人工神经网络.它包括一个易于处理训练数据集的框架.它易于使用,用途广泛,有据可查,而且速度很快.  


#### FFI
`https://www.php.net/manual/en/book.ffi.php`

此扩展允许加载共享库(`.DLL`或`.so`),调用C函数和访问C数据结构,在纯PHP中无需深入了解Zend扩展API,并且无需学习第三种"中级"语言.公共 API 实现为单个类[FFI](https://www.php.net/manual/en/class.ffi.php)几个静态方法(其中一些可以动态调用)和重载对象方法,执行与 C 数据的实际交互。


FFI 很危险,因为它允许在非常低的级别上与系统接口. FFI 扩展只能由具有 C 语言工作知识的开发人员使用 以及使用的 C API.为了最大限度地降低风险,FFI API 的使用可能会受到限制 使用 [ffi.enable](ffi.configuration.php#ini.ffi.enable)`php.ini`指令.
FFI 扩展不会使经典的 PHP 扩展 API 过时;它只是 提供与 C 函数和数据结构的临时接口.
目前,访问 FFI 数据结构的速度要慢得多(约 2 倍). 而不是访问本机 PHP 数组和对象.因此,使用毫无意义 FFI 速度扩展;但是,使用它来减少内存可能是有意义的 消费.


#### Radius
`https://www.php.net/manual/en/book.radius.php`
此软件包基于 libradius(远程身份验证拨入用户)Service)的 FreeBSD.它允许客户端执行身份验证和通过对远程服务器的网络请求进行记帐.  
此 PECL 扩展增加了对半径身份验证的完全支持([»&nbsp;RFC 2865](http://www.faqs.org/rfcs/rfc2865)) 和 Radius Accounting([»&nbsp;RFC 2866](http://www.faqs.org/rfcs/rfc2866)).此软件包可用适用于 Unix(在 FreeBSD 和 Linux 上测试)和 Windows.  
可以找到自由半径的确切描述 [»&nbsp;这里](http://www.freebsd.org/cgi/man.cgi?query=libradius).详细说明 配置文件可以在这里找到[".&nbsp;](http://www.freebsd.org/cgi/man.cgi?query=radius.conf)


#### Pspell
`https://www.php.net/manual/en/book.pspell.php`
这些功能允许您检查单词的拼写并提供建议.  


#### Directories
`https://www.php.net/manual/en/book.dir.php`


#### Sessions
`https://www.php.net/manual/en/book.session.php`
PHP 中的会话支持包括一种保留某些数据的方法跨后续访问.  
访问您网站的访问者将被分配一个唯一的 ID,即所谓的会话 ID.这要么存储在 cookie 上的用户端或在 URL 中传播.  
会话支持允许您在<var class="varname">[$_SESSION](reserved.variables.session.php)</var> superglobal array.当访客访问时你的站点,PHP 将自动检查[session.auto_start](https://www.php.net/manual/en/session.configuration.php#ini.session.auto-start)设置为 1) 或根据您的请求(明确通过[session_start())](function.session-start.php)是否为特定会话ID 已随请求一起发送.如果是这种情况,则先前重新创建保存的环境.  
如果打开[session.auto_start](session.configuration.php#ini.session.auto-start)放置对象的唯一方法 到您的会话中是使用 [auto_prepend_file](ini.core.php#ini.auto-prepend-file) 在其中加载类定义,否则您必须 [serialize()](function.serialize.php) 你的对象 和 [unserialize()](function.unserialize.php) it 之后.
<var class="varname">[$_SESSION](reserved.variables.session.php)</var>(和所有注册的变量)被序列化PHP 在内部使用由[session.serialize_handler ini](session.configuration.php#ini.session.serialize-handler) settings,请求完成后. 未定义的注册变量是标记为未定义. 在后续访问中,未定义这些由会话模块,除非用户稍后定义它们.  
由于会话数据是序列化的,因此资源变量不能 存储在会话中.
序列化处理程序(`php`  和`php_binary`)继承register_globals  局限性.因此,数字索引或字符串索引包含  特殊字符(`|`和`！`不能使用.使用这些最终会  脚本关闭时出错.`php_serialize` 没有这样的限制.
请注意,使用会话时,会话的记录 在使用 <span class="function"><strong>session_register()</strong></span> 函数或通过添加新的 键到 <var class="varname">[$_SESSION](reserved.variables.session.php)</var> 超全局数组.这 无论会话是否已使用 [session_start()](https://www.php.net/manual/en/function.session-start.php)


#### V8js
`https://www.php.net/manual/en/book.v8js.php`
这个扩展将[»&nbsp;V8 Javascript 引擎](http://code.google.com/p/v8/)嵌入到 PHP 中.  


#### HRTime
`https://www.php.net/manual/en/book.hrtime.php`
HRTime扩展实现了高分辨率秒表类.它使用不同平台上最好的API,可将分辨率提高到纳秒.它还使实施成为可能使用底层 API 提供的低级别刻度的自定义秒表.  


#### Math
`https://www.php.net/manual/en/book.math.php`
这些数学函数将仅处理int 和 float 类型.要处理较大的数字,请查看[任意精度数学](book.bc.php)或[GNU Multiple Precision Functions](book.gmp.php) functions.  



#### XMLDiff
`https://www.php.net/manual/en/book.xmldiff.php`
该扩展能够生成两个 XML 文档的差异,然后将差异应用于源文档.diff 是一个 XML 文档,其中包含人类可读格式的复制/插入/删除指令节点.可以处理内存中的 DOMDocument 对象、本地文件和字符串.  


#### SNMP
`https://www.php.net/manual/en/book.snmp.php`
SNMP 扩展提供了一个非常简单且易于使用的工具集,用于通过简单网络管理协议管理远程设备.  
因为它是底层网络SNMP的包装器库,所有基本概念都是一样的,PHP 函数改变了它们行为取决于网络 SNMP 配置文件和环境变量.  
有关 Net-SNMP 的更多信息,请访问[»&nbsp;http://www.net-snmp.org/](http://www.net-snmp.org/)  


#### Sockets
`https://www.php.net/manual/en/book.sockets.php`
套接字扩展实现套接字的低级接口基于流行的BSD套接字的通信功能,提供可以充当套接字服务器和客户端.  
有关更通用的客户端套接字接口,请参阅[stream_socket_client()](function.stream-socket-client.php),[stream_socket_server()](function.stream-socket-server.php),[fsockopen()](function.fsockopen.php)和[pfsockopen().](function.pfsockopen.php)  
使用这些函数时,重要的是要记住,虽然他们中的许多人与他们的 C 对应物具有相同的名称,他们通常有不同的声明.请务必阅读描述以避免混淆.  
那些不熟悉套接字编程的人可以找到很多在适当的Unix手册页中有用的材料,并且有一个伟大的关于 C 语言套接字编程的教程信息在网络上,很多只需稍作修改即可应用于套接字编程在 PHP 中.[»&nbsp;Unix Socket常见问题解答](http://www.unixguide.net/network/socketfaq/)可能是一个好的开始.  


#### LDAP
`https://www.php.net/manual/en/book.ldap.php`
LDAP 是轻量级目录访问协议,并且是一个用于访问"目录服务器"的协议.目录是一个在树中保存信息的特殊数据库结构.  
这个概念类似于你的硬盘目录结构,除了在此上下文中,根目录是"世界"第一级子目录是"国家".较低级别的目录结构包含公司的条目,组织或地方,虽然更低,但我们还能找到目录人员条目,也许还有设备或文件.  
要引用硬盘上子目录中的文件,您可以使用类似以下内容:  
正斜杠标记引用中的每个分部,并且序列从左到右读取.  
等效于 LDAP 中的完全限定文件引用是"可分辨名称",简称为"DN".一个例子dn 可能是:  
逗号标记引用中的每个部分,以及序列从右到左读取.您可以将此 dn 解读为:  
就像没有关于如何组织的硬性规定一样硬盘、目录服务器的目录结构经理可以设置任何对目的.但是,使用了一些约定.这消息是您无法编写代码来访问目录服务器,除非您对其结构有所了解,否则而不是你可以在不了解什么是的情况下使用数据库可用.  
有关LDAP的大量信息,请访问  
[»&nbsp;Mozilla](https://wiki.mozilla.org/Directory) 
[»&nbsp;OpenLDAP 项目](http://www.openldap.org/) 
互联网工程任务组 RFC <a href="http://www.faqs.org/rfcs/rfcrfc4510" class="link external">» 4510 到 [»&nbsp;](http://www.faqs.org/rfcs/rfcrfc4519)&nbsp;4519</a>. 
Netscape SDK包含一个有用的[»&nbsp;程序员指南](https://wiki.mozilla.org/Mozilla_LDAP_SDK_Programmer%27s_Guide)HTML 格式.  


#### MySQL (PDO)
`https://www.php.net/manual/en/ref.pdo-mysql.php`
PDO_MYSQL数据源名称 (DSN) 由以下元素组成:  
`'mysql:host=host;dbname=dbname'`  
字符集.参见 [字符集](mysqlinfo.concepts.charset.php)概念文档以获取更多信息.  
当主机名设置为 `"localhost" 时`,连接到服务器是通过域套接字创建的.如果PDO_MYSQL是针对libmysqlclient编译的,那么套接字文件的位置位于 libmysqlclient 的编译位置.如果编译了PDO_MYSQL针对mysqlnd,可以通过[pdo_mysql.默认套接字](ref.pdo-mysql.php#ini.pdo-mysql.default-socket)设置.  


#### Variable handling
`https://www.php.net/manual/en/book.var.php`
有关变量行为方式的信息,请参阅[Variables](language.variables.php) 条目手册的[语言参考](langref.php)部分.  


#### Exif
`https://www.php.net/manual/en/book.exif.php`
使用 exif 扩展名,您可以处理图像元数据. 为例如,您可以使用EXIF函数读取所拍摄照片的元数据通过处理存储在标题中的信息从数码相机.这些常见于`JPEG`和`TIFF`图像.  


#### PS
`https://www.php.net/manual/en/book.ps.php`
该模块允许创建PostScript文档.它有很多与 PDF 扩展名的相似之处.实际上 API 几乎是相同,在许多情况下可以只替换前缀每个功能从pdf_到ps_.这也适用于以下函数:在 PostScript 文档中没有任何意义(如添加超链接)但如果将文档转换为 PDF,则会产生影响.  
此扩展创建的文档有时甚至更胜一筹使用PDF扩展名创建的文档,因为PSLIB的文本呈现函数可以处理字距调整、连字和连字这导致更好的盒装文本输出.  


#### XML-RPC
`https://www.php.net/manual/en/book.xmlrpc.php`
这些函数可用于编写 XML-RPC 服务器和客户端.  您可以在以下位置找到有关 XML-RPC 的更多信息:  [»&nbsp;http://www.xmlrpc.com/](http://www.xmlrpc.com/) 等  有关此扩展及其功能的文档,请访问  [»&nbsp;http://xmlrpc-epi.sourceforge.net/](http://xmlrpc-epi.sourceforge.net/). 


#### Calendar
`https://www.php.net/manual/en/book.calendar.php`
日历扩展提供了一系列功能来简化在不同的日历格式之间转换. 中介人或它所基于的标准是儒略日计数. 儒略日计数是从公元前 4713 年 1 月 1 日开始的天数 在 之间转换日历系统,您必须首先转换为儒略日计数,然后转换为您选择的日历系统. 儒略日计数与儒略历！有关儒略日计数的更多信息,请访问[»&nbsp;http://www.hermetic.ch/cal_stud/jdn.htm.](http://www.hermetic.ch/cal_stud/jdn.htm)欲了解更多信息有关日历系统的信息,请访问[»&nbsp;http://www.fourmilab.ch/documents/calendar/](http://www.fourmilab.ch/documents/calendar/). 本页摘录如下包含在这些说明中,并用引号引起来.  


#### Shared Memory
`https://www.php.net/manual/en/book.shmop.php`
Shmop 是一组易于使用的函数,允许 PHP 读取,写入、创建和删除 Unix 共享内存段.  


#### Quickhash
`https://www.php.net/manual/en/book.quickhash.php`
快速哈希扩展包含一组特定的强类型类处理特定的集合和哈希实现.  


#### PostgreSQL (PDO)
`https://www.php.net/manual/en/ref.pdo-pgsql.php`
PDO_PGSQL数据源名称 (DSN) 由以下元素组成,由空格或分号分隔:  
DSN 前缀是 <strong class="userinput"`>pgsql:`</strong>.  
数据库服务器所在的主机名.  
运行数据库服务器的端口.  
数据库的名称.  
连接的用户的名称.如果指定用户名在 DSN 中,PDO 忽略PDO 构造函数.  
连接用户的密码.如果指定DSN中的密码,PDO忽略密码参数的值在 PDO 构造函数中.  
SSL 模式.支持的值及其含义列在[»&nbsp;PostgreSQL 文档](http://www.postgresql.org/docs/current/interactive/).  


#### iconv
`https://www.php.net/manual/en/book.iconv.php`
此模块包含用于 iconv 字符集转换的接口设备.使用此模块,您可以转换由本地表示的字符串字符集转换为由另一个字符集表示的字符集,这可能是 Unicode 字符集.支持的字符集取决于系统的 iconv 实现.请注意,某些系统上的 iconv 功能可能无法正常工作如您所料.在这种情况下,最好安装[»&nbsp;GNU libiconv](http://www.gnu.org/software/libiconv/) library.它将最最终可能会得到更一致的结果.  
此扩展附带帮助您编写多语言的各种实用程序函数脚本.让我们看一下以下部分来探索新的特征.  


#### Ctype
`https://www.php.net/manual/en/book.ctype.php`
此扩展提供的功能检查字符是否或字符串根据当前语言环境(另请参阅[setlocale()](function.setlocale.php)).  
当使用整数参数调用这些函数时行为与来自 C 的对应项完全相同<var class="filename">ctype.h</var>.这意味着如果传递小于 256 的整数,它将使用它的 ASCII 值,以查看它是否适合指定范围(数字在0x30-0x39). 如果数字介于 -128 和 -1 之间(包括 -1),则 256 将添加并对其进行检查.  
从 PHP 8.1.0 开始,不推荐传递非字符串参数.将来,参数将被解释为字符串而不是 ASCII 代码点.根据预期行为,参数应强制转换为 string或者显式调用[chr().](function.chr.php)
当使用字符串参数调用时,它们将检查字符串中的每个字符,只会返回<strong>`如果`</strong>字符串中的每个字符都与请求的标准.当使用空字符串调用时,结果将始终为 <strong>`false`</strong>.  
传递除字符串或整数以外的任何其他内容将立即返回<strong>`假`</strong>值.  
应该注意的是,ctype 函数总是优先于正则表达式,甚至一些等效的`"str_*"`和`"is_*"`函数.这是因为 ctype 使用本机 C 库,因此处理速度明显加快.  
这些函数与 Python "ctypes" 库完全无关. 扩展名源于 <var class="filename">ctype.h</var> C 标头 在其中定义其 C 等效项的文件.
这个扩展也早于Python"ctypes",所以任何混淆 由这种命名引起的几乎不是PHP的错.


#### Solr
`https://www.php.net/manual/en/book.solr.php`
Solr扩展允许您与PHP中的Apache Solr服务器进行有效的通信.  
Solr扩展是一个速度极快、轻量级、功能丰富的库,允许PHP开发人员与Solr服务器实例进行有效的通信.
PECL 扩展的 1.x 版支持 Apache Solr Server 1.3-3.x
PECL 扩展的 2.x 版支持 Apache Solr Server 4.0+
有内置工具可以添加文档并对solr服务器进行更新.
它还包含允许您在搜索文档时构建对服务器的高级查询的工具.


#### SVN
`https://www.php.net/manual/en/book.svn.php`
此扩展实现了 PHP 绑定[»&nbsp;Subversion](http://subversion.apache.org/) (SVN),一个版本控制系统,允许PHP脚本与SVN存储库通信和工作副本,无需直接命令行调用<var class="filename">svn</var>可执行.  


#### Mcrypt
`https://www.php.net/manual/en/book.mcrypt.php`
此功能在 PHP 7.1.0 中被`弃用`,并且 `在` PHP 7.2.0 中删除.
此功能的替代方法包括:
此扩展已移至[»&nbsp;PECL](https://pecl.php.net/) 存储库,不再与PHP 从 PHP 7.2.0 开始.
这是 mcrypt 库的接口,它支持广泛的各种块算法,如DES,TripleDES,河豚(默认)、3 路、更安全的 SK64、更安全的 SK128、双鱼、茶、RC2 和CBC、OFB、CFB 和 ECB 密码模式下的 GOST.此外,它支持被认为是"非自由"的RC6和IDEA.默认情况下,CFB/OFB 为 8 位.  


#### ZooKeeper
`https://www.php.net/manual/en/book.zookeeper.php`
此扩展使用 libzookeeper 库来提供与 ZooKeeper 服务通信的 API.  
ZooKeeper 是一个 Apache 项目,它支持集中式服务来维护配置信息、命名、提供分布式同步和提供组服务.  


#### mqseries
`https://www.php.net/manual/en/book.mqseries.php`


#### Varnish
`https://www.php.net/manual/en/book.varnish.php`
Varnish Cache是一个开源的,最先进的Web应用程序加速器.该扩展使与正在运行的通过 TCP 套接字或共享内存的清漆实例.  


#### YAZ
`https://www.php.net/manual/en/book.yaz.php`
此扩展为YAZ 工具包,它实现了[»&nbsp;Z39.50信息检索协议](http://www.loc.gov/z3950/agency/).使用此扩展,您可以轻松实现 Z39.50 源(客户端)并行搜索或扫描 Z39.50 目标(服务器).  
该模块隐藏了 Z39.50 的大部分复杂性,因此它应该是相当容易使用.它非常支持持久的无状态连接类似于可用的各种 RDB API 提供的那些对于 PHP.这意味着会话是无状态的,但在用户,从而节省了大多数连接和初始化阶段的步骤例.  
YAZ 可在 [» http://www.indexdata.dk/yaz/.&nbsp;](http://www.indexdata.dk/yaz/)你可以找到新闻信息,此扩展的示例脚本等位于 [»&nbsp;http://www.indexdata.dk/phpyaz/.](http://www.indexdata.dk/phpyaz/)  
此扩展已移至[»&nbsp;PECL](https://pecl.php.net/) 存储库,不再与PHP 从 PHP 5.0.0 开始.


#### Parle
`https://www.php.net/manual/en/book.parle.php`
parle 扩展提供通用的词法分析和分析工具.该实现基于 <a href="http://www.benhanson.net/" class="link external">» Ben Hanson 的库,需要一个[»&nbsp;](http://en.cppreference.com/w/cpp/compiler_support)&nbsp;C++14</a> 编译器.词法分析器基于正则表达式匹配,解析器是 LALR(1).词法分析器和解析器是动态生成的,可以在最终确定后立即使用.Parle处理解析和词法,适当的数据结构表示和处理是实现者的任务.扩展尚不支持序列化和代码生成.  
词法分析是将字符序列拆分为词素列表的过程.然后,词法列表可用于针对形式语法的语法分析.这些操作也称为词法分析和分析.本文档并不旨在提供有关词法和分析的详尽信息.网上的众多资源提供了这方面的良好信息.包括几个使用示例,以显示功能.该扩展对于愿意学习或使用解析和词法的 PHP 程序员很有用.状态机和语法解析不必手动实现,这些复杂的任务被 parle 带走.因此,开发可以专注于实际解决问题.  
parle 的常见用例是,当数据格式太复杂而无法由与 PCRE 匹配的正则表达式处理时.实际应用范围很广.无论是特定的数据格式,现有函数的行为修改,甚至是自己的编程语言等等.诸如 <span class="methodname"><</a></span>a href="parle-lexer.dump.php" class="methodname">Parle\Lexer::d ump() 来检查生成的状态机,或者[Parle\Parser::d ump() 来检查生成的](parle-parser.dump.php)语法,都很有用.方法 [Parle\Parser::trace() 也](parle-parser.trace.php)可用于跟踪解析操作.  


#### IMAP
`https://www.php.net/manual/en/book.imap.php`
这些函数使您能够使用 <abbr title="Internet 邮件访问协议">IMAP 进行操作</abbr>协议,以及 `NNTP`,`POP3`和本地邮箱访问方法.  
但是,请注意,某些IMAP功能将不起作用正确使用 POP 协议.  


#### GnuPG
`https://www.php.net/manual/en/book.gnupg.php`
此模块允许您与 [»&nbsp;gnupg 进行交互](http://www.gnupg.org/).  


#### SVM
`https://www.php.net/manual/en/book.svm.php`
LibSVM 是 SVM 分类和回归问题的高效求解器.svm 扩展将其包装在 PHP 接口中,以便在 PHP 脚本中轻松使用.  


#### libxml
`https://www.php.net/manual/en/book.libxml.php`
这些函数/常量从 PHP 5.1.0 开始可用,并且以下核心扩展依赖于此 libxml 扩展:[DOM](book.dom.php),[libxml](book.libxml.php),[SimpleXML](book.simplexml.php),[SOAP](book.soap.php),[WDDX](book.wddx.php),[XSL](book.xsl.php),[XML](book.xml.php),[XMLReader](book.xmlreader.php),[XMLRPC](book.xmlrpc.php) and[XMLWriter.](book.xmlwriter.php)  


#### Misc.
`https://www.php.net/manual/en/book.misc.php`
这些函数被放在这里是因为没有其他函数类别似乎很合适.  


#### Mysql_xdevapi
`https://www.php.net/manual/en/book.mysql-xdevapi.php`
此扩展通过X DevAPI提供对MySQL文档存储的访问.X 开发接口是由多个 MySQL 连接器提供的通用 API,可轻松访问关系来自 API 的表以及以 JSON 表示的文档集合使用 CRUD 样式的操作.  
X DevAPI使用X协议,MySQL的新一代客户端-服务器协议8.0 服务器.  
有关 MySQL 文档存储的一般信息,请参阅[»&nbsp;MySQL 文档存储](https://dev.mysql.com/doc/refman/8.0/en/document-store.html)章节.  


#### Fileinfo
`https://www.php.net/manual/en/book.fileinfo.php`
此模块中的函数尝试猜测内容类型并通过查找某些文件来编码文件``特定文件中的位置.虽然这不是防弹方法使用的启发式方法做得很好.  


#### SQLite (PDO)
`https://www.php.net/manual/en/ref.pdo-sqlite.php`
PDO_SQLITE数据源名称 (DSN) 由以下元素组成:  
DSN 前缀是 <strong class="userinput">`sqlite:`</strong>.
要访问磁盘上的数据库,必须将绝对路径附加到DSN 前缀.  
要在内存中创建数据库,必须追加`:memory:`到DSN前缀.  
如果 DSN 仅包含 DSN 前缀,则使用临时数据库,关闭连接时将删除.  


#### POSIX
`https://www.php.net/manual/en/book.posix.php`
此模块包含指向 中定义的函数的接口不是 IEEE 1003.1 (POSIX.1) 标准文档可通过其他方式访问.  
敏感数据可以使用POSIX功能检索,例如 [posix_getpwnam()](function.posix-getpwnam.php) 和朋友.


#### Zip
`https://www.php.net/manual/en/book.zip.php`
此扩展使您能够透明地读取或写入压缩的 ZIP存档及其中的文件.  


#### dBase
`https://www.php.net/manual/en/book.dbase.php`
此扩展已移至[»&nbsp;PECL](https://pecl.php.net/) 存储库,不再与PHP 从 PHP 5.3.0 开始.
这些函数允许您访问以 dBase 格式存储的记录(DBF) 数据库.  
我们建议不要将 dBase 文件用作您的产品 数据库.使用 [»&nbsp;SQLite](http://sqlite.org/) 或选择任何真正的 SQL 服务器;<a href="http://www.mysql.com/" class="link external">» MySQL or [»&nbsp;](http://www.postgresql.org/)&nbsp;Postgres</a> 是 PHP 的常见选择.dBase 支持在这里允许您 将数据导入和导出到 Web 数据库和从 Web 数据库导出数据,因为 文件格式通常被Windows电子表格和 组织者.
从 dbase 7.0.0 开始,数据库通过以下方式自动锁定 [flock().](function.flock.php)之前一直不支持锁定, 因此,修改同一 dBase 文件的两个并发 Web 服务器进程将 很可能毁了您的数据库.即使使用 dbase 也可能发生这种情况 7.0.0+ 在进程级别实现锁的系统上 多线程 SAPI.
dBase 文件是固定长度记录的简单顺序文件.记录将追加到文件末尾,删除的记录将一直保持到你调用[dbase_pack()](function.dbase-pack.php).  
仅支持 dbf 文件级别 3 (dBASE III+) - 5 (dBASE V).可用的 dBase 字段类型包括:
从 dbase 7.0.0 开始,支持可为空的字段 <strong>`DBASE_TYPE_FOXPRO`</strong>数据库.如果字段可为空, 传递 <strong>`null`</strong> 将设置相应的标志,并在以后检索该字段时 值将为<strong>`空`</strong>.
不支持索引或备注字段.


#### RRD
`https://www.php.net/manual/en/book.rrd.php`
PECL/rrd 扩展提供与 RRDtool C 库的绑定.RRDtool 是开源的行业标准,高性能数据用于时间序列数据的日志记录和绘图系统.  
RRDtool主页是[»&nbsp;http://www.mrtg.org/rrdtool/](http://www.mrtg.org/rrdtool/).  


#### PDO
`https://www.php.net/manual/en/book.pdo.php`
`PHP 数据对象` (<abbr>PDO</abbr>) 扩展定义了一个轻量级、一致的接口用于访问 PHP 中的数据库.每个数据库驱动程序实现PDO接口可以公开特定于数据库的作为常规扩展功能的功能.请注意,您不能使用 PDO 扩展执行任何数据库功能本身;必须使用 <href="PDO.drivers.php" class="link">特定于数据库用于访问数据库服务器的 PDO 驱动程序</a>.  
PDO提供了一个`数据访问`抽象层,它这意味着,无论您使用哪个数据库,您都使用相同的数据库用于发出查询和获取数据的函数. PDO做`not` offer a `database`抽象化;它不会重写 SQL 或模拟缺少的功能. 你如果需要该工具,应使用成熟的抽象层.  
PDO随PHP一起提供.  


#### Statistics
`https://www.php.net/manual/en/book.stats.php`
这是统计信息扩展.它包含几十个函数对统计计算很有用.它是 2 科学的包装器库,即 DCDFLIB(用于累积的 C 例程库)Distributions Functions, Inverses, and Other parameters) by B. Brown &amp;J. Lavato and RANDLIB by Barry Brown, James Lavato &amp; Kathy Russell.包括 CD 和 PD 功能.  


#### Tokenizer
`https://www.php.net/manual/en/book.tokenizer.php`
分词器函数提供接口嵌入在 Zend Engine 中的 PHP 标记器.使用这些函数你可以编写自己的PHP源代码分析或修改工具,无需处理词汇级别的语言规范.  
另请参阅[附录](tokens.php).  


#### MS SQL Server (PDO)
`https://www.php.net/manual/en/ref.pdo-sqlsrv.php`
PDO_SQLSRV数据源名称 (DSN) 由以下元素组成:  
DSN 前缀是 `sqlsrv:`.  
跟踪中使用的应用程序名称.  
指定是否从连接池分配连接(1 或<strong>`真`</strong>)或不(0 或<strong>`假`</strong>).  
数据库的名称.  
指定与 SQL Server 的通信是否加密(1 或<strong>`真`</strong>)或未加密(0 或<strong>`假`</strong>).  
指定数据库镜像的服务器和实例(如果已启用)和配置),以便在主服务器不可用时使用.  
指定连接尝试失败之前等待的秒数.  
禁用或显式启用对多个活动结果集 (MARS) 的支持.  
指定是否对带引号的标识符使用 SQL-92 规则(1 或 <strong>`true`</strong>)或使用旧版事务处理 SQL 规则(0 或 <strong>`false`</strong>).  
数据库服务器的名称.  
指定用于跟踪数据的文件的路径.  
指定是启用 ODBC 跟踪(1 或 <strong>`true`</strong>)还是禁用 ODBC 跟踪(0 或 <strong>`false`</strong>)表示正在建立的连接.  
指定事务隔离级别.对此的接受值选项是 PDO::SQLSRV_TXN_READ_UNCOMMITTED, PDO::SQLSRV_TXN_READ_COMMITTED,PDO::SQLSRV_TXN_REPEATABLE_READ、PDO::SQLSRV_TXN_SNAPSHOT和PDO::SQLSRV_TXN_SERIALIZABLE.  
指定客户端是应信任(1 或 <strong>`true`</strong>)还是拒绝(0 或 <strong>`false`</strong>)自签名服务器证书.  
指定要跟踪的计算机的名称.  


#### UI
`https://www.php.net/manual/en/book.ui.php`
此扩展包装了libui,为本机外观用户界面的跨平台开发提供了OO API.  


#### PCRE
`https://www.php.net/manual/en/book.pcre.php`
这些函数中使用的模式语法非常类似于珀尔.表达式必须括在分隔符中,a例如,正斜杠 (/). 分隔符可以是任何非字母数字、非空格 ASCII 字符,反斜杠 (\) 和空字节.如果必须在表达式本身,需要通过反斜杠进行转义.也可以使用 Perl 样式 ()、{}、[] 和 &lt;&gt; 匹配分隔符.请参阅 [Pattern Syntax](reference.pcre.pattern.syntax.php)以获取详细说明.  
结束分隔符后可能跟各种修饰符,影响匹配.参见[Pattern 修饰符](reference.pcre.pattern.modifiers.php).  
此扩展维护已编译常规的全局每线程缓存 表达式(最多 4096 个).
您应该了解PCRE的一些局限性.阅读[»&nbsp;http://www.pcre.org/pcre.txt](http://www.pcre.org/pcre.txt)了解更多信息.
PCRE 库是一组实现常规的函数使用相同的语法和语义进行表达式模式匹配作为 Perl 5,只有一些差异(见下文). 当前实现对应于 Perl 5.005.  


#### Taint
`https://www.php.net/manual/en/book.taint.php`
污点是一个扩展,用于检测XSS代码(污点)字符串).并且还可用于发现SQL注入漏洞和shell.注射等.  
启用污点后,如果传递受污染的字符串(来自 $_GET,$_POST 或 $_COOKIE) 对于某些函数,污点会警告您.  


#### DBA
`https://www.php.net/manual/en/book.dba.php`
这些函数为访问伯克利数据库奠定了基础样式数据库.  
这是几个基于文件的数据库的常规抽象层.因此,功能仅限于功能的公共子集受现代数据库支持,例如[»&nbsp;Oracle Berkeley DB](https://www.oracle.com/database/berkeley-db/db.html).  


#### wkhtmltox
`https://www.php.net/manual/en/book.wkhtmltox.php`
libwkhtmltox 是一个开源的 LGPLv3 库,用于将 HTML 渲染为 PDF 和各种图像格式  使用 QtWebKit 渲染引擎.  


#### uopz
`https://www.php.net/manual/en/book.uopz.php`
uopz - Zend的用户操作 - 扩展公开了通常在编译和执行时使用的Zend Engine功能,以便 允许修改表示 PHP 代码的内部结构,并允许用户代码与 VM 交互.  
UOPZ支持以下活动:  
所有支持的活动都与opcache兼容


#### xattr
`https://www.php.net/manual/en/book.xattr.php`
xattr 扩展允许操作文件系统上的扩展属性.  


#### Lua
`https://www.php.net/manual/en/book.lua.php`
"Lua 是一种强大、快速、轻量级、可嵌入的脚本语言.此扩展嵌入了 lua 解释器,并为 lua 提供了一个 OO-API变量和函数.  


#### Sodium
`https://www.php.net/manual/en/book.sodium.php`
Sodium 是一个现代、易于使用的软件库,用于加密、解密、签名、密码散列等.其目标是提供构建更高级别加密工具所需的所有核心操作.  


#### Classes/Objects
`https://www.php.net/manual/en/book.classobj.php`
这些函数允许您获取有关类的信息和实例对象.您可以获取类的名称对象所属,以及其成员属性和方法.使用这些功能,您不仅可以发现对象的类成员资格,以及它的父级(即对象类扩展了什么类).  
请参阅 [Objects](language.types.object.php)部分,详细说明了如何类和对象在 PHP 中实现和使用.  


#### Error Handling
`https://www.php.net/manual/en/book.errorfunc.php`
这些是处理错误处理和日志记录的函数.他们允许您定义自己的错误处理规则,以及修改记录错误的方式.这允许您更改和增强错误报告以满足您的需求.  
使用日志记录功能,您可以将消息直接发送给其他人计算机,到电子邮件(或电子邮件到寻呼机网关！),到系统日志,等,因此您可以有选择地记录和监控最重要的部分您的应用程序和网站.  
错误报告功能允许您自定义级别和给出错误反馈的类型,从简单的通知到定制的错误期间返回的函数.  


#### Firebird (PDO)
`https://www.php.net/manual/en/ref.pdo-firebird.php`
PDO_FIREBIRD数据源名称 (DSN) 由以下元素组成:  
DSN 前缀是 <strong class="userinput">`firebird:`</strong>.  
数据库的名称.  
字符集.  
SQL 角色名称.  
数据库的方言;`1`或 `3`.如果未指定,方言默认为 `3`.从 PHP 7.4.0 开始提供.  


#### Zlib
`https://www.php.net/manual/en/book.zlib.php`
此模块使您能够透明地读取和写入gzip (.gz) 压缩文件,通过大多数版本的[文件系统](book.filesystem.php)函数适用于 gzip 压缩文件(和未压缩文件,也是,但不带插座).  
PHP 附带了一个用于 <var class="filename">.gz-files 的 fopen-wrapperper</var>. 有关详细信息,请参阅有关以下内容的部分 [zlib://.](wrappers.compression.php)


#### SOAP
`https://www.php.net/manual/en/book.soap.php`
SOAP 扩展可用于编写 SOAP 服务器和客户端.它支持<a href="http://www.w3.org/TR/soap11/" class="link external">» SOAP 1.1, <a href="http://www.w3.org/TR/soap12/" class="link external">» SOAP 1.2 和 [»&nbsp;WSDL 1.1 规范的子集](http://www.w3.org/TR/wsdl).&nbsp;</a>&nbsp;</a>  


#### Expect
`https://www.php.net/manual/en/book.expect.php`
此扩展允许通过 PTY 与进程进行交互.你可以考虑使用 <a href="wrappers.expect.php" class="link">`expect://`</a>带有 [文件系统的包装器提供](ref.filesystem.php)更简单、更直观的界面的功能.  


#### XSL
`https://www.php.net/manual/en/book.xsl.php`
XSL 扩展实现了 XSL 标准,使用 <a href="http://xmlsoft.org/XSLT/" class="link external">执行 [&nbsp;](http://www.w3.org/TR/xslt)»&nbsp;XSLT 转换</a>  


#### MySQL (Original)
`https://www.php.net/manual/en/book.mysql.php`
此扩展从 PHP 5.5.0 开始已弃用,并且已从 PHP 7.0.0 开始删除.相反,要么[mysqli](book.mysqli.php) or[PDO_MySQL](ref.pdo-mysql.php)扩展名应该是使用.另请参阅[MySQL API概述](mysqlinfo.api.choosing.php)以获取选择 MySQL API 时的进一步帮助.  
这些功能允许您访问 MySQL 数据库服务器.有关MySQL的更多信息可以在[»&nbsp;http://www.mysql.com/](http://www.mysql.com/)中找到.  
MySQL的文档可以在[»&nbsp;http://dev.mysql.com/doc/找到](http://dev.mysql.com/doc/).  


#### OpenAL
`https://www.php.net/manual/en/book.openal.php`
独立于平台的音频绑定.需要 [»&nbsp;OpenAL 库](https://www.openal.org/).  


#### BC Math
`https://www.php.net/manual/en/book.bc.php`
对于任意精度数学,PHP 提供了 BCMath支持任何大小和精度的数字,最高可达`2147483647`(或`0x7FFFFFFF`)十进制数字,如果有足够的内存,则表示为字符串.  
有效(又称格式正确)BCMath 数字是与正则表达式匹配的字符串`/^[+-]？[0-9]*(\.[0-9]*)？$/`.  
将类型float 的值传递给 BCMath 函数,该函数需要 作为操作数的 字符串可能没有预期的效果,因为 PHP 将<span class="type">float 值转换为 字符串</span>的方式,即 字符串可能是指数表示法(不是 BCMath 支持),并且在 PHP 8.0.0 之前,小数分隔符依赖于区域设置 (而 BCMath 总是期望一个小数点).


#### Gmagick
`https://www.php.net/manual/en/book.gmagick.php`
Gmagick是一个php扩展,用于使用GraphicsMagick API创建,修改和获取图像的元信息.  
GraphicsMagick以图像处理领域的瑞士军刀而自豪.它适用于超过 88 种主要格式包括DPX,GIF,JPEG,JPEG-2000,PNG,PDF,PNM和TIFF等重要格式.  
Gmagick由一个主要的Gmagick类,一个GmagickDraw类组成,它实际上是一个绘图棒和一个GmagickPixel类,其实例表示图像的单个像素(颜色,不透明度).   


#### MS SQL Server (PDO)
`https://www.php.net/manual/en/ref.pdo-dblib.php`
PDO_DBLIB数据源名称 (DSN) 由以下元素组成:  
DSN 前缀是 <strong class="userinput">`sybase:`</strong>如果PDO_DBLIB链接到Sybase ct-lib库,<strong class="userinput">`mssql:`</strong>如果PDO_DBLIB被链接到Microsoft SQL Server 库,或 <strong class="userinput">`dblib:`</strong>ifPDO_DBLIB与FreeTDS库相关联.  
数据库服务器所在的主机名.默认值为 127.0.0.1.  
数据库的名称.  
客户端字符集.  
应用程序名称(在系统进程中使用).默认为"PHP Generic DB-lib"或"PHP freetds".  
当前未使用.  


#### parallel
`https://www.php.net/manual/en/book.parallel.php`
parallel 是 PHP ≥ 7.2.0 的并行并发扩展.  从并行 1.2.0 开始,需要 PHP ≥ 8.0.0.  
以下是对核心到并行概念的简要说明,更详细的信息可以在手册的本节中找到.  
[parallel\Runtime](class.parallel-runtime.php) 表示一个 PHP 解释器线程.一个[parallel\Runtime](https://www.php.net/manual/en/class.parallel-runtime.php) 配置了一个可选的引导程序文件,该文件传递给[parallel\Runtime::__construct()](parallel-runtime.construct.php),这通常是一个自动加载器, 或其他一些预加载例程:在执行任何任务之前,将包含引导程序文件.
构造完成后,[parallel\Runtime](class.parallel-runtime.php) 保持可用,直到它被 PHP 对象的正常作用域规则关闭、杀死或销毁. [parallel\Runtime::run()](parallel-runtime.run.php) 允许程序员安排并行执行的任务. 一个[parallel\Runtime](class.parallel-runtime.php) 有一个FIFO调度,任务将按照它们的调度顺序执行.
parallel 在 [parallel\Runtime](class.parallel-runtime.php) 提供单个函数入口点来执行并行代码 使用自动调度:[parallel\run().](parallel.run.php)
任务只是一个[用于](class.closure.php)并行执行的闭包.[Closure](class.closure.php) 几乎可以包含任何指令,包括嵌套闭包. 但是,任务中禁止使用一些说明: 
屈服
按引用使用
声明类
声明命名函数
嵌套闭包可以生成或使用按引用,但不得包含类或命名函数声明. 
任务可能包含的文件中不禁止任何说明. 


#### Memcached
`https://www.php.net/manual/en/book.memcached.php`
[»&nbsp;memcached](http://www.memcached.org/) 是一个高性能的,分布式内存对象缓存系统,本质上是通用的,但旨在用于通过缓解数据库来加速动态 Web 应用程序负荷.  
此扩展使用 libmemcached 库来提供用于通信的 API使用内存缓存服务器.它还提供了一个<一个 href="ref.session.php" class="link">session</a> 处理程序(`memcached`).  
有关libmemcached的信息可以在[»&nbsp;http://libmemcached.org/libMemcached.html找到](http://libmemcached.org/libMemcached.html).  


#### LuaSandbox
`https://www.php.net/manual/en/book.luasandbox.php`
LuaSandbox 是 PHP 7 和 PHP 8 的扩展,可以安全地允许从 PHP 中运行不受信任的 Lua 5.1 代码.  
与 [Lua 扩展相比的区别](book.lua.php):
LuaSandbox支持时间和内存限制.  
LuaSandbox 为运行不受信任的代码提供了一个默认安全的环境.库存Lua功能进行了安全性审查,并修补了几个因此.  
LuaSandbox有一个PHP界面,它更复杂,更精确,更强大,但对于开发人员来说不太方便.  
LuaSandbox 仅支持 Lua 5.1.很难改变这一点,因为LuaSandbox 使用经过大量修改的 Lua 标准库,并且由于主要Lua版本之间缺乏向后兼容性.LuaSandbox旨在最大限度地提高与用户提供的向后兼容性脚本.  


#### Informix (PDO)
`https://www.php.net/manual/en/ref.pdo-informix.php`
PDO_INFORMIX数据源名称 (DSN) 基于 Informix ODBC DSN  字符串.有关配置 Informix ODBC DSN 的详细信息,请访问  [»&nbsp;Informix 动态服务器信息居中](http://publib.boulder.ibm.com/infocenter/idshelp/v10/index.jsp).PDO_INFORMIX DSN的主要组成部分是:  
DSN 前缀是 <strong class="userinput">`informix:`</strong>.  
DSN 可以是数据源设置,使用<var class="文件名">odbc.ini</var> 或完整的 [»&nbsp;连接字符串](http://publib.boulder.ibm.com/infocenter/idshelp/v10/topic/com.ibm.odbc.doc/odbc66.htm#sii02998361).  


#### OPcache
`https://www.php.net/manual/en/book.opcache.php`
OPcache 通过将预编译脚本字节码存储在共享内存,从而消除了 PHP 加载和解析脚本的需要在每个请求上.  
此扩展与 PHP 5.5.0 及更高版本捆绑在一起,并且[»&nbsp;在 PECL 中可用](https://pecl.php.net/package/ZendOpcache)适用于 PHP 版本 5.2、5.3 和 5.4.  


#### win32service
`https://www.php.net/manual/en/book.win32service.php`
win32service 扩展是特定于 Windows 的扩展,允许 PHP与服务控制管理器通信以启动、停止、注册并注销服务,甚至允许您的 PHP 脚本作为服务.  


#### SimpleXML
`https://www.php.net/manual/en/book.simplexml.php`
SimpleXML扩展提供了一个非常简单且易于使用的扩展用于将 XML 转换为可处理的对象的工具集普通属性选择器和数组迭代器.  


#### Yar
`https://www.php.net/manual/en/book.yar.php`
Yar 是一个 RPC 框架,旨在提供一种简单易行的方法 PHP 应用程序之间的通信 它能够同时调用多个远程服务.  


#### Oracle (PDO)
`https://www.php.net/manual/en/ref.pdo-oci.php`
PDO_OCI数据源名称 (DSN) 由以下元素组成:  
DSN 前缀是 <strong class="userinput">`oci:`</strong>.  


#### Function Handling
`https://www.php.net/manual/en/book.funchand.php`
这些函数都处理工作中涉及的各种操作与函数.  


#### Firebird/InterBase
`https://www.php.net/manual/en/book.ibase.php`
此扩展被视为未维护且已死.但是,源代码此扩展在 <abbr title="PHP Extension and Application Repository">PECL 中仍然可用</abbr><abbr>GIT</abbr> 在这里: [»&nbsp;https://github.com/php/pecl-database-interbase](https://github.com/php/pecl-database-interbase).
Firebird 是一个关系数据库,提供许多 ISO SQL-2003 功能运行在Linux,Windows和各种Unix平台上.火鸟提供出色的并发性、高性能和强大的语言支持存储过程和触发器.它已被用于生产系统,自 1981 年以来以各种名称.  
InterBase 是此 RDBMS 的闭源变体的名称,它由Embarcadero/Inprise开发.有关InterBase的更多信息是可在[»&nbsp;http://www.embarcadero.com/products/interbase.](http://www.embarcadero.com/products/interbase)  
Firebird是一个由C++程序员组成的商业独立项目(基金会),开发和增强多平台的技术顾问和支持基于源代码的关系数据库管理系统InterBase 旗下的 Inprise Corp(现称为 Embarcadero)2000 年 7 月 25 日的公共许可证 v.1.0.更多关于火鸟的信息是可在[»&nbsp;http://www.firebirdsql.org/.](http://www.firebirdsql.org/)  
此扩展已移至[»&nbsp;PECL](https://pecl.php.net/) 存储库,不再与PHP 从 PHP 7.4.0 开始
此扩展支持 InterBase 版本 6 及更高版本和 Firebird 版本 2.0 及更高版本.


#### ODBC and DB2 (PDO)
`https://www.php.net/manual/en/ref.pdo-odbc.php`
PDO_ODBC数据源名称 (DSN) 由以下元素组成:  
DSN 前缀是 <strong class="userinput">`odbc:`</strong>.如果您正在连接  到 ODBC 驱动程序管理器或 DB2 目录中编目的数据库,  可以将数据库的编目名称追加到 DSN.  
在 ODBC 驱动程序管理器中编目的数据库的名称,或DB2 目录.或者,您可以提供完整的 ODBC用于连接到数据库的连接字符串,如中所述[»&nbsp;http://www.connectionstrings.com/.](http://www.connectionstrings.com/)  
连接的用户的名称.如果指定用户名在 DSN 中,PDO 忽略PDO 构造函数.  
连接用户的密码.如果指定DSN中的密码,PDO忽略密码参数的值在 PDO 构造函数中.  


#### Gearman
`https://www.php.net/manual/en/book.gearman.php`
[»&nbsp;Gearman](http://gearman.org) 是一个用于农业的通用应用程序框架将工作输出到多台机器或流程.它允许应用程序并行完成任务,对处理进行负载平衡,并在语言之间调用函数. 框架可以是用于各种应用程序,从高可用性网站到数据库传输复制事件.  
此扩展提供了用于编写 Gearman 客户端和工作线程的类.  


#### Swoole
`https://www.php.net/manual/en/book.swoole.php`
Swoole是一个高性能的网络框架,使用事件驱动的异步非阻塞 I/O 模型.它可用于开发高性能、可扩展、并发TCP,UDP,Unix套接字,HTTP,Websocket服务.要开始使用,请查看[»&nbsp;Swoole Docs](https://www.swoole.co.uk/docs/).  


#### XMLReader
`https://www.php.net/manual/en/book.xmlreader.php`
XMLReader 扩展是一个 XML 拉取分析器.阅读器充当光标在文档流上向前移动并在每个节点处停止在路上.  
需要注意的是,在内部,libxml 使用 UTF-8 编码 因此,检索到的内容的编码将始终在 UTF-8 编码.


#### runkit7
`https://www.php.net/manual/en/book.runkit7.php`


#### Stomp
`https://www.php.net/manual/en/book.stomp.php`
此扩展允许 php 应用程序通过简单的面向对象和过程接口与任何符合 Stomp 的消息代理进行通信.[»&nbsp;Stomp 官方网站](https://stomp.github.io/)  


#### JSON
`https://www.php.net/manual/en/book.json.php`
此扩展实现了 [»&nbsp;JavaScript Object Notation (JSON)](http://www.json.org/)数据交换格式.PHP 带有一个解析器这是专门为 PHP 编写的,并在PHP 许可证.  
PHP 实现了原始文件中指定的 JSON 超集[»&nbsp;RFC 7159](http://www.faqs.org/rfcs/rfc7159).  


#### Yaf
`https://www.php.net/manual/en/book.yaf.php`
`Yet Another Framework` (<abbr>Yaf</abbr>) 扩展是一个用于开发 Web 应用程序的 PHP 框架.  
一个简单的 Yaf 基准可以在 [»&nbsp;Yaf Performance](http://www.laruence.com/2011/12/02/2333.html)中找到.  
有关快速入门指南,请参阅 [教程](yaf.tutorials.php)部分.  


#### Mail
`https://www.php.net/manual/en/book.mail.php`
[mail()](function.mail.php) 函数允许您发送邮件.  


#### Gender
`https://www.php.net/manual/en/book.gender.php`
Gender PHP extension是gender.c程序的一个端口,最初由Joerg Michael编写.主要目的是找出名字的性别.目前的数据库包含来自54个国家的&gt;40000个名字.  


#### Recode
`https://www.php.net/manual/en/book.recode.php`
此模块包含 GNU Recode 库的接口.革奴重新编码库在各种编码字符集之间转换文件,并且表面编码.当无法完全实现时,它可能会摆脱的冒犯字符或依靠近似值.图书馆识别或生成近 150 种不同的字符集,并能够在几乎任何对之间转换文件.最[»&nbsp;RFC 1345](http://www.faqs.org/rfcs/rfc1345) 字符集是支持.  


#### Date/Time
`https://www.php.net/manual/en/book.datetime.php`
[DateTimeImmutable](class.datetimeimmutable.php)和相关类允许你表示日期/时间信息.可以通过传入日期/时间信息的字符串表示,或来自当前系统的时间.  
提供了一组丰富的方法来修改和格式化此信息还包括处理时区和 DST 转换.  
PHP 中的日期/时间功能实现了 ISO 8601 日历,这是一个[»&nbsp;外推格里高利从](https://en.wikipedia.org/wiki/Proleptic_Gregorian_calendar)公历已经到位,还包括年份<</code>code class="literal">0 作为介于两者之间的年份`-1BCE` 和 `1 CE.`不支持闰秒.  
日期和时间信息在内部存储为 64 位数字,因此支持所有可能有用的日期(包括负年份).这范围从过去的大约2920亿年到相同的前途.  


#### pthreads
`https://www.php.net/manual/en/book.pthreads.php`
pthreads 是一个面向对象的 API,它提供了所需的所有工具用于 PHP 中的多线程.PHP 应用程序可以创建、读取、写入、执行并与线程、工作线程和线程对象同步.  
pthreads 扩展不能在 Web 服务器环境中使用. 因此,PHP 中的线程处理仅限于基于 CLI 的应用程序.
pthreads (v3) 只能与 PHP 7.2+ 一起使用:这是由于 ZTS 模式在 7.0 和 7.1 中不安全.
[Threaded](class.threaded.php) 类构成了允许 pthreads 运行的功能.它公开同步方法和一些对程序员有用的接口.  
[Thread](class.thread.php) 类允许线程由只需扩展它并实现一个`run`方法.任何成员可以由任何上下文写入和读取,并引用线.任何上下文也可以执行任何公共和受保护的方法.当[Thread::start()](thread.start.php) 方法的实现是从创建它的上下文中调用.只有创建线程可以启动并加入它.  
[Worker](class.worker.php) 类具有持久状态,并且将可从调用 [Thread::start() (](thread.start.php)an继承的方法),直到对象超出范围或显式shutdown (via [worker::shutdown()](worker.shutdown.php)).任何具有对 worker 对象的引用可以将任务堆叠到 Worker 上(通过[worker::stack()](worker.stack.php)),这些任务将在其中执行由单独的线程中的工人.<代码类="文字">运行</code>方法的worker 对象将在 worker 堆栈上的任何对象之前执行,允许要执行的对象可以初始化的资源需要.  
[Pool](class.pool.php) 类用于创建一组工作线程在它们之间分发[Threaded](class.threaded.php) 对象.是的在 PHP 中使用多个线程的最简单、最有效的方法应用.  
[Pool](class.pool.php) 类不扩展 [Threaded class](class.threaded.php),因此基于池的对象是 被认为是一个普通的PHP对象.因此,它的实例不应该是 在不同上下文中共享.
[Volatile](class.volatile.php) 类是 pthreads v3 的新功能.它被使用表示可变[线程](class.threaded.php)属性[Threaded](class.threaded.php) 类(因为这些类现在不可变默认值).它也用于存储PHP数组[Threaded](class.threaded.php) contexts.  
同步是线程处理时的一项重要功能.所有对象pthreads 创建的在 (这将是Java程序员熟悉)的形式[Threaded::wait()](threaded.wait.php) 和[Threaded::notify().](threaded.notify.php)叫[Threaded::wait()](threaded.wait.php) 在对象上会导致上下文等待另一个上下文调用[Threaded::notify()](threaded.notify.php) 在同一对象上.此机制允许在[Threaded](class.threaded.php)PHP 中的对象.  
任何旨在用于多线程部分的对象应用程序应扩展[Threaded](class.threaded.php).  
数据存储: 根据经验,任何可以序列化的数据类型都可以用作线程对象的成员,可以从任何上下文中读取和写入并引用线程对象. 并非每种类型的数据都是串行存储的,基本类型以其真实形式存储. 复杂类型、数组和非线程对象以串行方式存储;可以使用引用从任何上下文读取和写入线程对象. 除线程对象外,用于设置线程对象成员的任何引用都与线程对象中的引用分开; 任何上下文都可以通过对线程对象的引用随时直接从线程对象读取相同的数据.  
静态成员: 创建新上下文(线程或工作线程)时,通常会复制它们,但具有内部状态的资源和对象将失效(出于安全原因).这允许它们充当一种线程本地存储.例如,在启动上下文时,其静态成员包含数据库服务器的连接信息和连接本身的类将仅复制简单连接信息,而不复制连接.允许新上下文以与创建它的上下文相同的方式启动连接,将连接存储在同一位置,而不会影响原始上下文.  
执行print_r、var_dump和其他对象调试函数时,它们不包括递归保护.  
资源: 在 PHP 中定义资源的扩展和功能完全没有为这种环境做好准备;pthreads 为在上下文之间共享资源做出了规定,但是,对于大多数类型的资源,它应该被视为不安全.在上下文之间共享资源时,应格外小心.
在 pthreads 执行的环境中,为了提供稳定的环境,需要一些限制和限制.


#### Simdjson
`https://www.php.net/manual/en/book.simdjson.php`
通过适用于 PHP 的 simdjson 绑定提供更快的 JSON 解码(单指令,多数据)  


#### Yac
`https://www.php.net/manual/en/book.yac.php`
Yac(Yet Another cache),是一种无锁的共享内存用户数据缓存,可用于替换APC,本地memcache.  


#### LZF
`https://www.php.net/manual/en/book.lzf.php`
LZF 是一种非常快速的压缩算法,非常适合节省空间只有轻微的速度成本.它可以针对速度或空间进行优化编译时间.此扩展使用 [»&nbsp;liblzf](http://oldhome.schmorp.de/marc/liblzf.html)马克·莱曼(Marc Lehmann)的图书馆为其运营.  


#### Memcache
`https://www.php.net/manual/en/book.memcache.php`
Memcache模块提供方便的程序和面向对象的接口到内存缓存,高效的缓存守护进程,特别是旨在减少动态 Web 应用程序中的数据库负载.  
Memcache 模块还提供了一个 <一个 href="ref.session.php" class="link">session 处理程序 (<code class="literal">memcache</a></code>).  
有关memcached的更多信息可以在[»&nbsp;http://www.memcached.org/找到](http://www.memcached.org/).  


#### Output Control
`https://www.php.net/manual/en/book.outcontrol.php`
输出控制功能允许您控制何时输出从脚本发送.这在几个不同的情况,特别是当您需要将标头发送到浏览器时脚本开始输出数据后.输出控件函数不会影响使用<span class="function"><</a></span></a></span>a href="function.header.php" class="function">header() or <span class="function"><a href="function.setcookie.php" class="function">setcookie(),仅诸如 [echo 之类的函数和](function.echo.php)PHP 代码块.  


#### OAuth
`https://www.php.net/manual/en/book.oauth.php`
此扩展提供 OAuth 1.0a 使用者和提供程序绑定.OAuth 是一个建立在HTTP之上的授权协议,允许应用程序安全地访问数据,而无需存储用户名和密码.  


#### SSH2
`https://www.php.net/manual/en/book.ssh2.php`
绑定到 [»&nbsp;libssh2](http://libssh2.org/) 库提供对资源(命令行管理程序、远程执行程序、隧道、文件传输)的访问在使用安全加密传输的远程计算机上.  


#### OCI8
`https://www.php.net/manual/en/book.oci8.php`
这些函数允许您访问 Oracle 数据库.它们支持 SQL 和PL/SQL 语句.基本功能包括事务控制,PHP绑定变量到 Oracle 占位符,并支持大型对象 (LOB) 类型和收藏. Oracle 的可扩展性功能,如数据库驻留还支持连接池 (DRCP) 和结果缓存.  


#### Enchant
`https://www.php.net/manual/en/book.enchant.php`
Enchant 是 PHP 绑定[»&nbsp;附魔库](http://www.abisource.com/projects/enchant/).附魔步骤在所有拼写之上提供统一性和一致性库,并实现某些可能缺少的功能任何单独的提供程序库.一切都应该"正常工作"对于"只是工作"的任何定义.  
Enchant 支持以下后端:
`Aspell/Pspell(打算替换Ispell)`  
`Ispell(古老的罪恶,可以解释为事实上的标准)`  
`MySpell/Hunspell(一个OOo项目,也被Mozilla使用)`  
`Uspell(主要是意第绪语、希伯来语和东欧语言 - 托管在AbiWord的CVS模块"uspell"下)`  
`hspell (希伯来语)`  
`AppleSpell (Mac OSX)`  


#### IBM (PDO)
`https://www.php.net/manual/en/ref.pdo-ibm.php`
PDO_IBM数据源名称 (DSN) 基于 IBM CLI DSN.专业  DSN PDO_IBM的组件包括:  
DSN 前缀是 <strong class="userinput">`ibm:`</strong>.  
DSN 可以是以下任一选项:
a) 使用 <var class="filename">db2cli 设置数据源.ini</var>或<var class="filename">odbc.ini</var>  
b) 编目的数据库名称,即 DB2 客户机中的数据库别名目录  
c) 以下格式的完整连接字符串: <code class="code">DRIVER={IBM DB2 ODBC DRIVER};D ATABASE=`database`;主机名=<代码类="参数">主机名</code>;端口=`端口`;协议=TCPIP;UID=`username`;PWD=`密码`; 其中参数表示以下值: 
数据库的名称. 
数据库服务器的主机名或 IP 地址. 
数据库正在侦听的 TCP/IP 端口  请求. 
用于连接到  数据库. 
用于连接到数据库的密码. 


#### FTP
`https://www.php.net/manual/en/book.ftp.php`
此扩展中的函数实现客户端对文件的访问使用文件中定义的文件传输协议 (FTP) 的服务器[»&nbsp;http://www.faqs.org/rfcs/rfc959.](http://www.faqs.org/rfcs/rfc959) 此扩展名是用于详细访问FTP服务器,提供广泛的范围对执行脚本的控制.如果您只想读取或写入 FTP 服务器上的文件,请考虑使用<a href="wrappers.ftp.php" class="link">`ftp:// wrapper`</a>使用 [文件系统函数](ref.filesystem.php)它提供了一个更简单,更直观的界面.  


#### ImageMagick
`https://www.php.net/manual/en/book.imagick.php`
Imagick 是一个原生的 php 扩展,用于使用ImageMagick API.  
ImageMagick是一个软件套件,用于创建,编辑和撰写位图图像. 它可以读取,转换和写入各种格式的图像(超过100) 包括DPX,EXR,GIF,JPEG,JPEG-2000,PDF,PhotoCD,PNG,Postscript,SVG和TIFF.
ImageMagick Studio LLC是一个非营利组织,致力于免费提供软件成像解决方案.


#### Eio
`https://www.php.net/manual/en/book.eio.php`
此扩展通过 [&nbsp;提供异步 POSIX I/O](http://software.schmorp.de/pkg/libeio.html)图书馆由马克·莱曼撰写.  

从版本 0.3.0 alpha 开始,与 libeio 通信中使用的变量  在内部,可以检索  [eio_get_event_stream().](function.eio-get-event-stream.php)可以使用变量  绑定到某个其他扩展支持的事件循环.你可能会  组织一个简单的事件循环,其中 EIO 和 libevent 一起工作:  


#### DOM
`https://www.php.net/manual/en/book.dom.php`
DOM 扩展允许您通过 DOM 对 XML 文档进行操作带有 PHP 的 API.  


#### Network
`https://www.php.net/manual/en/book.network.php`
提供各种联网功能.  


#### Phar
`https://www.php.net/manual/en/book.phar.php`
phar 扩展提供了一种将整个 PHP 应用程序放入单个文件中的方法称为"phar"(PHP Archive),便于分发和安装.除了提供这项服务外,phar 扩展名还提供文件格式用于通过[PharData class](class.phardata.php), 就像PDO为访问不同的数据库提供了一个统一的界面. 与PDO不同,它不能在不同的数据库之间转换,Phar也可以在tar之间进行转换,带有一行代码的 zip 和 phar 文件格式. 看[Phar::convertToExecutable()](phar.converttoexecutable.php) 举个例子.  


#### Hash
`https://www.php.net/manual/en/book.hash.php`
消息摘要(哈希)引擎. 允许直接或增量处理使用各种哈希算法的任意长度消息.  


#### Igbinary
`https://www.php.net/manual/en/book.igbinary.php`

Igbinary是标准PHP序列化程序的替代品.`igbinary`以紧凑的二进制形式存储PHP数据结构,而不是PHP的`serialize()`所使用的时间和空间消耗的文本表示.当使用memcached、APCu或类似的基于内存的存储来存储序列化数据时,内存节省非常显著。存储需求的典型减少约为50%。确切的百分比取决于数据。


#### PHP Options/Info
`https://www.php.net/manual/en/book.info.php`
这个函数使你能够获得很多关于PHP本身的信息,例如运行时配置、加载的扩展、版本等等.您还将找到为正在运行的 PHP 设置选项的函数.PHP 最著名的函数 - [phpinfo() -](function.phpinfo.php)可以在这里找到.  


#### SQLSRV
`https://www.php.net/manual/en/book.sqlsrv.php`
SQLSRV 扩展允许您访问 Microsoft SQL Server 和 SQL Azure数据库.驱动程序的 3.0 版本支持SQL Server,从 SQL Server 2005 开始,包括 SQL Server 2012 和 SQL服务器 2012 本地数据库.(有关 LocalDB 的更多信息,请参阅[»&nbsp;PHP Driver for SQL Server for LocalDB 支持](http://msdn.microsoft.com/en-us/library/hh487161.aspx)和[»&nbsp;SQL Server 2012 Express LocalDB](http://msdn.microsoft.com/en-us/library/hh510202(SQL.110).aspx).)  
SQLSRV 扩展由 Microsoft 支持,可在此处下载:[»&nbsp;http://msdn.microsoft.com/en-us/sqlserver/ff657782.aspx.](http://msdn.microsoft.com/en-us/sqlserver/ff657782.aspx)SQL Server 2012 LocalDB 可以是下载: [»&nbsp;http://go.microsoft.com/fwlink/？链接 ID=237665](http://go.microsoft.com/fwlink/?LinkID=237665).  


#### CommonMark
`https://www.php.net/manual/en/book.cmark.php`
此扩展提供对 CommonMark 的参考实现的访问,CommonMark 是带有规范的 Markdown 语法的合理化版本.  
CommonMark 扩展提供了一个简单的解析 API: 
CommonMark 扩展提供了支持多种格式的简单渲染 API: 
CommonMark 扩展实现了对 CommonMark\Node 对象的访问:  
CommonMark 扩展提供了一个 CQL(CommonMark 查询语言)的接口: 


#### Arrays
`https://www.php.net/manual/en/book.array.php`
这些功能允许您与数组以各种方式.阵列对于存储至关重要,管理和操作变量集.  
支持简单和多维数组,并且可以用户创建或由其他函数创建.有特定的数据库处理功能用于填充来自数据库查询的数组,以及几个函数返回数组.  
请参阅[Arrays](language.types.array.php)部分,详细说明数组的原理在 PHP 中实现和使用.另请参阅[数组运算符](language.operator.array.php)对于如何操作数组的其他方法.  


#### Filter
`https://www.php.net/manual/en/book.filter.php`
此扩展通过验证或清理数据来筛选数据.这是当数据源包含未知(或外来)数据时特别有用,就像用户提供的输入一样.例如,此数据可能来自 HTML 表单.  
有两种主要类型的筛选:`validation` 和 `sanitization`.  
[Validation](filter.filters.validate.php) 用于验证或检查数据是否符合某些条件.例如传入<strong>`FILTER_VALIDATE_EMAIL`</strong>将确定是否数据是有效的电子邮件地址,但不会更改数据本身.  
[Sanitization](filter.filters.sanitize.php) 将清理数据,因此它可能会通过删除不需要的字符来更改数据.例如,传入<strong>`FILTER_SANITIZE_EMAIL`</strong>将删除不适合电子邮件地址包含的字符.也就是说,它不会验证数据.  
标志可以选择与验证和消毒以根据需要调整行为.


#### cURL
`https://www.php.net/manual/en/book.curl.php`
PHP 支持 libcurl,一个由 Daniel Stenberg 创建的库,它允许您连接和通信到许多不同类型的具有许多不同类型协议的服务器.库库尔目前支持 http、https、ftp、gopher、telnet、dict、file 和LDAP 协议.libcurl 还支持 HTTPS 证书,HTTPPOST,HTTP PUT,FTP 上传(这也可以用PHP完成ftp 扩展名)、基于 HTTP 表单的上传、代理、cookie 和用户+密码身份验证.  


#### SQLite3
`https://www.php.net/manual/en/book.sqlite3.php`
支持 SQLite 版本 3 数据库.  


#### COM
`https://www.php.net/manual/en/book.com.php`
COM 是 `组件对象模型的首字母缩写`;它是一个面向对象层(和相关服务)位于 DCE RPC(开放标准)之上,以及定义一个通用调用约定,该约定支持以任何用于调用和与用任何其他语言编写的代码进行互操作的语言(前提是这些语言是 COM 感知的). 不仅可以代码用任何语言编写,但它甚至不需要是相同语言的一部分可执行;代码可以从 DLL 加载,也可以在另一个 DLL 中找到在同一台计算机上运行的进程,或者使用 DCOM(分布式 COM)的进程在远程计算机上的另一个进程中找到,甚至没有您的代码需要知道组件所在的位置.  
有一个称为 OLE 自动化的 COM 子集,它包含一组允许松散绑定到 COM 对象的 COM 接口,以便它们可以在运行时进行内省和调用,而无需编译时知识对象的工作原理. PHP COM 扩展使用 OLE自动化接口,允许您创建和调用兼容对象从您的脚本中. 从技术上讲,这真的应该被称为"`OLE Automation Extension for PHP"`,因为并非所有 COM 对象都是 OLE相容.  
现在,为什么要或应该使用 COM？ COM是粘合的主要方式之一Windows平台上的应用程序和组件;使用 COM您可以启动微软 Word,填写文档模板并保存结果为 Word 文档,并将其发送给您网站的访问者. 你还可以使用 COM 为您的网络执行管理任务,并配置您的 IIS;这些只是最常见的用途;你可以做很多事情更多与 COM .  
此外,我们还支持实例化和创建使用 COM 互操作性层的 .Net 程序集微软.  


#### RpmInfo
`https://www.php.net/manual/en/book.rpminfo.php`
此扩展名使您能够从 RPM 文件中检索信息或从已安装的 RPM 数据库中.  


#### Bzip2
`https://www.php.net/manual/en/book.bzip2.php`
bzip2 函数用于透明地读取和写入 bzip2 (.bz2)压缩文件.  


#### MySQLi
`https://www.php.net/manual/en/book.mysqli.php`
`mysqli` 扩展允许您访问MySQL 4.1 及更高版本提供的功能.更多信息MySQL 数据库服务器可在以下位置找到[»&nbsp;http://www.mysql.com/](http://www.mysql.com/)  
可以从PHP找到可用于使用MySQL的软件概述at [Overview](mysqli.overview.php)  
MySQL 的文档可以在以下位置找到:[»&nbsp;http://dev.mysql.com/doc/.](http://dev.mysql.com/doc/)  
本文档的部分内容来自 MySQL 手册甲骨文公司的权限.  
示例使用 [»&nbsp;world](http://dev.mysql.com/doc/world-setup/en/index.html)或者[»&nbsp;sakila](http://dev.mysql.com/doc/sakila/en/index.html) 数据库,它们是免费提供.  


#### Inotify
`https://www.php.net/manual/en/book.inotify.php`
inotify 扩展公开了 inotify 函数 [inotify_init()](function.inotify-init.php),<span class="function"><</a></span>a href="function.inotify-add-watch.php" class="function">inotify_add_watch() 和 [inotify_rm_watch().](function.inotify-rm-watch.php)  
由于 C [inotify_init()](function.inotify-init.php) 函数返回文件描述符,PHP 的[inotify_init()](function.inotify-init.php) 返回一个流资源,可用于标准流函数,如<span class="function"><</a></span>a href="function.stream-select.php" class="function">stream_select(), [stream_set_blocking()](function.stream-set-blocking.php)和[fclose().](function.fclose.php)[inotify_read()](function.inotify-read.php) 取代了 C 读取 inotify 的方式事件.  


#### 0MQ messaging
`https://www.php.net/manual/en/book.zmq.php`
"ØMQ是一个软件库,可让您快速设计和实现基于消息的快速应用程序." --0MQ网站  
有关 0MQ 的更多信息,请参阅 [»&nbsp;http://zeromq.org/](http://zeromq.org/).  


#### intl
`https://www.php.net/manual/en/book.intl.php`
国际化扩展(进一步称为 Intl)是一个包装器对于[»&nbsp;ICU](http://www.icu-project.org/)库,使 PHP 程序员能够执行各种区域设置感知操作,包括但不限于格式化、音译、编码转换、日历操作、[»&nbsp;符合 UCA](http://www.unicode.org/reports/tr10/) 的排序规则,定位文本边界和使用区域设置标识符、时区和字素,  
它倾向于紧跟ICU API,以便有经验的人在C / C++或Java中使用ICU可以轻松使用PHP API.此外,这种方式ICU文档将有助于理解各种ICU功能.  
Intl 由几个模块组成,每个模块都公开相应的重症监护室接口:  
[»&nbsp;其他 ICU 文档](http://site.icu-project.org/docs/)
[»&nbsp;ICU 用户指南](https://unicode-org.github.io/icu/userguide/)
[»&nbsp;统一码排序规则算法](http://www.unicode.org/reports/tr10/)


#### Multibyte String
`https://www.php.net/manual/en/book.mbstring.php`
虽然有许多语言,每个必要的字符都可以由一对一映射到 8 位值表示,还有几种语言需要这么多字符才能书写通信,它们不能包含在仅字节的范围内可以编码(一个字节由八个位组成.每个位只能包含两个非重复值,1 或 0.因此,一个字节只能代表256 个唯一值(2 的 8 次方)).多字节字符开发编码方案以表达超过 256 个字符在常规字节编码系统中.  
当您操作(修剪、拆分、拼接等)编码在多字节编码,需要使用特殊函数,因为两个或更多连续字节可以表示此类编码中的单个字符计划.否则,如果应用非多字节感知字符串函数对于字符串,它可能无法检测到 的开头或结尾多字节字符,最终得到一个损坏的垃圾字符串很可能失去了它原来的意义.  
`mbstring` 提供多字节特定的字符串函数帮助您处理 PHP 中的多字节编码.除此之外,`mbstring` 处理字符编码之间的转换可能的编码对.`mbstring` 旨在处理基于 Unicode 的编码,例如 UTF-8 和 UCS-2 以及许多为方便起见,单字节编码(列于 [支持的字符编码](mbstring.supported-encodings.php)).  


#### xdiff
`https://www.php.net/manual/en/book.xdiff.php`
Xdiff扩展使您能够创建和应用包含以下内容的修补程序文件文件的不同修订版本之间的差异.  
此扩展支持两种操作模式 - 字符串和文件,以及作为两种不同的补丁格式 - 统一和二进制.统一的补丁非常好对于文本文件,因为它们是人类可读且易于查看的.对于二进制文件,例如档案或图像,二进制补丁将是足够的选择,因为它们是二进制安全的并且妥善处理不可打印的字符.  
从版本 1.5.0 开始,有两组不同的函数用于生成二进制补丁.新功能 - [xdiff_string_rabdiff()](function.xdiff-string-rabdiff.php) 和[xdiff_file_rabdiff()](function.xdiff-file-rabdiff.php) 生成与旧函数兼容的输出但通常速度更快,产生的结果较小.有关方法的更多详细信息生成二进制补丁以及它们之间的差异,请检查[»&nbsp;libxdiff](http://www.xmailserver.org/xdiff-lib.html) 网站.  
此扩展使用 libxdiff 来实现这些功能.请看[»&nbsp;http://www.xmailserver.org/xdiff-lib.html](http://www.xmailserver.org/xdiff-lib.html) 了解更多信息.  


#### Componere
`https://www.php.net/manual/en/book.componere.php`
Componere <sub class="subscript">(拉丁语,英语:compose)</sub>面向生产环境,并提供一个 API类的组成、猴子修补和选角.  
[Componere\Definition](class.componere-definition.php)用于在运行时定义(或重新定义)类;  然后可以注册该类,并在重新定义的情况下替换原始类  只要 [Componere\Definition](class.componere-definition.php) 存在.  
[Componere\Patch](class.componere-patch.php) 用于在运行时更改对象特定实例的类;  只要 [Componere\Patch 存在,补丁就会一直有效](class.componere-patch.php),并且可以显式恢复.  `Componere`强制转换函数可以在用户定义的兼容类型之间进行转换;  其中兼容意味着`Type`是`object类型的子或超级`.  


#### CUBRID (PDO)
`https://www.php.net/manual/en/ref.pdo-cubrid.php`
PDO_CUBRID数据源名称 (DSN) 由以下元素组成,用分号分隔:  
DSN 前缀是 <strong class="userinput">`cubrid:`</strong>.  
数据库服务器所在的主机名.  
运行数据库服务器的端口.  
数据库的名称.  
当您建立与 CUBRID 的连接时,您应该提供用户名和密码(DSN除外).  


#### ODBC
`https://www.php.net/manual/en/book.uodbc.php`
除了正常的 ODBC 支持外,统一 ODBC 的功能还体现在PHP 允许您访问多个借用ODBC API 的语义,用于实现自己的 API. 而不是维护多个数据库驱动程序,这些驱动程序几乎都相同,这些驱动程序已统一为一组ODBC 函数.  
统一 ODBC 支持以下数据库函数: [»&nbsp;Adabas D](http://www.adabas.com/),[»&nbsp;IBM DB2](http://www-306.ibm.com/software/data/db2/),[»&nbsp;iODBCs](http://www.iodbc.org/),[»&nbsp;实心](http://www.solidtech.com/),和[»&nbsp;Sybase SQL Anywhere](http://www.sybase.com/).  
除 iODBC 外,在以下情况下不涉及 ODBC 连接到上述数据库.您的功能 用来和他们说话只是碰巧分享相同 名称和语法作为 ODBC 函数.但是,构建 PHP 通过 iODBC 支持,您可以使用任何符合 ODBC 标准 带有 PHP 应用程序的驱动程序.更多关于iODBC的信息, 可在 [»&nbsp;www.iodbc.org](http://www.iodbc.org/) 与替代的 unixODBC 可用 [»&nbsp;www.unixodbc.org.](http://www.unixodbc.org/)


#### Mailparse
`https://www.php.net/manual/en/book.mailparse.php`
邮件解析是用于解析和处理电子邮件的扩展.它可以处理[» RFC 822](http://www.faqs.org/rfcs/rfc822) 和 [»&nbsp;RFC 2045 ](http://www.faqs.org/rfcs/rfc2045)&nbsp;(`MIME`)消息.  
Mailparse是基于流的,这意味着它不会保留在内存中它处理的文件的副本 - 因此在以下情况下非常节省资源处理大型消息.  
Mailparse 需要 [mbstring](book.mbstring.php) 扩展名和 MB字符串必须在邮件解析之前加载.


#### GeoIP
`https://www.php.net/manual/en/book.geoip.php`
GeoIP扩展允许您查找IP地址的位置.城市 州、国家、经度、纬度和其他所有信息,例如 ISP和连接类型可以在GeoIP的帮助下获得.  
此扩展不支持MaxMind当前的"GeoIP2"数据库, 只有"GeoIP旧版"数据库文件.


#### Filesystem
`https://www.php.net/manual/en/book.filesystem.php`
构建此扩展不需要外部库,但如果需要PHP 要在 Linux 上支持 LFS(大文件),那么你需要有一个最近的glibc 和你需要使用以下编译器标志编译 PHP:`-D_LARGEFILE_SOURCE -D_FILE_OFFSET_BITS=64`.  


#### WinCache
`https://www.php.net/manual/en/book.wincache.php`
适用于PHP的Windows缓存扩展是一个PHP加速器,用于提高速度在 Windows 和 Windows Server 上运行的 PHP 应用程序.一旦 Windows 缓存扩展PHP 由 PHP 引擎启用和加载,PHP 应用程序可以利用无需任何代码修改的功能.  
Windows 缓存扩展包括 5 种不同类型的缓存.下面介绍每种缓存类型的用途及其提供的好处.  
`PHP 操作码缓存 - PHP` 是一个脚本处理引擎,它读取  包含文本和/或 PHP 指令并生成另一个的输入数据流  数据流,最常见的是 HTML 格式.这意味着在 Web 服务器上  PHP 引擎在每次请求时读取、解析、编译和执行 PHP 脚本  通过 Web 客户端.读取、解析和编译操作给  Web 服务器的 CPU 和文件系统,从而影响 PHP Web 应用程序的整体性能.  PHP 字节码(操作码)缓存用于将编译的脚本字节码存储在共享内存中,因此  PHP引擎可以重用它来执行同一脚本. 
在 `Wincache 2.0.0 中删除了对操作码缓存的支持`,所有用户  希望有一个opcache应该使用[OPcache](book.opcache.php)扩展  包含在 PHP 中. 
`File Cache` - 即使启用了 PHP 操作码缓存,PHP 引擎  必须访问文件系统上的脚本文件.当 PHP 脚本存储在远程  UNC 文件共享中,文件操作引入了显著的性能开销.  适用于 PHP 的 Windows 缓存扩展包括用于存储内容的文件缓存  共享内存中的 PHP 脚本文件,这减少了文件系统操作量  由 PHP 引擎执行. 
`解析文件路径缓存` - PHP 脚本经常包含或操作  使用相对文件路径与文件.每个文件路径都必须规范化为  PHP 引擎的绝对文件路径.当 PHP 应用程序使用许多 PHP 文件并且  通过相对路径访问它们,解析路径的操作可能会产生负面影响  影响应用程序的性能.适用于 PHP 的 Windows 缓存扩展  提供解析文件路径缓存,用于存储相对之间的映射  和绝对文件路径,从而减少了路径分辨率的数量  PHP引擎必须执行. 
`用户缓存(从1.1.0版本开始可用)` - PHP 脚本可以利用  使用用户缓存 API 的共享内存缓存.PHP 对象和变量可以存储在  用户缓存,然后在后续请求中重复使用.这可用于提高 PHP 脚本的性能  并在多个 PHP 进程之间共享数据. 
`Session Handler(自 1.1.0 版起可用)` - WinCache 会话处理程序可用于  将 PHP 会话数据存储在共享内存高速缓存中.这避免了读取的文件系统操作  和写入会话数据,这提高了在 PHP 会话中存储大量数据时的性能. 


#### Xhprof
`https://www.php.net/manual/en/book.xhprof.php`
XHProf 是一个轻量级的分层和基于检测的分析器.在数据收集阶段,它会跟踪呼叫计数并包含程序的动态调用图中弧的指标.它以独占方式计算报告/后处理阶段的指标,例如墙(已用)时间,CPU 时间和内存使用情况.函数配置文件可以按调用方细分或被叫者.XHProf 通过检测在数据收集时间本身调用图,并通过提供独特的递归调用的深度限定名称.  
XHProf 包括一个简单的基于 HTML 的用户界面(用 PHP 编写).基于浏览器用于查看探查器结果的 UI 使查看结果或共享结果变得容易与同行.还支持调用图图像视图.  
XHProf 报告通常有助于理解代码的结构正在执行.报表的分层性质可用于确定,例如,什么调用链导致特定函数被调用.  
XHProf 支持比较两个运行(也称为"差异"报告)或聚合的功能来自多次运行的数据.比较和聚合报告,与单次运行报告非常相似,提供配置文件的"平面"和"分层"视图.  
其他文档可通过[»&nbsp;facebook xhprof](http://web.archive.org/web/20110514095512/http://mirror.facebook.net/facebook/xhprof/doc.html)网站.  


#### XMLWriter
`https://www.php.net/manual/en/book.xmlwriter.php`
这是 XMLWriter 扩展.它包装了libxml xmlWriter API.  
此扩展表示提供非缓存、生成包含 XML 数据的流或文件的只进方式.  
此扩展可用于面向对象的样式或过程一.记录的每个方法都描述了替代过程调用.  


#### URLs
`https://www.php.net/manual/en/book.url.php`
处理 URL 字符串:编码、解码和解析.  


#### GMP
`https://www.php.net/manual/en/book.gmp.php`
大多数 GMP 函数接受 GMP 编号参数.这些都显示在此 文档为 [GMP](class.gmp.php) 对象.最 这些函数还将接受数字和字符串参数,只要 因为可以将后者转换为数字.另外,如果有 可以对参数进行操作的高性能函数(仅限整数), 然后它将被使用(这是透明地完成的).另请参阅 [gmp_init() function.](function.gmp-init.php)
从 PHP 5.6 开始, [arithmetic](language.operator.arithmetic.php), [bitwise](language.operator.bitwise.php),以及 [comparison](language.operator.comparison.php) 运算符 可以与 [GMP](class.gmp.php) 对象返回自 [gmp_init()](function.gmp-init.php) 和其他 GMP 函数.


#### IBM DB2
`https://www.php.net/manual/en/book.ibm-db2.php`
这些函数使您能够访问 IBM DB2 通用数据库,IBM使用 DB2 调用级别接口的 Cloudscape 和 Apache Derby 数据库(DB2 CLI).  


#### APCu
`https://www.php.net/manual/en/book.apcu.php`
APCu 是 PHP 的内存中键值存储.键的类型是字符串,值可以是任何PHP变量.APCu 仅支持变量的用户空间缓存.  
APCu 缓存在 Windows 上是按进程的,因此当使用基于进程的缓存时(而不是基于线程)SAPI,它不会在不同的进程之间共享.  
APCu 是 APC 剥离了操作码缓存.  
第一个APCu代码库的版本是4.0.0,它是从当时APC主分支的头部分叉出来的.PHP 7 支持从 APCu 5.0.0 开始提供.PHP 8 支持从 APCu 5.1.19 开始提供.  


#### FastCGI Process Manager
`https://www.php.net/manual/en/book.fpm.php`
FPM(FastCGI Process Manager)是一个主要的PHP FastCGI实现,包含一些功能(大部分)对重载站点有用.
这个SAPI是与PHP捆绑在一起的.  


#### OpenSSL
`https://www.php.net/manual/en/book.openssl.php`
此扩展绑定了[»&nbsp;用于对称和 OpenSSL](http://www.openssl.org/) 库的函数非对称加解密,PBKDF2、PKCS7、PKCS12、X509等加密操作.除此之外,它还提供TLS的实现流.  
OpenSSL 提供了许多此模块当前不支持的功能.其中一些可能会在将来添加.  


#### PCNTL
`https://www.php.net/manual/en/book.pcntl.php`
PHP 中的进程控制支持实现了 Unix 风格的流程创建、程序执行、信号处理和流程终止.不应在Web 服务器环境和意外结果(如果有)过程控制功能在 Web 服务器环境中使用.  
本文档旨在解释每个过程控制功能.有关详细信息关于Unix进程控制,我们鼓励您咨询您的系统文档,包括fork(2)、waitpid(2)和signal(2)或全面的参考,例如UNIX 环境由 W. Richard Stevens (Addison-Wesley) 设计.  
PCNTL 现在使用即时报价作为信号句柄回调机制,即比以前的机制快得多.此更改遵循相同的内容使用"用户刻度"的语义.你使用 <span class="function"><strong>declare()</strong></span>用于指定程序中回调的位置的语句允许发生.这使您可以最大程度地减少处理开销异步事件.过去,在启用 pcntl 的情况下编译 PHP 会始终会产生此开销,无论您的脚本是否实际使用PCNTL.  


#### Mhash
`https://www.php.net/manual/en/book.mhash.php`
这些函数旨在与[»&nbsp;mhash一起使用](http://mhash.sourceforge.net/).Mhash 可用于创建校验和,消息摘要、消息身份验证代码等.  
这是 mhash 库的接口.Mhash支持广泛的各种哈希算法,如MD5,SHA1,GOST等别人.有关支持的哈希的完整列表,请参阅[constants page.](mhash.constants.php)一般规则是您可以访问来自 PHP 的哈希算法与 <strong>`MHASH_hashname`</strong>.例如,到访问 TIGER 您使用 PHP 常量<strong>`MHASH_TIGER`</strong>.  
此扩展名被 [Hash 淘汰](book.hash.php).
从 PHP 7.0.0 开始,Mhash 扩展已完全集成到 <href="book.hash.php" class="link">Hash 扩展中</a>.因此,它不再是 可以使用 [extension_loaded();](function.extension-loaded.php) 改用[function_exists()](function.function-exists.php) 代替.此外,Mhash不是 更长的报告由 [get_loaded_extensions()](function.get-loaded-extensions.php) 和相关 特征.


#### phpdbg
`https://www.php.net/manual/en/book.phpdbg.php`
作为SAPI模块实现,phpdbg可以完全控制环境,而不会影响代码的功能或性能.  
phpdbg 旨在成为 PHP 的轻量级、功能强大、易于使用的调试平台.它提供以下功能:

  


#### Rnp
`https://www.php.net/manual/en/book.rnp.php`
此模块允许您使用[»&nbsp;RNP](https://www.rnpgp.org/) 库.RNP是OpenPGP的高性能C++Mozilla Thunderbird使用的库.  


#### Tidy
`https://www.php.net/manual/en/book.tidy.php`
Tidy 是 Tidy HTML 清理和修复实用程序的绑定,它允许您不仅清理和以其他方式操作HTML,XHTML,和 XML 文档,但也遍历文档树,包括那些嵌入了脚本语言,如PHP或ASP它们使用面向对象的构造.  


#### Readline
`https://www.php.net/manual/en/book.readline.php`
读取行函数实现一个接口到 GNU Readline 库.这些是提供的功能可编辑的命令行.一个例子是Bash允许你的方式使用箭头键插入字符或滚动浏览命令历史记录.由于它的互动性库,它对编写 Web 应用程序几乎没有用处,但在编写从[command line.](features.commandline.php)  
从 PHP 7.1.0 开始,Windows 支持此扩展.  
读取行扩展不是线程安全的！因此,将其与任何 强烈建议不要使用真正的线程安全SAPI(如Apache mod_winnt).


#### Strings
`https://www.php.net/manual/en/book.strings.php`
这些函数都以各种方式操作字符串.更多可以在正则表达式和[URL 处理](book.url.php)部分.  
有关字符串行为方式的信息,尤其是有关单引号、双引号和转义序列的用法,请参阅[String](language.types.string.php) 条目[Types部分](language.types.php)手动.  


#### Reflection
`https://www.php.net/manual/en/book.reflection.php`
PHP 带有一个完整的反射 API,它增加了内省类、接口、函数、方法和扩展.此外,反射 API 还提供了以下方法:检索函数、类和方法的文档注释.  
请注意,内部的某些部分<缩写title="应用程序编程接口">API</abbr>缺少使用反射扩展所需的代码.例如,内部 PHP 类可能缺少性能.但是,这少数情况被认为是错误,因此它们应该被发现并修复.  


#### WDDX
`https://www.php.net/manual/en/book.wddx.php`
这些函数旨在与[»&nbsp;WDDX 一起使用](http://www.openwddx.org/).  
不要将不受信任的用户输入传递给 [wddx_deserialize().](function.wddx-deserialize.php) 反序列化可能导致代码由于对象而被加载和执行 实例化和自动加载,恶意用户可能能够利用 这.使用安全、标准的数据交换格式,例如 JSON(通过 <span class="function"><</a></span>a href="function.json-decode.php" class="function">json_decode() 和 [json_encode())](function.json-encode.php) if 您需要将序列化数据传递给用户.


#### var_representation
`https://www.php.net/manual/en/book.var_representation.php`


#### Direct IO
`https://www.php.net/manual/en/book.dio.php`
PHP 支持直接 io 函数,如 Posix 中所述标准(第 6 节),用于在较低位置执行 I/O 功能级别比 C 语言流 I/O 函数(`fopen()`, `fread()`,..). 用途的 DIO 函数应仅在直接考虑需要控制设备. 在所有其他情况下,标准[文件系统](book.filesystem.php)函数更多比够用.  


#### Event
`https://www.php.net/manual/en/book.event.php`
这是基于时间和信号高效调度 I/O、时间和信号的扩展使用可用于特定的最佳 I/O 通知机制的事件平台.这是 PHP 基础结构的 libevent 端口.  
请注意,Windows 支持在 中引入 `event-1.9.0` .
版本`1.0.0`引入新的面向对象的API(打破向后兼容性),以及支持libevent 2+,包括HTTP,DNS,OpenSSL和事件侦听器.  
注意 `事件-1.0.0` 和更大与以前的版本不兼容.


#### Random
`https://www.php.net/manual/en/book.random.php`



#### ssdeep
`https://www.php.net/manual/en/book.ssdeep.php`
ssdeep是一个用于创建和比较模糊哈希或[»&nbsp;上下文分段触发哈希](http://dfrws.org/2006/proceedings/12-Kornblum.pdf).  
模糊哈希可以匹配具有"...相同的序列字节顺序相同,尽管字节位于这些序列之间内容和长度可能不同".([»&nbsp;SSDEEP项目页面](http://ssdeep.sourceforge.net))  
此扩展提供了用于创建和比较模糊哈希的函数.  


#### Gettext
`https://www.php.net/manual/en/book.gettext.php`

