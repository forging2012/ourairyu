<?php

/*
	@Title: 字符实体引用列表
	@Description: 统计动画收藏情况
	@Privacy: public
*/

global $oc_siteinfo;
global $oc_project;
global $oc_res;

$oc_siteinfo['title'] = '字符实体引用列表';
$oc_siteinfo['keywords'] = 'HTML, XML, character, entity, 字符, 实体, 引用, 参考, reference';
$oc_siteinfo['desc'] = '汇集了很多 HTML 和 XML 中的字符实体';

$oc_res['css'] = array( $oc_project->mainSite . 'docs/res/css/view.css' );

function template_doc_catalog() { ?>
			<a href="javascript:void(0);" class="catalog_title">实体类别</a>
			<ul id="entity_catalog" class="catalog_section"></ul>
<?php
}

function template_doc_content() { ?>
			<!-- <h1 class="doc_title"><span class="fr"><?php echo $oc_siteinfo['title']; ?></span></h1> -->
			<dl class="statement">
				<dt><strong>使用方式</strong></dt>
				<dd>
					<ul class="n-rst">
						<li><strong>HTML/XHTML</strong>——<code>&#&lt;entity_num&gt;;</code>或<code>&#&lt;entity_name&gt;;</code>，建议用<code>entity_num</code>来获取！</li>
						<li><strong>CSS</strong>——<code>\&lt;entity_num&gt;</code>，注意：是<code>\</code>，而不是<code>\u</code>！</li>
						<li><strong>JavaScript</strong>——<code>"\u&lt;HEX&gt;"</code>或<code>String.fromCharCode(&lt;entity_num&gt;)</code>，<code>HEX</code>是<code>entity_name</code>的十六进制形式。</li>
					</ul>
				</dd>
			</dl>
			<?php
				require_once( OC_APATH_CMN . 'class/class-database.php' );
				
				$db = new CLS_Database;
				$db->select_db(OC_DEV_MODE === 'release' ? 'ourai_misc' : 'ourai');
				$result = $db->query("SELECT * FROM `ourai_character_entities` ORDER BY `ENTITY_NUM` ASC");
				$entitySet = array();
				
				foreach( $result as $r ) {
					$entityCate = $r['entityCate'];
					
					if ( empty($entitySet[$entityCate]) ) {
						$entitySet[$entityCate] = array();
					}
					
					if ( empty($entitySet[$entityCate]['entitySet']) ) {
						$entitySet[$entityCate]['entitySet'] = array();
					}
					
					$entitySet[$entityCate]['entityCategory'] = $entityCate;
					$entitySet[$entityCate]['entityCategoryZh'] = $r['entityCateZh'];
					array_push($entitySet[$entityCate]['entitySet'], $r);
				}
				
				foreach( $entitySet as $entities ) {
					$cat = $entities['entityCategory'];
			?>
			<h2 id="Entity_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', $cat); ?>" class="n-rst" data-entity-category="<?php echo $cat; ?>" data-entity-category-zh="<?php echo $entities['entityCategoryZh']; ?>" data-entity-count="<?php echo count($entities['entitySet']) ?>"><span class="symbol">&#182;</span> <?php echo $cat; ?></h2>
			<div class="view-wrapper">
				<table class="view-list">
					<colgroup>
						<col style="width: 50px;">
						<col style="width: 70px;">
						<col style="width: 70px;">
						<col style="width: 70px;">
						<col>
					</colgroup>
					<thead>
						<tr>
							<th>显示</th>
							<th>名称</th>
							<th>编号</th>
							<th>HEX</th>
							<th>描述</th>
						</tr>
					</thead>
					<tbody><?php
						foreach( $entities['entitySet'] as $entity ) {
							$num = $entity['entityNum']; ?>
						<tr style="font-family: Verdana;">
							<td style="text-align: center; font-family: Serif;">&#<?php echo $num; ?>;</td>
							<td style="font-family: Georgia;"><?php echo $entity['entityName']; ?></td>
							<td><?php echo $num; ?></td>
							<td><?php echo str_pad(strtoupper(base_convert($num, 10, 16)), 4, "0", STR_PAD_LEFT); ?></td>
							<td style="font-family: Georgia, Serif;"><?php echo empty($entity['entityDescZh']) ? $entity['entityDesc'] : '<span style="font-family: SimSum, Serif;">' . $entity['entityDescZh'] . '</span>'; ?></td>
						</tr><?php } ?>
					</tbody>
				</table>
			</div><?php } ?>
			<script>
				var headers = document.getElementById("content").getElementsByTagName("h2"),
					contents = document.getElementById("entity_catalog"),
					item, header, idx = 0;
				
				for ( ; idx < headers.length; idx++ ) {
					header = headers[idx];
					item = document.createElement("li");
					item.innerHTML = "&ndash; <a href=\"#" + header.id + "\" title=\"" + header.getAttribute("data-entity-category") + "\">" + header.getAttribute("data-entity-category-zh") + "</a> (" + header.getAttribute("data-entity-count") + ")";
					contents.appendChild( item );
				}
			</script>
<?php
}

$oc_project->theme_layout(OC_THEME_DOC); ?>