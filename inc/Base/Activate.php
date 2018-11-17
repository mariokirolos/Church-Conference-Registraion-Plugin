<?php 

/**
 *
 *
 *		@Package Registraion Form
 *
 *
 */

namespace Req\Base;

 class Activate{

 	public static function activate(){
 		flush_rewrite_rules();
 	}
 }