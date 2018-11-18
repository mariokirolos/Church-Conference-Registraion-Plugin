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
use \Req\Taxonomies\Conference;
use \Req\Pages\ConferenceBookings;

class FrontEnd extends BaseController{

	function register(){

		add_shortcode('set_form', array($this , 'create_form'));
		//add_action('save_post' , array($this , 'changeStatus' ) , 10 , 2);
	}

	function create_form(){
		$this-> wpshout_save_post_if_submitted();;
		return require_once("$this->plugin_path/templates/frontend.php");
	}


	function BlueFire_url_construction(){
		$rid = '83e606feac1d';
		$apiKey = 'd92lSA83k183';
		$hostURL = 'https://bluefire-secure.com/go/cf/checkout.php';
		$redUrl = 'https://www.example.com/thank-you/';
		$orderId = 532; // An order ID or invoice number
		$total = 12.50; // The total order amount
		$getArray = array(
		 'rid' => $rid,
		 'orderId' => $orderId,
		 'total' => $total,
		 'time' => mktime(),
		 'clientIp' => $_SERVER['REMOTE_ADDR'],
		 'redirect' => $redUrl,
		 'descrip' => 'Example Cart Checkout'
		);
		$hashSubj = http_build_query($getArray);
		$sig = hash('sha256', $hashSubj . $apiKey);
		$getArray['signature'] = $sig;
		$payLink = $hostURL . '?' . http_build_query($getArray);
	}


	function wpshout_save_post_if_submitted() {
    // Stop running function if form wasn't submitted
    if ( !isset($_POST['title']) ) {
        return;
    }

    // Check that the nonce was set and valid
    if( !wp_verify_nonce($_POST['_wpnonce'], 'wps-frontend-post') ) {
        echo 'Did not save because your form seemed to be invalid. Sorry';
        return;
    }

    // Do some minor form validation to make sure there is content
    if (strlen($_POST['title']) < 3) {
        echo 'Please enter a title. Titles must be at least three characters long.';
        return;
    }
    if (strlen($_POST['content']) < 100) {
        echo 'Please enter content more than 100 characters in length';
        return;
    }

    // Add the content of the form to $post as an array
    $post = array(
        'post_title'    => $_POST['title'],
        'post_content'  => $_POST['content'],
        'post_category' => $_POST['cat'], 
        'tags_input'    => $_POST['post_tags'],
        'post_status'   => 'draft',   // Could be: publish
        'post_type' 	=> 'post' // Could be: `page` or your CPT
    );
    wp_insert_post($post);
    
    //if Post were added successfully, redirect to blue fire if the blue fire was selected
    //$this->
    echo 'Saved your post successfully! :)';
}
}