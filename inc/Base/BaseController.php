<?php 

/**
 *
 *
 *		@Package Registraion Form
 *
 *
 */

namespace Req\Base;

 class BaseController{


 	public $plugin_path;
 	public $plugin_url;
 	public $plugin;
 	public $managers = array();
 	public $base_table_name;
 	public $base_OCR_table;
 	public $wpdb;

	function __construct(){
		global $wpdb;

		$this->plugin_path = plugin_dir_path( dirname(__FILE__ , 2) );
		$this->plugin_url = plugin_dir_url( dirname(__FILE__ , 2) );
		$this->plugin = plugin_basename(  dirname(__FILE__ , 3 ) ) . '/'  . plugin_basename(  dirname(__FILE__ , 3 ) ) . '.php' ;
		$this->wpdb = $wpdb;
		
	}

 }