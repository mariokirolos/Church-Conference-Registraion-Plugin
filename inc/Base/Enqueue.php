<?php 
/**
 *
 *
 *		@Package Registraion Form
 *
 *
 */

namespace Req\Base;

use \Req\Base\BaseController;

 class Enqueue extends BaseController{

 	public function register(){
 		//Register all required js and css for the admin views
		add_action('admin_enqueue_scripts' , array( $this , 'adminEnqueue'));
		//Register all required js and css for the frontend views.
		add_action('wp_enqueue_scripts' , array( $this , 'frontendEnqueue'));
 	}


 	function adminEnqueue(){
		//wp_enqueue_media();

		wp_enqueue_style('RegistraionSty' , $this->plugin_url . 'assets/css/style.css' );
		wp_enqueue_script('RegistraionSty' , $this->plugin_url . 'assets/js/admin.js' , __FILE__ );

		//Date Picker Files
		wp_enqueue_style('jQueryUI' , 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' , '' , '1.12.1');
		wp_enqueue_script('jQueryUI' , 'https://code.jquery.com/ui/1.12.1/jquery-ui.js' , '' , '1.12.1');

		//

	}

	function frontendEnqueue(){
		// wp_enqueue_style('AutobodyStyles' , $this->plugin_url . 'assets/css/mainfrontend.css' );
		// wp_enqueue_style( 'bootstrap' , 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');
		// wp_enqueue_style( 'style' , 'https://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css');
	
	

		// wp_enqueue_script('googleapis' , 'https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js');
		// wp_enqueue_script( 'googleajax'  , 'https://code.jquery.com/ui/1.12.0/jquery-ui.js');
	}

 }