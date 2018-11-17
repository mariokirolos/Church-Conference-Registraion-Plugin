<?php 

/**
 *
 *
 *		@Package Registraion Form
 *
 *
 */

namespace Req\Api\Callbacks;


 class InputCallBacks{





 	public function TextBox($args){

 		$readonly = (isset($args['readonly'])) ? 'readonly="readonly"' : '';

 		$dependant = (isset($args['dependant']))? $args['dependant'] : '';

 		

 		$return = '<div class="'. $args['class'] .'" data-dependont="'. $dependant .'">';

 		$return .= (!empty($args['label'])) ? '<label for="'. $args['name'] .'">'. $args['label'] .':</label><br />' : '' ;
		$return .= '<input type="text" name="'. $args['name'] .'" id="'. $args['name'] .'" value="'. $args['value'] .'" '. $readonly .' />
		</div>';

		return $return;
 	}

 	public function TextArea($args){
 		return '<div class="question">
			<label  for="'. $args['name'] .'">'. $args['label'] .':</label>
			<br />
			<textarea name="'. $args['name'] .'" id="'. $args['name'] .'">'. $args['value'] .'</textarea>
		</div>';
 	}

 	public function SelectDropDown($args){
 		$dependant = (isset($args['dependant']))? $args['dependant'] : '';

 		$return =  '<div class="'. $args['class'] .'" data-dependont="'. $dependant .'">';
			$return .= (!empty($args['label'])) ? '<label for="'. $args['name'] .'">'. $args['label'] .':</label><br />' : '' ;
			$return .= '<select name="'. $args['name'] .'" id="'. $args['name'] .'">' ;
			foreach($args['options'] as $option):
				$return .=  '<option value="'. $option .'" ';
				$return .=	($option == $args['value']) ? 'selected' : '' ;
				$return .= '>'. $option .'</option>';
			endforeach;
		$return .= '</select>
		</div>';

		return $return;
 	}


}