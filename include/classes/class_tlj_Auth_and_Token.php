<?php
class tlj_Auth_and_Token {
  private $soap_Username;
  private $soap_Password;
  public $soapVar_Header;

  function __construct( $Username, $Password, $wsSecurityNS ) {
    $this->$soap_Username = new SoapVar($Username, XSD_STRING, NULL, $wsSecurityNS, NULL, $wsSecurityNS);
    $this->$soap_Password = new SoapVar($Password, XSD_STRING, NULL, $wsSecurityNS, NULL, $wsSecurityNS);
    $soap_Auth = new tlj_WSSEAuth($soap_Username, $soap_Password);
    $soapVar_Auth = new SoapVar($soap_Auth, SOAP_ENC_OBJECT, NULL, $wsSecurityNS, 'UsernameToken', $wsSecurityNS);
    $soap_Auth_Token = new tlj_WSSEToken($soapVar_Auth);
    $soapVar_Auth_Token = new SoapVar($soap_Auth_Token, SOAP_ENC_OBJECT, NULL, $wsSecurityNS, 'UsernameToken', $wsSecurityNS);
    $soapVar_Security = new SoapVar($soapVar_Auth_Token, SOAP_ENC_OBJECT, NULL, $wsSecurityNS, 'Security', $wsSecurityNS);
    $this->$soapVar_Header = new SoapHeader($wsSecurityNS, 'Security', $soapVar_Security, true, "TlkPrincipal");

  }
}