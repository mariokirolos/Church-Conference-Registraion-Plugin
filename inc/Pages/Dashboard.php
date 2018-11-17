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

class Dashboard extends BaseController{

	public $conference;
	public $bookings;


	public function register(){

		//Register the Page on the Admin Menu
		add_action('admin_menu' , array($this , 'register_menu_items'));
	}

	public function register_menu_items(){
		add_menu_page( 'Registration' , 'Registraion Forms', 'manage_options' , 'ac_registration' , array($this , 'adminDashboard' ) );
	}

	public function adminDashboard(){
 		return require_once("$this->plugin_path/templates/dashboard.php");
 	}

	public function getConferences(){

		$this->conference = new Conference();
		$this->bookings = new ConferenceBookings();

		$returnData = [];

		//Get All Conferences
		$conf = $this->conference->getAllConferences();

		foreach($conf as $key => $one){
			$returnData[$key]['term_taxonomy_id'] = $one->term_id;
			$returnData[$key]['name'] = $one->name;
			$returnData[$key]['count'] = $one->count;


			//Get the Bookings in each conference.
			$bookings = $this->bookings->getConferenceBookings($one->term_id);
			$returnData[$key]['totalPaid'] = $bookings['totalPaid'];
			$returnData[$key]['totalRemaining'] = $bookings['totalRemaining'];



		}


		return $returnData;
	}


}