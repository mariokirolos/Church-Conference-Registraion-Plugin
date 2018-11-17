<?php 

/**
 *
 *
 *		@Package Registraion Form
 *
 *
 */

namespace Req\Pages;

use Req\Taxonomies\Conference;

 class ConferenceBookings{


 	public $roomTypes = array();
 	public $taxonomy = '';


	function register(){

		$this->taxonomy = new Conference();

		//Create the Custom Post Type
		add_action( 'init', array($this , 'register_CPT_ConferenceBookings') );
		// Add the extra fields to it
		add_action( 'add_meta_boxes_conference_booking', array($this , 'no_of_adults_metaboxes') );
		//Saving the extra fields
		add_action( 'save_post_conference_booking', array($this , 'conference_booking_save_post') ); 

		//Update the table 
		add_action('manage_conference_booking_posts_columns' , array( $this , 'set_custom_columns'));

		//Set the table columns to the custom fields
		add_action('manage_conference_booking_posts_custom_column' , array( $this , 'set_custom_columns_data') , 10 , 2 );

		add_filter('manage_edit-conference_booking_sortable_columns' , array($this , 'custom_sortable_columns'));

	}

	 

	function register_CPT_ConferenceBookings() {
	
		$labels = array(
			'name'               => __( 'Conference Bookings', 'conference-bookings' ),
			'singular_name'      => __( 'Booking', 'conference-bookings' ),
			'add_new'            => _x( 'Add New Booking', 'conference-bookings', 'conference-bookings' ),
			'add_new_item'       => __( 'Add New Booking', 'conference-bookings' ),
			'edit_item'          => __( 'Edit Booking', 'conference-bookings' ),
			'new_item'           => __( 'New Booking', 'conference-bookings' ),
			'view_item'          => __( 'View Booking', 'conference-bookings' ),
			'search_items'       => __( 'Search Bookings', 'conference-bookings' ),
			'not_found'          => __( 'No Bookings found', 'conference-bookings' ),
			'not_found_in_trash' => __( 'No Bookings found in Trash', 'conference-bookings' ),
			'parent_item_colon'  => __( 'Conference:', 'conference-bookings' ),
			'menu_name'          => __( 'Bookings', 'conference-bookings' ),
		);
	
		$args = array(
			'labels'              => $labels,
			'hierarchical'        => true,
			'description'         => 'Here will keep all the bookings for any conference that the church will do.',
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => null,
			'menu_icon'           => 'dashicons-calendar-alt',
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => true,
			'capability_type'     => 'post',
			'supports'            => array(
				'title',
			),
		);
	
		register_post_type( 'conference_booking', $args );
	}


	function no_of_adults_metaboxes( ) {
   		global $wp_meta_boxes;
   		add_meta_box('general_information_div', __('General Information'), array($this , 'all_information_html') , 'conference_booking', 'normal', 'high');
	}


	function all_information_html()
	{
	    global $post;
	    $custom = get_post_custom($post->ID);
	    $number_ad = isset($custom["no_of_adults"][0])?$custom["no_of_adults"][0]:'';
	    $number_ch = isset($custom["no_of_childs"][0])?$custom["no_of_childs"][0]:'';
	    $bt_0_4 = isset($custom["age_between_0_and_4"][0])?$custom["age_between_0_and_4"][0]:'';
	    $bt_5_11 = isset($custom["age_between_5_and_11"][0])?$custom["age_between_5_and_11"][0]:'';
	    $Young_youth = isset($custom["Young_youth"][0])?$custom["Young_youth"][0]:'';
	    $ch_grades = isset($custom["ch_grades"][0])?$custom["ch_grades"][0]:'';
	    $paid = isset($custom["paid"][0])?$custom["paid"][0]:'';
	    $remaining = isset($custom["remaining"][0])?$custom["remaining"][0]:'';
	    

	    $payment_method = isset($custom["payment_method"][0])?unserialize($custom["payment_method"][0]):'';
		$check_numbers = isset($custom["check_numbers"][0])?unserialize($custom["check_numbers"][0]):'';
	    $payment_amount = isset($custom["payment_amount"][0])?unserialize($custom["payment_amount"][0]):'';
	    $payment_date = isset($custom["payment_date"][0])?unserialize($custom["payment_date"][0]):'';
	    

	    $room_numbers  = isset($custom["room_numbers"][0])?$custom["room_numbers"][0]:'';
	    $hotelComments = isset($custom["hotelComments"][0])?$custom["hotelComments"][0]:'';
		$extraComments = isset($custom["extraComments"][0])?$custom["extraComments"][0]:'';
		$roomtype = isset($custom["room_type"][0])?$custom["room_type"][0]:'';
		
		$emailaddress = isset($custom["emailaddress"][0])?$custom["emailaddress"][0]:'';



		//If the Post is not new get the room types from the conference
		if('publish' == get_post_status ( $post->ID )){
			$confID =  $this->taxonomy->getTaxonomyID($post->ID);
			$roomTypes = $this->taxonomy->getRoomTypes($confID);
		}


	    
	?>

		<div class="question">
			<label for="no_of_adults">Number of Adults:</label>
			<br />
			<select name="no_of_adults" id="no_of_adults">
				<?php for($i = 1 ; $i <=5; $i++):
					print '<option value="'. $i .'" ';
						print ($i == $number_ad) ? 'selected' : '' ;
					print '>'. $i .'</option>';
				endfor; ?>
			</select>
		</div>
	

		<div class="question">
			<label for="no_of_childs">Number of Childs:</label>
			<br />
			<select name="no_of_childs" id="no_of_childs">
				<?php for($i = 0 ; $i <=5; $i++):
					print '<option value="'. $i .'" ';
						print ($i == $number_ch) ? 'selected' : '' ;
					print '>'. $i .'</option>';
				endfor; ?>
			</select>	
		</div>
		
		<div class="dependable-question" data-dependont="no_of_childs">
			<label for="age_between_0_and_4"># of Children between 0 and 4</label>
			<br />
			<select name="age_between_0_and_4" id="age_between_0_and_4">
				<?php for($i = 0 ; $i <=5; $i++):
					print '<option value="'. $i .'" ';
						print ($i == $bt_0_4) ? 'selected' : '' ;
					print '>' .$i .'</option>';
				endfor; ?>
			</select>	
		</div>

		<div class="dependable-question" data-dependont="no_of_childs">
			<label for="age_between_5_and_11"># of Children between 5 and 11</label>
			<br />
			<select name="age_between_5_and_11" id="age_between_5_and_11">
				<?php for($i = 0 ; $i <=5; $i++):
					print '<option value="'. $i .'" ';
						print ($i == $bt_5_11) ? 'selected' : '' ;
					print '>' .$i .'</option>';
				endfor; ?>
			</select>	
		</div>

		<div class="dependable-question" data-dependont="no_of_childs">
			<label for="Young_youth">Young youth</label>
			<br />
			<select name="Young_youth" id="Young_youth">
				<?php for($i = 0 ; $i <=5; $i++):
					print '<option value="'. $i .'" ';
						print ($i == $Young_youth) ? 'selected' : '' ;
					print '>' .$i .'</option>';
				endfor; ?>
			</select>	
		</div>
		
		<div class="dependable-question" data-dependont="no_of_childs">
			<label for="ch_grades">Children Grades</label>
			<br />
			<input type="text" name="ch_grades" id="ch_grades" value="<?php print $ch_grades; ?>" />
		</div>
		
		<div class="question">
			<label for="paid">Amount Paid</label>
			<br />
			<input type="text" readonly="readonly" name="paid" id="paid" value="<?php print $paid; ?>" />
		</div>
		
		<div class="question">
			<label for="remaining">Amount Remaining</label>
			<br />
			<input type="text" readonly="readonly" name="remaining" id="remaining" value="<?php print $remaining; ?>" />
		</div>

		<table id="paymentInformation">
			<thead>
				<tr>
					<th>
						Payment Method
					</th>
					<th>
						Payment Amount
					</th>
					<th>
						Check Number
					</th>
					<th>
						Payment Date
					</th>
					<th>
						<button type="button" id="AddPaymentRow">Add</button>
					</th>
				</tr>
			</thead>
			<tbody id="paymentTableBody">

				<?php if($payment_method == '' ):
					//This is a new booking
					?>
				<tr>
					<td>
						<select name="payment_method[]" class="payment_method">
							<option <?php echo ($payment_method == 'Check') ? 'selected' : '' ;?> value="Check">Check</option>
							<option <?php echo ($payment_method == 'Cash') ? 'selected' : '' ;?> value="Cash">Cash</option>
						</select>
					</td>
					<td>
						<input type="text" class="paid_amount" value="0" name="payment_amount[]" />
					</td>
					<td>
						<input type="text" name="check_numbers[]" class="checknumbers" value="<?php print $check_numbers; ?>" />
					</td>
					<td>
						<input type="text" class="datepicker" name="payment_date[]" value="<?php  print date('m/d/Y');?>" />
					</td>
					<td>
						&nbsp;
					</td>
				</tr>

					<?php
				else:
					//Updating Booking 
					foreach($payment_method as $key => $onepayment):
						?>
				<tr>
					<td>
						<select name="payment_method[]" class="payment_method">
							<option <?php echo ($payment_method[$key] == 'Check') ? 'selected' : '' ;?> value="Check">Check</option>
							<option <?php echo ($payment_method[$key] == 'Cash') ? 'selected' : '' ;?> value="Cash">Cash</option>
						</select>
					</td>
					<td>
						<input type="text" class="paid_amount" value="<?php print $payment_amount[$key] ?>" name="payment_amount[]" />
					</td>
					<td>
							<input type="text" name="check_numbers[]" class="checknumbers" <?php  if($payment_method[$key] != 'Check'): ?>  style="display:none" <?php endif;?>value="<?php print $check_numbers[$key]; ?>" />
						
					</td>
					<td>
						<input type="text" class="datepicker" name="payment_date[]" value="<?php  print $payment_date[$key]; ?>" />
					</td>
					<td>
						<?php  if($key > 0 ): ?>
							<button type="button" class="removeRowBTN">Remove</button>
						<?php endif; ?>
					</td>
				</tr>
<?php
					endforeach;
				endif; ?>
			</tbody>
		</table>
		
		<div class="question">
			<label for="room_type">Room Type</label><p class="description">Please Select the Conference first</p>
			<br />
			<input type="hidden" name="roomtype" id="roomtype" value="<?php print $roomtype; ?>">
			<select name="room_type" id="room_type">
				<?php if(!empty($post->ID)):
					foreach($roomTypes as $one):
						print '<option value="'. $one .'" ';
							if($one == $roomtype):
								print ' selected ';
							endif;
						print '>'. $one .'</option>';
					endforeach;
				endif; ?>
			</select>
		</div>	

		<div class="question">
			<label for="room_numbers">Room number(s)</label><br />
			<input type="text" name="room_numbers" id="room_numbers" value="<?php print $room_numbers; ?>">
			
		</div>
		
		<div class="question">
			<label  for="hotelComments">Comments for the Hotel:</label>
			<br />
			<textarea name="hotelComments" id="hotelComments"><?php print $hotelComments;?></textarea>
		</div>
		
		<div class="question">
			<label for="extraComments">Extra Comments:</label>
			<br />
			<textarea name="extraComments" id="extraComments"><?php print $extraComments;?></textarea>
		</div>

		<div class="question">
			<label for="emailaddress">Email Address:</label>
			<br />
			<input type="text" name="emailaddress" id="emailaddress" value="<?php print $emailaddress; ?>">
		</div>

	<?php
	}



	function conference_booking_save_post(){

		 if(empty($_POST)) return; 
    	global $post;


   		update_post_meta($post->ID, "no_of_adults", $_POST["no_of_adults"]);
   		update_post_meta($post->ID, "no_of_childs", $_POST["no_of_childs"]);
   		

   		update_post_meta($post->ID, "age_between_0_and_4", $_POST["age_between_0_and_4"]);
   		update_post_meta($post->ID, "age_between_5_and_11", $_POST["age_between_5_and_11"]);
   		update_post_meta($post->ID, "Young_youth", $_POST["Young_youth"]);
   		update_post_meta($post->ID, "ch_grades", $_POST["ch_grades"]);
   		update_post_meta($post->ID, "paid", $_POST["paid"]);
   		update_post_meta($post->ID, "remaining", $_POST["remaining"]);
   		
   		update_post_meta($post->ID, "payment_method", $_POST["payment_method"]);
   		update_post_meta($post->ID, "payment_amount", $_POST["payment_amount"]);
   		update_post_meta($post->ID, "check_numbers", $_POST["check_numbers"]);
   		update_post_meta($post->ID, "payment_date", $_POST["payment_date"]);
   		//

   		update_post_meta($post->ID, "room_type", $_POST["room_type"]);
   		update_post_meta($post->ID, "hotelComments", $_POST["hotelComments"]);
   		update_post_meta($post->ID, "extraComments", $_POST["extraComments"]);
   		update_post_meta($post->ID, "room_numbers", $_POST["room_numbers"]);

   		update_post_meta($post->ID, "emailaddress", $_POST["emailaddress"]);

   		


	}


	public function set_custom_columns($columns){

		$title = $columns['title'];
		$date = $columns['date'];
		$conference = $columns['taxonomy-conferences'];

		unset($columns['title'] , $columns['date'] , $columns['taxonomy-conferences']);




		$columns['title'] = $title;
		$columns['paid'] = 'Paid';
		$columns['remaining'] = 'Remaining';
		$columns['room_type'] = 'Room Type';
		$columns['date'] = $date;






		return $columns;
	}


	public function set_custom_columns_data($column , $postid ){

		$custom = get_post_custom($postid);
	    $number_ad = isset($custom["no_of_adults"][0])?$custom["no_of_adults"][0]:'';
	    $number_ch = isset($custom["no_of_childs"][0])?$custom["no_of_childs"][0]:'';
	    $bt_0_4 = isset($custom["age_between_0_and_4"][0])?$custom["age_between_0_and_4"][0]:'';
	    $bt_5_11 = isset($custom["age_between_5_and_11"][0])?$custom["age_between_5_and_11"][0]:'';
	    $Young_youth = isset($custom["Young_youth"][0])?$custom["Young_youth"][0]:'';
	    $ch_grades = isset($custom["ch_grades"][0])?$custom["ch_grades"][0]:'';
	    $paid = isset($custom["paid"][0])?$custom["paid"][0]:'';
	    $remaining = isset($custom["remaining"][0])?$custom["remaining"][0]:'';
	    

	    $payment_method = isset($custom["payment_method"][0])?unserialize($custom["payment_method"][0]):'';
		$check_numbers = isset($custom["check_numbers"][0])?unserialize($custom["check_numbers"][0]):'';
	    $payment_amount = isset($custom["payment_amount"][0])?unserialize($custom["payment_amount"][0]):'';
	    $payment_date = isset($custom["payment_date"][0])?unserialize($custom["payment_date"][0]):'';
	    

	    $room_numbers  = isset($custom["room_numbers"][0])?$custom["room_numbers"][0]:'';
	    $hotelComments = isset($custom["hotelComments"][0])?$custom["hotelComments"][0]:'';
		$extraComments = isset($custom["extraComments"][0])?$custom["extraComments"][0]:'';
		$roomtype = isset($custom["room_type"][0])?$custom["room_type"][0]:'';

		switch($column){
			case 'paid':
				echo $paid;
			break;
			case 'remaining':
				echo $remaining;
			break;
			case 'room_type':
				echo $roomtype;
			break;
		}
	}

	public function custom_sortable_columns($columns){
		$columns['paid'] = 'paid';
		$columns['remaining'] = 'remaining';
		$columns['room_type'] = 'room_type';


		return $columns;
	}

	public function getConferenceBookings($confid){
		$posts_array = get_posts(
		    array(
		        'posts_per_page' => -1,
		        'post_type' => 'conference_booking',
		        'tax_query' => array(
		            array(
		                'taxonomy' => 'conferences',
		                'field' => 'term_id',
		                'terms' => $confid,
		            )
		        )
		    )
		);


		$totalPaid = 0;
		$totalRemaining = 0;

		foreach($posts_array as $key => $post){
			$custom = get_post_custom($post->ID);

			$posts_array[$key]->{'paid'} = $custom['paid'][0];
			$posts_array[$key]->{'remaining'} = $custom['remaining'][0];
			$totalPaid +=  $custom['paid'][0];
			$totalRemaining += $custom['remaining'][0];
		}


		$posts_array['totalPaid'] = $totalPaid;
		$posts_array['totalRemaining'] = $totalRemaining;


		 return $posts_array;
	}
 }