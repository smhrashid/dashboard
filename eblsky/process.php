<?php

$configArray = array();

// possible values:
// FALSE = test mode
// TRUE = live mode
$configArray["gatewayMode"] = FALSE;

// If using a proxy server, uncomment the following proxy settings

// If no authentication is required, only uncomment proxyServer
// Server name or IP address and port number of your proxy server
//$configArray["proxyServer"] = "server:port";

// Username and password for proxy server authentication
//$configArray["proxyAuth"] = "username:password";

// If using certificate validation, modify the following configuration settings
// alternate trusted certificate file
// leave as "" if you do not have a certificate path
//$configArray["certificatePath"] = "C:/ca-cert-bundle.crt";

// possible values:
// FALSE = disable verification
// TRUE = enable verification
$configArray["certificateVerifyPeer"] = FALSE;

// possible values:
// 0 = do not check/verify hostname
// 1 = check for existence of hostname in certificate
// 2 = verify request hostname matches certificate hostname
$configArray["certificateVerifyHost"] = 0;

// Merchant ID supplied by your payments provider
$configArray["merchantId"] = "20070005";

// API password which can be configured in Merchant Administration
$configArray["password"] = "cd8f2ab3946fe668e25492051e5b2b01";

// The debug setting controls displaying the raw content of the request and response for a transaction.
// In production you should ensure this is set to FALSE as to not display/use this debugging information
$configArray["debug"] = FALSE;

// Version number of the API being used for your integration this is the default value if it isn't being specified in process.php
$configArray["version"] = "41";
@session_start();
?>

   
<?php
/* 	
 This class holds all the merchant related variables and proxy 
 configuration settings	
*/
class Merchant {
	private $proxyServer = "";
	private $proxyAuth = "";
	private $proxyCurlOption = 0;
	private $proxyCurlValue = 0;	
	
	private $certificatePath = "";
	private $certificateVerifyPeer = FALSE;	
	private $certificateVerifyHost = 0;

	private $gatewayUrl = "";
	private $debug = FALSE;
	private $version = "";
	private $merchantId = "";
	private $password = "";
	private $apiUsername = "";
	
	/*
	 The constructor takes a config array. The structure of this array is defined 
	 at the top of this page.
	*/
	function __construct($configArray) {
		if (array_key_exists("proxyServer", $configArray))
			$this->proxyServer = $configArray["proxyServer"];
		
		if (array_key_exists("proxyAuth", $configArray))
			$this->proxyAuth = $configArray["proxyAuth"];
			
		if (array_key_exists("proxyCurlOption", $configArray))
			$this->proxyCurlOption = $configArray["proxyCurlOption"];
		
		if (array_key_exists("proxyCurlValue", $configArray))
			$this->proxyCurlValue = $configArray["proxyCurlValue"];
			
		if (array_key_exists("certificatePath", $configArray))
			$this->certificatePath = $configArray["certificatePath"];
			
		if (array_key_exists("certificateVerifyPeer", $configArray))
			$this->certificateVerifyPeer = $configArray["certificateVerifyPeer"];
			
		if (array_key_exists("certificateVerifyHost", $configArray))
			$this->certificateVerifyHost = $configArray["certificateVerifyHost"];
		
		if (array_key_exists("gatewayUrl", $configArray))
			$this->gatewayUrl = $configArray["gatewayUrl"];
		
		if (array_key_exists("debug", $configArray))	
			$this->debug = $configArray["debug"];
			
		if (array_key_exists("version", $configArray))
			$this->version = $configArray["version"];
			
		if (array_key_exists("merchantId", $configArray))	
			$this->merchantId = $configArray["merchantId"];
		
		if (array_key_exists("password", $configArray))
			$this->password = $configArray["password"];
			
		if (array_key_exists("apiUsername", $configArray))
			$this->apiUsername = $configArray["apiUsername"];	
	}
	
