<?php 

class tlj_soapClient { 
	private $_wsSecurityNS = "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd";

	private $_wsHeader;
	protected $ws = null; // holder of web service for future calls

	function __construct( array $config ) {
		$this->api_key = $config['api_key'];
		$this->_wsHeader = new SoapHeader(
			$this->_wsSecurityNS, 
			'Security', 
			$this->get__soapVar_Security($config['username'], $config['pwd']), 
			true, 
			"TlkPrincipal"
		);
	}

	private function get__soapVar_Security( $username, $pwd ) {
		$soap_Username = new SoapVar($username, XSD_STRING, NULL, $this->_wsSecurityNS, NULL, $this->_wsSecurityNS);
		$soap_Password = new SoapVar($pwd, XSD_STRING, NULL, $this->_wsSecurityNS, NULL, $this->_wsSecurityNS);

		$soap_Auth = new WSSEAuth($soap_Username, $soap_Password);
		$soapVar_Auth = new SoapVar($soap_Auth, SOAP_ENC_OBJECT, NULL, $this->_wsSecurityNS, 'UsernameToken', $this->_wsSecurityNS);
		$soap_Auth_Token = new WSSEToken($soapVar_Auth);
		$soapVar_Auth_Token = new SoapVar($soap_Auth_Token, SOAP_ENC_OBJECT, NULL, $this->_wsSecurityNS, 'UsernameToken', $this->_wsSecurityNS);
		$soapVar_Security = new SoapVar($soapVar_Auth_Token, SOAP_ENC_OBJECT, NULL, $this->_wsSecurityNS, 'Security', $this->_wsSecurityNS);

		return $soapVar_Security;
	}

	protected function init_client( $endpoint ) {
		$this->ws = @new SoapClient( $endpoint . '?wsdl');
		$this->ws->__setSoapHeaders( array( $this->_wsHeader ) );
		$this->ws->__setLocation( $endpoint . '?api_key=' . $this->api_key );
	}

	protected function reset_client() {

	}

	public function call( $function_name, $args ) {
		return $this->ws->__soapCall( $function_name, $args );
	}
}

// additional classes to facilitate WSSE addition to standard SOAP for PHP
class WSSEAuth {
	private $Username;
	private $Password;

	function __construct($username, $password) {
		$this->Username = $username;
		$this->Password = $password;
	}
}

class WSSEToken {
	private $UsernameToken;

	function __construct ($token) {
		$this->UsernameToken = $token;
	}
}