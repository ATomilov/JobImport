<?php
/**
 * Plugin Name: Job Import plugin 
 * Plugin URI:
 * Description:  Import Jobs from Lumesse system
 * Version: 1.0
 * Author: Cimpleo <Alexey Tomilov>
 * Author URI: http://cimpleo.com
 * Requires at least: 4.4
 * Tested up to: 4.9
 *
 *
 * @package JobImport_plugin
 * @author Cimpleo
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class tlj_JobImport_plugin {
	/**
	 * Plugin version
	 * @var string
	 */
	public $version = '1.1';

	/**
	 * Plugin __construct 
	 */
	public function __construct() {
		$this->init_hooks();
		$this->includesFiles();
		// $this->initDefinesConstants();
	}

	/**
	 * Hook into actions and filters.
	 *
	 */
	private function init_hooks() {
		// Plugin actions
			register_activation_hook( __FILE__, array( $this, 'installPlugin' ) );
			register_deactivation_hook( __FILE__,  array( $this, 'deactivatePlugin' ) );	
	
		// Actions
			add_action( 'admin_init', array( $this, 'registerSettingsFields' ) );
			add_action( 'admin_menu', array( $this, 'addMenuItem' ) );
			add_action( 'add_meta_boxes', array( $this, 'addCustomMetaBoxes' ) );
			// add_action( 'edit_form_after_title',  array( $this, 'move_metabox_after_title' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueFiles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'includeFrontJs' ) );
		}

	/**
	 * Include required core files.
	 */
	public function includesFiles() {
		include_once( $this->plugin_path().'/include/classes/class-tlj-WSSEAuth.php' );
		include_once( $this->plugin_path().'/include/classes/class-tlj-WSSEToken.php' );
		include_once( $this->plugin_path().'/include/classes/class-tlj-Auth-and-Token.php' );
		include_once( $this->plugin_path().'/include/classes/class-tlj-soapClient.php' );
		// include_once( $this->plugin_path().'/include/classes/class_defaultSoap.php' );
		include_once( $this->plugin_path().'/include/classes/class-tlj-queries.php' );
		include_once( $this->plugin_path().'/include/classes/requests/class-getAdvertisementById.php' );
		// include_once( $this->plugin_path().'/include/classes/requests/create-request.php' );
		include_once( $this->plugin_path().'/include/classes/class-tlj-main.php' );
	}

	/**
	 * 
	 * Register settings fields for Import Settings Page
	 * 
	 * 
	 */
	public function registerSettingsFields() {
		register_setting( 'selectedPostTypes_group', 'selectedPostTypes' );
		register_setting( 'apiCredentials_group', 'apiCredentials' );
		register_setting( 'idTalentlinkJob_group', 'idTalentlinkJob' );
	}

	/**
	 * 
	 * Install Plugin Hook.
	 * 
	 */
	public static function installPlugin() {
		if ( ! current_user_can( 'activate_plugins' ) )
			return;

		$posts_ids = array_values( get_posts( array(
			'fields'          => 'ids',
			'posts_per_page'  => -1,
			'post_type'       => 'job'
		) ) );
		update_option( 'idTalentlinkJob', $posts_ids );

		$apiCredentials = array(
			'username' => 'THubUser',
			'pwd' => 'Password1234',
			'api_key' => 'dabc4dvptajdnrhwnqsf6dnz',
			'url_web_service' => 'https://api3.lumesse-talenthub.com'
		);
		update_option( 'apiCredentials', $apiCredentials );
	}

	/**
	 * 
	 * Deactivate Plugin hook.
	 * Remove options.
	 * 
	 */
	public static function deactivatePlugin() {
		if ( ! current_user_can( 'activate_plugins' ) )
			return;
		delete_option( 'selectedPostTypes' );
		delete_option( 'apiCredentials' );
		delete_option( 'idTalentlinkJob' );
	}

/**
 * Add Meta Box
 * 
 */
public function addCustomMetaBoxes(){
	$options = array_values( get_option( 'selectedPostTypes' ) );
	if ( !empty( $options ) ) : 
			add_meta_box( 'job_import_meta_box', __( 'Main information', 'jobimport_plugin' ), array ($this, 'build_meta_box'), $options, 'side', 'high' );
	endif;
}

/**
 * Add Content to Meta Box
 * 
 */
function build_meta_box() {

}

// function move_metabox_after_title () {
// 	global $post, $wp_meta_boxes;
// 	$post_types = get_post_types( array( 'public' => true ),'names' );
// 	foreach( $post_types as $post_type ) :
// 		do_meta_boxes( get_current_screen(), 'advanced', $post );
// 		unset( $wp_meta_boxes[$post_type]['advanced'] );
// 	endforeach;
// }

/**
 * Enquque Scripts and Style
 * 
 */
public function adminEnqueueFiles() {
	wp_enqueue_style( 'JI-style.css', $this->plugin_url('/assets/css/main.css') );
	// Script
	wp_enqueue_script( 'jquery' );
	// wp_enqueue_script( 'main', $this->plugin_url('/assets/js/main.js'), array( 'jquery' ) );
}

public function includeFrontJs() {
	wp_enqueue_script( 'main', $this->plugin_url('/assets/js/main.js'), array( 'jquery' ) );
	wp_localize_script( 'main', 'tljJobImport', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'id' => 1,
//		'noncefield'	=> wp_create_nonce('cj-export-nonce')
	));
}

  /**
	 * Add Item In Admin Menu.
	 *
	 */
	public function addMenuItem() {
		add_submenu_page( 'tools.php', 'Job Import Settings', 'Job Import', 'manage_options', 'jobimport',  array( $this, 'renderPage' ) );
	}

	/**
	 * Render export page
	 * 
	 */
	public function renderPage() {
		include_once( $this->plugin_path().'/include/page-settings.php' );
	}

	/**
	 * Get the plugin url.
	 * @return string
	 */
	public function plugin_url( $path ) {
		return untrailingslashit( plugins_url( $path, __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}
	
}
new tlj_JobImport_plugin();