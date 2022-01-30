<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.linkedin.com/in/nimesh-sangada-125420160/
 * @since      1.0.0
 *
 * @package    Hippo_api
 * @subpackage Hippo_api/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Hippo_api
 * @subpackage Hippo_api/admin
 * @author     Nimesh <nimeshsangada007@gmail.com>
 */
class Hippo_api_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Hippo_api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Hippo_api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/hippo_api-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Hippo_api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Hippo_api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/hippo_api-admin.js', array( 'jquery' ), $this->version, false );

	}
	public function add_plugin_admin_menu() {


	    add_menu_page('Hippo API Settings', 'Hippo API Settings', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'));
	}

	public function display_plugin_setup_page() {

		include_once 'partials/hippo_api-admin-display.php';

	}

	public function the_form_response() {
		
		if( isset( $_POST['hippo_api_setting_nonce'] ) && wp_verify_nonce( $_POST['hippo_api_setting_nonce'], 'hippo_api_setting_form_nonce') ) {
        
        
			// sanitize the input
			$api_url = $_POST['api_url'];
			$api_token = $_POST['api_token'];
			
			update_option( 'hippo_api_url', $api_url );
			update_option( 'hippo_api_token', $api_token );

			// do the processing

			// add the admin notice
			$admin_notice = "success";

			// redirect the user to the appropriate page
			$this->custom_redirect( $admin_notice, $_POST );
			exit;
		}			
		else {
			wp_die( __( 'Invalid nonce specified', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
						'response' 	=> 403,
						'back_link' => 'admin.php?page=' . $this->plugin_name,

				) );
		}
	}
	public function custom_redirect( $admin_notice, $post_var ){



        wp_redirect(admin_url('admin.php').'?page=hippo_api&data-updated='.$admin_notice);

        exit;



	}
}
