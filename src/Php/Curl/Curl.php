<?php

declare(strict_types=1);

namespace Phpext\Php\Curl;

class Curl
{
    const URL = "http://192.168.99.100:89";

    #ref: https://curl.haxx.se/libcurl/c/curl_easy_setopt.html

    public function request()
    {
        # create a cURL handle
        $ch = curl_init();
        # set the URL (this could also be passed to curl_init() if desired)
        curl_setopt($ch, CURLOPT_URL, self::URL);
        # set the HTTP method to POST
        //curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        # setting this option to an empty string enables cookie handling
        # but does not load cookies from a file
        curl_setopt($ch, CURLOPT_COOKIEFILE, "");
        # set the values to be sent
        /*curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            "username"=>"usr",
            "password"=>"pss"
        ));*/

        # return the response body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # send the request
        $result = curl_exec($ch);
        echo($result);

        # we are not calling curl_init()
        # simply change the URL
        curl_setopt($ch, CURLOPT_URL, self::URL);
        # change the method back to GET
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        # send the request
        $result = curl_exec($ch);
        # finished with cURL
        curl_close($ch);
    }

    public function api()
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            //CURLOPT_POST => 1,
            CURLOPT_URL => self::URL,
            CURLOPT_RETURNTRANSFER => 1,
            CURLINFO_HEADER_OUT => 1,
            //CURLOPT_POSTFIELDS => ['field_contents']
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        echo $result;

        #request
        /*$method = 'DELETE'; // Create a DELETE request
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        $content = curl_exec($ch);
        curl_close($ch);*/
    }
}
