<?php
class curlLib {
    public $url;
    
    public function getContentFromURL() {
      if(DEBUG_METHOD_CALLS) echo "In method: " .__METHOD__ ."<br />";
      $curlConn = curl_init();
      curl_setopt($curlConn, CURLOPT_URL,$this->url);
      curl_setopt($curlConn, CURLOPT_RETURNTRANSFER,true);

      $returnedJSON = curl_exec($curlConn);
      curl_close($curlConn);
      $responseObj = json_decode($returnedJSON,true);
      if(DEBUG_DATA) print_r($responseObj);
      return $responseObj;
    }
}
