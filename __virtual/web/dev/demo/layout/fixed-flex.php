<?php

/*
	@Title: 局部自适应
	@Description: 一部分固定一部分自适应的布局
	@Privacy: public
*/

global $oc_project;
global $oc_siteinfo;
global $oc_setting;

$oc_siteinfo['title'] = '局部自适应';
$oc_setting['limit_ie'] = false;

$oc_project->html_header(); ?>
		<style>
			html, body { min-width: 0; min-height: 0; }
			#consoleArea { height: 50px; background-color: #DDD; }
			#layoutArea div { background-color: lime; }

			.fixed { position: absolute; z-index: 1; top: 50px; bottom: 0; width: 250px; background-color: orange !important; }
			.fixed_left { left: 0; }
			.fixed_right { right: 0; }
		</style>
		<div id="consoleArea">
			<button data-direction="left">左边固定</button>
			<button data-direction="right">右边固定</button>
			<button data-direction="both">两边固定</button>
		</div>
		<div id="layoutArea">
			<div data-direction="left">left</div>
			<div id="flexArea">middle</div>
			<div data-direction="right">right</div>
		</div>
		<script src="<?php echo $oc_project->common; ?>javascript/library/jquery/jquery-1.7.1.min.js"></script>
		<script>
			$("#consoleArea button").click(function() {
				var btn = $(this),
					dir = btn.attr("data-direction");

				btn.attr("disabled", true);
				btn.siblings(":disabled").removeAttr("disabled");

				if ( dir === "both" ) {
					$("div[data-direction]").addClass("fixed").show();
					$("div[data-direction='left']").addClass("fixed_left");
					$("div[data-direction='right']").addClass("fixed_right")
					$("#flexArea").css({ marginLeft: 255, marginRight: 255 });
				}
				else {
					$("div[data-direction]")
						.removeClass("fixed")
						.removeClass("fixed_left")
						.removeClass("fixed_right")
						.hide();
					$("div[data-direction='" + dir + "']")
						.addClass("fixed")
						.addClass("fixed_" + dir)
						.show();
					$("#flexArea").css("margin", 0).css(("margin-" + dir), 255);
				}
			});
		</script>
<?php

$oc_project->html_footer();

?>