	// Get methods to return a specific value
	public function GetProxyServer() { return $this->proxyServer; }
	public function GetProxyAuth() { return $this->proxyAuth; }
	public function GetProxyCurlOption() { return $this->proxyCurlOption; }
	public function GetProxyCurlValue() { return $this->proxyCurlValue; }
	public function GetCertificatePath() { return $this->certificatePath; }
	public function GetCertificateVerifyPeer() { return $this->certificateVerifyPeer; }
	public function GetCertificateVerifyHost() { return $this->certificateVerifyHost; }
	public function GetGatewayUrl() { return $this->gatewayUrl; }
	public function GetDebug() { return $this->debug; }
	public function GetVersion() { return $this->version; }	
	public function GetMerchantId() { return $this->merchantId; }
	public function GetPassword() { return $this->password; }
	public function GetApiUsername() { return $this->apiUsername; }
	
	// Set methods to set a value
	public function SetProxyServer($newProxyServer) { $this->proxyServer = $newProxyServer; }
	public function SetProxyAuth($newProxyAuth) { $this->proxyAuth = $newProxyAuth; }
	public function SetProxyCurlOption($newCurlOption) { $this->proxyCurlOption = $newCurlOption; }
	public function SetProxyCurlValue($newCurlValue) { $this->proxyCurlValue = $newCurlValue; }
	public function SetCertificatePath($newCertificatePath) { $this->certificatePath = $newCertificatePath; }
	public function SetCertificateVerifyPeer($newVerifyHostPeer) { $this->certificateVerifyPeer = $newVerifyHostPeer; }
	public function SetCertificateVerifyHost($newVerifyHostValue) { $this->certificateVerifyHost = $newVerifyHostValue; }
	public function SetGatewayUrl($newGatewayUrl) { $this->gatewayUrl = $newGatewayUrl; }
	public function SetDebug($debugBool) { $this->debug = $debugBool; }
	public function SetVersion($newVersion) { $this->version = $newVersion; }
	public function SetMerchantId($merchantId) {$this->merchantId = $merchantId; }
	public function SetPassword($password) { $this->password = $password; }
	public function SetApiUsername($apiUsername) { $this->apiUsername = $apiUsername; }
}

?>
<?php

class Connection {
  protected $curlObj;

  function __construct($merchantObj) {
    // initialise cURL object/options
    $this->curlObj = curl_init();

    // configure cURL proxy options by calling this function
    $this->ConfigureCurlProxy($merchantObj);

    // configure cURL certificate verification settings by calling this function
    $this->ConfigureCurlCerts($merchantObj);
  }

  function __destruct() {
    // free cURL resources/session
    curl_close($this->curlObj);
  }

  // Send transaction to payment server
  public function SendTransaction($merchantObj, $request) {
    // [Snippet] howToPost - start
    curl_setopt($this->curlObj, CURLOPT_POSTFIELDS, $request);
    // [Snippet] howToPost - end

    // [Snippet] howToSetURL - start
    curl_setopt($this->curlObj, CURLOPT_URL, $merchantObj->GetGatewayUrl());
		// [Snippet] howToSetURL - end

    // [Snippet] howToSetHeaders - start
    // set the content length HTTP header
    curl_setopt($this->curlObj, CURLOPT_HTTPHEADER, array("Content-Length: " . strlen($request)));

    // set the charset to UTF-8 (requirement of payment server)
    curl_setopt($this->curlObj, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded;charset=UTF-8"));
    // [Snippet] howToSetHeaders - end

    curl_setopt($this->curlObj, CURLOPT_FOLLOWLOCATION, false);

    // tells cURL to return the result if successful, of FALSE if the operation failed
    curl_setopt($this->curlObj, CURLOPT_RETURNTRANSFER, TRUE);



    // this is used for debugging only. This would not be used in your integration, as DEBUG should be set to FALSE
    if ($merchantObj->GetDebug()) {
      curl_setopt($this->curlObj, CURLOPT_HEADER, TRUE);
      curl_setopt($this->curlObj, CURLINFO_HEADER_OUT, TRUE);
    }

    // [Snippet] executeSendTransaction - start
    // send the transaction
    $response = curl_exec($this->curlObj);
    // [Snippet] executeSendTransaction - end

    // this is used for debugging only. This would not be used in your integration, as DEBUG should be set to FALSE
    if ($merchantObj->GetDebug()) {
      $requestHeaders = curl_getinfo($this->curlObj);
      $response = $requestHeaders["request_header"] . $response;
    }

    // assigns the cURL error to response if something went wrong so the caller can echo the error
    if (curl_error($this->curlObj))
      $response = "cURL Error: " . curl_errno($this->curlObj) . " - " . curl_error($this->curlObj);

    // respond with the transaction result, or a cURL error message if it failed
    return $response;
  }

  // [Snippet] howToConfigureProxy - start
  // Check if proxy config is defined, if so configure cURL object to tunnel through
  protected function ConfigureCurlProxy($merchantObj) {
    // If proxy server is defined, set cURL option
    if ($merchantObj->GetProxyServer() != "") {
      curl_setopt($this->curlObj, CURLOPT_PROXY, $merchantObj->GetProxyServer());
      curl_setopt($this->curlObj, $merchantObj->GetProxyCurlOption(), $merchantObj->GetProxyCurlValue());
    }

    // If proxy authentication is defined, set cURL option
    if ($merchantObj->GetProxyAuth() != "")
      curl_setopt($this->curlObj, CURLOPT_PROXYUSERPWD, $merchantObj->GetProxyAuth());
  }
  // [Snippet] howToConfigureProxy - end

  // [Snippet] howToConfigureSslCert - start
  // configure the certificate verification related settings on the cURL object
  protected function ConfigureCurlCerts($merchantObj) {
    // if user has given a path to a certificate bundle, set cURL object to check against them
    if ($merchantObj->GetCertificatePath() != "")
      curl_setopt($this->curlObj, CURLOPT_CAINFO, $merchantObj->GetCertificatePath());

    curl_setopt($this->curlObj, CURLOPT_SSL_VERIFYPEER, $merchantObj->GetCertificateVerifyPeer());
    curl_setopt($this->curlObj, CURLOPT_SSL_VERIFYHOST, $merchantObj->GetCertificateVerifyHost());
  }
  // [Snippet] howToConfigureSslCert - end

}



class Parser extends Connection {
  function __construct($merchantObj) {
    // call parent ctor to init members
    parent::__construct($merchantObj);
  }

