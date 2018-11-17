<?php 

/**
 *
 *
 *      @Package Registraion Form
 *
 *
 */

namespace Req\Api;

class Ajax {
    public function register(){
        //Get Taxonomy Information
        add_action( 'wp_ajax_TermInfo', array( $this, 'TermInfo' ) ); 
    }


    function TermInfo(){
        $termid = (int)$_POST['term'];
        $metaData = get_term_meta( $termid );
        $metaReadable = unserialize( $metaData['conference_meta'][0] );
    	
    	
        echo json_encode($metaReadable);

        die();
    }

}