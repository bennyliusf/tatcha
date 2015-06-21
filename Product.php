<?php
class Product{
    // set limit=0 to get all products
    function __construct() {
        $i = 0;
        $result = $this->curlProductJSONDecode($this->iniUrl);
        foreach($result as $val){
            $i++;
        }
        $this->totalRows = $i;
    }

    private $iniUrl = "http://api.tatcha.com/shop/api/rest/products?page=1&limit=0 -H 'Accept: text/xml'";

    static $totalRows;
    
    function curlProductJSONDecode($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        if ( $error = curl_error($ch) ) {
            echo 'ERROR: ',$error;
        }
        curl_close($ch);
        return  json_decode($result);
    }

    function getTotalRows(){
        return $this->totalRows;
    }

}
?>