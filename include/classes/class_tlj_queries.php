<?php
class tlj_Queries {
  public function get_Advertisement( $postingTargetId, $langCode ) {
    
    try {
      $client = new tlj_SoapClient;
      $result = $client->ws->__soapCall( 'getAdvertisementById', array ( new getAdvertisementById( $postingTargetId, $langCode ) ) );
    }
    catch ( Exception $e ) {
      return new WP_Error( 'error_soapcall', $e->getMessage() );
    }
    
  }
}