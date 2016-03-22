<?php

global $oc_project;
global $oc_siteinfo;

$request = $oc_project->pathname;

if ( empty($request) ) {
	$request .= '/';
}

$dirTitle = 'Index of /' . $request;
$dirTitle = substr($dirTitle, 0, strlen($dirTitle) - 1);
$oc_siteinfo['title'] = $dirTitle;

$oc_project->xhtml_header(); ?>
	<div id="main">
		<div id="content">
			<h1 class="index-title"><?php echo $dirTitle; ?></h1>
			<div class="view-wrapper">
				<table class="view-list">
					<colgroup>
						<col style="width: 40px;" />
						<col />
						<col style="width: 150px;" />
						<col style="width: 80px;" />
						<col style="width: 240px;" />
					</colgroup>
					<thead>
						<tr>
							<th></th>
							<th class="txt-l">Name</th>
							<th class="txt-r">Last modified</th>
							<th class="txt-r">Size</th>
							<th class="txt-l">Description</th>
						</tr>
					</thead>
					<tbody>
						<?php echo $oc_project->traverse_dir($oc_project->page['path']); ?>
					</tbody>
				</table>
				<script type="text/javascript">
					var rows = document.getElementsByTagName("table")[0].getElementsByTagName("tbody")[0] .getElementsByTagName("tr");
					rows[0].setAttribute("class", "first");
					rows[rows.length - 1].setAttribute("class", "last");
				</script>
			</div>
		</div>
		<div id="overlay">遮罩层</div>
	</div><?php
$oc_project->xhtml_footer();

?>