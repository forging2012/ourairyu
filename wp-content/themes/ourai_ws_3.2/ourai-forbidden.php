		<style>
			.abs-ctr { max-width: 800px; margin: 0 auto; }
			table { background-color: #FFF; font-size: 1.2em; table-layout: fixed; }
			table th, table td { border: 1px solid #BBB; }
			table tbody th { background-color: #DEDEDE; }
			table tfoot td { font-size: 13px; font-style: italic; font-family: Georgia, Serif; background-color: #F5F5F5; }
			td b { color: #F00; }
			caption { margin-bottom: 10px; }
		</style>
		<div class="abs-ctr">
			<div class="abs-ctr-wrp">
				<table class="abs-ctr-cnt">
					<caption><h2>环境检测结果</h2></caption>
					<colgroup>
						<col style="width: 150px;">
						<col>
					</colgroup>
					<tfoot>
						<tr>
							<td class="txt-r" colspan="2">注：为了访问者的网络安全以及获得更好的浏览体验，本站不支持 IE8 以下浏览器。<br>请升级浏览器或者更换为 Firefox、Chrome 等浏览器，谢谢配合！</td>
						</tr>
					</tfoot>
					<tbody>
						<tr>
							<th class="txt-r">操作系统</th>
							<td><?php echo $oc_env['os']['type']; ?></td>
						</tr>
						<tr>
							<th class="txt-r">浏览器</th>
							<td><b><?php echo $oc_env['browser']['type'] . ' ' . $oc_env['browser']['version']; ?></b></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>