<?php
/**
 * The template for displaying search forms in Twenty Eleven
 *
 * @package WordPress
 * @subpackage Ourai.WS
 * @since Ourai.WS 3.2
 */
?>
	<form method="get" id="searchform" class="search_form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="text" class="search_text" name="s" id="s" placeholder="搜索...">
		<input type="submit" class="search_button" value="搜索">
	</form>
