<?php
/**
 * HTTP_Connection - handles how to make a request.
 */
class HTTP_Connection {
    public function __construct($apikey, $apisecret, $gatewayID, $gatewaypass) {
        $this->_apiKey = $apikey;
        $this->_apiSecret = $apisecret;
        $this->_gatewayID = $gatewayID;
        $this->_gatewayPass = $gatewaypass;
    }
    public function _setAttr($apikey, $apisecret, $gatewayID, $gatewaypass) {
        $this->_apiKey = $apikey;
        $this->_apiSecret = $apisecret;
        $this->_basicAuthToken = join(' ', array('Basic', base64_encode(join("", array($gatewayID, ':', $gatewaypass)))));
    }
    public function _getAttr() {
        return array($this->_apiKey, $this->_apiSecret, $this->_gatewayID, $this->_gatewayPass);
    }
    public  function _generateTestPayload() {
        $postData = array(
        			 'merchant_ref' => '123ABC', 
        			 'transaction_type' => 'authorize', 
        			 'method' => '3DS', 'amount' => '1299', 
        			 'currency_code' => 'USD', 
        			 '3DS' => array(
        					'type' => 'A', 
        					'transactionId' => '999999', 
        					'eciIndicator' => '05', 
        					'merchantIdentifier' => '1432', 
        					'encryptedData' => 'eG00ViEHWhnLTPJcuL/urOJ6aGfYGtae9lxrKSxAPwsdEfKzIb8VSvyv9GIhprErDjKE6kDDIUmFbTr7QtiKJD3b0b0d0oxEj+tWlmVBSTTAm1T+9yD97dbkhoH9NmfQVEQKVRKpC1co3Oc/nQZRhrjcRsD+5cihV9hbdLsAGaFKKrtKsAe1IWwzxr9lQdW+YL+vBnFJoqPT6Lr+Ijz6KTWTez7gxrlfOdFq8FmQyxjninSt1QhxUXNyyS4dKgwpi7jR0MbWZpKLcVgY2sl9p+W0mjk64/zCxSGVKd7x2FiTzZKg0Y9qoHiWJ40KyXa9NYAMS+H4uxzMHlMWttjz1J0Zw+87CQDW0/LjnyILd/kljZkXe3jnA5Ba50evn9iO2eBWsCc9HN1JseiCwAaoSVTMQogrNwv0b8Ph767A1udTo8+Di62WLTDwaz14NpwHlUK8/xU1HWTy/XBF6RbrJymLpNeHqs0dOOZ2wQJJGwCByGW3shfkSyvhqg8+dsPk1Z2qcrRadfRVSLwCcX6kIvlYab+mnUSCDOvqee2GzT/wYST69OrFlagEGI8odbd8nCzXHaRor1nxM1op3b1rWw7nUPyqc4JsEgcjyNyqQp4lXY1dD9qGkAHeakaEKre0fUNaRH3/bEhElm752CAl9XTXJKPOqUaofpAlA23K6xRHQ2LVOUqZH7ra6xsGcCrXOTOR/37mOnrwf6CBaJpE3nb0PfoOaifS6pRHlF6DAJh45nMuDN445PQUVRwZN6n+5VAPBIZkYMotWfLmgbClwF4ymDHwt967vONDuLJj5lEpuh2jN6NksN7Q0LTrRHdaR5Pc1lHDO2FQs3zRdn1z4r0gmqM/Wkh2YhZf/f0x8kxYfYJfCeaYaYsM2ikJhAz3lATv/ntL08PgjLTvVHtkwD9YHdYQeLydF6+F0nE/+yymDiEStg9sNFG3mGIdUZXTg7MmXdnbVL5cilFFxHzhDHCu9MM+LpLMIlsP0ySAmz0+9J80v7ZNd7Ag34777KMZc6MY/I3XSkkF7bfIdCBZGoQgRJLhJT+IUfeCqAr0uJVH7rwZsdH1PxjdVfIYq6zELKPsGJGsn/80sVz+qI0bbxazIIE07WmPkl+FPtQZfcrsMgU6RxhvqtlKcNYoz2GI/ZKa/HLNw/s7SCupSljH3hQ2QnJIhCEuNbPmWCElF/1tD7ZJUYydacxJhA5ntqI7kqS2EvMAAlOwSHJO', 'publicKeyHash' => 'dxCK7GDzZd3JocWOla8OtUeLJ7tf+OHLFAi9heOMb6o=', 
        					'wrappedKey' => 'MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEowqX6SpLQSCSBd83rJFSJEnMcH+P3Ffc3zC1Bg4cbexcVTqmSa7SdRVLJkEltfpreP9urkHOFsMyUAwjNb7jBg==', 
        					'symmetricKeyInfo' => 'AES/GCM/NoPadding', 
        					'asymmetricKeyInfo' => 'ECDH', 
        					'signatureAlgInfo' => 'SHA256withECDSA', 
        					'pkcs7Signature' => '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'
        				)
				);
        return json_encode($postData);
    }
    public function _generateCreditCardTestPayload(){
    	   $data = array(
    			'merchant_ref'=> 'GODADDY',
    			'transaction_type'=> 'authorize',
    			'method'=> 'credit_card',
    			'amount'=> '11',
    			'currency_code'=> 'USD',
    			'credit_card'=> array(
        					'type'=> 'visa',
        					'cardholder_name'=> 'xyz',
				          'card_number'=> '4788250000028291',
        					'exp_date'=> '1014',
        					'cvv'=> '123'
    						),
    			'billing_address'=> array(
        						'street'=> 'dsdsds',
        						'state_province'=> 'NY',
        						'zip_postal_code'=> '11747',
       						'city'=> 'New York',
        						'country'=> 'US'
    						)
		);

    	   return json_encode($data);
    }
    public  function _makePayment($URL, $args) {
        $ch = curl_init($URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        	'Content-Type: application/json', 
        	'apikey:'.$this->_apiKey, 
        	'apisecret:'.$this->_apiSecret, 
        	'Authorization:'.$this->_basicAuthToken
        ));
        return curl_exec($ch);
    }
}
?>