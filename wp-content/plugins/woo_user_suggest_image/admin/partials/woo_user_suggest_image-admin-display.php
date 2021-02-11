<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.cedcoss.com/
 * @since      1.0.0
 *
 * @package    Woo_user_suggest_image
 * @subpackage Woo_user_suggest_image/admin/partials
 */

if(isset($_POST['submit_setting'])) {
    $setting_val = isset($_POST['user_suggest_enable'])?sanitize_text_field($_POST['user_suggest_enable']):'';
    $data = update_option('ced_user_image_suggestion_setting',$setting_val);
        ?>
        <div class="notice notice-success is-dismissible" style="padding:7px;background-color:#23282d;color:white;font-size:10px;text-align:center;margin:15px">
		Setting Updated Successsfully
        </div>
<?php
} 
$get_data_from_optios_table = get_option('ced_user_image_suggestion_setting');
if('user_suggest_enable' !== $get_data_from_optios_table) {
    $enabled = "";
} else {
    $enabled = 'checked';
}

?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div style="padding:15px;background-color:#23282d;color:white;font-size:30px;text-align:center;margin:15px">
		Suggestion Image of USER by CEDCOMMERCE
</div>
<hr>
<h3>Hey if you want to create a option that will show on frontent to add a user suggestion images </h3>
<hr>
<form method='POST'>
 <input type="checkbox" value = 'user_suggest_enable'name = 'user_suggest_enable' <?php echo $enabled?> >  Check for Enable the setting
 <input type="submit" name = "submit_setting" value = "ENABLE SETTING"> 
</form>