<?php 

/**
 *
 *
 *		@Package Registraion Form
 *
 *
 */

namespace Req\Pages;

use \Req\Base\BaseController;

class ConfirmationEmail  extends BaseController{


	function register(){


		add_action( 'publish_conference_booking', array($this , 'sendConfirmationEmail') , 10 , 2 );
		
		//
		
	}



	function sendConfirmationEmail( $ID, $post ){

		$to = $_POST['emailaddress'];
		$message = require_once("$this->plugin_path/templates/confirmationEmail.php");


		$headers = array('Content-Type: text/html; charset=UTF-8');
		$headers[]= “From: YourName <first email>”;	//Replace this one with a real email



		if ( $post->post_date != $post->post_modified )
		  {
			$message = 'Updating';
		  }
		  else
		  {
		  	if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
		  		wp_mail( $to, 'Confirmation Email',   $message, $headers );
		  	}
		  }
	}
}
