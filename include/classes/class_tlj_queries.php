<?php


/**
* 
*/
class tlj_Queries extends tlj_soapClient {

	protected $_wsEndPoints = array(
		'FoAdvert'	=> 'https://api3.lumesse-talenthub.com/CareerPortal/SOAP/FoAdvert'
	);

	protected $client;

	function __construct() {
		$config = get_option('apiCredentials');
		$this->client = new tlj_soapClient( $config );

	}



	public function getAdvertisementById( $id ) {
		try {
			$this->client->init_client($this->_wsEndPoints['FoAdvert']);
			$result = $this->client->call('getAdvertisementById', array(
				'postingTargetId' => $id,
				'langCode'		  => 'UK'
			));	


			return $result;
			
		} catch (Exception $e) {
			return new WP_Error( '101', $e->getMessage());			
		}
	}
}