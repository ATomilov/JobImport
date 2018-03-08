<?php

class tlj_Main {

	/**
	 * [__construct description]
	 */
	function __construct() {
		$this->init_hooks();
	}

	/**
	 * [init_hooks description]
	 *
	 */
	private function init_hooks(){
		// Ajax actions
		add_action( 'wp_ajax_doGetAdvertisementById', array( $this, 'ajax_doGetAdvertisementById' ) );
	}

	public function ajax_doGetAdvertisementById() {
		$id = $_POST['id'];
		$test_request = new tlj_Queries;
		$result = $test_request->getAdvertisementById( $id );
		if ( is_wp_error( $result ) ) :
			echo $result->get_error_message();
		else :
			echo json_encode( $result );
		endif;
		wp_die();
	}
}
new tlj_Main();