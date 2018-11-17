<?php 

/**
 *
 *
 *		@Package Registraion Form
 *
 *
 */


namespace Req;

class Init{

	/**
	*	Store all the classes inside an array
	*	@return array of full list of classes.
	*	
	*/
	public static function get_services(){
		return array(
			Pages\Dashboard::class,
			Base\Enqueue::class,
			Pages\ConferenceBookings::class,
			Taxonomies\Conference::class,
			Api\Ajax::class,
			Api\Export::class,
			Pages\ConfirmationEmail::class,
		);
	}


	/**
	*
	*	Loop through all services and register them
	*
	*	@return 
	*
	*/
	public static function register_services(){
		foreach(self::get_services() as $class){
			$service = self::instantiate($class);
			if(method_exists($service, 'register')){
				$service->register();
			}
		}
	}


// 	/**
// 	*
// 	*	Register Service
// 	*	@return Class The Service
// 	*/

	private static function instantiate($class){
		return new $class();
	}



}