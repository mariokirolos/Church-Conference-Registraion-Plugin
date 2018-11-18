<?php 

/**
 *
 *
 *		@Package Registraion Form
 *
 *
 */

namespace Req\Taxonomies;

 class Conference{

 	public $roomTypes = array();
 	public $taxonomyMeta = array();


 	function register(){

		
 			$this->roomTypes = array('King' , 'DBL' , 'Suite');

 			//Creating Custom Taxonomy
 			add_action( 'init', array($this , 'create_conferences_taxonomies' ) );
 			
 			
 			// Add the fields to the "presenters" taxonomy, using our callback function  
			add_action( 'conferences_add_form_fields', array ( $this, 'conferences_taxonomy_custom_fields' ), 10, 2 );  
			  
			// Save the changes made on the "presenters" taxonomy, using our callback function  
			add_action( 'created_conferences', array( $this , 'save_conference_fields' ) , 10, 2 );  
 			
 			add_action( 'conferences_edit_form_fields', array ( $this, 'update_conference_tax' ), 10, 2 );
   			add_action( 'edited_conferences', array ( $this, 'updated_conference_tax' ), 10, 2 );

   			//Putting the Custom Taxonomy right after the Title 
		add_action('add_meta_boxes_conference_booking' , array($this , 'rearrange_meta_boxes'));

 	}




	function create_conferences_taxonomies(){


		$labels = array(
			'name'					=> 'Conferences' , 
			'singular_name'			=> 'Conference' ,
			'search_items' 			=> 'Search Conferences',
		    'popular_items' 		=> 'Popular Conferences',
		    'all_items' 			=> 'All Conferences' ,
		    'parent_item' => null,
		    'parent_item_colon' => null,
		    'edit_item' => __( 'Edit Conference' ), 
		    'update_item' => __( 'Update Conference' ),
		    'add_new_item' => __( 'Add New Conference' ),
		    'new_item_name' => __( 'New Conference' ),
		    'separate_items_with_commas' => __( 'Separate conference with commas' ),
		    'add_or_remove_items' => __( 'Add or remove conference' ),
		    'choose_from_most_used' => __( 'Choose from the most used conferences' ),
		    'menu_name' => __( 'Conferences' ),
		);


		$args = array(
			'hierarchical' => true,
		    'labels' => $labels,
		    'show_ui' => true,
		    'show_admin_column' => true,
		    'update_count_callback' => '_update_post_term_count',
		    'query_var' => true,
		    'rewrite' => array( 'slug' => 'conferences' )
		);


		register_taxonomy( 'conferences', array('conference_booking'), $args);


	}


	
	function conferences_taxonomy_custom_fields($tag) {  
	?>
	<div class="form-field term-group">
     <label for="adult-price"><?php _e('Adult Price', 'adult-price'); ?></label>
     <input type="text" id="adult-price" name="conference_meta[adult_price]"   />
   </div>

   <div class="form-field term-group">
     <label for="child-price"><?php _e('Child Price', 'child-price'); ?></label>
     <input type="text" id="child-price" name="conference_meta[child_price]"   />
   </div>

	<div class="form-field term-group">
     <label for="room-types"><?php _e('Available room types', 'available-room-types'); ?></label>
		<?php 
			foreach($this->roomTypes as $type):
				print '<input type="checkbox" name="conference_meta[available_room_types][]" value="'. $type .'" /> ' . $type .'<br />';
			endforeach;
		?>
   </div>

   <?php 

	}  

	 public function save_conference_fields ( $term_id, $tt_id ) {
	   if( isset( $_POST['conference_meta'] ) && '' !== $_POST['conference_meta'] ){
	     $extra_data = $_POST['conference_meta'];
	     add_term_meta( $term_id, 'conference_meta', $extra_data, true );
	   }
	 }


	 public function update_conference_tax ( $term, $taxonomy ) { ?>
	   <tr class="form-field term-group-wrap">
	     <th scope="row">
	       <label for="adult-price"><?php _e( 'Adult Price', 'adult-price' ); ?></label>
	     </th>
	     <td>
	       <?php $conference_meta = get_term_meta ( $term -> term_id, 'conference_meta', true );
	        ?>
	      <input type="text" id="adult-price" name="conference_meta[adult_price]" value="<?php print $conference_meta['adult_price']; ?>"  />
	     </td>
	   </tr>
	   <tr class="form-field term-group-wrap">
	     <th scope="row">
	       <label for="child-price"><?php _e( 'Child Price', 'child-price' ); ?></label>
	     </th>
	     <td>
	      <input type="text" id="child-price" name="conference_meta[child_price]" value="<?php print $conference_meta['child_price']; ?>"  />
	     </td>
	   </tr>

		<tr class="form-field term-group-wrap">
	     <th scope="row">
	       <label for="room-types"><?php _e( 'Available Room Types', 'room-types' ); ?></label>
	     </th>
	     <td>
	       <?php 
				foreach($this->roomTypes as $type):
					print '<input type="checkbox" name="conference_meta[available_room_types][]" value="'. $type .'" ';

						if(in_array($type , $conference_meta['available_room_types']  )):
							print ' checked ';
						endif;

					print '/> ' . $type .'<br />';
				endforeach;
	       ?>
	     </td>
	   </tr>


	 <?php
	 }

	 public function updated_conference_tax ( $term_id, $tt_id ) {
	   if( isset( $_POST['conference_meta'] ) && '' !== $_POST['conference_meta'] ){
	     $extra_data = $_POST['conference_meta'];
	     update_term_meta ( $term_id, 'conference_meta', $extra_data );
	   } else {
	     update_term_meta ( $term_id, 'conference_meta', '' );
	   }
	 }





	 public function getTaxonomyID($postid){
	 	$conf = wp_get_post_terms( $postid , 'conferences' ) ;
	 	if(empty($conf))
	 		return false;
	 	
	 	return $conf[0]->term_id;
	 }

	 public function getRoomTypes($confid){
	 	$data = (get_term_meta($confid));
	 	$raw = $data['conference_meta'][0];
	 	$unserialize = unserialize($raw);
	 	$rooms = $unserialize['available_room_types'];

	 	return $rooms;
	 }

	 public function getAllConferences(){
	 	//Get all Taxonomies IDs;

	 	$terms = get_terms( array(
		    'taxonomy' => 'conferences',
		    'hide_empty' => true,
		) );

	 	return $terms;
	 }


	 	public function rearrange_meta_boxes(){
		global $wp_meta_boxes;
    	



// Miriam









    	$confdiv = $wp_meta_boxes['conference_booking']['side']['core']['conferencesdiv'];
    	unset($wp_meta_boxes['conference_booking']['side']['core']['conferencesdiv']);
	    $wp_meta_boxes['conference_booking']['normal']['core'] = array('conferencesdiv' => $confdiv) + $wp_meta_boxes['conference_booking']['normal']['core'];

	}
 }