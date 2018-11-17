<?php 

/**
 *
 *
 *		@Package Registraion Form
 *
 *
 */

namespace Req\Base;

 class Deactivate{

 	public static function deactivate(){
 		flush_rewrite_rules();
 	}

 	//Remove the database tables data.
 }