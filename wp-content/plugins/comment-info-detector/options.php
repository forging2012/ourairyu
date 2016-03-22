<?php

$mode = trim($_GET['mode']);

$CID_settings = array('CID_options');

if (!empty($_POST['Submit'])) {
	$CID_options = array();
	$CID_options['flag_icons_url'] = trim($_POST['flag_icons_url']);
	$CID_options['flag_template'] = trim($_POST['flag_template']);
	
	$CID_options['WB_OS_icons_url'] = trim($_POST['WB_OS_icons_url']);
	$CID_options['WB_OS_template'] = trim($_POST['WB_OS_template']);
	
	$CID_options['auto_display_flag'] = intval($_POST['auto_display_flag']);
	$CID_options['auto_display_WB_OS'] = intval($_POST['auto_display_WB_OS']);
	
	$update_queries = array();
	$update_queries[] = update_option('CID_options', $CID_options);
	
	$update_text = array();
	$update_text[] = __('Comment Info Detector Options', 'comment-info-detector');
	
	$i=0;
	$text = '';
	foreach ($update_queries as $update_query) {
		if ($update_query) {
			$text .= '<font color="green">'.$update_text[$i].' '.__('Updated', 'comment-info-detector').'</font><br />';
		}
		$i++;
	}
	if (empty($text)) {
		$text = '<font color="red">'.__('No Option Updated', 'comment-info-detector').'</font>';
	}
}

if(!empty($_POST['do'])) {
	switch($_POST['do']) {		
		case __('UNINSTALL', 'comment-info-detector') :
			if(trim($_POST['uninstall_cid_yes']) == 'yes') {
				echo '<div id="message" class="updated fade">';
				echo '<p>';
				foreach($CID_settings as $setting) {
					$delete_setting = delete_option($setting);
					if($delete_setting) {
						echo '<font color="green">';
						printf(__('Setting key \'%s\' has been deleted.', 'comment-info-detector'), "<strong><em>{$setting}</em></strong>");
						echo '</font><br />';
					} else {
						echo '<font color="red">';
						printf(__('Cannot delete setting key \'%s\'.', 'comment-info-detector'), "<strong><em>{$setting}</em></strong>");
						echo '</font><br />';
					}
				}
				echo '</p>';
				echo '</div>'; 
				$mode = 'end-UNINSTALL';
			}
			break;
	}
}

