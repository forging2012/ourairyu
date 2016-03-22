<?php

/*
	@Title: 帐号注册向导
	@Description: 
	@Privacy: public
*/

global $oc_project;
global $oc_siteinfo;

$oc_siteinfo['title'] = '帐号注册向导';

function template_doc_catalog() { ?>
		<a class="catalog_title" href="javascript:void(0);">目录</a>
		<ul class="catalog_section"></ul>
<?php
}

function template_doc_content() {
	global $oc_project;

	$t_root = $oc_project->root;
	$t_dir_img = $t_root . 'guide/image/';
?>
		<style>
			#content p { text-indent: 0; }
			#content img { padding: 5px; border: 1px solid #CCC; background-color: #FFF; }
		</style>
		<h2 id="Account_Register" class="n-rst"><span class="symbol">&#9798;</span> 注册帐号</h2>
		<div class="view-wrapper">
			<p>访问 <a href="<?php echo $t_root; ?>wp-admin/"><?php echo $t_root; ?>wp-admin/</a>，点击登录框下面的【注册】。</p>
			<p><img src="<?php echo $t_dir_img; ?>step_1.1.jpg"></p>
			<p>输入要注册的用户名及电子邮箱。帐号暂时仅支持字母和数字，以后会进行升级！<br>经测试，<a href="http://live.com" title="进入 Hotmail 邮箱" target="_blank">Hotmail</a>、<a href="http://gmail.com/" title="进入 Gmail 邮箱" target="_blank">Gmail</a>、<a href="http://mail.163.com/" title="进入网易邮箱" target="_blank">网易邮箱</a>及 <a href="http://mail.qq.com/" title="进入 QQ 邮箱" target="_blank">QQ 邮箱</a>都能够正常注册。</p>
			<p><img src="<?php echo $t_dir_img; ?>step_1.2.jpg"></p>
			<p>若用户名及电子邮箱都未被人注册过的话，系统将发送一封激活帐号用的电子邮件。</p>
			<p><img src="<?php echo $t_dir_img; ?>step_1.3.jpg"></p>
		</div>
		<h2 id="Account_Activate" class="n-rst"><span class="symbol">&#9798;</span> 激活帐号</h2>
		<div class="view-wrapper">
			<p>登录电子邮箱，查看系统发送的邮件。如果在【收件箱】中未找到的话请到【垃圾邮件】中查看。</p>
			<p><img src="<?php echo $t_dir_img; ?>step_2.1.jpg"></p>
			<p>点击电子邮件中的链接进行帐号激活操作。如果链接不能够直接点击，请复制并粘贴到浏览器地址栏中后访问。</p>
			<p><img src="<?php echo $t_dir_img; ?>step_2.2.jpg"></p>
			<p>激活成功的话将出现下图中的提示，并且系统会发送一封包含用户名及密码的电子邮件。</p>
			<p><img src="<?php echo $t_dir_img; ?>step_2.3.jpg"><br><img src="<?php echo $t_dir_img; ?>step_2.4.jpg"></p>
		</div>
		<h2 id="Account_Login" class="n-rst"><span class="symbol">&#9798;</span> 登录系统</h2>
		<div class="view-wrapper">
			<p>点击电子邮件中的链接或访问 <a href="<?php echo $t_root; ?>wp-admin/"><?php echo $t_root; ?>wp-admin/</a> 进入系统登录页面。</p>
			<p><img src="<?php echo $t_dir_img; ?>step_3.1.jpg"></p>
			<p>输入正确的用户名和密码之后就可以进入系统了。</p>
			<p><img src="<?php echo $t_dir_img; ?>step_3.2.jpg"></p>
		</div>
		<script>
			var toc = document.getElementById("catalog").getElementsByTagName("ul")[0],
				headers = document.getElementById("content").getElementsByTagName("h2"),
				fragment = document.createDocumentFragment(),
				header, item, link, text;
				
			for ( var i=0; i<headers.length; i++ ) {
				header = headers[i];
				item = document.createElement("li");
				text = header.innerHTML.match(/span\>\x20(.+)/i)[1];
								
				item.innerHTML = "– " + "<a href=\"#" + header.id + "\" title=\"" + text + "\">" + text + "</a>";
				fragment.appendChild(item);
			}
			
			toc.appendChild(fragment);
		</script>
<?php
}

$oc_project->theme_layout(OC_THEME_DOC); ?>