  function __destruct() {
    // call parent dtor to free resources
    parent::__destruct();
  }

	// [Snippet] howToConfigureURL - start
  // Modify gateway URL to set the version
  // Assign it to the gatewayUrl member in the merchantObj object
  public function FormRequestUrl($merchantObj) {
    $gatewayUrl = $merchantObj->GetGatewayUrl();
    $gatewayUrl .= "/version/" . $merchantObj->GetVersion();

    $merchantObj->SetGatewayUrl($gatewayUrl);
    return $gatewayUrl;
  }
  // [Snippet] howToConfigureURL - end

  // [Snippet] howToConvertFormData - start
  // Form NVP formatted request and append merchantId, apiPassword & apiUsername
  public function ParseRequest($merchantObj, $formData) {
    $request = "";

    if (count($formData) == 0)
      return "";

    foreach ($formData as $fieldName => $fieldValue) {
      if (strlen($fieldValue) > 0 && $fieldName != "merchant" && $fieldName != "apiPassword" && $fieldName != "apiUsername") {
        // replace underscores in the fieldnames with decimals
        for ($i = 0; $i < strlen($fieldName); $i++) {
          if ($fieldName[$i] == '_')
            $fieldName[$i] = '.';
        }
        $request .= $fieldName . "=" . urlencode($fieldValue) . "&";
      }
    }

    // [Snippet] howToSetCredentials - start
    // For NVP, authentication details are passed in the body as Name-Value-Pairs, just like any other data field
    $request .= "merchant=" . urlencode($merchantObj->GetMerchantId()) . "&";
    $request .= "apiPassword=" . urlencode($merchantObj->GetPassword()) . "&";
    $request .= "apiUsername=" . urlencode($merchantObj->GetApiUsername());
    // [Snippet] howToSetCredentials - end

    return $request;
  }
  // [Snippet] howToConvertFormData - end
}

?>
<?php
    class Skypay
    {
        protected $skypay;
        protected $merchant;
        protected $parser;
        protected $order;
        protected $completeUrl;