switch($mode) {
	case 'end-UNINSTALL':
		$deactivate_url = 'plugins.php?action=deactivate&amp;plugin=comment-info-detector/comment-info-detector.php';
		if(function_exists('wp_nonce_url')) { 
			$deactivate_url = wp_nonce_url($deactivate_url, 'deactivate-plugin_comment-info-detector/comment-info-detector.php');
		}
		echo '<div class="wrap">';
		echo '<h2>'.__('Uninstall Comment Info Detector', 'comment-info-detector').'</h2>';
		echo '<p><strong>'.sprintf(__('<a href="%s">Click here</a> to finish the uninstallation and Comment Info Detector will be deactivated automatically.', 'comment-info-detector'), $deactivate_url).'</strong></p>';
		echo '</div>';
		break;
		
	default:
	$CID_options = get_option('CID_options');
?>
<script type="text/javascript">
	/* <![CDATA[*/
	function CID_default_templates(template) {
		var default_template;
		switch(template) {
			case 'flag_icons_url':
				default_template = "<?php echo WP_PLUGIN_URL . "/comment-info-detector/flags"; ?>";
				break;
			case 'flag_template':
				default_template = '<span class="country-flag"><img src="%IMAGE_BASE%/%COUNTRY_CODE%.png" title="%COUNTRY_NAME%" alt="%COUNTRY_NAME%" /> %COUNTRY_NAME%</span> ';
				break;
			case 'WB_OS_icons_url':
				default_template = "<?php echo WP_PLUGIN_URL . "/comment-info-detector/browsers"; ?>";
				break;
			case 'WB_OS_template':
				default_template = '<span class="WB-OS"><img src="%IMAGE_BASE%/%BROWSER_CODE%.png" title="%BROWSER_NAME%" alt="%BROWSER_NAME%" /> %BROWSER_NAME% %BROWSER_VERSION% <img src="%IMAGE_BASE%/%OS_CODE%.png" title="%OS_NAME%" alt="%OS_NAME%" /> %OS_NAME% %OS_VERSION%</span>';
				break;				
		}
		document.getElementById(template).value = default_template;
	}
	/* ]]> */
</script>
<?php if (!empty($text)) { echo '<div id="message" class="updated fade"><p>'.$text.'</p></div>'; } ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"> 
<div class="wrap"> 
	<h2><?php _e('Comment Info Detector Options', 'comment-info-detector'); ?></h2>
	<table class="form-table">
		<tr>
			<td valign="top">
				<strong><?php _e('Country Flag Icons Base URL:', 'comment-info-detector'); ?></strong><br /><br />
				<input type="button" name="RestoreDefault" value="<?php _e('Restore Default URL', 'comment-info-detector'); ?>" onclick="CID_default_templates('flag_icons_url');" class="button" />
			</td>
			<td valign="top">
				<input type="text" id="flag_icons_url" name="flag_icons_url" size="90" value="<?php echo htmlspecialchars(stripslashes($CID_options['flag_icons_url'])); ?>" />
			</td>
		</tr>
		
		<tr>
			<td valign="top">
				<strong><?php _e('Country Flag Template:', 'comment-info-detector'); ?></strong><br /><br />
				<?php _e('Allowed Variables:', 'comment-info-detector'); ?><br />
				- %COUNTRY_CODE%<br />
				- %COUNTRY_NAME%<br />
				- %IMAGE_BASE%<br />
				- %COMMENTER_IP%<br />
				<br />
				<input type="button" name="RestoreDefault" value="<?php _e('Restore Default Template', 'comment-info-detector'); ?>" onclick="CID_default_templates('flag_template');" class="button" />
			</td>
			<td valign="top">
				<textarea cols="87" rows="10"  id="flag_template" name="flag_template"><?php echo htmlspecialchars(stripslashes($CID_options['flag_template'])); ?></textarea>
			</td>
		</tr>

		<tr>
			<td valign="top">
				<strong><?php _e('Web Browser and OS Icons Base URL:', 'comment-info-detector'); ?></strong><br /><br />
				<input type="button" name="RestoreDefault" value="<?php _e('Restore Default URL', 'comment-info-detector'); ?>" onclick="CID_default_templates('WB_OS_icons_url');" class="button" />
			</td>
			<td valign="top">
				<input type="text" id="WB_OS_icons_url" name="WB_OS_icons_url" size="90" value="<?php echo htmlspecialchars(stripslashes($CID_options['WB_OS_icons_url'])); ?>" />
			</td>
		</tr>
		
		<tr>
			<td valign="top">
				<strong><?php _e('Web Browser and OS Template:', 'comment-info-detector'); ?></strong><br /><br />
				<?php _e('Allowed Variables:', 'comment-info-detector'); ?><br />
				- [BROWSER] - [/BROWSER]<br />
				- %BROWSER_NAME%<br />
				- %BROWSER_CODE%<br />
				- %BROWSER_VERSION%<br />
				- [OS] - [/OS]<br />
				- %OS_NAME%<br />
				- %OS_CODE%<br />
				- %OS_VERSION%<br />
				- %IMAGE_BASE%<br />
				<br />
				<input type="button" name="RestoreDefault" value="<?php _e('Restore Default Template', 'comment-info-detector'); ?>" onclick="CID_default_templates('WB_OS_template');" class="button" />
			</td>
			<td valign="top">
				<textarea cols="87" rows="10"  id="WB_OS_template" name="WB_OS_template"><?php echo htmlspecialchars(stripslashes($CID_options['WB_OS_template'])); ?></textarea>
			</td>
		</tr>
		<tr>
			<td valign="top" width="30%"><strong><?php _e('Display Country Flags Automatically:', 'comment-info-detector'); ?></strong></td>
			<td valign="top">
				<select name="auto_display_flag" size="1">
					<option value="0"<?php selected('0', $CID_options['auto_display_flag']); ?>><?php _e('No', 'comment-info-detector'); ?></option>
					<option value="1"<?php selected('1', $CID_options['auto_display_flag']); ?>><?php _e('Yes', 'comment-info-detector'); ?></option>
					<option value="2"<?php selected('2', $CID_options['auto_display_flag']); ?>><?php _e('Yes but don\'t display in WP-Admin', 'comment-info-detector'); ?></option>
				</select>
				<br /><?php _e('Use this option if you don\'t want to modify your theme code', 'comment-info-detector'); ?>
			</td>
		</tr>
		<tr>
			<td valign="top" width="30%"><strong><?php _e('Display Web Browsers and OS Automatically:', 'comment-info-detector'); ?></strong></td>
			<td valign="top">
				<select name="auto_display_WB_OS" size="1">
					<option value="0"<?php selected('0', $CID_options['auto_display_WB_OS']); ?>><?php _e('No', 'comment-info-detector'); ?></option>
					<option value="1"<?php selected('1', $CID_options['auto_display_WB_OS']); ?>><?php _e('Yes', 'comment-info-detector'); ?></option>
					<option value="2"<?php selected('2', $CID_options['auto_display_WB_OS']); ?>><?php _e('Yes but don\'t display in WP-Admin', 'comment-info-detector'); ?></option>
				</select>
				<br /><?php _e('Use this option if you don\'t want to modify your theme code', 'comment-info-detector'); ?>
			</td>
		</tr>		
	</table>
	<p class="submit">
		<input type="submit" name="Submit" class="button" value="<?php _e('Save Changes', 'comment-info-detector'); ?>" />
	</p>
</div>
</form>
<p>&nbsp;</p>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"> 
<div class="wrap"> 
	<h2><?php _e('Uninstall Comment Info Detector', 'comment-info-detector'); ?></h2>
	<p>
		<input type="checkbox" name="uninstall_cid_yes" value="yes" />&nbsp;<?php _e('Yes', 'comment-info-detector'); ?><br /><br />
		<input type="submit" name="do" value="<?php _e('UNINSTALL', 'comment-info-detector'); ?>" class="button" onclick="return confirm('<?php _e('Are you sure to uninstall this plugin?\nChoose [Cancel] to stop, [OK] to uninstall.', 'comment-info-detector'); ?>')" />
	</p>
</div> 
</form>
<?php } ?>