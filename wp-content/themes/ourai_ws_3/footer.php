<?php
global $oc_module;

if ( in_array($oc_module, array('signup', 'activate')) ) { ?>
<script>
	$("body").attr("data-page", "<?php echo $oc_module; ?>");
	$(".abs-ctr-cnt").eq(0).append( $("#content") );
	
	$("#content")
		.addClass("mu_panel")
		.before($("#content h2"));
<?php if ( $oc_module === 'signup' ) { ?>
	
	$("#content").after("<a id=\"backtoblog\" class=\"mu_panel\" href=\"<?php echo esc_url( home_url( '/' ) ); ?>\" title=\"<?php esc_attr_e( 'Are you lost?' ); ?>\"><?php printf( __( '&larr; Back to %s' ), get_bloginfo( 'title', 'display' ) ); ?></a>");
		
	$("form br").remove();
	$("form label").each(function() {
		var label = $(this),
			target = label.attr("for");
		
		label.wrap("<div data-for=\"" + target + "\"></div>");
		$("[data-for='" + target + "']").append($("#" + target));
	});
<?php } ?>

	if ( !$("#content form").size() ) {
		$(".abs-ctr-cnt").width( 500 );
	}
</script><?php
} ?>