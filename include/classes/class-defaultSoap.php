<?php
class TLK_SOAP
{
private $_apiKey = 'dabc4dvptajdnrhwnqsf6dnz'; // API Key
private $_wsEndPoint = "https://api3.lumesse-talenthub.com/CareerPortal/SOAP/FoAdvert"; // end point for WS
private $_wsUsername = "THubUser"; // username for WS
private $_wsPassword = "Password1234"; // password for WS
private $_wsSecurityNS = "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd";
public $ws = null; // holder of web service for future calls
public $result;

function __construct()
{
$soap_Username = new SoapVar($this->_wsUsername, XSD_STRING, NULL, $this->_wsSecurityNS, NULL, $this->_wsSecurityNS);
$soap_Password = new SoapVar($this->_wsPassword, XSD_STRING, NULL, $this->_wsSecurityNS, NULL, $this->_wsSecurityNS);
$soap_Auth = new WSSEAuth($soap_Username, $soap_Password);
$soapVar_Auth = new SoapVar($soap_Auth, SOAP_ENC_OBJECT, NULL, $this->_wsSecurityNS, 'UsernameToken', $this->_wsSecurityNS);
$soap_Auth_Token = new WSSEToken($soapVar_Auth);
$soapVar_Auth_Token = new SoapVar($soap_Auth_Token, SOAP_ENC_OBJECT, NULL, $this->_wsSecurityNS, 'UsernameToken', $this->_wsSecurityNS);
$soapVar_Security = new SoapVar($soapVar_Auth_Token, SOAP_ENC_OBJECT, NULL, $this->_wsSecurityNS, 'Security', $this->_wsSecurityNS);
$soapVar_Header = new SoapHeader($this->_wsSecurityNS, 'Security', $soapVar_Security, true, "TlkPrincipal");
try
{
$this->ws = @new SoapClient($this->_wsEndPoint . '?wsdl');
$this->ws->__setSoapHeaders(array($soapVar_Header));
$this->ws->__setLocation($this->_wsEndPoint . '?api_key=' . $this->_apiKey);
$this->result =$this->ws->__getFunctions();
$this->ws->__soapCall('getAdvertisementById', array('postingTargetId'=>'1234','langCode'=> 'HU'));
}
catch (Exception $e)
{
echo $e->getMessage();
}
}
}

// additional classes to facilitate WSSE addition to standard SOAP for PHP
class WSSEAuth
{
private $Username;
private $Password;

function __construct($username, $password)
{
$this->Username = $username;
$this->Password = $password;
}
}

class WSSEToken
{
private $UsernameToken;

function __construct ($token)
{
$this->UsernameToken = $token;
}
}