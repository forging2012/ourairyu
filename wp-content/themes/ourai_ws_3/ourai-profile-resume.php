				<div class="profile">
					<div id="briefInfo">
						<div id="headline">
							<h1>林垚</h1>
							<p>前端开发工程师</p>
							<dl>
								<dt>所在地</dt>
								<dd class="first">浙江杭州</dd>
								<dt>行业</dt>
								<dd>互联网/电子商务</dd>
								<dt>工作年限</dt>
								<dd class="last"><?php
									$t_date = getdate();
									$t_year = $t_date['year'] - 2010;
									$t_d2c = array( 'd_1' => '一', 'd_2' => '二', 'd_3' => '三', 'd_4' => '四', 'd_5' => '五', 'd_6' => '六', 'd_7' => '七', 'd_8' => '八', 'd_9' => '九', 'd_10' => '十' );
									
									echo $t_d2c['d_' . $t_year];
									
									unset($t_year);
									unset($t_d2c);
								?>年工作经验</dd>
							</dl>
						</div>
						<dl id="overview">
							<dt>毕业院校</dt>
							<dd>沈阳职业技术学院</dd>
							<dt>毕业时间</dt>
							<dd>2010 年 7 月</dd>
							<dt>学历专业</dt>
							<dd>大专/软件</dd>
							<dt>周岁年龄</dt>
							<dd><?php echo $t_date['year'] - 1988; ?></dd>
						</dl>
					</div>
					<h3 class="heading">自我简介</h3>
					<p>林垚，1988 年出生于辽宁省抚顺市。2007 年至 2009 年间在<a href="http://www.vtcsy.com/" title="访问沈阳职业技术学院主页" rel="external nofollow">沈阳职业技术学院</a>（大专）主修软件开发相关技能。2009 年开始至毕业，参加由学院选拔的优秀学生所组成的“校企合作软件开发团队”。目前在浙江省杭州市从事前端开发相关工作。</p>
					<p>亲眼目睹了互联网的蓬勃发展，其所能实现的事情越来越多，随之给人们带来更多的便利和乐趣。觉得这是一个时刻充满朝气、富有挑战的行业，对其充满兴趣和激情，想加入到这个行列中为改变人们的生活方式出一份力。</p>
					<div style="display: none;">
						<p>未毕业时，突然对网页制作产生了兴趣，于是在能够自定义页面模板的名为“<a href="http://www.blogbus.com/" rel="external nofollow" title="访问博客大巴">博客大巴</a>”的博客托管服务平台申请帐号，开始踏入“前端开发”这个领域。</p>
						<p>经过自己不断地探索，了解了“兼容各大主流浏览器”是怎么一回事，也明白了“BOM”及“DOM”之间的区别与联系。前端开发的相关技术掌握到一定程度后，觉得需要熟悉一下后端开发，并且设计方面的一些知识也是不可或缺的。因此，又自学了 PHP 和 MySQL，并不时地到国外的 UI 设计网站欣赏作品。</p>
						<p>目前，互联网正处于蓬勃发展阶段，相关技术在不断快速地升级更新，其所能实现的事情越来越多，随之给人们带来更多的便利和乐趣！我愿意投身到互联网开发事业当中，为改变人们的生活出一份力！</p>
						<p>我相信——<b style="font-size: 1.2em; vertical-align: bottom;">代码可以改变互联网，互联网能够改变世界！</b></p>
					</div>
					<h3 class="heading">工作经历</h3>
					<dl class="overview-list">
						<dt>2011.04 - 2013.01</dt>
						<dd>
							<h4 class="company-post">前端架构及开发</h4>
							<a class="company-name" href="http://www.dbappsecurity.com.cn/" title="访问杭州安恒信息技术有限公司主页" rel="external nofollow">杭州安恒信息技术有限公司</a><small class="company-department">研发中心·扫描器组（Scanner）</small>
							<p class="first">进行“明鉴® WEB 应用弱点扫描器”平台版的代码维护以及新功能开发。将扫描出来的结果按照弱点的等级以及分类等方式用树视图的形式展现出来，并用不同的图标来加以区分；将扫描结果的查询条件用选项卡的形式按类别等进行分隔。经过一系列的页面调整，使操作变得更加流畅，提升了用户体验。</p>
							<p>2011 年 11 月，为了适应互联网的发展，防范各种网络威胁，公司决定开始新产品的开发——<a href="http://www.dbappsecurity.com.cn/products/products15.html" title="访问明鉴®网站安全监测平台的产品介绍页面" rel="external nofollow">明鉴®网站安全监测平台</a>。独自一人承担了原型设计、前端架构及开发等任务。通过与产品经理、UI 设计师及技术负责人的沟通交流，出色地在工期内完成了该产品的开发工作。</p>
							<p><b>在职期间曾被评为“优秀新人员工”，所在团队获得项目奖。</b></p>
						</dd>
						<dt>2010.05 - 2011.02</dt>
						<dd>
							<h4 class="company-post">软件测试、前端开发</h4>
							<span class="company-name">抚顺启运软件开发公司</span>
							<p class="first">刚开始是为自助建站平台（对日）进行功能测试，凭借细心以及严谨的操作逻辑，找到了一些通过正常操作无法发现的 BUG，软件的健壮性、稳定性得到了显著提升。后来转为前端开发，参与到建站平台的开发工作当中，完成了多文本编辑器的内容编辑、部件文本及样式设定等功能模块。</p>
						</dd>
						<dt>2009.08 - 2010.03</dt>
						<dd>
							<h4 class="company-post">客户端应用开发</h4>
							<span class="company-name">沈阳宏芯科技开发公司</span>
							<p class="first">实习阶段，接下开发文件传阅系统的任务。在上级的指导帮助下，根据需求文档对软件进行的设计、开发及测试。遇到技术难题时与其他实习生进行讨论，并从技术论坛上借助前人的经验，最终圆满地完成任务并交工。</p>
						</dd>
					</dl>
					<h3 class="heading">项目经验</h3>
					<dl class="overview-list">
						<dt>2012.02 - <?php echo date('Y.m'); ?></dt>
						<dd>
							<h4>个人网站</h4>
							<div class="project-info">
								<p><b>主要技术：</b>HTML、CSS、CSS3、JavaScript、AJAX、PHP、MySQL、伪静态、客户端平台判断等</p>
								<p><b>开发工具：</b>MyEclipse 8.5</p>
								<p><b>项目简介：</b>也就是本站，由于是个人网站，内容以兴趣爱好、业余生活等为主。页面完全由自己设计，PHP 程序除了 <a href="http://cn.wordpress.org/" title="WordPress 官方网站" rel="external nofollow">WordPress</a> 未使用任何框架。目前本站有文章、相册、文档、宅生活等功能模块。文章模块采用 WordPress 进行管理；相册模块用 PHP 及 AJAX 通过 API 抓取 Flickr 上的图片信息数据；文档模块是遍历指定文件夹获取文件信息；宅生活模块则是通过读取数据库来显示数据。</p>
								<p><b>经验总结：</b>通过拿自己的网站当作实验田，PHP 与 MySQL 的技能知识得到提高，明白了如何从整体考虑去架构一个网站，以及一些需要注意的安全性问题。</p>
							</div>
						</dd>
						<dt>2011.11 - 2013.01</dt>
						<dd>
							<h4>明鉴®网站安全监测平台</h4>
							<div class="project-info">
								<p><b>主要技术：</b>HTML、CSS、CSS3、JavaScript、AJAX 等</p>
								<p><b>开发工具：</b>MyEclipse 8.5</p>
								<p><b>项目简介：</b>该平台是一套软、硬件一体化监测平台，是明鉴® WEB 应用弱点扫描器平台版的升级版本。采用远程监测技术对 Web 应用提供 7×24 小时实时安全监测服务。具有 Web 漏洞、网页木马、网页篡改、网站可用性及网页关键字等监测模块。用户通过 Web 页面进行新建、修改任务等操作，将数据传到服务器端之后，再将指令下发到底层引擎，从而进行对指定网站的周期性检测。</p>
								<p><b>经验总结：</b>此项目初期，独自承担了原型设计、前端架构及开发等任务，对开发流程的各个环节有更深入地了解和体会；在与产品经理、UI 设计师及技术负责人沟通时，锻炼提高了与不同岗位的人之间的交流能力。后期当互联网版本正式投入使用时，通过解决在网络环境下出现的各种各样的问题，增强了应对意外情况的处理能力；在对前端的性能及代码进行优化、重构的过程中，提升了对架构的把握能力。</p>
							</div>
						</dd>
						<dt>2011.04 - 2011.10</dt>
						<dd>
							<h4>明鉴® WEB 应用弱点扫描器平台版</h4>
							<div class="project-info">
								<p><b>主要技术：</b>HTML、CSS、JavaScript、AJAX 等</p>
								<p><b>开发工具：</b>MyEclipse 6</p>
								<p><b>项目简介：</b>本系统提供了 Web 漏洞、网页木马及网页篡改等弱点扫描模块，使用户能够全方位地实时检测网站的安全情况。扫描结果中会展示出弱点名称、等级、分类等信息，还有详细的修复建议帮助用户避免再次出现相同漏洞。网站地址可以选择所属行业及分类等，用户可以更加快速地管理及查找网站地址。</p>
								<p><b>经验总结：</b>独自一个人负责前端的开发，锻炼了与后端开发人员的团队协作能力。通过对项目功能的维护及开发，在网络信息安全方面有了一些了解，AJAX 技术的运用变得更加灵活自如。</p>
							</div>
						</dd>
						<dt>2010.05 - 2011.02</dt>
						<dd>
							<h4>自助建站平台</h4>
							<div class="project-info">
								<p><b>主要技术：</b>HTML、CSS、JavaScript、AJAX 等</p>
								<p><b>开发工具：</b>Visual Studio 2008</p>
								<p><b>项目简介：</b>通过本平台，用户可以不用自己写 HTML 以及 CSS 等就能构造属于自己的网站或者网店。为用户提供了多种多样的模块供其拼凑网页页面，还有很多特色素材和模版供其下载。在本平台中，用户可以自由拖拽网页和模块的位置，操作极其方便快捷，是非技术人员自己建站的利器。</p>
								<p><b>经验总结：</b>初步体会到了团队协作开发的氛围。HTML、CSS 编码能力得到了巩固加强，对 JavaScript 编程有了些自己的理解。</p>
							</div>
						</dd>
						<dt>2009.08 - 2010.03</dt>
						<dd>
							<h4>文件传阅系统</h4>
							<div class="project-info">
								<p><b>主要技术：</b>C++、MFC、SQL Server 2000 等</p>
								<p><b>开发工具：</b>Microsoft Visual 6.0</p>
								<p><b>项目简介：</b>该系统可以将文件原文转换成图片并通过软件服务端将相关信息上传到数据库中。还能够将 WORD 文档通过服务端上传到数据库中。每当数据库中添加新的文件时，各个客户端都会弹出消息提示通知有新文件。服务端用户可以对数据库信息进行增加、修改、删除等操作；而客户端用户只可以浏览查阅文件以及下载 WORD 文档；管理员则可以将文件进行分类。</p>
								<p><b>经验总结：</b>第一次体会到了真正的软件开发是什么样子，锻炼了靠自己想办法解决疑难问题的能力。稍微了解 Windows 应用开发的一些机制。</p>
							</div>
						</dd>
					</dl>
					<table id="experiences">
						<colgroup>
							<col style="width: 120px;">
							<col style="">
						</colgroup>
						<thead>
							<tr>
								<th>项目类型</th>
								<th>项目介绍</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th rowspan="2">工作项目</th>
								<td style="border-bottom-style: dashed;">
									<dl>
										<dt><b class="project-name">自助建站平台</b></dt>
										<dd>
											<div><span class="project-period">2010.05 - 2011.03</span><span class="company">抚顺正佳科技有限公司</span></div>
											<p>该项目是面向日本用户的系统。本系统为用户提供了多种多样的模块，可以自由拖拽使其拼凑成网页；还有很多素材和模版供用户下载。使用本系统，不懂网页制作的人也能够轻松打造属于自己的网站或者网店！</p>
											<p>在此项目中，我主要负责写与用户交互部分的 JavaScript 脚本程序，有时也写 HTML 和 CSS。</p>
										</dd>
									</dl>
								</td>
							</tr>
							<tr>
								<td style="border-top-style: dashed;">
									<dl>
										<dt><b class="project-name">明鉴网站安全监测平台</b></dt>
										<dd>
											<div><span class="project-period">2011.04 - 现在</span><span class="company">杭州安恒信息技术有限公司</span></div>
											<p>该产品是一套软硬件一体化监测平台，采用远程监测技术对WEB应用提供 7×24 小时实时安全监测服务。通过对网站的不间断监测服务从而提升网站的安全防护能力和网站服务质量，并通过安全监测平台的事件跟踪功能建立起一种长效的安全保障机制。（详情请参看<a href="http://www.dbappsecurity.com.cn/products/products15.html" rel="external nofollow" title="查看该产品">产品页面</a>）</p>
											<p>在此项目中，负责产品的前端架构及优化，页面制作，交互及数据处理的 JavaScript 脚本程序编写。</p>
										</dd>
									</dl>
								</td>
							</tr>
							<tr>
								<th>个人项目</th>
								<td>
									<dl>
										<dt><b class="project-name">宅男的部屋</b></dt>
										<dd>
											<div><span class="project-period">2012.03 - 现在</span></div>
											<p>也就是本站啦……作为我的生活的缩影展示在网络上。</p>
											<p>网站除了文章部分是利用 WordPress 来进行管理之外，其他部分未使用任何框架，皆为自己通过 PHP 来进行编写处理。为了使其开发起来更加方便，运行起来更加稳定快速，目前正在重新思考整体架构。</p>
										</dd>
									</dl>
								</td>
							</tr>
						</tbody>
					</table>
					<ul>
						<li></li>
					</ul>
					<h3 class="heading">专业技能</h3>
					<table class="overview-table">
						<colgroup>
							<col style="width: 11em;">
							<col style="">
						</colgroup>
						<thead>
							<tr>
								<th>技能名称</th>
								<th>掌握程度</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>HTML/XHTML</th>
								<td>
									<ol class="n-rst">
										<li>结构、表现与操作三者分离</li>
										<li>规范、语义化，符合 W3C 标准</li>
										<li>不滥用 id 及 class 属性，严格控制自定义属性</li>
									</ol>
								</td>
							</tr>
							<tr>
								<th>CSS/CSS3</th>
								<td>
									<ol class="n-rst">
										<li>兼容各主流浏览器，较少使用 CSS hack</li>
										<li>充分理解选择器优先级</li>
										<li>合理运用 id、class 及标签等</li>
									</ol>
								</td>
							</tr>
							<tr>
								<th>JavaScript</th>
								<td>
									<ol class="n-rst">
										<li>熟练使用 jQuery，写过表单验证、数据表格等插件</li>
										<li>面向对象编程</li>
										<li>代码模式及规范</li>
										<li>具备丰富的 AJAX 开发经验</li>
									</ol>
								</td>
							</tr>
							<tr>
								<th>XML</th>
								<td>用 XML 结合 XSL 及 XPath 写过页面</td>
							</tr>
							<tr>
								<th>PHP</th>
								<td rowspan="2">能够进行简单的开发和数据增删改操作</td>
							</tr>
							<tr>
								<th>MySQL</th>
							</tr>
						</tbody>
					</table>
					<h3 class="heading">语言能力</h3>
					<table class="overview-table">
						<colgroup>
							<col style="width: 11em;">
							<col style="">
						</colgroup>
						<thead>
							<tr>
								<th>语言种类</th>
								<th>考级经历</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>英语</th>
								<td><span style="display: none;">读写能力良好，听说能力一般，能够看懂英语技术文档。</span>
									<ol class="n-rst">
										<li>2008 年 6 月，通过<a href="http://www.pretco.com.cn/" title="访问高等学校英语应用能力考试官网" rel="external nofollow">高等学校英语应用能力考试</a> A 级（PRETCO-A）考试</li>
										<li>2007 年 12 月，通过高等学校英语应用能力考试 B 级（PRETCO-B）考试</li>
									</ol>
								</td>
							</tr>
							<tr>
								<th>日语</th>
								<td><span style="display: none;">读写能力良好，听说能力良好，能够看懂日语文章并可与日本人交流。</span>2012 年 12 月，参加<a href="http://www.jlpt.jp/" title="访问日本语能力考试官网" rel="external nofollow">日本语能力考试</a>一级（JLPT N1）考试</td>
							</tr>
						</tbody>
					</table>
					<h3 class="heading">兴趣爱好</h3>
					<p>兴趣广泛，除了专业相关技术之外，喜欢听音乐、看电影、玩游戏、旅游、骑行、读书、语言及文化研究等。</p>
					<h3 class="heading">自我评价</h3>
					<p>责任心很强，具备团队精神，能够积极主动与团队其他成员沟通交流，保质保量完成任务；好奇心旺盛，学习能力强，可通过自学理论知识及反复练习实践的方式掌握想要了解的技能；热爱网络开发技术，喜欢挑战新鲜事物，愿意与同行进行技术上的分享交流。</p>
				</div>
