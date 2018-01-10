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

final class JobImport_plugin {
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
		// $this->includesFiles();
		// $this->initDefinesConstants();
	}

	/**
	 * Hook into actions and filters.
	 *
	 */
	private function init_hooks() {
		// Plugin actions
			// register_activation_hook( __FILE__, array( $this, 'installPlugin' ) );
			// register_deactivation_hook( __FILE__,  array( $this, 'deactivatePlugin' ) );	
	
		// Actions
			// add_action( 'admin_init', array( $this, 'registerSettingsFields' ) );
			add_action( 'admin_menu', array( $this, 'addMenuItem' ) );
			// add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueFiles' ) );
		}

  /**
	 * Add Item In Admin Menu.
	 * 
	 */
	public function addMenuItem() {
		add_submenu_page( 'tools.php', 'Job Import Data', 'Job Import', 'manage_options', 'jobimport',  array( $this, 'renderPage' ) );
	}

	/**
	 * Render export page
	 * 
	 */
	public function renderPage() {
		include_once( $this->plugin_path().'/include/page-settings.php' );
	}

	/**
	 * Get the plugin path.
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}
	
}
new JobImport_plugin();