        public function __construct($configArray)
        {
            // The below value should not be changed
            if (!array_key_exists("proxyCurlOption", $configArray)) {
                $configArray["proxyCurlOption"] = CURLOPT_PROXYAUTH;
            }
            
            // The CURL Proxy type. Currently supported values: CURLAUTH_NTLM and CURLAUTH_BASIC
            if (!array_key_exists("proxyCurlValue", $configArray)) {
                $configArray["proxyCurlValue"] = CURLAUTH_NTLM;
            }

            // Base URL of the Payment Gateway. Do not include the version.
            if (!array_key_exists("gatewayUrl", $configArray)) {
                if ($configArray["gatewayMode"] === true) {
                    $configArray["gatewayUrl"] = "https://ap-gateway.mastercard.com/api/nvp";
                } else {
                    $configArray["gatewayUrl"] = "https://test-gateway.mastercard.com/api/nvp";
                }
            }
            // API username in the format below where Merchant ID is the same as above
            $configArray["apiUsername"] = "merchant." . $configArray["merchantId"];

            $this->merchant = new Merchant($configArray);
            $this->parser = new Parser($this->merchant);
        }

        public function Request($requestArray, $requestType="POST")
        {
            $requestUrl = $this->parser->FormRequestUrl($this->merchant);

            //This builds the request adding in the merchant name, api user and password.
            $request = $this->parser->ParseRequest($this->merchant, $requestArray);
            //Submit the transaction request to the payment server
            $response = $this->parser->SendTransaction($this->merchant, $request, $requestType);

            //Parse the response
            $result = $this->ParseData($response);

            return $result;
        }

        public function Checkout($orderArray)
        {
            $this->RectifyOrder($orderArray);
            $this->order = $this->Array2Dot($orderArray);

            $requestArray=array_merge(array("apiOperation" => "CREATE_CHECKOUT_SESSION", "order.description" => "TEST ORDER"), $this->order);
                                                     
            $checkout = $this->Request($requestArray);
            if ($checkout['result'] == 'SUCCESS') {
                $_SESSION['eblskypay'] = $checkout;
                $url = parse_url($this->merchant->GetGatewayUrl());
                $url['host'] = str_replace('-', '.', 'easternbank.' . $url['host']);
                $url['path'] = "/checkout/entry/" . $checkout["session.id"];
                $this->redirect($url['scheme'] . '://' . $url['host'] . $url['path']);
            }
            return $checkout;
        }

        public function RetrieveOrder($orderID)
        {
            $requestArray = array(
                "apiOperation" => "RETRIEVE_ORDER",
                "order.id" => $orderID
            );

            return $this->Request($requestArray);
        }

        public function VoidTransaction($orderID, $transactionID)
        {
            $requestArray = array(
                "apiOperation" => "VOID",
                "order.id" => $orderID,
                "transaction.targetTransactionId" => $transactionID,
                "transaction.id" => 'VOID-' . $transactionID
            );

            return $this->Request($requestArray);
        }

        // function for removing unnecessary data
        // basically it removes single dimension data from array
        public function RectifyOrder(&$orderArray)
        {
            foreach ($orderArray as $key=>$value) {
                if (!is_array($value)) {
                    unset($orderArray[$key]);
                }
            }
        }

        // array to dot notation
        public function Array2Dot($dataArray)
        {
            $recursiveDataArray = new RecursiveIteratorIterator(new RecursiveArrayIterator($dataArray));
            $result = array();
            foreach ($recursiveDataArray as $leafValue) {
                $keys = array();
                foreach (range(0, $recursiveDataArray->getDepth()) as $depth) {
                    $keys[] = $recursiveDataArray->getSubIterator($depth)->key();
                }
                $result[ join('.', $keys) ] = $leafValue;
            }
            return $result;
        }

        //convert nvp data to array
        public function ParseData($string)
        {
            $array=array();
            $pairArray = array();
            $param = array();
            if (strlen($string) != 0) {
                $pairArray = explode("&", $string);
                foreach ($pairArray as $pair) {
                    $param = explode("=", $pair);
                    $array[urldecode($param[0])] = urldecode($param[1]);
                }
            }
            return $array;
        }

        public function redirect($newURL)
        {
            header('Location: ' . $newURL);
            die();
        }

        public function pr($data)
        {
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }
    }
?>    
    
    
    
    
    
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['order']['id']) && isset($_POST['order']['amount']) && isset($_POST['order']['currency'])) {
        $skypay = new skypay($configArray);
        $responseArray = $skypay->Checkout($_POST);
    }    
?>
