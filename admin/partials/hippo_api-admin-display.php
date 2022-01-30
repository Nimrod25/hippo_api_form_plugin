<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.linkedin.com/in/nimesh-sangada-125420160/
 * @since      1.0.0
 *
 * @package    Hippo_api
 * @subpackage Hippo_api/admin/partials
 */

	/**
	 * The form to be loaded on the plugin's admin page
	 */
	if( current_user_can( 'edit_users' ) ) {		

	// Generate a custom nonce value.
	$hippo_api_nonce = wp_create_nonce( 'hippo_api_setting_form_nonce' ); 

	// Build the Form
	$url = "";
	$token ="";
	if (get_option('hippo_api_url',false) ){
	   echo $url = get_option('hippo_api_url');
	}
	if (get_option('hippo_api_token',false) ){
	    $token = get_option('hippo_api_token');
	}
?>				
	<h2><?php _e( 'Hippo API Settings', $this->plugin_name ); ?></h2>		
	<div class="hippo_api_setting_form">

	<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" id="hippo_api_setting_form" >			

		<input type="hidden" name="action" value="hippo_api_form_response">
		<input type="hidden" name="hippo_api_setting_nonce" value="<?php echo $hippo_api_nonce ?>" />			
			<table class="form-table">
        	<tbody>
        		<tr>
        			<th scope="row"><label for="api_url"> <?php _e('API URL', $this->plugin_name); ?> </label></th>
        			<td><input required id="api_url" type="text" name="api_url" value="<?php echo $url; ?>" placeholder="e.g. https://www.google.com" /></td>
        		</tr>
            	<tr>
        			<th scope="row"><label for="api_token"> <?php _e('API Token', $this->plugin_name); ?> </label></th>
        			<td><input required id="api_token" type="text" name="api_token" value="<?php echo $token; ?>" placeholder="e.g. AUn1791230023000n"/></td>
        		</tr>
            
        	</tbody>
        </table>
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Setting"></p>
	</form>
			
	</div>
<?php    
}
else {  
?>
	<p> <?php __("You are not authorized to perform this operation.", $this->plugin_name) ?> </p>
<?php   
}