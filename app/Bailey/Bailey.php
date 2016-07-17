<?php

namespace App\Bailey;

/*
|
| DestinyUI 3.0
| (C) 2016 TUDT
|
| "Bailey", a.k.a. DestinyCore API client.
|
*/

use Config;

class Bailey{



    /**
     * doAPIrequest
     * @param  string $endpoint API endpoint to call to, without forward and trailing slashes.
     * @param  string $method HTTP method to use.
     * @param  array $variables key-value array of variables to send along with the API request.
     * @param  string $baseURL The base URI/URL of the API server.
     * @return string raw cURL result on query success. bool FALSE if access is forbidden.
     *
     * note: this is not a public function!
     */
    function doAPIrequest(string $endpoint, string $method, array $variables = [], string $baseURL = Config::get("uiconfig.core_base_api_url")){

        // Get API Key
        $apiKey = Config::get("uiconfig.core_api_key");

        // Init cURL and set stuff:
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"$baseURL/$endpoint");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        // VERY VERY IMPORTANT: the API key header.
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-Auth-APIKey: $apiKey"
        ));

        curl_setopt($ch, CURLOPT_POSTFIELDS,$variables); // POST data field(s)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // run the cURL query
        $result = curl_exec($ch);
        $returnHttpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        // Is result forbiden or unauthorized?
        if($returnHttpCode == 401 || $returnHttpCode == 403){
            return false;
        }else{
            return $result;
        }

    }

}
