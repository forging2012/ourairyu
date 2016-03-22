<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to twentyeleven_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
	<div id="comments">
		<form id="commentForm" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">
			<table id="respond">
				<caption>发表评论</caption>
				<colgroup>
					<col style="width: 200px;" />
					<col style="width: 200px;" />
					<col style="width: 200px;" />
				</colgroup>
				<!--thead><tr><td colspan="2">请自觉遵守互联网相关的政策法规，严禁发布色情、暴力、反动的言论。 </td></tr></thead-->
				<tfoot><tr><td colspan="2"><input type="submit" name="submit" value="提交评论" /></td></tr></tfoot>
				<tbody>
					<tr>
						<td><input class="ipt-txt" type="text" value="" name="author" id="author" /></td>
						<td><input class="ipt-txt" type="text" value="" name="email" id="email" /></td>
						<td><input class="ipt-txt fr" type="text" value="" name="url" id="url" /></td>
					</tr>
					<tr><td colspan="3"><textarea name="comment"></textarea></td></tr>
				</tbody>
			</table>
			<input type="hidden" value="<?php echo $id; ?>" name="comment_post_ID" />
		</form>
		<ul>
		<?php if ($comments && count($comments) > 0) : ?>
			<li>
				<h3><?php echo count($comments); ?> 条评论</h3>
				<ol id="commentList"><?php wp_list_comments('type=comment&reverse_top_level=true&callback=ourai_commentlist'); ?></ol>
			</li>
		<?php endif; ?>
			<!--li class="fl"><h3><?php echo count($trackbacks); ?> 次引用</h3></li-->
		</ul>
	</div>
