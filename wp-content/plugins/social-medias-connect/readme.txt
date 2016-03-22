=== Social Medias Connect ===
Contributors: QiQiBoY
Donate link: http://www.qiqiboy.com
Tags: wordpress, weibo, 新浪微博, 腾讯微博, 微博连接, socila medias connect
Requires at least: 3.0
Tested up to: 3.1
Stable Tag: 1.5.10

提供wordpress与其它社交媒体(Social Medias)网站的账号绑定、连接登陆及文章同步、评论同步转发功能。

== Description ==

<p>支持微博账号与网站已有账号的绑定。</p>
<p>提供wordpress与其它社交媒体网站的连接登陆及文章同步、评论同步转发功能。</p>
<p>支持Twitter、新浪微博、腾讯微博、搜狐微博、网易微博、豆瓣、饭否、Follow5的连接登陆、文章同步、评论转发到微博等功能</p>
<p>评论同步到微博不同于之前同类型的任何插件，本插件会将评论以转发+评论的形式发布到微博。你一定会问，转发+评论的是哪条微博呢？正是你发布文章时发布到微博的那条文章更新微博！！</p>
<p>效果预览：<a href="http://www.qiqiboy.com/products/plugins/social-medias-connect#respond">http://www.qiqiboy.com/products/plugins/social-medias-connect#respond</a></p>
<p>欢迎在新浪微博收听我：<a href="http://weibo.com/qiqiboy">@qiqiboy</a></p>

<p>V1.5功能
1.新增微博账户与网站账户的绑定。
2.新增饭否、follow5支持。
</p>

== Installation ==

1. Download the plugin archive and expand it (you've likely already done this).
2. Put the 'Social Medias Connect' directory into your wp-content/plugins/ directory.
3. Go to the Plugins page in your WordPress Administration area and click 'Activate' for Social Medias Connect.
4. Go to the 'Social Medias Connect' Options page (Settings > Social Medias Connect Option).
5. Go to widgets page to add the widget to your sidebar.

下载插件，上传到插件目录，在后台管理中激活插件，到设置页面进行简单设置即可。<br>

== Screenshots ==

1. 自动插入到评论区域的微博连接登陆入口效果
2. 自动插入到博客登陆界面的的微博连接登陆入口效果
3. 浮动窗口显示绑定按钮效果
4. 后台管理界面截图

== Frequently Asked Questions ==

FAQ请参见<a href="http://www.qiqiboy.com/products/plugins/social-medias-connect">http://www.qiqiboy.com/products/plugins/social-medias-connect</a>

== Changelog ==
= 1.5.10 =
修复css文件引入造成的html验证失败问题，增加自定义登陆按钮提示文字。
= 1.5.9 =
新增设置是否记住微博连接用户的登陆状态，改善前台js浮动框的登陆图标显示。新增微博通(weiboto.com)的连接登陆。
= 1.5.8 =
新增支持使用做啥账号连接登陆、文章同步。
= 1.5.7 =
紧急修复腾讯微博授权时404错误，修复我的微博@ 用户名匹配
= 1.5.6 =
优化图片加载流程，增加微博地址的调用%%url%%，优化头像的获取，显示转发微博增加搜狐、163、饭否的支持
= 1.5.5 =
我的微薄新增被转发微博的显示，widget小工具优化。
= 1.5.4 =
我的微博新增微博来源，图片新增lightbox效果，修复我的微薄中twitter的错误。
= 1.5.3 =
我的微博新增自定义显示格式功能。
= 1.5.2 =
增加卸载页面；新增评论中的表情转换为相应的微博表情（暂时支持新浪和腾讯微博）;修复follow5标签同步bug；新增帮助页面邮件支持。
= 1.5.1 =
新增饭否连接登陆及账号绑定。
= 1.5 =
新增Follow5连接登陆及账号绑定。
= 1.4.9 =
我的最新微博增加缓存，防止api接口调用次数过多。
= 1.4.8 =
修复twitter的一处授权问题，修复评论同步的cookie删除问题。
= 1.4.7 =
完善1.4.6的注册逻辑。
= 1.4.6 =
优化微博用户注册流程，加入用户名冲突后的自定义用户名功能。
= 1.4.5 =
设置面板的调整，新增微博账号的绑定，支持级别用户。
= 1.4.4 =
注册过程优化，评论同步增加cookie记录，增强用户体验。
= 1.4.3 =
新增加了可选短网址服务商。
= 1.4.1 =
重写了http方法，支持更多主机
= 1.4.1 =
1.新增自定义同步格式，支持文章同步和评论同步的格式自定义。
2.新增同步标签、同步摘要。 
3.更精确的文字截取，准确截取twitter和国内新浪微博的发布字数。
= 1.3.5 =
修复安装多个最新微薄小工具时的错误问题
= 1.3.4 =
1.增加多微薄按钮放置，不会起冲突。
2.添加边栏“我的微博”，“微博登陆”等小工具。
= 1.3.3 =
修复短连接时锚点引起的一个问题
= 1.3.2 =
修复豆瓣同步的错误
= 1.3.1 =
增加开启/关闭缩略图同步功能
2011/04/21
= 1.3 =
2011/04/21
1.新增连接登陆新增twitter服务。默认关闭。请确认你的主机身在“墙外”再启用twitter连接、同步功能。
2.同步文章新增同步文章缩略图到微博功能。如果没有给文章设置缩略图，那么程序会自动抓取文章中第一张图片
3.增加文字截断功能。不用再担心文字过多同步失败了。
4.新增使用短网址api功能。
= 1.2 =
2011/04/16
更新默认更新状态，草稿、私密等文章不同步，编辑早期的文章也默认不同步。如果要同步，可以选中 同步 状态按钮。
增加文章同步状态说明。位置在文章编辑页面->下面的“同步文章更新状态”一栏。
= 1.0 =
2011/04/15
插件开发完毕，上线。
== Upgrade Notice ==
暂无.