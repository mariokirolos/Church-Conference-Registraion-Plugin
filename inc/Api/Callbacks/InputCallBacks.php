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

 		$input_class = (isset($args['input_class']))? $args['input_class'] : '';
 		

 		$return = '<div class="'. $args['class'] .'" data-dependont="'. $dependant .'">';

 		$return .= (!empty($args['label'])) ? '<label for="'. $args['name'] .'">'. $args['label'] .':</label><br />' : '' ;
		$return .= '<input type="text" name="'. $args['name'] .'" class="'. $input_class .'" id="'. $args['name'] .'" value="'. $args['value'] .'" '. $readonly .' />
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
 		$input_class = (isset($args['input_class']))? $args['input_class'] : '';

 		$return =  '<div class="'. $args['class'] .'" data-dependont="'. $dependant .'">';
			$return .= (!empty($args['label'])) ? '<label for="'. $args['name'] .'">'. $args['label'] .':</label><br />' : '' ;
			$return .= '<select name="'. $args['name'] .'" class="'. $input_class .'" id="'. $args['name'] .'">' ;
			if(!empty($args['options'])):
				foreach($args['options'] as $option):
					$return .=  '<option value="'. $option .'" ';
					$return .=	($option == $args['value']) ? 'selected' : '' ;
					$return .= '>'. $option .'</option>';
				endforeach;
			endif;
		$return .= '</select>
		</div>';

		return $return;
 	}


}