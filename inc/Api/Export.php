<?php 

/**
 *
 *
 *      @Package Registraion Form
 *
 *
 */

namespace Req\Api;
use Req\Pages\Dashboard;



class Export {
    public function register(){
        //Get Taxonomy Information
        add_action( 'restrict_manage_posts', array($this , 'add_export_button' ) ); 
        add_action( 'init', array($this , 'func_export_all_posts' ));
    }


    function add_export_button() {
        $screen = get_current_screen();

        if (isset($screen->post_type) && ('conference_booking' == $screen->post_type)) {
            ?>
            <input type="submit" name="export_all_bookings" id="export_all_bookings" class="button button-primary" value="Export All Bookings">
            <script type="text/javascript">
                jQuery(function($) {
                    $('#export_all_bookings').insertAfter('#post-query-submit');
                });
            </script>
            <?php
        }
    }

    function func_export_all_posts() {


        $abc = 'abcdefghijklmnopqrstuvwxyz';
        $ABC = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '0123456789';
        $all = $abc.$ABC.$num;
        $shuffle = substr(str_shuffle($all) ,  0 , 10);
        $name = 'bookings_'. date('m/d/Y') .'-'. $shuffle . '.csv';


        if(isset($_GET['export_all_bookings'])) {
            $arg = array(
                    'post_type' => 'conference_booking',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                );
     
            global $post;
            $arr_post = get_posts($arg);
            if ($arr_post) {
     
                header('Content-type: text/csv');
                header('Content-Disposition: attachment; filename="'. $name .'"');
                header('Pragma: no-cache');
                header('Expires: 0');
     
                $file = fopen('php://output', 'w');
     
                fputcsv($file, 
                    array(
                        'Names', 
                        'No of Adults',
                        'No of Childs',
                        'Childs 0 to 4',
                        'Childs 5 to 11',
                        'Young youth',
                        'Children grade',
                        'Total Paid',
                        'Total Remaining',
                        'Room Type',
                        'Hotel Comments',
                        'Extra Comments',
                        'Room Number'
                    )
                );
     
                foreach ($arr_post as $post) {
                    $meta = get_post_meta($post->ID);
                     fputcsv($file, array(
                         get_the_title(), 
                         $meta['no_of_adults'][0],
                         $meta['no_of_childs'][0],
                         $meta['age_between_0_and_4'][0],
                         $meta['age_between_5_and_11'][0],
                         $meta['Young_youth'][0],
                         $meta['ch_grades'][0],
                         $meta['paid'][0],
                         $meta['remaining'][0],
                         $meta['room_type'][0],
                         $meta['hotelComments'][0],
                         $meta['extraComments'][0],
                         $meta['room_numbers'][0]
                    ));
                }
     
                exit();
            }
        }


        if(isset($_GET['export_conference'])){
            //Do certain conference
            $arg = array(
                    'post_type' => 'conference_booking',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'conferences',
                            'field' => 'term_id',
                            'terms' => $_GET['export_conference'],
                        )
                    )
                );
     
            global $post;
            $arr_post = get_posts($arg);
            if ($arr_post) {
     
                header('Content-type: text/csv');
                header('Content-Disposition: attachment; filename="'. $name .'"');
                header('Pragma: no-cache');
                header('Expires: 0');
     
                $file = fopen('php://output', 'w');
     
                fputcsv($file, 
                    array(
                        'Names', 
                        'No of Adults',
                        'No of Childs',
                        'Childs 0 to 4',
                        'Childs 5 to 11',
                        'Young youth',
                        'Children grade',
                        'Total Paid',
                        'Total Remaining',
                        'Room Type',
                        'Hotel Comments',
                        'Extra Comments',
                        'Room Number'
                    )
                );
     
                foreach ($arr_post as $post) {
                    $meta = get_post_meta($post->ID);
                     fputcsv($file, array(
                         get_the_title(), 
                         $meta['no_of_adults'][0],
                         $meta['no_of_childs'][0],
                         $meta['age_between_0_and_4'][0],
                         $meta['age_between_5_and_11'][0],
                         $meta['Young_youth'][0],
                         $meta['ch_grades'][0],
                         $meta['paid'][0],
                         $meta['remaining'][0],
                         $meta['room_type'][0],
                         $meta['hotelComments'][0],
                         $meta['extraComments'][0],
                         $meta['room_numbers'][0]
                    ));
                }
     
                exit();
            }
        }

        if(isset($_GET['export_pending_rooms'])){
             //Do certain conference
            $arg = array(
                    'post_type' => 'conference_booking',
                    'post_status' => 'draft',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'conferences',
                            'field' => 'term_id',
                            'terms' => $_GET['export_pending_rooms'],
                        )
                    )
                );
     
            global $post;
            $arr_post = get_posts($arg);
            if ($arr_post) {
     
                header('Content-type: text/csv');
                header('Content-Disposition: attachment; filename="pending_'. $name .'"');
                header('Pragma: no-cache');
                header('Expires: 0');
     
                $file = fopen('php://output', 'w');
     
                fputcsv($file, 
                    array(
                        'Names', 
                        'No of Adults',
                        'No of Childs',
                        'Childs 0 to 4',
                        'Childs 5 to 11',
                        'Young youth',
                        'Children grade',
                        'Total Paid',
                        'Total Remaining',
                        'Room Type',
                        'Hotel Comments',
                        'Extra Comments',
                        'Room Number'
                    )
                );
     
                foreach ($arr_post as $post) {
                    $meta = get_post_meta($post->ID);
                     fputcsv($file, array(
                         get_the_title(), 
                         $meta['no_of_adults'][0],
                         $meta['no_of_childs'][0],
                         $meta['age_between_0_and_4'][0],
                         $meta['age_between_5_and_11'][0],
                         $meta['Young_youth'][0],
                         $meta['ch_grades'][0],
                         $meta['paid'][0],
                         $meta['remaining'][0],
                         $meta['room_type'][0],
                         $meta['hotelComments'][0],
                         $meta['extraComments'][0],
                         $meta['room_numbers'][0]
                    ));
                }
     
                exit();
            }
        }


        if(isset($_GET['total_conferences_report'])){
            //Export the total report
            $dashboard = new Dashboard();
            $conferences = $dashboard->getConferences();
            if ($conferences) {
                
                header('Content-type: text/csv');
                header('Content-Disposition: attachment; filename="'. $name .'"');
                header('Pragma: no-cache');
                header('Expires: 0');
     
                $file = fopen('php://output', 'w');
     
                fputcsv($file, 
                    array(
                        'Conference', 
                        'Total Number of Rooms',
                        'Paid Amount',
                        'Remaining Amount',
                    )
                );

                foreach ($conferences as $one) {

                     fputcsv($file, array(
                         $one['name'],
                         $one['count'],
                         $one['totalPaid'],
                         $one['totalRemaining']
                    ));
                }
     
                exit();
            }


        }
    }
}




/*

Update the Registraion forms table.

*/