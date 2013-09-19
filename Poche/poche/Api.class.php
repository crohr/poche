<?php

class Api {

    public static function call($method, $params)
    {
        $curl = curl_init();
        $timeout = 15;
        $useragent = "Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0";

        $url_to_call = POCHE_API . '/links/' . $method . '?';
        foreach ($params as $key => $param) {
            $url_to_call .= '&' . $key . '=' . $param;
        }

        curl_setopt($curl, CURLOPT_URL, $url_to_call);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);

        # for ssl, do not verified certificate
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE );

        # FeedBurner requires a proper USER-AGENT...
        curl_setopt($curl, CURL_HTTP_VERSION_1_1, true);
        curl_setopt($curl, CURLOPT_ENCODING, "gzip, deflate");
        curl_setopt($curl, CURLOPT_USERAGENT, $useragent);

        $json_data = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $httpcodeOK = isset($httpcode) and ($httpcode == 200 or $httpcode == 301);
        curl_close($curl);

        if (!$httpcodeOK)
            return false;

        return json_decode($json_data);
    }
}