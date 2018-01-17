<?php
class tlj_SoapClient {
  private $_apiKey;
  private $_wsEndPoint = "https://api3.lumesse-talenthub.com/CareerPortal/SOAP/FoAdvert"; // end point for WS
  private $_wsUsername;
  private $_wsPassword;
  private $_wsSecurityNS = "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd";
  public $ws = null; // holder of web service for future calls

  function __construct() {
    $options_api = get_option( 'apiCredentials' );
    $this->_apiKey = esc_attr( $options_api['api_key'] );
    $this->_wsUsername = esc_attr( $options_api['username'] );
    $this->_wsPassword = esc_attr( $options_api['password'] );
    // $this->_wsEndPoint = esc_attr( $options_api['url_web_service'] );
    $build_header = new tlj_Auth_and_Token( $this->_wsUsername, $this->_wsPassword, $this->_wsSecurityNS );
    try {
      $this->ws = new SoapClient( $this->_wsEndPoint . '?wsdl' );
      $this->ws->__setSoapHeaders( $build_header->getHeader() );
      $this->ws->__setLocation( $this->_wsEndPoint . '?api_key=' . $this->_apiKey );
    }
    catch (Exception $e){
      echo $e->getMessage();
    }
    


  }
}