<?php 
/**
 *
 *	Plugin Name: Registration Form
 *	Description: This form will create a form for the church with all the required fields for the church in order to collect all the required data and edit it anytime if needed.
 *	Author: Mario Kirolos
 *	Author URI: https://mariokirolos.com
 *	Plugin URI: https://mariokirolos.com/plugins/registration-form
 */



if(! defined ('ABSPATH')){
	die();
}


if(file_exists( dirname( __FILE__ ) . '/vendor/autoload.php')){
	require_once( dirname( __FILE__ ) . '/vendor/autoload.php');
}


//Register the Activate and deactivate 

function RegistrationFormActivate(){
	Req\Base\Activate::activate();
}

function RegistrationFormDeactivate(){
	Req\Base\Deactivate::deactivate();
}

//Register the activate Hook
register_activation_hook( __FILE__, 'RegistrationFormActivate' );

//Register the Deactivate Hook
register_deactivation_hook( __FILE__, 'RegistrationFormDeactivate' );


if( class_exists('Req\\Init') ){
	Req\Init::register_services();
}